
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
			@if(Auth::User()->access_rights()->users_view)
				<div class="panel panel-default">
					<div class="panel-heading">Users</div>
					<div class="panel-body">
						@if(Auth::User()->access_rights()->users_view)
							<a href="{{ route('users.index') }}" class="link-tag view-a"> View Users </a>
						@endif
					</div>
				</div>
			@endif
			
			@if(Auth::User()->access_rights()->member_view or
				Auth::User()->access_rights()->member_create )
				<div class="panel panel-default">
					<div class="panel-heading">Members</div>
					<div class="panel-body">
						@if(Auth::User()->access_rights()->member_view)
							<a href="{{ route('members.index') }}" class="link-tag view-a"> View Members </a>
						@endif
						@if(Auth::User()->access_rights()->member_create)
							<a href="{{ route('members.create') }}" class="link-tag add-a"> Add Member </a>
						@endif
					</div>
				</div>
			@endif
			
			@if(Auth::User()->access_rights()->loans_view or
				Auth::User()->access_rights()->loans_create )
				<div class="panel panel-default">
					<div class="panel-heading">Loans</div>
					<div class="panel-body">
						@if(Auth::User()->access_rights()->loans_view)
							<a href="{{ route('loans.index') }}" class="link-tag view-a"> View Loans </a>
						@endif
						@if(Auth::User()->access_rights()->loans_create)
							<a href="{{ route('loans.create') }}" class="link-tag add-a"> Add Loan </a>
						@endif
					</div>
				</div>
			@endif
			
			@if(Auth::User()->access_rights()->loans_view or
				Auth::User()->access_rights()->loans_create )
				<div class="panel panel-default">
					<div class="panel-heading">Loan Types</div>
					<div class="panel-body">
						@if(Auth::User()->access_rights()->loans_view)
							<a href="{{ route('loan_types.index') }}" class="link-tag view-a"> View Loan Types </a>
						@endif
						@if(Auth::User()->access_rights()->loans_create)
							<a href="{{ route('loan_types.create') }}" class="link-tag add-a"> Add Loan Type </a>
						@endif
					</div>
				</div>
			@endif
			
			@if(Auth::User()->access_rights()->shares_view or
				Auth::User()->access_rights()->shares_create )
				<div class="panel panel-default">
					<div class="panel-heading">Shares</div>
					<div class="panel-body">
						@if(Auth::User()->access_rights()->shares_view)
							<a href="{{ route('shares.index') }}" class="link-tag view-a"> View Shares </a>
						@endif
						@if(Auth::User()->access_rights()->shares_create)
							<a href="{{ route('shares.create') }}" class="link-tag add-a">Add Shares</a>
						@endif
					</div>
				</div>
			@endif
			
			@if(Auth::User()->access_rights()->coa_view or
				Auth::User()->access_rights()->coa_create )
				<div class="panel panel-default">
					<div class="panel-heading">Chart of Accounts</div>
					<div class="panel-body">
						@if(Auth::User()->access_rights()->coa_view)
							<a href="{{ route('coa.index') }}" class="link-tag view-a"> View Chart </a>
						@endif
						@if(Auth::User()->access_rights()->coa_create)
							<a href="{{ route('coa.create') }}" class="link-tag add-a">Add Item</a>
						@endif
					</div>
				</div>
			@endif
			
			@if(Auth::User()->access_rights()->signatories_view or
				Auth::User()->access_rights()->signatories_create )
				<div class="panel panel-default">
					<div class="panel-heading">Signatories</div>
					<div class="panel-body">
						@if(Auth::User()->access_rights()->signatories_view)
							<a href="{{ route('signatories.index') }}" class="link-tag view-a"> View Signatories </a>
						@endif
						@if(Auth::User()->access_rights()->signatories_create)
							<a href="{{ route('signatories.create') }}" class="link-tag add-a">Add Signatory</a>
						@endif
					</div>
				</div>
			@endif
			
			@if(Auth::User()->access_rights()->check_voucher_view or
				Auth::User()->access_rights()->check_voucher_create )
				<div class="panel panel-default">
					<div class="panel-heading">Check Voucher</div>
					<div class="panel-body">
						@if(Auth::User()->access_rights()->check_voucher_view)
							<a href="{{ route('check_voucher.index') }}" class="link-tag view-a"> View Check Voucher </a>
						@endif
						@if(Auth::User()->access_rights()->check_voucher_create)
							<a href="{{ route('check_voucher.create') }}" class="link-tag add-a">Add Check Voucher</a>
						@endif
					</div>
				</div>
			@endif
        </div>
        </div>
    </div>
</div>
@endsection
