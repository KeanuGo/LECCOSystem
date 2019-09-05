<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;

class CheckVoucherController extends Controller
{
	public function index(){
		if(Auth()->User()->access_rights()->check_voucher_view){
			if(isset($_GET['from']) && isset($_GET['to']) && isset($_GET['date'])) {
				$date_type = $_GET['date'];
				$from_date = $_GET['from'] ;
				$to_date = $_GET['to'];
				$check_voucher = DB::table('check_voucher')->orderBy('date_disbursed', 'asc');
				if($to_date !==''){
					$check_voucher = $check_voucher->whereDate($date_type, '<=', $to_date);
				}
				if($from_date !==''){
					$check_voucher = $check_voucher->whereDate($date_type, '>=', $from_date);
				}
				$check_voucher = $check_voucher->select('date_disbursed', 'cv_no', 'check_no', 'payee', 'description')->get();
				$cv_entries = DB::table('check_voucher')
				->join('cv_entries', 'cv_entries.id', 'check_voucher.cv_no')
				->join('chart_of_accounts', 'cv_entries.account_code', 'chart_of_accounts.account_code')
				->select('chart_of_accounts.account_title', 'cv_entries.*');
				if($from_date !==''){
					$cv_entries = $cv_entries->whereDate($date_type, '>=', $from_date);
				}
				if($to_date !==''){
					$cv_entries = $cv_entries->whereDate($date_type, '<=', $to_date);
				}
				$cv_entries = $cv_entries->get();
			}else{
				$check_voucher = DB::table('check_voucher')
				->orderBy('date_disbursed', 'asc')
				->select('date_disbursed', 'cv_no', 'check_no', 'payee', 'description')->get();
				$cv_entries = DB::table('check_voucher')
				->join('cv_entries', 'cv_entries.id', 'check_voucher.cv_no')
				->join('chart_of_accounts', 'cv_entries.account_code', 'chart_of_accounts.account_code')
				->select('chart_of_accounts.account_title', 'cv_entries.*')
				->get();
			}
			return view('check_voucher.index')->with(['page_title'=> 'Check Vouchers', 'check_voucher' => $check_voucher, 'cv_entries' => $cv_entries]);
		}else{
			return new Response(view('unauthorized')->with('role', 'Authorized person'));
		}
	}
	
    public function create(){
		if(Auth()->User()->access_rights()->check_voucher_create){
			$columns = DB::select(DB::raw('EXEC sp_columns check_voucher'));
			$chart_of_accounts = DB::table('chart_of_accounts')->select('account_code', 'account_title')->get();
			//echo json_encode($chart_of_accounts);
			
			return view('check_voucher.create')->with(['page_title'=> 'Add Check Voucher', 'columns' => $columns, 'chart_of_accounts' => $chart_of_accounts]);
		}else{
			return new Response(view('unauthorized')->with('role', 'Authorized person'));
		}
	}
	
