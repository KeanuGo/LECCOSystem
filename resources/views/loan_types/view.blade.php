@extends('layouts.app')

@section('content')
<div align="center">
<h1 style='width:90%;text-align:left;' >Loan Types</h1>
</div>
<div class="container">
	<table class="table table-striped">
		@foreach($loan_type as $k => $v)
			@if(strpos($k, 'created_at') !== false or strpos($k, 'updated_at') !== false)
				@continue;
			@endif
			<tr>
				@if($k == 'id')
					<th>Loan Type ID</th>
				@else
					<th>{{ ucwords(str_replace('_', ' ', $k)) }}</th>
				@endif
				<td>{{ $v }}</td>
			</tr>
		@endforeach
	</table>
	<hr>
	<div class="no-print">
		@if(Auth::User()->access_rights()->loans_types_edit)
			<a href="{{ route('loan_types.edit', ['id' => $loan_type['id']]) }}" class="link-tag edit-a"> Edit</a>
		@endif
		@if(Auth::User()->access_rights()->loans_types_delete)
			<a href="{{ route('loan_types.delete', ['id' => $loan_type['id']]) }}" class="link-tag delete-a"> Delete</a>
		@endif
		@if(Auth::User()->access_rights()->loans_view)
			<a href="{{ route('loan_types.index') }}" class="link-tag view-a"> View All Loan Types </a>
		@endif
	</div>
</div>
@endsection