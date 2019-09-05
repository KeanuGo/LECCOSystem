@extends('layouts.app')

@section('content')
<div align="center">
<h1 style='width:90%;text-align:left;' >Aging Loans</h1>
</div>
<div class="container">
	<div class="no-print" align="left">
		{!! Form::open(['url' => route('loans.view_aging_loans'), 'method' => 'GET']); !!}
		<label for="late_by">Late by</label>
		<input type="number" name="late_by_amount" step="1" value={{$late_by_amount}} style="max-width:50px;">
		<input type="radio" name="late_by" value="DAY" style="margin-right:10px;margin-left:10px"
		@if($late_by == 'DAY')
		{{ 'checked' }}
		@endif
		>Day/s
		<input type="radio" name="late_by" value="MONTH" style="margin-right:10px;margin-left:10px"
		@if($late_by == 'MONTH')
		{{ 'checked' }}
		@endif
		>Month/s
		<input type="radio" name="late_by" value="YEAR" style="margin-right:10px;margin-left:10px"
		@if($late_by == 'YEAR')
		{{ 'checked' }}
		@endif
		>Year/s
		&nbsp&nbsp{{ Form::submit('Filter', array('class' => 'btn btn-primary')) }}
		<a href="{{ route('loans.view_aging_loans') }}" class="link-tag view-a">Clear Filter</a>
		<br><br>
	</div>
	@include('partials.filter_bar')
	<br>
	<table class="table table-striped" id='main-table'>
		<tr>
			@if($loans->first())
				@foreach($loans->first() as $k => $v)
					<th>{{ ucwords(str_replace('_', ' ', $k)) }}</th>
				@endforeach
				<th>Actions</th>
			@else
				<th> Empty </th>
			@endif
		</tr>
		@foreach($loans as $loan)
			<tr>
			@foreach($loan as $k => $v)
				<td> {{ $v }} </td>
			@endforeach
			<td no-search>
			@if(Auth::User()->access_rights()->loans_view)
				<a href="{{ route('loans.view', ['id' => $loan->id]) }}" class="link-tag view-a">View</a>
			@endif
			</td>
			</tr>
		@endforeach
	</table>
</div>
<script>
	function search(){
		var searchbar = document.getElementById("searchbar");
		var tosearch = searchbar.value.toLowerCase();
		var table = document.getElementById("main-table");
		if(table && searchbar){
			var rows = table.rows;
			for(var i = 1; i < rows.length; i++){
				var cells = rows[i].cells;
				var includes = false;
				for(var j = 0; j < cells.length; j++){
					if(cells[j].innerHTML.toLowerCase().includes(tosearch) && !cells[j].hasAttribute("no-search")){
						includes = true;
						break;
					}
				}
				if(includes){
					rows[i].style.display = 'table-row';
				}else{
					rows[i].style.display = 'none';
				}
			}
		}
	}
</script>
@endsection