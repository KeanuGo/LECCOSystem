<?php $__env->startSection('content'); ?>
<div align="center" id="printOnly">
	<label>LEYECO II CREDIT COOPERATIVE</label><br>
	<label>Tacloban City</label>
</div>
<div align="center">
	<label style="font-size: 20px">Check Disbursement Journal</label>
</div>

<div class="container">
	<div class="no-print" align="center">
		<?php echo Form::open(['url' => route('check_voucher.index'), 'method' => 'GET']);; ?>

		<input type="radio" name="date" value="date_disbursed" style="margin-right:10px;margin-left:10px" checked>Disbursement Date
		<input type="radio" name="date" value="created_at" style="margin-right:10px;margin-left:10px">Created At
		<input type="radio" name="date" value="updated_at" style="margin-right:10px;margin-left:10px">Updated At
		&nbsp&nbsp&nbsp&nbsp&nbsp From: &nbsp&nbsp<?php echo e(Form::date('from', \Carbon\Carbon::now())); ?>

		&nbsp&nbsp&nbsp&nbsp&nbsp To: &nbsp&nbsp<?php echo e(Form::date('to', \Carbon\Carbon::now())); ?>

		&nbsp&nbsp<?php echo e(Form::submit('Filter', array('class' => 'btn btn-primary'))); ?>

		<a href="<?php echo e(route('check_voucher.index')); ?>" class="link-tag view-a">Clear Filter</a>
		<br><br>
	</div>
	<input type="text" id="date_field" name="first" style="display:none" value="0">
	<?php $__currentLoopData = $check_voucher; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cv): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
		<script>
			var months= [ "January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
			var div_month = new Date(<?php echo json_encode($cv->date_disbursed, 15, 512) ?>).getMonth();
			var div_year = new Date(<?php echo json_encode($cv->date_disbursed, 15, 512) ?>).getYear()+1900;
			var m = months[div_month];
			var prev_date = document.getElementById("date_field");
						
			var prev_month = new Date(prev_date.value).getMonth();
			var prev_year = new Date(prev_date.value).getYear()+1900;
			var prev_m = months[prev_month];
			
			if(prev_date.value == 0) {
				prev_date.setAttribute('value', "00-00-00");
			}else{
				prev_date.setAttribute('value', <?php echo json_encode($cv->date_disbursed, 15, 512) ?>);
			}
			
			if(prev_m != m || div_year != prev_year) {
				<?php if($cv->date_disbursed): ?>
					document.write("<div align='center'><label style='font-size:20px'>" + m + " " + div_year + "</label></div>");
				<?php else: ?>
					document.write("<div align='center'><label style='font-size:20px'>No Disbursement Date</label></div>");
				<?php endif; ?>
			}
			prev_date.setAttribute('value', <?php echo json_encode($cv->date_disbursed, 15, 512) ?>);
			
		</script>
		
		<div style="border: 2px solid black; border-radius: 20px;margin-bottom:1px;padding: 10px" class="no-break">	
			
			<table class="table2 table-striped" id="main-table">
				<tr>
					<?php if($check_voucher->first()): ?>
						<?php $__currentLoopData = $check_voucher->first(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<?php if(strpos($k, 'id') !== false or strpos($k, 'description') !== false): ?>
								<?php continue; ?>;
							<?php endif; ?>	
							<td><strong><?php echo e(ucwords(str_replace('_', ' ', $k))); ?></strong></td>
							
							<td><span class="values">&nbsp&nbsp&nbsp<?php echo e($cv->$k); ?>&nbsp&nbsp&nbsp</span></td>
						<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						
					<?php else: ?>
						<th> Empty </th>
					<?php endif; ?>
				</tr>
				<tr>
					<td><strong> Description </strong></td>
					<td colspan="7"> <?php echo e($cv->description); ?> </td>
				</tr>
				<tr><td colspan="8"><hr style="border: 1px solid black; margin:10px"></td></tr>
				<tr>
				<?php $__currentLoopData = $cv_entries->first(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
					<?php if(strpos($k, 'account') === false and strpos($k, 'debit') === false and strpos($k, 'credit') === false): ?>
						<?php continue; ?>;
					<?php endif; ?>
					<th colspan="2"><?php echo e(ucwords(str_replace('_', ' ', $k))); ?></th>
				<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
				</tr>
				<?php $__currentLoopData = $cv_entries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cv_ent): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				<?php if($cv_ent->id === $cv->cv_no): ?>
				<tr>
					<?php $__currentLoopData = $cv_ent; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
					<?php if(strpos($k, 'account') === false and strpos($k, 'debit') === false and strpos($k, 'credit') === false): ?>
						<?php continue; ?>;
					<?php endif; ?>
					<td colspan="2"> <?php echo e($v); ?> </td>
				<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
				</tr>
				<?php endif; ?>
				<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
				<tr class="no-print">
				<th colspan="2">Actions</th>
				<td no-search colspan="8" class="no-print">
				<?php if(Auth::User()->access_rights()->check_voucher_view): ?>
					<a href="<?php echo e(route('check_voucher.view', ['id' => $cv->cv_no])); ?>" class="link-tag view-a"> View</a>
				<?php endif; ?>
				<?php if(Auth::User()->access_rights()->check_voucher_edit): ?>
					<a href="<?php echo e(route('check_voucher.edit', ['id' => $cv->cv_no])); ?>" class="link-tag edit-a"> Edit</a>
				<?php endif; ?>
				<?php if(Auth::User()->access_rights()->check_voucher_delete): ?>
					<a href="<?php echo e(route('check_voucher.delete', ['id' => $cv->cv_no])); ?>" class="link-tag delete-a"> Delete</a>
				<?php endif; ?>
				</td>
				</tr>
			</table>
		</div>
	<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
	<br>
	<div class="no-print">
		<?php if(Auth::User()->access_rights()->coa_create): ?>
			<a href="<?php echo e(route('check_voucher.create')); ?>" class="link-tag add-a"> Add CV </a>
		<?php endif; ?>
		<?php if(Auth::User()->access_rights()->check_voucher_view): ?>
			<a href="<?php echo e(route('check_voucher.general_summary_of_accounts')); ?>" class="link-tag view-a">General Ledger Summary</a>
			<a href="<?php echo e(route('check_voucher.sub_summary_of_accounts')); ?>" class="link-tag view-a">Subsidiary Ledger Summary</a>
			<a href="<?php echo e(route('check_voucher.sub_sub_summary_of_accounts')); ?>" class="link-tag view-a">Sub-Subsidiary Ledger Summary</a>
		<?php endif; ?>
	</div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>