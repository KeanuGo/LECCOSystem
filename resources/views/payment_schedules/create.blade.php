@extends('layouts.app')

@section('content')
<div align="center">
<h1 style='width:90%;text-align:left;' >Payment Schedule</h1>
</div>
<div class="container">
	<div class="row">
	{!! Form::open(['url' => route('loans.store'), 'id'=>'add_loans_form']); !!}
	<!--<form action="{{route('loans.store')}}" id="add_loans_form" method="POST">-->
		<input type="hidden" value="{{csrf_token()}}" form="add_loans_form">
		<table>
		<tr><td colspan =2><h3>Loan</h3></td></tr>
		@foreach($loans_values as $k => $v)
			<tr>
			<td>{{ ucwords(str_replace('_', ' ', $k)) }}</td>
			<td>{{ Form::text("loans_values[$k]", json_decode(json_encode($v),true), ['readonly' => '']) }}</td>
			</tr>
		@endforeach
		<tr><td colspan=2><h3>Payrolls</h3></td></tr>
		@foreach($payrolls_values as $k => $v)
			<tr>
			<td>
			@if($k == 'others')
				{{ ucwords(str_replace('_', ' ', $k)) .' : '. (json_encode($v)) }}
			@else
				{{ ucwords(str_replace('_', ' ', $k)) }}
			@endif
			</td>
			<td>
			{{ Form::hidden("payrolls_values[$k]", json_encode($v), ['readonly' => '', 'payroll_checkbox' => '']) }}
			</td>
			</tr>
		@endforeach
		</table>
		{{ Form::submit('Add', array('class' => 'btn btn-primary')) }}
	</form>
	</div>
	<div id='payments_schedule_table'></div>
