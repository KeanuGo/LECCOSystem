<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class SignatoriesController extends Controller
{
    public function index(){
		if(Auth()->User()->access_rights()->signatories_view){
			$signatories = DB::table('signatories')->select('id','name', 'designation')->get();
			return view('signatories.index')->with(['page_title'=> 'Signatories','signatories' => $signatories]);
		}else{
			return new Response(view('unauthorized')->with('role', 'Authorized person'));
		}
	}
	
	public function create(){
		if(Auth()->User()->access_rights()->signatories_create){
			$columns = DB::select(DB::raw('EXEC sp_columns signatories'));
			return view('signatories.create')->with(['page_title'=> 'Add Signatories', 'columns' => $columns]);
		}else{
			return new Response(view('unauthorized')->with('role', 'Authorized person'));
		}
	}
	
	public function store(){
		if(Auth()->User()->access_rights()->signatories_create){
			$row = [];
			foreach($_REQUEST as $k => $v){
				if($k === '_token'){
					continue;
				}
				$row[$k] = $v;
				echo $k . '=>' . $v . '<br>';
			}
			$arr = array_combine(Schema::getColumnListing('signatories'), Schema::getColumnListing('signatories'));
			$signatories_values = array_intersect_key($row, $arr);
			$signatories = DB::table('signatories')->insertGetId($signatories_values);
			return redirect()->route('signatories.index', ['id' => $signatories]);
		}else{
			return new Response(view('unauthorized')->with('role', 'Authorized person'));
		}
	}
	
	public function edit($id){
		if(Auth()->User()->access_rights()->signatories_edit){
			$signatories = DB::table('signatories')->where('id', $id);
			$columns = DB::select(DB::raw('EXEC sp_columns signatories'));
			return view('signatories.edit')->with(['page_title'=> 'Edit Signatories', 'signatories' => json_decode(json_encode($signatories->first()), true), 'columns' => $columns]);
		}else{
			return new Response(view('unauthorized')->with('role', 'Authorized person'));
		}
	}
	
	public function update($id){
		if(Auth()->User()->access_rights()->signatories_edit){
			$row = [];
			foreach($_REQUEST as $k => $v){
				if($k === '_token' or $k == 'id'){
					continue;
				}
				$row[$k] = $v;
				echo $k . '=>' . $v . '<br>';
			}
			$row['updated_at'] = \Carbon\Carbon::now('Asia/Manila');
			$arr = array_combine(Schema::getColumnListing('signatories'), Schema::getColumnListing('signatories'));
			$access_rights_values = array_intersect_key($row, $arr);
			$member = DB::table('signatories')->where('id', $id)->update($access_rights_values);
			return redirect()->route('signatories.index', ['id' => $id]);
		}else{
			return new Response(view('unauthorized')->with('role', 'Authorized person'));
		}
	}
	
	public function delete($id){
		if(Auth()->User()->access_rights()->signatories_delete){
			$member = DB::table('signatories')->where('id', $id);
			if($member->first()){
				$member->delete();
			}
			return redirect()->route('signatories.index');
		}else{
			return new Response(view('unauthorized')->with('role', 'Authorized person'));
		}
	}
}
