@extends('layouts.app')

@section('content')
<div align="center">
<h1 style='width:90%;text-align:left;' >Loans</h1>
</div>
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Add Loan</div>
				{!! Form::open(['url' => route('payment_schedule.create'), 'method' => 'get', 'id' => 'add_loan_form', 'onsubmit' => 'generatePaymentSchedule()']); !!}
                <div class="panel-body">
				<table class='table table-striped'>
                        {{ csrf_field() }}
						@foreach($columns as $column)
						<tr>
							@if($column->COLUMN_NAME == 'id' or strpos($column->COLUMN_NAME, 'created_at') !== false or strpos($column->COLUMN_NAME, 'updated_at') !== false)
								@continue;
							@elseif(strpos($column->COLUMN_NAME, 'member') !== false and strpos($column->COLUMN_NAME, 'id') !== false)
								<td>
									{{ Form::label($column->COLUMN_NAME, 'Member', array('class' => 'col-md-4 control-label')) }}
									<div class="col-md-6">
										{{ Form::select($column->COLUMN_NAME, $members, null, array('class' => 'form-control', 'required' => '')) }}
									</div>
								</td>
								@continue;
							@elseif(strpos($column->COLUMN_NAME, 'loan') !== false and strpos($column->COLUMN_NAME, 'type') !== false)
								<td>
									{{ Form::label($column->COLUMN_NAME, ucwords(str_replace('_', ' ', $column->COLUMN_NAME)), array('class' => 'col-md-4 control-label')) }}
									<div class="col-md-6">
										{{ Form::select($column->COLUMN_NAME, $loan_types, null, array('class' => 'form-control', 'required' => '', 'onchange' => 'loanTypeChanged()')) }}
									</div>
								</td>
								@continue;
							@endif
							<!--<div class="form-group">-->
								<td colspan="2">
								{{ Form::label($column->COLUMN_NAME, ucwords(str_replace('_', ' ', $column->COLUMN_NAME)), array('class' => 'col-md-4 control-label')) }}
								
								<div class="col-md-6">
									@if(strpos($column->COLUMN_NAME, 'avatar') !== false)
										{{ Form::text($column->COLUMN_NAME, 'FILECHOOSER HERE', array('class' => 'form-control', 'required' => '')) }}
									@elseif($column->COLUMN_NAME === 'total_interest' or $column->COLUMN_NAME === 'total_loan_receivable')
										{{ Form::number($column->COLUMN_NAME, null, array('class' => 'form-control', 'step' => '0.01', 'readonly' => '')) }}
									@elseif($column->COLUMN_NAME === 'amount' or $column->COLUMN_NAME === 'interest_per_annum' or $column->COLUMN_NAME === 'term')
										@if($column->NULLABLE == 1)
											{{ Form::number($column->COLUMN_NAME, null, array('class' => 'form-control', 'step' => '0.01', 'oninput' => 'calculate_everything()')) }}
										@else
											{{ Form::number($column->COLUMN_NAME, null, array('class' => 'form-control', 'step' => '0.01', 'required' => '', 'oninput' => 'calculate_everything()')) }}
										@endif
									@elseif(strpos($column->TYPE_NAME, 'date') !== false)
										@if($column->NULLABLE == 1)
											{{ Form::date($column->COLUMN_NAME, \Carbon\Carbon::now(), array('class' => 'form-control')) }}
										@else
											{{ Form::date($column->COLUMN_NAME, \Carbon\Carbon::now(), array('class' => 'form-control', 'required' => '')) }}
										@endif
									@elseif(strpos($column->TYPE_NAME, 'int') !== false)
										@if($column->NULLABLE == 1)
											{{ Form::number($column->COLUMN_NAME, null, array('class' => 'form-control')) }}
										@else
											{{ Form::number($column->COLUMN_NAME, null, array('class' => 'form-control')) }}
										@endif
									@elseif(strpos($column->TYPE_NAME, 'money') !== false or strpos($column->TYPE_NAME, 'decimal') !== false)
										@if($column->NULLABLE == 1)
											{{ Form::number($column->COLUMN_NAME, null, array('class' => 'form-control', 'step' => '0.01')) }}
										@else
											{{ Form::number($column->COLUMN_NAME, null, array('class' => 'form-control', 'step' => '0.01', 'required' => '')) }}
										@endif
									@elseif(strpos($column->TYPE_NAME, 'real') !== false)
										@if($column->NULLABLE == 1)
											{{ Form::number($column->COLUMN_NAME, null, array('class' => 'form-control', 'step' => 'any')) }}
										@else
											{{ Form::number($column->COLUMN_NAME, null, array('class' => 'form-control', 'step' => 'any', 'required' => '')) }}
										@endif
									@elseif(strpos($column->TYPE_NAME, 'float') !== false)
										@if($column->NULLABLE == 1)
											{{ Form::number($column->COLUMN_NAME, null, array('class' => 'form-control', 'step' => 'any')) }}
										@else
											{{ Form::number($column->COLUMN_NAME, null, array('class' => 'form-control', 'step' => 'any', 'required' => '')) }}
										@endif
									@elseif(strpos($column->TYPE_NAME, 'binary') !== false)
										@if($column->NULLABLE == 1)
											{{ Form::number($column->COLUMN_NAME, null, array('class' => 'form-control', 'step' => 'any')) }}
										@else
											{{ Form::number($column->COLUMN_NAME, null, array('class' => 'form-control', 'step' => 'any', 'required' => '')) }}
										@endif
									@else
										@if($column->NULLABLE == 1)
											{{ Form::text($column->COLUMN_NAME, '', array('class' => 'form-control' )) }}
										@else
											{{ Form::text($column->COLUMN_NAME, '', array('class' => 'form-control', 'required' => '')) }}
										@endif
									@endif
								</div>
								</td>
							<!--</div>-->
						</tr>
						@endforeach
						<tr><td>
						<div class="form-group">
							<h4 class="col-md-6" style="width:100%;">Loan Payment Deduction:</h4>
						</div>
						</td></tr>
						@foreach($payrolls as $column)
							@if(strpos($column->TYPE_NAME, 'bit') !== false)
								<tr>
								<td>
								<!--<div class="form-group">-->
									{{ Form::label($column->COLUMN_NAME, ucwords(str_replace('_', ' ', $column->COLUMN_NAME)), array('class' => 'col-md-4 control-label')) }}
									<div class="col-md-6">
										@if($column->NULLABLE == 1)
											{{ Form::checkbox($column->COLUMN_NAME, 1, false, array('class' => 'form-control', 'payroll_checkbox' => '')) }}
										@else
											{{ Form::checkbox($column->COLUMN_NAME, 1, false, array('class' => 'form-control', 'payroll_checkbox' => '')) }}
										@endif
									</div>
								<!--</div>-->
								</td>
								</tr>
							@endif
						@endforeach
						<tr>
						<td>
						<div class="col-md-6">
						<input type="text" id="row_count_field" name="row_count_field" style="display:none">
						<input type="text" id="doc_info_length_field" name="doc_info_length_field" style="display:none">
						
						<table id="additional_doc_info_table">
							<thead>
							<th>Others</th>
							</thead>
							<tbody>
								<tr>
								<td colspan="2" align="center"><input type="button" id="button2" name="add_doc_info" value="Specify" onclick="add_doc_info_function()" class="btn"></td>
								<tr>
							</tbody>
						</table>
						</div>
						</td>
						</tr>
						<tr>
							<td align="center">
							<div>
								<button type="button" onclick="calculatePaymentSchedule()" formaction="" class="btn">View Payments</button>
								<button type="button" onclick="generatePaymentApplied()" formaction="" class ="btn">Payment Applied</button>
							</div>
							</td>
						</tr>
						<tr>
						<!--<div class="form-group">-->
							<td colspan="2">
                            <div class="col-md-8 col-md-offset-4">
                                {{ Form::submit('Add', array('class' => 'btn btn-primary')) }}
								<a class="btn btn-default btn-close" href="{{ url()->previous() }}">Cancel</a>
                            </div>
							</td>
                        <!--</div>-->
						</tr>
				</table>
                </div>
				{{ Form::close() }}
            </div>
        </div>
    </div>
