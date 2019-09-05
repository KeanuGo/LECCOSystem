@extends('layouts.app')

@section('content')
<div align="center">
	<label style="font-size: 20px">Check Disbursement Journal</label>
</div>

<div class="container">
	<div class="no-print" align="center">
		{!! Form::open(['url' => route('check_voucher.index'), 'method' => 'GET']); !!}
		<input type="radio" name="date" value="date_disbursed" style="margin-right:10px;margin-left:10px" checked>Disbursement Date
		<input type="radio" name="date" value="created_at" style="margin-right:10px;margin-left:10px">Created At
		<input type="radio" name="date" value="updated_at" style="margin-right:10px;margin-left:10px">Updated At
		&nbsp&nbsp&nbsp&nbsp&nbsp From: &nbsp&nbsp{{ Form::date('from', \Carbon\Carbon::now()) }}
		&nbsp&nbsp&nbsp&nbsp&nbsp To: &nbsp&nbsp{{ Form::date('to', \Carbon\Carbon::now()) }}
		&nbsp&nbsp{{ Form::submit('Filter', array('class' => 'btn btn-primary')) }}
		<a href="{{ route('check_voucher.index') }}" class="link-tag view-a">Clear Filter</a>
		<br><br>
	</div>
	<input type="text" id="date_field" name="first" style="display:none" value="0">
	@foreach($check_voucher as $cv)
		<script>
			var months= [ "January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
			var div_month = new Date(@json($cv->date_disbursed)).getMonth();
			var div_year = new Date(@json($cv->date_disbursed)).getYear()+1900;
			var m = months[div_month];
			var prev_date = document.getElementById("date_field");
						
			var prev_month = new Date(prev_date.value).getMonth();
			var prev_year = new Date(prev_date.value).getYear()+1900;
			var prev_m = months[prev_month];
			
			if(prev_date.value == 0) {
				prev_date.setAttribute('value', "00-00-00");
			}else{
				prev_date.setAttribute('value', @json($cv->date_disbursed));
			}
			
			if(prev_m != m || div_year != prev_year) {
				@if($cv->date_disbursed)
					document.write("<div align='center'><label style='font-size:20px'>" + m + " " + div_year + "</label></div>");
				@else
					document.write("<div align='center'><label style='font-size:20px'>No Disbursement Date</label></div>");
				@endif
			}
			prev_date.setAttribute('value', @json($cv->date_disbursed));
			
		</script>
		
		<div style="border: 2px solid black; border-radius: 20px;margin-bottom:1px;padding: 10px" class="no-break">	
			
			<table class="table2 table-striped" id="main-table">
				<tr>
					@if($check_voucher->first())
						@foreach($check_voucher->first() as $k => $v )
							@if(strpos($k, 'id') !== false or strpos($k, 'description') !== false)
								@continue;
							@endif	
							<td><strong>{{ ucwords(str_replace('_', ' ', $k)) }}</strong></td>
							
							<td><span class="values">&nbsp&nbsp&nbsp{{ $cv->$k }}&nbsp&nbsp&nbsp</span></td>
						@endforeach
						
					@else
						<th> Empty </th>
					@endif
				</tr>
				<tr>
					<td><strong> Description </strong></td>
					<td colspan="7"> {{$cv->description}} </td>
				</tr>
				<tr><td colspan="8"><hr style="border: 1px solid black; margin:10px"></td></tr>
				<tr>
				@foreach($cv_entries->first() as $k => $v)
					@if(strpos($k, 'account') === false and strpos($k, 'debit') === false and strpos($k, 'credit') === false)
						@continue;
					@endif
					<th colspan="2">{{ ucwords(str_replace('_', ' ', $k)) }}</th>
				@endforeach
				</tr>
				@foreach($cv_entries as $cv_ent)
				@if($cv_ent->id === $cv->cv_no)
				<tr>
					@foreach($cv_ent as $k => $v)
					@if(strpos($k, 'account') === false and strpos($k, 'debit') === false and strpos($k, 'credit') === false)
						@continue;
					@endif
					<td colspan="2"> {{ $v }} </td>
				@endforeach
				</tr>
				@endif
				@endforeach
				<tr class="no-print">
				<th colspan="2">Actions</th>
				<td no-search colspan="8" class="no-print">
				@if(Auth::User()->access_rights()->check_voucher_view)
					<a href="{{ route('check_voucher.view', ['id' => $cv->cv_no]) }}" class="link-tag view-a"> View</a>
				@endif
				@if(Auth::User()->access_rights()->check_voucher_edit)
					<a href="{{ route('check_voucher.edit', ['id' => $cv->cv_no]) }}" class="link-tag edit-a"> Edit</a>
				@endif
				@if(Auth::User()->access_rights()->check_voucher_delete)
					<a href="{{ route('check_voucher.delete', ['id' => $cv->cv_no]) }}" class="link-tag delete-a"> Delete</a>
				@endif
				</td>
				</tr>
			</table>
		</div>
	@endforeach
	<br>
	<div class="no-print">
		@if(Auth::User()->access_rights()->coa_create)
			<a href="{{ route('check_voucher.create') }}" class="link-tag add-a"> Add CV </a>
		@endif
		@if(Auth::User()->access_rights()->check_voucher_view)
			<a href="{{ route('check_voucher.general_summary_of_accounts') }}" class="link-tag view-a">General Ledger Summary</a>
			<a href="{{ route('check_voucher.sub_summary_of_accounts') }}" class="link-tag view-a">Subsidiary Ledger Summary</a>
			<a href="{{ route('check_voucher.sub_sub_summary_of_accounts') }}" class="link-tag view-a">Sub-Subsidiary Ledger Summary</a>
		@endif
	</div>
</div>
@endsection