@extends('layouts.app')

@section('content')
<div align="center">
<h1 style='width:90%;text-align:left;' >Shares</h1>
</div>
<div class="container">
	@include('partials.filter_bar')
	<table class="table table-striped" id="main-table">
		<tr>
			@if($shares->first())
				@foreach($shares->first() as $k => $v)
					<th>{{ ucwords(str_replace('_', ' ', $k)) }}</th>
				@endforeach
				<th class="no-print">Actions</th>
			@else
				<th> Empty </th>
			@endif
		</tr>
		@foreach($shares as $share)
			<tr>
			@foreach($share as $k => $v)
				<td> {{ $v }} </td>
			@endforeach
			
			</tr>
		@endforeach
	</table>
	<div class="no-print">
		@if(Auth::User()->access_rights()->shares_create)
			<a href="{{ route('shares.create') }}" class="link-tag add-a"> Add Shares </a>
		@endif
	</div>
</div>
@endsection