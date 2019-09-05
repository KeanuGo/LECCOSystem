@extends('layouts.app')

@section('content')

<div align="center">
<h1 style='width:90%;text-align:left;' >Check Voucher</h1>
</div>
<div class="container">
    <div class="row">
        <div class="col-md-9 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Add Check Voucher</div>
				{!! Form::open(['url' => route('check_voucher.store'),'onsubmit' => 'return checkCVEntries()', 'enctype'=> 'multipart/form-data']); !!}
                <div class="panel-body">
				<table class='table table-striped'>
                        {{ csrf_field() }}
						@foreach($columns as $column)
						<tr>
							@if($column->COLUMN_NAME == 'cv_no' or strpos($column->COLUMN_NAME, 'created_at') !== false or strpos($column->COLUMN_NAME, 'updated_at') !== false)
								@continue;
							@endif
							<!--<div class="form-group">-->
								<td colspan="2">
								{{ Form::label($column->COLUMN_NAME, ucwords(str_replace('_', ' ', $column->COLUMN_NAME)), array('class' => 'col-md-4 control-label')) }}
								
								<div class="col-md-6">
									@if(strpos($column->COLUMN_NAME, 'attachment') !== false)
										<input type="file" class="form-control-file" name="attachment" id="attachmentFile" aria-describedby="fileHelp">
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
						<tr>
						<td colspan="2">
						<div class="col-md-6">
							<input type="text" id="row_count_field" name="row_count_field" style="display:none">
							<p id="cv_entries_status" style="color:red" ></p>
							<table id="additional_doc_info_table">
								<thead>
								<th>Account Title</th><th>Account Code</th><th>Debit</th><th>Credit</th>
								</thead>
								<tbody>
									<tr>
									<td colspan="4" align="center"><br><input type="button" id="button2" name="add_doc_info" value="Add Account" onclick="add_doc_info_function()" class="btn btn-primary"></td>
									<tr>
								</tbody>
							</table>
						</div>
						</td>
						</tr>
						<tr>
						
						<!--<div class="form-group">-->
							<td colspan="2">
                            <div class="col-md-8 col-md-offset-4">
                                {{ Form::submit('Add', array('class' => 'btn btn-primary')) }}
								<a href="{{ url()->previous() }}" class="btn btn-default btn-close"> Cancel </a>
							</td>
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
	<datalist id ="account_codes">
		@foreach($chart_of_accounts as $chart_of_account)
			<option value="{{$chart_of_account->account_code}}">{{$chart_of_account->account_title}}</>
		@endforeach
	</datalist>
</div>
<script type="text/javascript" src="jquery.js"></script>
<script>
	var row_count = 0;
	var doc_info_length = 0;
	function add_doc_info_function(){
		//alert("here1");
		var doc_info_table = document.getElementById("additional_doc_info_table");
		var new_row = doc_info_table.insertRow(row_count+1);
		var cell1 = new_row.insertCell(0);
		var cell2 = new_row.insertCell(1);
		var cell3 = new_row.insertCell(2);
		var cell4 = new_row.insertCell(3);
		var cell5 = new_row.insertCell(4);
		//var cell4 = new_row.insertCell(0);
		cell1.innerHTML = "<input type='text' name='cv_entries[" + String(row_count) + "][account_title]' id='cv_entries[" + String(row_count) + "][account_title]' placeholder='Account title "+ String(row_count) + "' class='mytext foo' readonly>";
		cell2.innerHTML = "<input type='text' name='cv_entries[" + String(row_count) + "][account_code]' id='" + String(row_count) + "' placeholder = 'Account code " + String(row_count) + "' class='mytext foo' oninput='checkcoa(this.id);checkCVEntries()' list='account_codes' required>";
		cell3.innerHTML = "<input type='number' name='cv_entries[" + String(row_count) + "][debit]' id='cv_entries[" + String(row_count) + "][debit]' placeholder = 'Debit" + String(row_count) + "' step ='0.01' value='0.00' class='mytext foo' onchange='checkCVEntries()' required>";
		cell4.innerHTML = "<input type='number' name='cv_entries[" + String(row_count) + "][credit]' id='cv_entries[" + String(row_count) + "][credit]' placeholder = 'Credit" + String(row_count) + "' step ='0.01' value='0.00' class='mytext foo' onchange='checkCVEntries()' required>";
		cell5.innerHTML = "<input type='button' name='remove" + String(row_count) + "' id='remove" + String(row_count) + "' value='X' onclick='remove_doc_info(this)' class ='button xButton'>";
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
					var attribType = document.getElementById("cv_entries[" + String(j+1) + "][account_title]");
					attribType.setAttribute("name", "cv_entries[" + String(j)+"][account_title]");
					attribType.setAttribute("id", "cv_entries[" + String(j)+"][account_title]");
					attribType.setAttribute("placeholder", "Account title " + String(j));
					var attribType = document.getElementById("" + String(j+1));
					attribType.setAttribute("name", "cv_entries[" + String(j)+"][account_code]");
					attribType.setAttribute("id", "" + String(j));
					attribType.setAttribute("placeholder", "Account code " + String(j));
					var attribType = document.getElementById("cv_entries[" + String(j+1) + "][debit]");
					attribType.setAttribute("name", "cv_entries[" + String(j)+"][debit]");
					attribType.setAttribute("id", "cv_entries[" + String(j)+"][debit]");
					attribType.setAttribute("placeholder", "Debit " + String(j));
					var attribType = document.getElementById("cv_entries[" + String(j+1) + "][credit]");
					attribType.setAttribute("name", "cv_entries[" + String(j)+"][credit]");
					attribType.setAttribute("id", "cv_entries[" + String(j)+"][credit]");
					attribType.setAttribute("placeholder", "Credit " + String(j));
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
	var coas = {};
	var pd= @json($chart_of_accounts);	
	for(var i = 0; i < pd.length; i++) {
		for(var k in pd[i]){
			coas[pd[i]['account_code']] = pd[i]['account_title'];
		}
	}
	function checkcoa(id){
		//access coas
		var hi= document.getElementById(id).value;
		var val;
		for(var k in coas){
			if(k==hi){
				val=coas[k];
			}
		}
		document.getElementById("cv_entries["+id+"][account_title]").setAttribute("value", val);
	}
	/*checks the empty fields*/
	
	checkCVEntries();
	function checkCVEntries(){
		var no_problems = true;
		var innerHtml = "";
		var status = document.getElementById("cv_entries_status");
		var total_debit = 0;
		var total_credit = 0;
		var has_cash_in_bank = false;
		for(var i = 0; i< row_count;i++){
			var debit = Number(document.getElementById("cv_entries["+i+"][debit]").value);
			var credit = Number(document.getElementById("cv_entries["+i+"][credit]").value);
			var account_title_field = document.getElementById("cv_entries["+i+"][account_title]").value;
			if(account_title_field.toLowerCase().includes('cash') &&
			   account_title_field.toLowerCase().includes('bank')){
				has_cash_in_bank = (has_cash_in_bank || true);
			}
			total_credit += credit;
			total_debit += debit;
		}
		if(total_credit-total_debit != 0){
			innerHtml += "Total Debit and Credit not equal!<br>";
			no_problems = false;
		}
		if(!has_cash_in_bank){
			innerHtml += "No cash in bank!<br>";
			no_problems = false;
		}
		
		if(status){
			status.innerHTML = innerHtml;
		}
		return no_problems;
	}
</script>
@endsection