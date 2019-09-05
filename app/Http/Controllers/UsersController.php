<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Auth;
class UsersController extends Controller
{
	protected function validator(array $data)
    {
        return Validator::make($data, [
            'password' => 'required|string|min:6|confirmed',
        ]);
    }
	public function profile()
    {
        $user = Auth::user();
        return view('profile',compact('user',$user));
    }
	
	public function update_avatar(Request $request){
 
        $request->validate([
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
 
        $user = Auth::user();
 
		$avatarName = $user->id.'user.'.request()->avatar->getClientOriginalExtension();
 
        $request->avatar->storeAs('avatars',$avatarName);
 
        $user->avatar = $avatarName;
        $user->save();
 
        return back()
            ->with('success','You have successfully upload image.');
 
    }
	
    public function index(){
		if(Auth()->User()->access_rights()->users_view){
			$users = DB::table('users')->select('avatar', 'id', 'name', 'email')->get();
			return view('users.index')->with(['page_title'=> 'Users', 'users' => $users]);
		}else{
			return new Response(view('unauthorized')->with('role', 'Authorized person'));
		}
	}
	
	public function view_rights(Request $request, $id){
		if(Auth()->User()->access_rights()->users_view){
			$access_rights = DB::table('access_rights')->where('user_id', $id);
			$columns = DB::select(DB::raw('EXEC sp_columns access_rights'));
			return view('users.view_rights')->with(['page_title'=> 'Access Rights','access_rights' => json_decode(json_encode($access_rights->first()), true), 'columns' => $columns]);
		}else{
			return new Response(view('unauthorized')->with('role', 'Authorized person'));
		}
	}
	
	public function update_rights($id){
		if(Auth()->User()->access_rights()->invoke_rights){
			$row = [];
			foreach($_REQUEST as $k => $v){
				if($k === '_token'){
					continue;
				}
				$row[$k] = $v;
				echo $k . '=>' . $v . '<br>';
			}
			$arr = array_combine(Schema::getColumnListing('access_rights'), Schema::getColumnListing('access_rights'));
			$access_rights_values = array_intersect_key($row, $arr);
			foreach($arr as $key){
				if(strpos($key, 'id') !== false){
					continue;
				}
				if(!array_key_exists($key, $access_rights_values)){
					$access_rights_values[$key] = false;
				}
			}
			DB::table('access_rights')->where('user_id', $id)->update($access_rights_values);
			return redirect()->route('users.view_rights', ['id' => $id]);
		}else{
			return new Response(view('unauthorized')->with('role', 'Authorized person'));
		}
	}
	
	public function delete($id){
		if(Auth()->User()->access_rights()->invoke_rights){
			
			DB::table('access_rights')->where('user_id', $id)->delete();
			DB::table('users')->where('id', $id)->delete();
			return redirect()->route('users.index', ['id' => $id]);
		}else{
			return new Response(view('unauthorized')->with('role', 'Authorized person'));
		}
	}
}