	public function store(Request $request) {
		if(Auth()->User()->access_rights()->check_voucher_create){
			$row = [];
			foreach($_REQUEST as $k => $v){
				if($k === '_token' or $v === ''){
					continue;
				}
				$row[$k] = $v;
				echo $k . '=>' . json_encode($v) . '<br>';
			}
			$arr = array_combine(Schema::getColumnListing('check_voucher'), Schema::getColumnListing('check_voucher'));
			$row['created_at']= \Carbon\Carbon::now('Asia/Manila');
			$row['updated_at']= \Carbon\Carbon::now('Asia/Manila');
			if(request()->attachment){
				$row['attachment'] = '_cv'.time().'.'.request()->attachment->getClientOriginalExtension();
			}else{
				$row['attachment'] = null;
			}
			$check_voucher_values = array_intersect_key($row, $arr);
			$date  = \Carbon\Carbon::now('Asia/Manila');
			$yr= new Carbon( $date );
			$yr= (int)$yr->year;
			
			$max = DB::table('check_voucher')->orderBy('cv_no', 'desc');
			if($max->first()){
				$max = $max->first()->cv_no;
			}else{
				$max = 0;
			}
			if($max < $yr*10000){
				//DB::unprepared("SET IDENTITY_INSERT check_voucher ON");
				$check_voucher_values['cv_no'] = ($yr*10000)+1;
				DB::table('check_voucher')->insert($check_voucher_values);
				$check_voucher = $check_voucher_values['cv_no'];
				//DB::unprepared("SET IDENTITY_INSERT check_voucher OFF");
			}else{
				$check_voucher_values['cv_no'] = $max+1;
				DB::table('check_voucher')->insert($check_voucher_values);
				$check_voucher = $check_voucher_values['cv_no'];
			}
			if(request()->attachment){
				$av= $check_voucher.'_cv.'.request()->attachment->getClientOriginalExtension();
				DB::table('check_voucher')->where('cv_no', $check_voucher)->update(['attachment'=> $av]);
				$request->attachment->storeAs('attachments',$av);
			}
			foreach($row['cv_entries'] as $cv_entry){
				$cv_entry['id'] = $check_voucher;
				$arr = array_combine(Schema::getColumnListing('cv_entries'), Schema::getColumnListing('cv_entries'));
				$cv_entry_values = array_intersect_key($cv_entry, $arr);
				DB::table('cv_entries')->insert($cv_entry_values);
			}
			return redirect()->route('check_voucher.index', ['id' => $check_voucher]);
		}else{
			return new Response(view('unauthorized')->with('role', 'Authorized person'));
		}
	}
	
	public function view($id){
		if(Auth()->User()->access_rights()->check_voucher_view){ 
			$check_voucher = DB::table('check_voucher')
				->where('check_voucher.cv_no', $id)
				->get()->first();
				//echo json_encode($check_voucher);
				
			$cv_entries = DB::table('cv_entries')
				->join('chart_of_accounts', 'cv_entries.account_code', 'chart_of_accounts.account_code')
				->select('cv_entries.*', 'chart_of_accounts.account_title')
				->where('cv_entries.id', $id)
				->get();
				//echo json_encode($cv_entries);
			$signatories = DB::table('signatories')->get();
			return view('check_voucher.view')->with(['check_voucher' => json_decode(json_encode($check_voucher), true),'cv_entries' =>  json_decode(json_encode($cv_entries), true),'signatories' =>  json_decode(json_encode($signatories), true)]);
		}else{
			return new Response(view('unauthorized')->with('role', 'Authorized person'));
		}
	}
	
	public function edit($id){
		if(Auth()->User()->access_rights()->check_voucher_edit){
			$check_voucher = DB::table('check_voucher')->where('cv_no', $id);
			$cv_entries = DB::table('cv_entries')->where('id', $id)->get();
			$columns = DB::select(DB::raw('EXEC sp_columns check_voucher'));
			$chart_of_accounts = DB::table('chart_of_accounts')->select('account_code', 'account_title')->get();
			//echo json_encode($cv_entries);
			return view('check_voucher.edit')->with(['page_title'=> 'Edit in CV', 'check_voucher' => json_decode(json_encode($check_voucher->first()), true), 'columns' => $columns, 'chart_of_accounts' => $chart_of_accounts, 'cv_entries' => json_decode(json_encode($cv_entries),true)]);
		}else{
			return new Response(view('unauthorized')->with('role', 'Authorized person'));
		}
	}
	