</div>
<script>
	var row_count = 0;
	var doc_info_length = 0;
	function add_doc_info_function(){
		//alert("here1");
		var doc_info_table = document.getElementById("additional_doc_info_table");
		var new_row = doc_info_table.insertRow(row_count+1);
		var cell1 = new_row.insertCell(0);
		
		var cell3 = new_row.insertCell(1);
		//var cell4 = new_row.insertCell(0);
		cell1.innerHTML = "<input type='text' name='others[" + String(row_count) + "]' id='attributeNo" + String(row_count) + "' placeholder='others["+ String(row_count) + "]' class='form-control' size='80' payroll_checkbox='' checked required>";
		cell3.innerHTML = "<input type='button' name='remove" + String(row_count) + "' id='remove" + String(row_count) + "' value='X' onclick='remove_doc_info(this)' class ='btn'>";
		//cell4.innerHTML = "Row " + String(row_count);
		row_count++;
		var row_count_field = document.getElementById("row_count_field");
		row_count_field.setAttribute("value", row_count);
	}
	function remove_doc_info(input){
		var doc_info_table = document.getElementById("additional_doc_info_table");
		var name = input.getAttribute("name");
		//window.alert("Trying to find '" + name + "'" + String(row_count));
		for(var i = doc_info_length; i < row_count; i++){
			var row = document.getElementById("remove"+String(i));
			//window.alert("Iterate" + String(i) + ". Comparing: " + name + ", " + row.getAttribute("name"));
			if(!(name.localeCompare(row.getAttribute("name")))){
				//window.alert("Removing row " + i + ", Row count = " + row_count);
				for(var j = i; j < row_count-1; j++){
					var attribType = document.getElementById("attributeNo" + String(j+1));
					attribType.setAttribute("name", "others[" + String(j) + "]");
					attribType.setAttribute("id", "attributeNo" + String(j) + "");
					attribType.setAttribute("placeholder", "others[" + String(j) + "]");
					
					var removeButton = document.getElementById("remove" + String(j+1));
					removeButton.setAttribute("name", "remove" + String(j));
					removeButton.setAttribute("id", "remove" + String(j));
				}
				doc_info_table.deleteRow(i+1);
				row_count--;
				var row_count_field = document.getElementById("row_count_field");
				row_count_field.setAttribute("value", row_count);
				//window.alert("Removed row " + i + ", New row count = " + row_count);
				break;
			}
		}
	}
