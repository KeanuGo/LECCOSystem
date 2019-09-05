@extends('layouts.app')

@section('content')
<div align="center">
<h1 style='width:90%;text-align:left;' >Loans</h1>
</div>
<div class="container">
	@include('partials.filter_bar')
	<table class="table table-striped" id='main-table'>
		<tr>
			@if($loans->first())
				@foreach($loans->first() as $k => $v)
					<th>{{ ucwords(str_replace('_', ' ', $k)) }}</th>
				@endforeach
				<th class="no-print">Actions</th>
			@else
				<th> Empty </th>
			@endif
		</tr>
		@foreach($loans as $loan)
			<tr>
			@foreach($loan as $k => $v)
				<td> {{ $v }} </td>
			@endforeach
			<td no-search class="no-print">
			@if(Auth::User()->access_rights()->loans_view)
				<a href="{{ route('loans.view', ['id' => $loan->id]) }}" class="link-tag view-a">View</a>
			@endif
			@if(Auth::User()->access_rights()->loans_delete)
				<a href="{{ route('loans.delete', ['id' => $loan->id]) }}" class="link-tag delete-a">Delete</a>
			@endif
			</td>
			</tr>
		@endforeach
	</table>
	<div class="no-print">
		@if(Auth::User()->access_rights()->loans_create)
			<a href="{{ route('loans.create') }}" class="link-tag add-a"> Add Loan </a>
			
		@endif
		@if(Auth::User()->access_rights()->loans_view)
			<a href="{{ route('loans.view_aging_loans') }}" class="link-tag view-a"> View Aging Loans </a>
			<a href="{{ route('loans.lpds') }}" class="link-tag view-a">Loans Payment Deduction Schedule </a>
		@endif
	</div>
</div>
@endsection