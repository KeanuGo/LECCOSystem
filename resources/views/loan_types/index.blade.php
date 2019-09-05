@extends('layouts.app')

@section('content')
<div align="center">
<h1 style='width:90%;text-align:left;' >Loan Types</h1>
</div>
<div class="container">
	@include('partials.filter_bar')
	<table class="table table-striped" id="main-table">
		<tr>
			@if($loan_types->first())
				@foreach($loan_types->first() as $k => $v)
					<th>{{ ucwords(str_replace('_', ' ', $k)) }}</th>
				@endforeach
				<th class="no-print">Actions</th>
			@else
				<th> Empty </th>
			@endif
		</tr>
		@foreach($loan_types as $loan_type)
			<tr>
			@foreach($loan_type as $k => $v)
				<td> {{ $v }} </td>
			@endforeach
			<td no-search class="no-print">
			@if(Auth::User()->access_rights()->loans_types_view)
				<a href="{{ route('loan_types.view', ['id' => $loan_type->id]) }}" class="link-tag view-a">View</a>
			@endif
			@if(Auth::User()->access_rights()->loans_types_edit)
				<a href="{{ route('loan_types.edit', ['id' => $loan_type->id]) }}" class="link-tag edit-a"> Edit</a>
			@endif
			@if(Auth::User()->access_rights()->loans_types_delete)
				<a href="{{ route('loan_types.delete', ['id' => $loan_type->id]) }}" class="link-tag delete-a"> Delete</a>
			@endif
			</td>
			</tr>
		@endforeach
	</table>
	<div class="no-print">
		@if(Auth::User()->access_rights()->loans_create)
			<a href="{{ route('loan_types.create') }}" class="link-tag add-a"> Add Loan Type </a>
		@endif
	</div>
</div>
@endsection