</script>
<script>
	var loan_types_interest = {
		@foreach($loan_types_interest as $k => $v)
			'{{ $k }}' : {{ $v }},
		@endforeach
	};
	loanTypeChanged();

	function calculate_everything(){
		/*var amount_field = document.getElementById('amount');
		var interest_per_annum_field = document.getElementById('interest_per_annum');
		var total_interest_field = document.getElementById('total_interest');
		var total_loan_receivable_field = document.getElementById('total_loan_receivable');
		var term_field = document.getElementById('term');
		
		var amount = Number(amount_field.value);
		var interest_per_annum = Number(interest_per_annum_field.value);
		var term = Number(term_field.value);*/
		calculateTotalInterest();
		//alert(amount + ', ' + interest_per_annum + ', ' + term);
	}
	
	function loanTypeChanged(){
		var interest_per_annum_field = document.getElementById('interest_per_annum');
		var loan_types_field = document.getElementById('loan_type');
		if(interest_per_annum_field && loan_types_field){
			interest_per_annum_field.setAttribute('value', loan_types_interest[loan_types_field.value]);
			interest_per_annum_field.value = loan_types_interest[loan_types_field.value];
		}
	}
	
	function calculateTotalInterest()
	{
		var is_fixed = true;
		var principal = Number(document.getElementById('amount').value);
		var amount = Number(principal);
		var years = ((document.getElementById('term').value))/12.0;
		var apr = Number(document.getElementById('interest_per_annum').value);
		var total_interest = 0.0;
		var periodic_payment = monthly(principal, years, apr);
		payments = years * 12;
		monthlyinterest = apr/12;
		monthlypayment = monthly(principal, years, apr);
		if(is_fixed){
			total_interest = (apr*years)*principal;
		}else{
			for(i = 1; i <= payments; i++)
			{
				interestpayment= principal * monthlyinterest;
				total_interest += interestpayment;

				principalpayment = monthlypayment - interestpayment;
				principal = principal - principalpayment;

			}

		}		
		var total_interest_field = document.getElementById('total_interest');
		if(total_interest_field){
			total_interest_field.value = roundtopennies(total_interest);
			total_interest_field.setAttribute('value', roundtopennies(total_interest));
		}
		var total_loan_receivable_field = document.getElementById('total_loan_receivable');
		if(total_loan_receivable_field){
			var total_loan_receivable = Number(total_interest) + Number(amount);
			total_loan_receivable_field.value = roundtopennies(total_loan_receivable);
			total_loan_receivable_field.setAttribute('value', roundtopennies(total_loan_receivable));
		}
	}
	
	function calculatePaymentSchedule(){
		//var table = document.getElementById('payment_schedule_table');
		//if(table){
			var principal = Number(document.getElementById('amount').value);
			var years = ((document.getElementById('term').value))/12.0;
			var apr = Number(document.getElementById('interest_per_annum').value);
			//alert(principal + ", " + years + ", " + apr);
			monthlyamortization(principal, years,apr);
		//}
	}
	
	function monthlyamortization(principal, years, apr)
	{
		var is_fixed = true;
		var fixed_interest = 1;
		var total_interest = 0.0;
		var total_periodic = 0.0;
		var total_principal = 0.0;
		var popnewwindow = window.open('','popwindow','width=430,height=400,scrollbars=yes,resizable=yes');
		var periodic_payment = monthly(principal, years, apr);
		var name = document.getElementById('member_id');
		var start_of_payment = document.getElementById('start_of_payment');
		var loan_type = document.getElementById('loan_type');
		if(name && loan_type && start_of_payment){
			name = name.options[name.selectedIndex].text;
			loan_type = loan_type.value;
			start_of_payment = start_of_payment.value;
			start_of_payment = new Date(start_of_payment);
		}
		var payment_day = start_of_payment;
		popnewwindow.opener.focus();
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
		
		//popnewwindow.document.open();
		popnewwindow.document.write("<html><head><title>Amortization Schedule</title></head>");
		popnewwindow.document.write("<center><h3>Amortization Schedule</h3><hr>");
		
		popnewwindow.document.write("<div style='width:80%'>");
		popnewwindow.document.write("<h3 align='left'>");
		popnewwindow.document.write("Name: " + name + "<br>");
		popnewwindow.document.write("Loan Type: " + loan_type + "<br>");
		popnewwindow.document.write("Start of Payment: " + formatDate(start_of_payment) + "<br>");
		popnewwindow.document.write("</h3>");
		popnewwindow.document.write("</div>");
		
		popnewwindow.document.write("<table width='80%' border=1>");
		popnewwindow.document.write("<tr>");
		popnewwindow.document.write("<th colspan=6>");
		popnewwindow.document.write("" + numberWithCommas(roundtopennies(principal)));
		popnewwindow.document.write(" at " + roundtopennies2(apr)  + "% Interest per annum");
		popnewwindow.document.write("  Term: " + Number(years)*12 + " months<br>");
		popnewwindow.document.write("Monthly payment: " + numberWithCommas(roundtopennies(monthlypayment)));
		popnewwindow.document.write("</th>");
		popnewwindow.document.write("</tr>");

		popnewwindow.document.write("<tr>");
		//popnewwindow.document.write("<th></th>");
		popnewwindow.document.write("<th colspan=6><center>Amortization Schedule</center></th>");
		popnewwindow.document.write("</tr>")	;

		popnewwindow.document.write("<tr>");
		//popnewwindow.document.write("<th></th>");
		popnewwindow.document.write("<th width=100>No</th>");
		popnewwindow.document.write("<th width=100>Month/Yr Applied</th>");
		popnewwindow.document.write("<th width=100>Periodic Payment</th>");
		popnewwindow.document.write("<th width=100>Interest</th>");
		popnewwindow.document.write("<th width=100>Principal</th>");
		popnewwindow.document.write("<th width=100>Balance</th>");
		popnewwindow.document.write("<tr>");

		for(i = 1; i <= payments; i++)
		{
			popnewwindow.document.write("<tr>");
			popnewwindow.document.write("<td width=100 align='center'>" + i + "</td>");
			
			popnewwindow.document.write("<td width=100 align='center'><input type='date' style='border:0;text-align:center;' value='"+ dateValue(payment_day) + "' readonly></td>");
			popnewwindow.document.write("<td width=100 align='center'>" + numberWithCommas(roundtopennies(periodic_payment)) + "</td>");
			total_periodic += Number(periodic_payment);
			payment_day = nextMonth(payment_day);
			
			if(is_fixed){
				interestpayment= static_interest;
			}else{
				interestpayment= principal * monthlyinterest;
			}
			total_interest += Number(interestpayment);
			popnewwindow.document.write("<td width=100 align='center'>" + numberWithCommas(roundtopennies(interestpayment)) + "</td>");

			principalpayment = monthlypayment - interestpayment;
			popnewwindow.document.write("<td width=100 align='center'>" + numberWithCommas(roundtopennies(principalpayment)) + "</td>");
		
			popnewwindow.document.write("<td width=100 align='center'>" + numberWithCommas(roundtopennies(principal)) + "</td>");
			
			principal = principal - principalpayment;
			total_principal += Number(principalpayment);

			//popnewwindow.document.write("<td>");
		}
		
		popnewwindow.document.write("<tr>");
		popnewwindow.document.write("<th width=100>Total:</th>");
		popnewwindow.document.write("<th width=100></th>");
		popnewwindow.document.write("<th width=100>"+ numberWithCommas(roundtopennies(total_periodic)) +"</th>");
		popnewwindow.document.write("<th width=100>"+ numberWithCommas(roundtopennies(total_interest)) +"</th>");
		popnewwindow.document.write("<th width=100>"+ numberWithCommas(roundtopennies(total_principal)) +"</th>");
		popnewwindow.document.write("<th width=100></th>");
		popnewwindow.document.write("</tr>");
		
		popnewwindow.document.write("</table> </center></body></html>");
		
		popnewwindow.document.write("<div style='width:100%' align='center'>");
		popnewwindow.document.write("<div style='width:80%' align='center'>");
		popnewwindow.document.write("<table style ='width:100%'>");
		popnewwindow.document.write("<tr>");			
		popnewwindow.document.write("<th align='left'>Processed by:</th>");
		popnewwindow.document.write("<th align='left'>Evaluated by:</th>");
		popnewwindow.document.write("</tr>");
		popnewwindow.document.write("<tr><td colspan ='2' height=20></td></tr>");
		popnewwindow.document.write("<tr>");			
		popnewwindow.document.write("<td align='left'>");
		popnewwindow.document.write("<div style='width:50%' align='center'><input type='text' style='border:0;text-align:center;' placeholder ='Enter name of office staff' autofocus>");
		popnewwindow.document.write("<hr><input type='text' style='border:0;text-align:center;' placeholder ='Enter position of office staff'></div>");
		popnewwindow.document.write("</td>");			
		popnewwindow.document.write("<td align='left'>");
		popnewwindow.document.write("<div style='width:50%' align='center'><input type='text' style='border:0;text-align:center;' placeholder ='Enter name of evaluator'>");
		popnewwindow.document.write("<hr><input type='text' style='border:0;text-align:center;' placeholder ='Enter position of evaluator'></div>");
		popnewwindow.document.write("</td>");			
		popnewwindow.document.write("</tr>");
		popnewwindow.document.write("<tr><td colspan ='2' height=50></td></tr>");
		popnewwindow.document.write("<tr>");			
		popnewwindow.document.write("<th align='left'>Verified by:</th>");
		popnewwindow.document.write("<th align='left'>Approved by:</th>");
		popnewwindow.document.write("</tr>");
		popnewwindow.document.write("<tr><td colspan ='2' height=20></td></tr>");
		popnewwindow.document.write("<tr>");			
		popnewwindow.document.write("<td align='left'>");
		popnewwindow.document.write("<div style='width:50%' align='center'><input type='text' style='border:0;text-align:center;' placeholder ='Enter name of verifier' autofocus>");
		popnewwindow.document.write("<hr><input type='text' style='border:0;text-align:center;' placeholder ='Enter position of verifier'></div>");
		popnewwindow.document.write("</td>");			
		popnewwindow.document.write("<td align='left'>");
		popnewwindow.document.write("<div style='width:50%' align='center'><input type='text' style='border:0;text-align:center;' placeholder ='Enter name of authorizer'>");
		popnewwindow.document.write("<hr><input type='text' style='border:0;text-align:center;' placeholder ='Enter position of authorizer'></div>");
		popnewwindow.document.write("</td>");			
		popnewwindow.document.write("</tr>");
		popnewwindow.document.write("</table>");
		popnewwindow.document.write("</div>");
		popnewwindow.document.write("</div>");
		popnewwindow.document.close();
		popnewwindow.focus();
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
	
	function generatePaymentApplied(){
		//var table = document.getElementById('payment_schedule_table');
		//if(table){
			var principal = Number(document.getElementById('amount').value);
			var years = ((document.getElementById('term').value))/12.0;
			var apr = Number(document.getElementById('interest_per_annum').value);
			var count= 0;
			//alert(principal + ", " + years + ", " + apr);
			var pd = document.querySelectorAll('[payroll_checkbox=""]');
			var pded=[];
			for(var i = 0; i < pd.length; i++){
				if(!pd[i].checked){
					continue;
				}
				count++;
				if(pd[i].type == 'checkbox'){
					pded.push(pd[i].name);
				}else if(pd[i].type == 'text'){
					pded.push(pd[i].value);
				}
			}
			//alert(pded);
			//alert(count);
			
			
			monthlyamortization1(principal, years,apr, count,pded);
		//}
	}
	
	function monthlyamortization1(principal, years, apr, count, pded)
	{
		var is_fixed = true;
		var total_interest = 0.0;
		var total_periodic = 0.0;
		var total_principal = 0.0;
		var popnewwindow = window.open('','popwindow','width=430,height=400,scrollbars=yes,resizable=yes');
		var periodic_payment = monthly(principal, years, apr);
		var name = document.getElementById('member_id');
		var start_of_payment = document.getElementById('start_of_payment');
		var loan_type = document.getElementById('loan_type');
		if(name && loan_type && start_of_payment){
			name = name.options[name.selectedIndex].text;
			loan_type = loan_type.value;
			start_of_payment = start_of_payment.value;
			start_of_payment = new Date(start_of_payment);
		}
		popnewwindow.opener.focus();
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
		
		//popnewwindow.document.open();
		popnewwindow.document.write("<html><head><title>Payment Applied</title></head>");
		popnewwindow.document.write("<center><h3>Payment Applied</h3><hr>");
		
		popnewwindow.document.write("<div style='width:80%'>");
		popnewwindow.document.write("<h3 align='left'>");
		popnewwindow.document.write("Name: " + name + "<br>");
		popnewwindow.document.write("Loan Type: " + loan_type + "<br>");
		popnewwindow.document.write("Start of Payment: " + formatDate(start_of_payment) + "<br>");
		popnewwindow.document.write("</h3>");
		popnewwindow.document.write("</div>");
		
		popnewwindow.document.write("<table width='80%' border=1>");

		popnewwindow.document.write("<tr>");
		popnewwindow.document.write("<th colspan=6>");
		popnewwindow.document.write("" + numberWithCommas(roundtopennies(principal)));
		popnewwindow.document.write(" at " + roundtopennies2(apr)  + "% Interest per annum");
		popnewwindow.document.write("  Term: " + Number(years)*12 + " months<br>");
		popnewwindow.document.write("Monthly payment: " + numberWithCommas(roundtopennies(monthlypayment/count)));
		popnewwindow.document.write("</th>");
		popnewwindow.document.write("</tr>");

		popnewwindow.document.write("<tr>");
		//popnewwindow.document.write("<th></th>");
		popnewwindow.document.write("<th colspan=6><center>Payment Applied</center></th>");
		popnewwindow.document.write("</tr>")	;

		var or_periodic_payment= periodic_payment;
		var or_interestpayment= interestpayment;
		var or_principalpayment= principalpayment;
		var or_principal= principal;
		var pr= [];
		for(j = 1; j <= count; j++){
			var payment_day = start_of_payment;
			popnewwindow.document.write("<tr>");
		//popnewwindow.document.write("<th></th>");
			popnewwindow.document.write("<th colspan=6  style='background-color: #87faed;'><center>"+pded[j-1]+"</center></th>");
			popnewwindow.document.write("</tr>")	;
			popnewwindow.document.write("<tr>");
			//popnewwindow.document.write("<th></th>");
			popnewwindow.document.write("<th width=100>No</th>");
			popnewwindow.document.write("<th width=100>Month/Yr Applied</th>");
			popnewwindow.document.write("<th width=100>Periodic Payment</th>");
			popnewwindow.document.write("<th width=100>Interest</th>");
			popnewwindow.document.write("<th width=100>Principal</th>");
			popnewwindow.document.write("<th width=100>Balance</th>");
			popnewwindow.document.write("<tr>");
			for(i = 1; i <= payments; i++)
			{
				
		
				popnewwindow.document.write("<tr>");
				popnewwindow.document.write("<td width=100 align='center'>" + i + "</td>");
				popnewwindow.document.write("<td width=100 align='center'><input type='date' style='border:0;text-align:center;' value='"+ dateValue(payment_day) +"' autofocus></td>");
				payment_day = nextMonth(payment_day);
				popnewwindow.document.write("<td width=100 align='center'>" + numberWithCommas(roundtopennies(periodic_payment/count)) + "</td>");
				total_periodic += Number(periodic_payment);
				
				if(is_fixed){
					interestpayment= static_interest;
				}else{
					interestpayment= principal * monthlyinterest;
				}
				total_interest += Number(interestpayment);
				popnewwindow.document.write("<td width=100 align='center'>" + numberWithCommas(roundtopennies(interestpayment/count)) + "</td>");

				principalpayment = monthlypayment - interestpayment;
				popnewwindow.document.write("<td width=100 align='center'>" + numberWithCommas(roundtopennies(principalpayment/count)) + "</td>");
			
				if(j!=1){
					principal = principal - (((j-1)*principalpayment)/count);
				}
				popnewwindow.document.write("<td width=100 align='center'>" + numberWithCommas(roundtopennies(principal)) + "</td>");
				
				if(j==1){
					principal = principal - principalpayment;
					pr.push(principal);
				}else{
					principal= pr[i-1];
				}
				total_principal += Number(principalpayment);

				//popnewwindow.document.write("<td>");
			}
			
			popnewwindow.document.write("<tr>");
			popnewwindow.document.write("<th width=100>Total:</th>");
			popnewwindow.document.write("<th width=100></th>");
			popnewwindow.document.write("<th width=100>"+ numberWithCommas(roundtopennies(total_periodic/count)) +"</th>");
			popnewwindow.document.write("<th width=100>"+ numberWithCommas(roundtopennies(total_interest/count)) +"</th>");
			popnewwindow.document.write("<th width=100>"+ numberWithCommas(roundtopennies(total_principal/count)) +"</th>");
			popnewwindow.document.write("<th width=100></th>");
			popnewwindow.document.write("</tr>");
			
			
			
			periodic_payment= or_periodic_payment;
			interestpayment= or_interestpayment;
			principalpayment= or_principalpayment;
			principal= or_principal;
			total_periodic= 0.0;
			total_interest= 0.0;
			total_principal= 0.0;
		}
		popnewwindow.document.close();
		popnewwindow.focus();
	}
</script>
@endsection