</div>
<script>
	calculateTotalInterest();
	generatePaymentApplied();
	
	function calculateTotalInterest()
	{
		var principal = Number(document.getElementsByName('loans_values[amount]')[0].value);
		var years = ((document.getElementsByName('loans_values[term]')[0].value))/12.0;
		var apr = Number(document.getElementsByName('loans_values[interest_per_annum]')[0].value);
		var total_interest = 0.0;
		var periodic_payment = monthly(principal, years, apr);
		payments = years * 12;
		monthlyinterest = apr/12;
		monthlypayment = monthly(principal, years, apr);

		for(i = 1; i <= payments; i++)
		{
			interestpayment= principal * monthlyinterest;
			total_interest += interestpayment;

			principalpayment = monthlypayment - interestpayment;
		
			
			principal = principal - principalpayment;

		}
	}
	
	function generatePaymentApplied(){
		//var table = document.getElementById('payment_schedule_table');
		//if(table){
			var principal = Number(document.getElementsByName('loans_values[amount]')[0].value);
			var years = ((document.getElementsByName('loans_values[term]')[0].value))/12.0;
			var apr = Number(document.getElementsByName('loans_values[interest_per_annum]')[0].value);
			var count= 0;
			//alert(principal + ", " + years + ", " + apr);
			var pded=[
				@foreach($payrolls_values as $k => $v)
					@if($k == 'others')
						@foreach($v as $k)
							'{{ $k }}',
						@endforeach
						@continue;
					@endif
					'{{ $k }}',
				@endforeach
			];
			count = pded.length;
			//alert(pded);
			//alert(count);
			
			
			monthlyamortization1(principal, years,apr, count,pded);
		//}
	}
	
	function monthlyamortization1(principal, years, apr, count, pded)
	{
		var is_fixed = 1;
		var total_interest = 0.0;
		var total_periodic = 0.0;
		var total_principal = 0.0;
		var periodic_payment = monthly(principal, years, apr);
		var name = document.getElementsByName('loans_values[member_id]')[0];
		var start_of_payment = document.getElementsByName('loans_values[start_of_payment]')[0];
		var loan_type = document.getElementsByName('loans_values[loan_type]')[0];
		if(name && loan_type && start_of_payment){
			name = name.value;
			loan_type = loan_type.value;
			start_of_payment = start_of_payment.value;
			start_of_payment = new Date(start_of_payment);
		}
		payments = years * 12;
		monthlyinterest = apr/12;
		monthlypayment = monthly(principal, years, apr);
		
		if(is_fixed){
			total_interest = (apr*years)*principal;
			static_interest = total_interest/payments;
			monthlypayment = (total_interest+principal)/payments;
			periodic_payment = monthlypayment;
			total_interest = 0;
		}
		
		document.write("<div class='container'>");
		document.write("<table width='80%' border=1 align='center'>");

		document.write("<tr>");
		document.write("<th colspan=6 style='text-align:center'>");
		document.write("" + numberWithCommas(roundtopennies(principal)));
		document.write(" at " + roundtopennies2(apr)  + "% Interest per annum");
		document.write("  Term: " + Number(years)*12 + " months<br>");
		document.write("Monthly payment: " + numberWithCommas(roundtopennies(monthlypayment/count)));
		document.write("</th>");
		document.write("</tr>");

		document.write("<tr>");
		//document.write("<th></th>");
		document.write("<th colspan=6><center>Payment Applied</center></th>");
		document.write("</tr>")	;

		var or_periodic_payment= periodic_payment;
		var or_interestpayment= interestpayment;
		var or_principalpayment= principalpayment;
		var or_principal= principal;
		var pr= [];
		for(j = 1; j <= count; j++){
			var payment_day = start_of_payment;
			document.write("<tr>");
		//document.write("<th></th>");
			document.write("<th colspan=6  style='background-color: #87faed;'><center>"+pded[j-1]+"</center></th>");
			document.write("</tr>")	;
			document.write("<tr>");
			//document.write("<th></th>");
			document.write("<th width=100 style='text-align:center'>No</th>");
			document.write("<th width=100 style='text-align:center'>Month/Yr Applied</th>");
			document.write("<th width=100 style='text-align:center'>Periodic Payment</th>");
			document.write("<th width=100 style='text-align:center'>Interest</th>");
			document.write("<th width=100 style='text-align:center'>Principal</th>");
			document.write("<th width=100 style='text-align:center'>Balance</th>");
			document.write("<tr>");
			for(i = 1; i <= payments; i++)
			{
				
		
				document.write("<tr>");
				document.write("<td width=100 align='center'>" + i + "</td>");
				document.write("<td width=100 align='center'><input type='date' style='border:0;text-align:center;' value='"+ dateValue(payment_day) +"' form='add_loans_form' name='payment_schedule[" + pded[j-1]+ "]["+i+"][expected_date_of_payment]' autofocus></td>");
				payment_day = nextMonth(payment_day);
				document.write("<td width=100 align='center'><input type='text' style='border:0;text-align:center;' value='" + numberWithCommas(roundtopennies(periodic_payment/count)) + "' form='add_loans_form' name='payment_schedule[" + pded[j-1]+ "]["+i+"][periodic_payment]' readonly></td>");
				total_periodic += Number(periodic_payment);

				if(is_fixed){
					interestpayment= static_interest;
				}else{
					interestpayment= principal * monthlyinterest;
				}
				
				total_interest += Number(interestpayment);
				document.write("<td width=100 align='center'>" + numberWithCommas(roundtopennies(interestpayment/count)) + "</td>");

				principalpayment = monthlypayment - interestpayment;
				document.write("<td width=100 align='center'>" + numberWithCommas(roundtopennies(principalpayment/count)) + "</td>");
			
				if(j!=1){
					principal = principal - (((j-1)*principalpayment)/count);
				}
				document.write("<td width=100 align='center'>" + numberWithCommas(roundtopennies(principal)) + "</td>");
				
				if(j==1){
					principal = principal - principalpayment;
					pr.push(principal);
				}else{
					principal= pr[i-1];
				}
				total_principal += Number(principalpayment);

				//document.write("<td>");
			}
			
			document.write("<tr>");
			document.write("<th width=100 style='text-align:center'>Total:</th>");
			document.write("<th width=100 style='text-align:center'></th>");
			document.write("<th width=100 style='text-align:center'>"+ numberWithCommas(roundtopennies(total_periodic/count)) +"</th>");
			document.write("<th width=100 style='text-align:center'>"+ numberWithCommas(roundtopennies(total_interest/count)) +"</th>");
			document.write("<th width=100 style='text-align:center'>"+ numberWithCommas(roundtopennies(total_principal/count)) +"</th>");
			document.write("<th width=100 style='text-align:center'></th>");
			document.write("</tr>");
			
			
			
			periodic_payment= or_periodic_payment;
			interestpayment= or_interestpayment;
			principalpayment= or_principalpayment;
			principal= or_principal;
			total_periodic= 0.0;
			total_interest= 0.0;
			total_principal= 0.0;
		}
		document.write('</div>');
	}
	
	function formatDate(date) {
	  var monthNames = [
		"January", "February", "March",
		"April", "May", "June", "July",
		"August", "September", "October",
		"November", "December"
	  ];

	  var day = date.getDate();
	  var monthIndex = date.getMonth();
	  var year = date.getFullYear();

	  return  monthNames[monthIndex] + ' ' + day + ', ' + year;
	}
	
	function nextMonth(date){
		next_month = new Date(date.getFullYear(), date.getMonth()+1, date.getDate());
		if(next_month.getDate() != date.getDate()){
			return ((new Date(next_month.getFullYear(), next_month.getMonth(), 0)));
		}else{
			return (next_month);
		}
	}
	
	function dateValue(date){
		var year = date.getFullYear();
		var month = date.getMonth()+1;
		var day = date.getDate();
		return year + "-" + (month<10?"0"+month:month) + "-" + (day<10?"0"+day:day);
	}
	
	function numberWithCommas(n) {
		var parts=n.toString().split(".");
		return parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",") + (parts[1] ? "." + parts[1] : "");
	}
	
	function monthly(principal, years, apr)
	{
		rate = apr/12;
		payments = years * 12;
		
		return principal * rate / (1 - (1/Math.pow(1 + rate, payments)));

	}
	
	function roundtopennies(n)
	{
		pennies = n * 100;
		
		pennies = Math.round(pennies);
		strPennies = "" + pennies;
		len = strPennies.length;
		
		return (pennies/100);
	}
	function roundtopennies2(n)
	{
		pennies = n * 10000;
		
		pennies = Math.round(pennies);

		strPennies = "" + pennies;
		len = strPennies.length;

		return strPennies.substring(0, len - 2)  + "." + strPennies.substring(len-2, len);

	}
	
	function switchyrs(form)
	{
		form.years.value = eval((form.months.value)/12)
	}
</script>
@endsection