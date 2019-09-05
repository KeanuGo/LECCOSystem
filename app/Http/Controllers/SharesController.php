<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Http\Request;

class SharesController extends Controller
{
    //
	
	public function index(){
		if(Auth()->User()->access_rights()->shares_view){
			$shares = DB::table('shares')->join('members', 'members.id', 'shares.member_id')->select('shares.id', 'members.first_name', 'members.last_name',  'shares.total', 'shares.amount', 'shares.price')->get();
			return view('shares.index')->with(['page_title'=> 'Shares', 'shares' => $shares]);
		}else{
			return new Response(view('unauthorized')->with('role', 'Authorized person'));
		}
	}
	
	public function view($id){
		if(Auth()->User()->access_rights()->shares_view){
			//$shares = DB::table('shares')->join('members', 'members.id', 'shares.member_id')->select('shares.id', 'members.first_name', 'members.last_name',  'shares.total', 'shares.amount', 'shares.price')->where('members.id',$id)->get();
			$shares = DB::table('shares')->select(DB::raw('MONTH(shares.created_at) as month, YEAR(shares.created_at) as year, sum(total) as total_no_shares, sum(price) as total_price, sum(amount) as total_amount'))->where('shares.member_id', $id)->orderBy('Month', 'asc', 'Year', 'asc')->groupBy(DB::raw("MONTH(shares.created_at)"), DB::raw("YEAR(shares.created_at)"))->get();
			$total_ns= $shares->sum('total_no_shares');
			$total_p= $shares->sum('total_price');
			$total_a= $shares->sum('total_amount');
			$totals = array($total_ns, $total_p, $total_a);
			$member = DB::table('members')->where('id', $id);
			return view('shares.view')->with(['page_title'=> 'Member Shares', 'shares' => $shares, 'totals' => $totals, 'member' => $member->first()]);
		}else{
			return new Response(view('unauthorized')->with('role', 'Authorized person'));
		}
	}
	
	public function create(){
		if(Auth()->User()->access_rights()->shares_create){
			$columns = DB::select(DB::raw('EXEC sp_columns shares'));
			$_members = DB::table('members')->select('id', 'first_name', 'last_name')->get();
			$members = [];
			foreach($_members as $member){
				$members[$member->id] = $member->first_name . ' ' . $member->last_name;
			}
			
			return view('shares.create')->with(['page_title'=> 'Add Shares Transaction', 'columns' => $columns, 'members' => $members]);
		}else{
			return new Response(view('unauthorized')->with('role', 'Authorized person'));
		}
	}
	
	public function store(Request $request){
		if(Auth()->User()->access_rights()->shares_create){
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
			$arr = array_combine(Schema::getColumnListing('shares'), Schema::getColumnListing('shares'));
			$access_rights_values = array_intersect_key($row, $arr);
			$share = DB::table('shares')->insertGetId($access_rights_values);
			return redirect()->route('shares.index');
		}else{
			return new Response(view('unauthorized')->with('role', 'Authorized person'));
		}
	}
}
