<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ChartofAccountsController extends Controller
{
	public function index(){
		if(Auth()->User()->access_rights()->coa_view){
			$columns = DB::select(DB::raw('EXEC sp_columns chart_of_accounts'));
			$coa = DB::table('chart_of_accounts')->select('id','account_code', 'account_title')->get();
			return view('coa.index')->with(['page_title'=> 'Chart of Accounts', 'coa' => $coa, 'columns' => $columns]);
		}else{
			return new Response(view('unauthorized')->with('role', 'Authorized person'));
		}
	}
	
	public function create(){
		if(Auth()->User()->access_rights()->coa_create){
			$columns = DB::select(DB::raw('EXEC sp_columns chart_of_accounts'));
			return view('coa.create')->with(['page_title'=> 'Add in Chart of Accounts', 'columns' => $columns]);
		}else{
			return new Response(view('unauthorized')->with('role', 'Authorized person'));
		}
	}
	
	public function store(){
		if(Auth()->User()->access_rights()->coa_create){
			$row = [];
			foreach($_REQUEST as $k => $v){
				if($k === '_token'){
					continue;
				}
				$row[$k] = $v;
				echo $k . '=>' . $v . '<br>';
			}
			$arr = array_combine(Schema::getColumnListing('chart_of_accounts'), Schema::getColumnListing('chart_of_accounts'));
			$coa_values = array_intersect_key($row, $arr);
			$coa = DB::table('chart_of_accounts')->insertGetId($coa_values);
			return redirect()->route('coa.index', ['id' => $coa]);
		}else{
			return new Response(view('unauthorized')->with('role', 'Authorized person'));
		}
	}
	
	public function edit($id){
		if(Auth()->User()->access_rights()->coa_edit){
			$coa = DB::table('chart_of_accounts')->where('id', $id);
			$columns = DB::select(DB::raw('EXEC sp_columns chart_of_accounts'));
			return view('coa.edit')->with(['page_title'=> 'Edit in Chart of Accounts', 'coa' => json_decode(json_encode($coa->first()), true), 'columns' => $columns]);
		}else{
			return new Response(view('unauthorized')->with('role', 'Authorized person'));
		}
	}
	
	public function update($id){
		if(Auth()->User()->access_rights()->coa_edit){
			$row = [];
			foreach($_REQUEST as $k => $v){
				if($k === '_token' or $k == 'id'){
					continue;
				}
				$row[$k] = $v;
				echo $k . '=>' . $v . '<br>';
			}
			$row['updated_at'] = \Carbon\Carbon::now('Asia/Manila');
			$arr = array_combine(Schema::getColumnListing('chart_of_accounts'), Schema::getColumnListing('chart_of_accounts'));
			$access_rights_values = array_intersect_key($row, $arr);
			$member = DB::table('chart_of_accounts')->where('id', $id)->update($access_rights_values);
			return redirect()->route('coa.index', ['id' => $id]);
		}else{
			return new Response(view('unauthorized')->with('role', 'Authorized person'));
		}
	}
	
	public function delete($id){
		if(Auth()->User()->access_rights()->coa_delete){
			$member = DB::table('chart_of_accounts')->where('id', $id);
			if($member->first()){
				$member->delete();
			}
			return redirect()->route('coa.index');
		}else{
			return new Response(view('unauthorized')->with('role', 'Authorized person'));
		}
	}
}
