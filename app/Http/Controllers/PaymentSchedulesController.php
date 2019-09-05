<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class PaymentSchedulesController extends Controller
{
    public function create(){
		if(Auth()->User()->access_rights()->loans_create){
			$row = [];
			foreach($_GET as $k => $v){
				if($k === '_token'){
					continue;
				}
				$row[$k] = $v;
				//echo $k . '=>' . json_encode($v) . '<br>';
			}
			$arr = array_combine(Schema::getColumnListing('loans'), Schema::getColumnListing('loans'));
			$loans_values = array_intersect_key($row, $arr);
			$arr = array_combine(Schema::getColumnListing('payrolls'), Schema::getColumnListing('payrolls'));
			$payrolls_values = array_intersect_key($row, $arr);
			if(array_key_exists('others',$row)){//change this to has key
				$payrolls_values['others'] = $row['others'];
			}
			return view('payment_schedules.create')->with(['page_title'=> 'Loan Payment Schedule', 'loans_values' => json_decode(json_encode($loans_values),true), 'payrolls_values' => json_decode(json_encode($payrolls_values),true)]);
		}else{
			return new Response(view('unauthorized')->with('role', 'Authorized person'));
		}
	}
	
	public function store(){
		if(Auth()->User()->access_rights()->loans_create){
			/*$payment_schedule = $_GET['payment_schedule'];
			$payroll_deductions = [];
			$loan_id = $_GET['loan_id'];
			DB::beginTransaction();
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
			DB::commit();*/
			return redirect()->route('loans.index');
		}else{
			return new Response(view('unauthorized')->with('role', 'Authorized person'));
		}
	}
	
	public function update(){
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
			echo '-------------<br>';
			if(array_key_exists('loan_id', $row) and array_key_exists('payroll', $row) and array_key_exists('payment_no', $row)){
				$payment_schedule = DB::table('payroll_deductions')
					->where('loan_id', $row['loan_id'])
					->where('payroll', $row['payroll'])
					->where('payment_no', $row['payment_no']);
				$arr = array_combine(Schema::getColumnListing('payroll_deductions'), Schema::getColumnListing('payroll_deductions'));
				if($payment_schedule->first()){
					$total_paid = DB::table('payroll_deductions')->where('loan_id', $row['loan_id'])->where('month_year_applied', '<=', $row['month_year_applied'])->groupBy('loan_id')->select(DB::raw('SUM(periodic_payment) as total'))->first();
					$payroll_deduction_values = array_intersect_key($row, $arr);
					$payroll_deduction_values['total_paid_balance'] = (float)($total_paid?$total_paid->total:0)+(float)$row['periodic_payment'];
					$prev_updated = true;
					if($payment_schedule->first()->payment_no > 1){
						$prev_payment_schedule = DB::table('payroll_deductions')
							->where('loan_id', $row['loan_id'])
							->where('payroll', $row['payroll'])
							->where('payment_no', ($row['payment_no']-1));
						if($prev_payment_schedule->first() and $prev_payment_schedule->first()->month_year_applied == null){
							$prev_updated = false;
						}
					}
					if($prev_updated){
						$payment_schedule->update($payroll_deduction_values);
					}
					return redirect()->route('loans.view', ['id' => $payment_schedule->first()->loan_id]);
				}else{
					return redirec()->route('loans.index');
				}
			}
		}else{
			return new Response(view('unauthorized')->with('role', 'Authorized person'));
		}
	}
	
	public function undo(){
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
			echo '-------------<br>';
			if(array_key_exists('loan_id', $row) and array_key_exists('payroll', $row) and array_key_exists('payment_no', $row)){
				$payment_schedule = DB::table('payroll_deductions')
						->where('loan_id', $row['loan_id'])
						->where('payroll', $row['payroll'])
						->where('payment_no', $row['payment_no']);
				$arr = array_combine(Schema::getColumnListing('payroll_deductions'), Schema::getColumnListing('payroll_deductions'));
				$payroll_deduction_values = array_intersect_key($row, $arr);;
				if($payment_schedule->first()){
					if(array_key_exists('month_year_applied', $payroll_deduction_values)){
						$payroll_deduction_values['month_year_applied'] = null;
						$payment_schedule->update($payroll_deduction_values);
					}
				}
				return redirect()->route('loans.view', ['id' => $payment_schedule->first()->loan_id]);
			}else{
				return redirec()->route('loans.index');
			}
		}else{
			return new Response(view('unauthorized')->with('role', 'Authorized person'));
		}
	}
}
