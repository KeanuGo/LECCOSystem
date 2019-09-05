<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class LoansController extends Controller
{
	public function index(){
		if(Auth()->User()->access_rights()->loans_view){
			$loans = DB::table('loans')
				->join('members', 'loans.member_id', 'members.id')
				->select('loans.id', (DB::raw('CONCAT(members.first_name, \' \', members.last_name) AS name')),
						 'loans.loan_type',
						 'loans.amount',
						 'loans.start_of_payment',
						 'loans.remarks',
						 'loans.term AS Term(Months)')
				->get();
			return view('loans.index')->with(['page_title'=> 'Loans', 'loans' => $loans]);
		}else{
			return new Response(view('unauthorized')->with('role', 'Authorized person'));
		}
	}
	
    public function create(){
		if(Auth()->User()->access_rights()->loans_create){
			$columns = DB::select(DB::raw('EXEC sp_columns loans'));
			$_members = DB::table('members')->select('id', 'first_name', 'last_name')->get();
			$members = [];
			foreach($_members as $member){
				$members[$member->id] = $member->first_name . ' ' . $member->last_name;
			}
			$_loan_types = DB::table('loan_types')->select('id', 'name', 'interest_per_annum')->get();
			$loan_types = [];
			$loan_types_interest = [];
			foreach($_loan_types as $loan_type){
				$loan_types[$loan_type->name] = $loan_type->name;
				$loan_types_interest[$loan_type->name] = $loan_type->interest_per_annum;
			}
			
			$payrolls = DB::select(DB::raw('EXEC sp_columns ' . 'payrolls'));
			return view('loans.create')
				->with(['page_title'=> 'Add Loan', 
						'columns' => $columns,
						'members' => $members,
						'loan_types' => $loan_types,
						'loan_types_interest' => $loan_types_interest,
						'payrolls' => $payrolls]);
		}else{
			return new Response(view('unauthorized')->with('role', 'Authorized person'));
		}
	}
	
	public function store(){
		if(Auth()->User()->access_rights()->loans_create){
			$row = [];
			foreach($_REQUEST as $k => $v){
				if($k === '_token'){
					continue;
				}
				$row[$k] = $v;
				//echo $k . '=>' . json_encode($v) . '<br>';
			}
			//echo '-------------<br>';
			$_loans_values = $row['loans_values'];
			$arr = array_combine(Schema::getColumnListing('loans'), Schema::getColumnListing('loans'));
			$_loans_values['created_at'] = \Carbon\Carbon::now('Asia/Manila');
			$_loans_values['updated_at'] = \Carbon\Carbon::now('Asia/Manila');
			$loans_values = array_intersect_key($_loans_values, $arr);
			DB::beginTransaction();
			$loan_id = DB::table('loans')->insertGetId($loans_values);
			$_payrolls_values = $row['payrolls_values'];
			$_payrolls_values['loan_id'] = $loan_id;
			$arr = array_combine(Schema::getColumnListing('payrolls'), Schema::getColumnListing('payrolls'));
			$payrolls_values = array_intersect_key($_payrolls_values, $arr);
			foreach($payrolls_values as $k => $v){
				$payrolls_values[$k] = (int)json_decode($v, true);
				//echo $k. '=>'. $payrolls_values[$k];
			}
			foreach($arr as $k => $v){
				if(!array_key_exists($k, $payrolls_values)){
					$payrolls_values[$k] = false;
				}
				//echo $k. '=>'. $payrolls_values[$k];
			}
			DB::table('payrolls')->insert($payrolls_values);
			if(array_key_exists('others',$_payrolls_values)){//change this to has key
				$_payrolls_values['others'] = json_decode($_payrolls_values['others'], true);
				foreach($_payrolls_values['others'] as $v){
					$payrolls_columns = array_combine(Schema::getColumnListing('payrolls'), Schema::getColumnListing('payrolls'));
					if(!array_key_exists($v, $payrolls_columns)){
						$v = str_replace(' ', '_', $v);
						DB::unprepared('ALTER TABLE payrolls ADD "'. $v .'" bit NOT NULL DEFAULT 0');
					}
					$status = DB::table('payrolls')->where('loan_id', $loan_id);
					$status->update([$v => true]);
				}
			}
			$payment_schedule = $row['payment_schedule'];
			//DB::commit();
			
			$payment_schedule = json_decode(json_encode($payment_schedule), true);
			$payroll_deductions = [];
			//$loan_id = $_GET['loan_id'];
			//DB::beginTransaction();
			foreach($payment_schedule as $payroll => $v){
				//echo $payroll. '<br>';
				foreach($v as $payment_no => $v1){
					$payroll_deduction = ['loan_id' => $loan_id, 'payroll' => $payroll, 'payment_no' => $payment_no];
					//echo 'payment_no ' . $payment_no . '<br>';
					foreach($v1 as $k2 => $v2){
						//echo $k2 . '=>' . $v2 . '<br>';
						if($k2 == 'periodic_payment'){
							$payroll_deduction[$k2] = str_replace(',', '', $v2);
							continue;
						}
						$payroll_deduction[$k2] = $v2;
					}
					array_push($payroll_deductions, $payroll_deduction);
				}
			}
			
			foreach($payroll_deductions as $payroll_deduction){
				$arr = array_combine(Schema::getColumnListing('payroll_deductions'), Schema::getColumnListing('payroll_deductions'));
				$payroll_deduction['created_at'] = \Carbon\Carbon::now('Asia/Manila');
				$payroll_deduction_values = array_intersect_key($payroll_deduction, $arr);
				//echo json_encode($payroll_deduction_values) . '<br>';
				DB::table('payroll_deductions')->insert($payroll_deduction_values);
			}
			DB::commit();
			return redirect()->route('payment_schedule.store');
		}else{
			return new Response(view('unauthorized')->with('role', 'Authorized person'));
		}
	}
	
	public function delete($id){
		if(Auth()->User()->access_rights()->loans_delete){
			$loan = DB::table('loans')->where('loans.id', $id)->delete();
			return redirect()->route('loans.index');
		}else{
			return new Response(view('unauthorized')->with('role', 'Authorized person'));
		}
	}
	
	public function view($id){
		if(Auth()->User()->access_rights()->loans_view){
			$loan = DB::table('loans')
				->join('members', 'loans.member_id', 'members.id')
				->select((DB::raw('CONCAT(members.first_name, \' \', members.last_name) AS name')),
						 'loans.*')
				->where('loans.id', $id)
				->get()->first();
			$payroll_deductions = DB::table('payroll_deductions')->where('loan_id', $id)
								  ->orderBy('payroll', 'asc')
								  ->orderBy('payment_no')
								  ->get();
			$_payroll_deductions = json_decode(json_encode($payroll_deductions), true);
			$payroll_deductions = array();
			foreach($_payroll_deductions as $payroll_deduction){
				if(!array_key_exists($payroll_deduction['payroll'], $payroll_deductions)){
					$payroll_deductions[$payroll_deduction['payroll']] = [];
				}
				array_push($payroll_deductions[$payroll_deduction['payroll']], array_except($payroll_deduction, ['payroll']));
			}
			$max = DB::table('payroll_deductions')->where('loan_id', $id)->whereNotNull('month_year_applied')->select(DB::raw('MAX(updated_at) as latest'));
			$max = ($max->first()?$max->first()->latest:null);
			//echo json_encode($payroll_deductions);
			$payrolls = DB::table('payrolls')->where('loan_id', $id)->first();
			return view('loans.view')->with(['page_title'=> 'Loan', 'loan' => $loan, 'payroll_deductions' => $payroll_deductions, 'payrolls' => $payrolls, 'latest' => $max]);
		}else{
			return new Response(view('unauthorized')->with('role', 'Authorized person'));
		}
	}
	
	public function view_aging_loans(){
		if(Auth()->User()->access_rights()->loans_view){
			$late_by = "DAY";
			$late_by_amount = "1";
			if(isset($_GET['late_by'])){
				$late_by = $_GET['late_by'];
			}
			if(isset($_GET['late_by_amount'])){
				$late_by_amount = $_GET['late_by_amount'];
			}
			$loans = DB::table('payroll_deductions')
				->join('loans', 'loans.id', 'payroll_deductions.loan_id')
				->join('members', 'members.id', 'loans.member_id')
				->where('payroll_deductions.month_year_applied', null)
				->where(DB::raw('DATEADD(DAY, 1, payroll_deductions.expected_date_of_payment)'), '<', DB::raw('DATEADD(' . $late_by . ', -' . $late_by_amount . ', GETDATE())'))
				->select('loans.id', DB::raw('CONCAT(members.first_name, \' \', members.last_name) as \'name\''), 'loans.loan_type', DB::raw('SUM(payroll_deductions.periodic_payment) as \'late_payable\''))
				->groupBy('loans.id', 'members.last_name', 'members.first_name', 'loans.member_id', 'loans.loan_type')
				->get();
				/*
				->select('payroll_deductions.loan_id', 'CONCAT(members.first_name, \' \', members.last_name) as \'name\'', 'SUM(payroll_deductions.periodic_payment) as \'late_payable\'')
				->where('payroll_deductions.expected_date_of_payment', '<', 'DATEADD(MONTH, -2, GETDATE())')
				->where('payroll_deductions.month_year_applied', 'IS NULL')
				echo json_encode($loans);
				*/
			return view('loans.view_aging_loans')->with(['page_title'=> 'Aging Loans', 'loans' => $loans, 'late_by' => $late_by, 'late_by_amount' => $late_by_amount]);
		}else{
			return new Response(view('unauthorized')->with('role', 'Authorized person'));
		}
	}
	
	public function lpds(){
		if(Auth()->User()->access_rights()->loans_view){
			$payroll_deductions = DB::select("select payroll, month_year_applied
												from
													(
														select payroll,
															   CAST(CONCAT(DATEPART(YEAR, month_year_applied), '-', DATEPART(MONTH, month_year_applied), '-1') AS date) AS month_year_applied
														from payroll_deductions
														where month_year_applied IS NOT NULL
													) AS something
												GROUP BY payroll, month_year_applied");
			return view('loans.lpds')->with(['page_title'=> 'Loans Payment Deduction Schedule', 'payroll_deductions' => $payroll_deductions]);
		}else{
			return new Response(view('unauthorized')->with('role', 'Authorized person'));
		}
	}
	
	public function viewschedule($id, $id2){
		if(Auth()->User()->access_rights()->loans_view){
			$first_day= substr($id2, 0, 8)."1";
			$last_day= substr($id2, 0, 8)."30";
			$_loan_types = DB::table('loan_types')->pluck('name');
			$loan_types = "";
			$last_element = $_loan_types->last();
			foreach($_loan_types as $lt){
				$loan_types = $loan_types . "[". $lt . "]";
				if(!($last_element == $lt)){
					$loan_types = $loan_types. ", ";
				}
			}
			$scheds = DB::select("select *
									from
									(
										select member_id, name, loan_type, SUM(total) as 'total'
										from (select members.id as member_id, something.*, loans.loan_type, CONCAT(members.first_name, ' ', members.last_name) as name
												from (
														select loan_id AS loan_id, SUM(periodic_payment) as total, payroll AS payroll
														from payroll_deductions
														where payroll_deductions.month_year_applied > '". $first_day ."' and
															  payroll_deductions.month_year_applied < '". $last_day ."' and
															  payroll_deductions.payroll = '". $id ."'
														GROUP BY loan_id, payroll
													 ) AS something
												JOIN loans on loans.id = something.loan_id
												JOIN members on loans.member_id = members.id
										) AS something_else
										GROUP BY name, member_id, loan_type
									) d
									pivot
									(
										SUM(total)
										for loan_type in (". $loan_types .")
									) piv;");
			
			return view('loans.viewschedule')->with(['page_title'=> 'Loan Payment Deductions', 'scheds' => json_decode(json_encode($scheds),true), 'payroll' => $id, 'day' => $id2]);
		}else{
			return new Response(view('unauthorized')->with('role', 'Authorized person'));
		}
	}
	
	public function update($id){
		if(Auth()->User()->access_rights()->loans_edit){
			$row = [];
			foreach($_REQUEST as $k => $v){
				if($k === '_token'){
					continue;
				}
				$row[$k] = $v;
				echo $k . '=>' . json_encode($v) . '<br>';
			}
			$row['updated_at'] = \Carbon\Carbon::now('Asia/Manila');
			$arr = array_combine(Schema::getColumnListing('loans'), Schema::getColumnListing('loans'));
			$loans_values = array_intersect_key($row, $arr);
			$loan = DB::table('loans')
				->where('loans.id', $id)
				->update($loans_values);
			return redirect()-> route('loans.view', ['id' => $id]);
		}else{
			return new Response(view('unauthorized')->with('role', 'Authorized person'));
		}
	}
}
