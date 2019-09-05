@extends('layouts.app')

@section('content')
<div align="center">
<h1 style='width:90%;text-align:left;' >
@if(isset($page_title))
	{{ $page_title }}
@else
	Check Voucher
@endif
</h1>
</div>
<div class="container">
	@include('partials.filter_bar')
	<table class="table table-striped" id="main-table">
		<tr>
			@if($summary_of_accounts->first())
				@foreach($summary_of_accounts->first() as $k => $v)
					@if(strpos($k, 'id') !== false)
						@continue;
					@endif	
					<th>{{ ucwords(str_replace('_', ' ', $k)) }}</th>
				@endforeach
			@else
				<th> Empty </th>
			@endif
		</tr>
		@foreach($summary_of_accounts as $cv)
			<tr>
			@foreach($cv as $k => $v)
				@if(strpos($k, 'id') !== false)
					@continue;
				@endif
				<td> {{ $v }} </td>
			@endforeach
			</tr>
		@endforeach
	</table>
	<!--<div>
		@if(Auth::User()->access_rights()->coa_create)
			<a href="{{ route('check_voucher.create') }}" class="link-tag add-a"> Add CV </a>
		@endif
	</div>-->
</div>
@endsection