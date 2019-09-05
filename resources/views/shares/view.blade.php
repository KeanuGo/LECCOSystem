@extends('layouts.app')

@section('content')
<div align="center">
<h1 style='width:90%;text-align:left;' >Shares</h1>
</div>
<div class="container">
	<div align="center">
	<table class="table table-striped" style="width:50%;">
		<tr>
			<th>Member ID</th><td>{{ $member->id }}</td>
		</tr>
		<tr>
			<th>Member Name</th><td>{{ $member->first_name . ' ' . $member->last_name }}</td>
		</tr>
	</table>
	</div>
	<table class="table table-striped">
		<tr>
			@if($shares->first())
				@foreach($shares->first() as $k => $v)
					<th>{{ ucwords(str_replace('_', ' ', $k)) }}</th>
				@endforeach
			@else
				<th> Empty </th>
			@endif
		</tr>
		@foreach($shares as $share)
			<tr>
			@foreach($share as $k => $v)
				@if($k == 'month')
					<td> {{ DateTime::createFromFormat('!m', $v)->format('F') }} </td>
				@else
					<td> {{ $v }} </td>
				@endif
			@endforeach
			
			</tr>
		@endforeach
		<tr>
		<td><strong>Total:</strong></td><td></td>
		@for($i=0; $i<3; $i++)
			
			<td> {{ $totals[$i] }} </td>
			
			
		@endfor
		</tr>
	</table>
</div>
@endsection