	public function update(Request $request, $id){
		if(Auth()->User()->access_rights()->check_voucher_edit){
			$row = [];
			foreach($_REQUEST as $k => $v){
				if($k === '_token' or $v === ''){
					continue;
				}
				$row[$k] = $v;
				echo $k . '=>' . json_encode($v) . '<br>';
			}
			$arr = array_combine(Schema::getColumnListing('check_voucher'), Schema::getColumnListing('check_voucher'));
			$row['updated_at']= \Carbon\Carbon::now('Asia/Manila');
			$check_voucher_values = array_intersect_key($row, $arr);
			if(!(DB::table('check_voucher')->where('cv_no', $check_voucher_values['cv_no'])->first()) or $id == $check_voucher_values['cv_no']){
				$check_voucher = DB::table('check_voucher')->where('cv_no', $id)->update($check_voucher_values);
				DB::table('cv_entries')->where('id', $check_voucher_values['cv_no'])->delete();
				foreach($row['cv_entries'] as $cv_entry){
					$cv_entry['id'] = $check_voucher_values['cv_no'];
					$arr = array_combine(Schema::getColumnListing('cv_entries'), Schema::getColumnListing('cv_entries'));
					$cv_entry_values = array_intersect_key($cv_entry, $arr);
					DB::table('cv_entries')->insert($cv_entry_values);
				}
				if(request()->attachment){
					$av= $id.'_cv.'.request()->attachment->getClientOriginalExtension();
					DB::table('check_voucher')->where('cv_no', $id)->update(['attachment'=> $av]);
					$request->attachment->storeAs('attachments',$av);
				}
				return redirect()->route('check_voucher.index', ['id' => $id]);
			}else{
				return back()->with('fail','CV No already exists');
			}
		}else{
			return new Response(view('unauthorized')->with('role', 'Authorized person'));
		}
	}
	
	public function delete($id){
		if(Auth()->User()->access_rights()->coa_delete){
			$check_voucher = DB::table('check_voucher')->where('cv_no', $id);
			if($check_voucher->first()){
				$check_voucher->delete();
			}
			$cv_entries = DB::table('cv_entries')->where('cv_entries.id', $id)->delete();
			
			return redirect()->route('check_voucher.index');
		}else{
			return new Response(view('unauthorized')->with('role', 'Authorized person'));
		}
	}
	
	public function general_summary_of_accounts(){
		if(Auth()->User()->access_rights()->coa_view){
			$gen_summary_of_accounts = DB::table('summary_of_accounts')
							 ->groupBy(['gen_account_code', 'gen_accounts_title'])
							 ->where('gen_account_code', '!=', '')
							 ->select(['gen_account_code as account_code', 'gen_accounts_title as account_title', DB::raw('SUM(debit) as [debit]'), DB::raw('SUM(credit) as [credit]')])
							 ->get();
			return view('check_voucher.general_summary_of_accounts')->with(['page_title'=> 'General Ledger Summary', 'summary_of_accounts' => $gen_summary_of_accounts]);
		}else{
			return new Response(view('unauthorized')->with('role', 'Authorized person'));
		}
	}
	
	public function sub_summary_of_accounts(){
		if(Auth()->User()->access_rights()->coa_view){
			$sub_summary_of_accounts = DB::table('summary_of_accounts')
							 ->groupBy(['sub_group', 'sub_group_title'])
							 ->where('sub_group', '!=', '')
							 ->select(['sub_group as account_code', 'sub_group_title as account_title', DB::raw('SUM(debit) as [debit]'), DB::raw('SUM(credit) as [credit]')])
							 ->get();
			return view('check_voucher.general_summary_of_accounts')->with(['page_title'=> 'Subsidiary Ledger Summary', 'summary_of_accounts' => $sub_summary_of_accounts]);
		}else{
			return new Response(view('unauthorized')->with('role', 'Authorized person'));
		}
	}
	
	public function sub_sub_summary_of_accounts(){
		if(Auth()->User()->access_rights()->coa_view){
			$sub_summary_of_accounts = DB::table('summary_of_accounts')
							 ->whereRaw('account_code LIKE \'%-%-%\'')
							 ->groupBy(['account_code', 'account_title'])
							 ->select(['account_code', 'account_title', DB::raw('SUM(debit) as [debit]'), DB::raw('SUM(credit) as [credit]')])
							 ->get();
			return view('check_voucher.general_summary_of_accounts')->with(['page_title'=> 'Sub-Subsidiary Ledger Summary', 'summary_of_accounts' => $sub_summary_of_accounts]);
		}else{
			return new Response(view('unauthorized')->with('role', 'Authorized person'));
		}
	}
	
	public function remove_attachment($id){
		if(Auth()->User()->access_rights()->coa_delete){
			$check_voucher = DB::table('check_voucher')->where('cv_no', $id)->update(['attachment' => null]);
			return redirect()->route('check_voucher.view', ['id' => $id]);
		}else{
			return new Response(view('unauthorized')->with('role', 'Authorized person'));
		}
	}
}
