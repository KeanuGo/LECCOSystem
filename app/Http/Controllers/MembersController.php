<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class MembersController extends Controller
{
	public function index(){
		if(Auth()->User()->access_rights()->member_view){
			$members = DB::table('members')->select('id', 'first_name', 'last_name')->get();
			return view('members.index')->with(['page_title'=> 'Members', 'members' => $members]);
		}else{
			return new Response(view('unauthorized')->with('role', 'Authorized person'));
		}
	}
	
	public function view($id){
		if(Auth()->User()->access_rights()->member_view){
			$member = DB::table('members')->where('id', $id);
			return view('members.view')->with(['page_title'=> 'Member', 'member' => json_decode(json_encode($member->first()), true)]);
		}else{
			return new Response(view('unauthorized')->with('role', 'Authorized person'));
		}
	}
	
    public function create(){
		if(Auth()->User()->access_rights()->member_create){
			$columns = DB::select(DB::raw('EXEC sp_columns members'));
			return view('members.create')->with(['page_title'=> 'Add Member', 'columns' => $columns]);
		}else{
			return new Response(view('unauthorized')->with('role', 'Authorized person'));
		}
	}
	
	public function store(Request $request){
		if(Auth()->User()->access_rights()->member_create){
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
			if(request()->avatar){
				$row['avatar'] = '_avatar'.time().'.'.request()->avatar->getClientOriginalExtension();
			}else{
				$row['avatar'] = 'user.jpg';
			}
			$arr = array_combine(Schema::getColumnListing('members'), Schema::getColumnListing('members'));
			$access_rights_values = array_intersect_key($row, $arr);
			$member = DB::table('members')->insertGetId($access_rights_values);
			if(request()->avatar){
				$av= $member.'member.'.request()->avatar->getClientOriginalExtension();
				DB::table('members')->where('id', $member)->update(['avatar'=> $av]);
				$request->avatar->storeAs('avatars',$av);
			}
			return redirect()->route('members.index');
		}else{
			return new Response(view('unauthorized')->with('role', 'Authorized person'));
		}
	}
	
	public function edit($id){
		if(Auth()->User()->access_rights()->member_edit){
			$member = DB::table('members')->where('id', $id)->first();
			$columns = DB::select(DB::raw('EXEC sp_columns members'));
			return view('members.edit')->with(['page_title'=> 'Edit Member', 'member' => json_decode(json_encode($member), true), 'columns' => $columns]);
		}else{
			return new Response(view('unauthorized')->with('role', 'Authorized person'));
		}
	}
	
	public function update(Request $request, $id){
		if(Auth()->User()->access_rights()->member_edit){
			$row = [];
			foreach($_REQUEST as $k => $v){
				if($k === '_token' or $k == 'id'){
					continue;
				}
				$row[$k] = $v;
				echo $k . '=>' . $v . '<br>';
			}
			$row['updated_at'] = \Carbon\Carbon::now('Asia/Manila');
			$arr = array_combine(Schema::getColumnListing('members'), Schema::getColumnListing('members'));
			$access_rights_values = array_intersect_key($row, $arr);
			$member = DB::table('members')->where('id', $id)->update($access_rights_values);
			if(request()->avatar){
				$av= $id.'member.'.request()->avatar->getClientOriginalExtension();
				DB::table('members')->where('id', $member)->update(['avatar'=> $av]);
				$request->avatar->storeAs('avatars',$av);
			}
			return redirect()->route('members.index');
		}else{
			return new Response(view('unauthorized')->with('role', 'Authorized person'));
		}
	}
	
	public function delete($id){
		if(Auth()->User()->access_rights()->member_delete){
			$member = DB::table('members')->where('id', $id);
			if($member->first()){
				$member->delete();
			}
			return redirect()->route('members.index');
		}else{
			return new Response(view('unauthorized')->with('role', 'Authorized person'));
		}
	}
}
