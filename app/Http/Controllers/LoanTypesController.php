<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class LoanTypesController extends Controller
{
    public function index(){
		if(Auth()->User()->access_rights()->loans_types_view){
			$loan_types = DB::table('loan_types')->select('id', 'name', 'interest_per_annum')->get();
			return view('loan_types.index')->with(['page_title'=> 'Loan Types', 'loan_types' => $loan_types]);
		}else{
			return new Response(view('unauthorized')->with('role', 'Authorized person'));
		}
	}
	
	public function create(){
		if(Auth()->User()->access_rights()->loans_types_create){
			$columns = DB::select(DB::raw('EXEC sp_columns loan_types'));
			return view('loan_types.create')->with(['page_title'=> 'Add Loan Type', 'columns' => $columns]);
		}else{
			return new Response(view('unauthorized')->with('role', 'Authorized person'));
		}
	}
	
	public function store(){
		if(Auth()->User()->access_rights()->loans_types_create){
			$row = [];
			foreach($_REQUEST as $k => $v){
				if($k === '_token'){
					continue;
				}
				$row[$k] = $v;
				echo $k . '=>' . $v . '<br>';
			}
			$row['created_at'] = \Carbon\Carbon::now('Asia/Manila');
			$row['updated_at'] = \Carbon\Carbon::now('Asia/Manila');
			$arr = array_combine(Schema::getColumnListing('loan_types'), Schema::getColumnListing('loan_types'));
			$loan_types_values = array_intersect_key($row, $arr);
			$loan_type = DB::table('loan_types')->insertGetId($loan_types_values);
			return redirect()->route('loan_types.view', ['id' => $loan_type]);
		}else{
			return new Response(view('unauthorized')->with('role', 'Authorized person'));
		}
	}
	
	public function view($id){
		if(Auth()->User()->access_rights()->loans_types_view){
			$loan_type = DB::table('loan_types')->where('id', $id);
			return view('loan_types.view')->with(['page_title'=> 'Loan Type', 'loan_type' => json_decode(json_encode($loan_type->first()), true)]);
		}else{
			return new Response(view('unauthorized')->with('role', 'Authorized person'));
		}
	}
	
	public function edit($id){
		if(Auth()->User()->access_rights()->loans_types_edit){
			$loan_type = DB::table('loan_types')->where('id', $id);
			$columns = DB::select(DB::raw('EXEC sp_columns loan_types'));
			return view('loan_types.edit')->with(['page_title'=> 'Edit Loan Type', 'loan_type' => json_decode(json_encode($loan_type->first()), true), 'columns' => $columns]);
		}else{
			return new Response(view('unauthorized')->with('role', 'Authorized person'));
		}
	}
	
	public function update($id){
		if(Auth()->User()->access_rights()->loans_types_edit){
			$row = [];
			foreach($_REQUEST as $k => $v){
				if($k === '_token' or $k == 'id'){
					continue;
				}
				$row[$k] = $v;
				echo $k . '=>' . $v . '<br>';
			}
			$row['updated_at'] = \Carbon\Carbon::now('Asia/Manila');
			$arr = array_combine(Schema::getColumnListing('loan_types'), Schema::getColumnListing('loan_types'));
			$access_rights_values = array_intersect_key($row, $arr);
			$member = DB::table('loan_types')->where('id', $id)->update($access_rights_values);
			return redirect()->route('loan_types.view', ['id' => $id]);
		}else{
			return new Response(view('unauthorized')->with('role', 'Authorized person'));
		}
	}
	
	public function delete($id){
		if(Auth()->User()->access_rights()->loans_types_delete){
			$member = DB::table('loan_types')->where('id', $id);
			if($member->first()){
				$member->delete();
			}
			return redirect()->route('loan_types.index');
		}else{
			return new Response(view('unauthorized')->with('role', 'Authorized person'));
		}
	}
}
