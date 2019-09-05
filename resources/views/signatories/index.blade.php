@extends('layouts.app')

@section('content')
<div align="center">
<h1 style='width:90%;text-align:left;' >Signatories</h1>
</div>
<div class="container">
	@include('partials.filter_bar')
	<table class="table table-striped" id="main-table">
		<tr>
			@if($signatories->first())
				@foreach($signatories->first() as $k => $v)
					@if(strpos($k, 'id') !== false)
						@continue;
					@endif	
					<th>{{ ucwords(str_replace('_', ' ', $k)) }}</th>
				@endforeach
				<th class="no-print">Actions</th>
			@else
				<th> Empty </th>
			@endif
		</tr>
		@foreach($signatories as $signatory)
			<tr>
			@foreach($signatory as $k => $v)
				@if(strpos($k, 'id') !== false)
					@continue;
				@endif
				<td> {{ $v }} </td>
			@endforeach
			<td no-search class="no-print">
			@if(Auth::User()->access_rights()->coa_edit)
				<a href="{{ route('signatories.edit', ['id' => $signatory->id]) }}" class="link-tag edit-a"> Edit</a>
			@endif
			@if(Auth::User()->access_rights()->coa_delete)
				<a href="{{ route('signatories.delete', ['id' => $signatory->id]) }}" class="link-tag delete-a"> Delete</a>
			@endif
			</td>
			</tr>
		@endforeach
	</table>
	<div class="no-print">
		@if(Auth::User()->access_rights()->coa_create)
			<a href="{{ route('signatories.create') }}" class="link-tag add-a"> Add Signatory </a>
		@endif
	</div>
</div>
@endsection