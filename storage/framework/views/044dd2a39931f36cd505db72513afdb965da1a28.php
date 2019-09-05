<?php $__env->startSection('content'); ?>

<div align="center">
<h1 style='width:90%;text-align:left;' >Check Voucher</h1>
</div>
<div class="container">
    <div class="row">
        <div class="col-md-9 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Add Check Voucher</div>
				<?php echo Form::open(['url' => route('check_voucher.update', ['id'=> $check_voucher['cv_no']]),'onsubmit' => 'return checkCVEntries()', 'enctype'=> 'multipart/form-data']);; ?>

                <div class="panel-body">
				<table class='table table-striped'>
                        <?php echo e(csrf_field()); ?>

						<?php $__currentLoopData = $columns; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $column): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
						<tr>
							<?php if($column->COLUMN_NAME == 'cv_no'): ?>
								<td colspan = "2">
									<?php echo e(Form::label($column->COLUMN_NAME, ucwords(str_replace('_', ' ', $column->COLUMN_NAME)), array('class' => 'col-md-4 control-label'))); ?>

									<div class="col-md-6">
										<?php echo e(Form::number($column->COLUMN_NAME, $check_voucher[$column->COLUMN_NAME], array('class' => 'form-control', 'readonly'))); ?>

									</div>
									<?php continue; ?>;
								</td>
							<?php elseif(strpos($column->COLUMN_NAME, 'created_at') !== false or strpos($column->COLUMN_NAME, 'updated_at') !== false): ?>
								<?php continue; ?>;
							<?php endif; ?>
							<!--<div class="form-group">-->
								<td colspan="2">
								<?php echo e(Form::label($column->COLUMN_NAME, ucwords(str_replace('_', ' ', $column->COLUMN_NAME)), array('class' => 'col-md-4 control-label'))); ?>

								
								<div class="col-md-6">
									<?php if(strpos($column->COLUMN_NAME, 'attachment') !== false): ?>
										<?php if($check_voucher['attachment']): ?>
											<?php echo e($check_voucher['attachment']); ?>

										<?php endif; ?>
										<input type="file" class="form-control-file" name="attachment" id="attachmentFile" aria-describedby="fileHelp">
									<?php elseif(strpos($column->TYPE_NAME, 'date') !== false): ?>
										<?php if($column->NULLABLE == 1): ?>
											<?php echo e(Form::date($column->COLUMN_NAME, $check_voucher[$column->COLUMN_NAME], array('class' => 'form-control'))); ?>

										<?php else: ?>
											<?php echo e(Form::date($column->COLUMN_NAME, $check_voucher[$column->COLUMN_NAME], array('class' => 'form-control', 'required' => ''))); ?>

										<?php endif; ?>
									<?php elseif(strpos($column->TYPE_NAME, 'int') !== false): ?>
										<?php if($column->NULLABLE == 1): ?>
											<?php echo e(Form::number($column->COLUMN_NAME, $check_voucher[$column->COLUMN_NAME], array('class' => 'form-control'))); ?>

										<?php else: ?>
											<?php echo e(Form::number($column->COLUMN_NAME, $check_voucher[$column->COLUMN_NAME], array('class' => 'form-control'))); ?>

										<?php endif; ?>
									<?php elseif(strpos($column->TYPE_NAME, 'money') !== false or strpos($column->TYPE_NAME, 'decimal') !== false): ?>
										<?php if($column->NULLABLE == 1): ?>
											<?php echo e(Form::number($column->COLUMN_NAME, $check_voucher[$column->COLUMN_NAME], array('class' => 'form-control', 'step' => '0.01'))); ?>

										<?php else: ?>
											<?php echo e(Form::number($column->COLUMN_NAME, $check_voucher[$column->COLUMN_NAME], array('class' => 'form-control', 'step' => '0.01', 'required' => ''))); ?>

										<?php endif; ?>
									<?php elseif(strpos($column->TYPE_NAME, 'real') !== false): ?>
										<?php if($column->NULLABLE == 1): ?>
											<?php echo e(Form::number($column->COLUMN_NAME, $check_voucher[$column->COLUMN_NAME], array('class' => 'form-control', 'step' => 'any'))); ?>

										<?php else: ?>
											<?php echo e(Form::number($column->COLUMN_NAME, $check_voucher[$column->COLUMN_NAME], array('class' => 'form-control', 'step' => 'any', 'required' => ''))); ?>

										<?php endif; ?>
									<?php elseif(strpos($column->TYPE_NAME, 'float') !== false): ?>
										<?php if($column->NULLABLE == 1): ?>
											<?php echo e(Form::number($column->COLUMN_NAME, $check_voucher[$column->COLUMN_NAME], array('class' => 'form-control', 'step' => 'any'))); ?>

										<?php else: ?>
											<?php echo e(Form::number($column->COLUMN_NAME, $check_voucher[$column->COLUMN_NAME], array('class' => 'form-control', 'step' => 'any', 'required' => ''))); ?>

										<?php endif; ?>
									<?php elseif(strpos($column->TYPE_NAME, 'binary') !== false): ?>
										<?php if($column->NULLABLE == 1): ?>
											<?php echo e(Form::number($column->COLUMN_NAME, $check_voucher[$column->COLUMN_NAME], array('class' => 'form-control', 'step' => 'any'))); ?>

										<?php else: ?>
											<?php echo e(Form::number($column->COLUMN_NAME, $check_voucher[$column->COLUMN_NAME], array('class' => 'form-control', 'step' => 'any', 'required' => ''))); ?>

										<?php endif; ?>
									<?php else: ?>
										<?php if($column->NULLABLE == 1): ?>
											<?php echo e(Form::text($column->COLUMN_NAME, $check_voucher[$column->COLUMN_NAME], array('class' => 'form-control' ))); ?>

										<?php else: ?>
											<?php echo e(Form::text($column->COLUMN_NAME, $check_voucher[$column->COLUMN_NAME], array('class' => 'form-control', 'required' => ''))); ?>

										<?php endif; ?>
									<?php endif; ?>
								</div>
								</td>
							<!--</div>-->
						</tr>
						<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						<tr>
						<td colspan="2">
						<div class="col-md-6">
							<input type="text" id="row_count_field" name="row_count_field" style="display:none">
							<p id="cv_entries_status" style="color:red"></p>
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
                                <?php echo e(Form::submit('Save', array('class' => 'btn btn-primary'))); ?>

								<a href="<?php echo e(url()->previous()); ?>" class="btn btn-default btn-close"> Cancel </a>
							</td>
                            </div>
							</td>
                        <!--</div>-->
						</tr>
				</table>
                </div>
				<?php echo e(Form::close()); ?>

            </div>
        </div>
    </div>
	<datalist id ="account_codes">
		<?php $__currentLoopData = $chart_of_accounts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $chart_of_account): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
			<option value="<?php echo e($chart_of_account->account_code); ?>"><?php echo e($chart_of_account->account_title); ?></>
		<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
	var pd= <?php echo json_encode($chart_of_accounts, 15, 512) ?>;	
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
	
	<?php for($i = 0; $i < count($cv_entries); $i++): ?>
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
		
		var code_field = document.getElementById('<?php echo e($i); ?>');
		var debit_field = document.getElementById('cv_entries[<?php echo e($i); ?>][debit]');
		var credit_field = document.getElementById('cv_entries[<?php echo e($i); ?>][credit]');
		if(code_field && debit_field && credit_field){
			code_field.value = '<?php echo e($cv_entries[$i]['account_code']); ?>';
			code_field.setAttribute('value', '<?php echo e($cv_entries[$i]['account_code']); ?>');
			checkcoa('<?php echo e($i); ?>');
			debit_field.value = <?php echo e($cv_entries[$i]['debit']); ?>;
			credit_field.value = <?php echo e($cv_entries[$i]['credit']); ?>;
			debit_field.setAttribute('value', <?php echo e($cv_entries[$i]['debit']); ?>);
			credit_field.setAttribute('value', <?php echo e($cv_entries[$i]['credit']); ?>);
		}
	<?php endfor; ?>
	checkCVEntries();
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>