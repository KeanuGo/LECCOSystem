@extends('layouts.app')

@section('content')
<div class="container">
	@include('partials.filter_bar')
	<br>
	<table class="table table-striped" id="main-table">
		<tr>
			@if(count($payroll_deductions) > 0)
				@foreach($payroll_deductions[0] as $k => $v)
					<th>{{ ucwords(str_replace('_', ' ', $k)) }}</th>
				@endforeach
				<th class="no-print">Actions</th>
			@else
				<th> Empty </th>
			@endif
		</tr>
		@foreach($payroll_deductions as $payroll_deduction)
			<tr>
			@foreach($payroll_deduction as $k => $v)
				@if(strpos($k, 'month') !== false and strpos($k, 'year') !== false and strpos($k, 'applied') !== false)
					<td>{{ \Carbon\Carbon::parse($v)->format('F Y') }}</td>
					@continue;
				@endif
				<td> {{ ucwords(str_replace('_', ' ', $v)) }} </td>
			@endforeach
			<td no-search class="no-print">
				<a href="{{ route('loans.viewschedule', ['id' => $payroll_deduction->payroll, 'id2' => $payroll_deduction->month_year_applied]) }}" class="link-tag view-a">View</a>
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