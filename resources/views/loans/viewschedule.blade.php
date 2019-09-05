@extends('layouts.app')

@section('content')
<div class="container">
	@include('partials.filter_bar')
	<br>
	<table class="table table-striped" id="main-table">
		@if(count($scheds)>0)
			<tr><th colspan="{{ count($scheds[0]) }}" no-search><h3 style='text-align:center;'>{{ ucwords(str_replace('_', ' ', $payroll)) }} for {{ \Carbon\Carbon::parse($day)->format('F Y') }}</h3></th></tr>
			<tr>
				@foreach($scheds[0] as $k => $v)
					<th no-search>{{ ucwords(str_replace('_', ' ', $k)) }}</th>
				@endforeach
			</tr>
		@else
			<tr><th no-search> Empty </th></tr>
		@endif
		@foreach($scheds as $sched)
			<tr>
			@foreach($sched as $k => $v)
				<td> {{ ($v== null? '0.00' :$v) }} </td>
			@endforeach
			
			</tr>
		@endforeach
	</table>
	<div class="no-print">
		<a href="" onclick="return printDiv()" class="btn btn-default"> Print </a>
		<a href="{{ route('loans.lpds') }}" class="link-tag view-a"> Back </a>
	</div>
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
				var all_no_search = true;
				for(var j = 0; j < cells.length; j++){
					if(tosearch == ""){
						includes = true;
						break;
					}
					if(!cells[j].hasAttribute("no-search")){
						all_no_search = false;
						if(cells[j].innerHTML.toLowerCase().includes(tosearch)){
							includes = true;
							break;
						}
					}
				}
				if(includes || all_no_search){
					rows[i].style.display = 'table-row';
				}else{
					rows[i].style.display = 'none';
				}
			}
		}
	}
	
	function printDiv(){
		var divToPrint = document.getElementById('main-table');
		newWin = window.open("");
		newWin.document.write('<div align="center">');
		newWin.document.write('<table>');
		newWin.document.write('<tr>');
		newWin.document.write('<td>');
		newWin.document.write('<img src="/storage/others/lecco_logo.jpg" style="max-width: 80px; max-height: 80px; margin-right: 0px">');
		newWin.document.write('</td>');
		newWin.document.write('<td style="text-align:center">');
		newWin.document.write('<label>LEYECO II EMPLOYEES CREDIT COOPERATIVE (LECCO)</label>');
		newWin.document.write('<br><label style="font-size:12px">LEYECO II, Real St., Sagkahan, Tacloban City</label>');
		newWin.document.write('</td>');
		newWin.document.write('</tr>');
		newWin.document.write('</table>');
		newWin.document.write('</div>');
		newWin.document.write("<h3 style='text-align:center;'> {{ ucwords(str_replace('_', ' ', $payroll)) }} for {{ \Carbon\Carbon::parse($day)->format('F Y') }} </h3>");
		newWin.document.write("<hr>");
		newWin.document.write("<table border = 1 style='text-align:center;'>");
		var total_per_type = {};
		@if(count($scheds)>0)
			newWin.document.write("<tr>");
			@foreach($scheds[0] as $k => $v)
				newWin.document.write("<th>{{ ucwords(str_replace('_', ' ', $k)) }}</th>");
			@endforeach
			newWin.document.write("<th> Total </th>");
			newWin.document.write("</tr>");
			@foreach($scheds as $sched)
				var total = 0;
				newWin.document.write("<tr>");
				@foreach($sched as $k => $v)
					newWin.document.write("<td> {{ ($v== null? '0.00' :$v) }} </td>");
					@if(!($k == 'member_id' or $k == 'name'))
						total_per_type['{{ $k }}'] = (total_per_type['{{ $k }}'] || 0.0);
						total_per_type['{{ $k }}'] += total_per_type['{{ $k }}'] + Number({{ ($v== null? '0.00' :$v) }});
						total += Number({{ ($v== null? '0.00' :$v) }});
					@endif
				@endforeach
				newWin.document.write("<td>" + total + "</td>");
				newWin.document.write("</tr>");
			@endforeach
		@endif
		newWin.document.write("<th colspan = 2> Totals </td>");
		var total = 0;
		for(var k in total_per_type){
			newWin.document.write("<th>" + total_per_type[k] + "</td>");
			total += total_per_type[k];
		}
		newWin.document.write("<th>" + total + "</td>");
		newWin.document.write("</table>");
		newWin.print();
		newWin.close();
	}
</script>
@endsection