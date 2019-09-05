<?php $__env->startSection('content'); ?>
<div align="center">
<h1 style='width:90%;text-align:left;' >Loans</h1>
</div>
<div class="container">
	<table class="table table-striped">
		<?php $__currentLoopData = $loan; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
			<?php if(strpos($k, 'created_at') !== false or strpos($k, 'updated_at') !== false or strpos($k, 'avatar') !== false or strpos($k, 'avatar') !== false): ?>
				<?php continue; ?>;
			<?php endif; ?>
			<tr>
				<?php if($k == 'id'): ?>
					<th>Loan ID</th>
				<?php else: ?>
					<th><?php echo e(ucwords(str_replace('_', ' ', $k))); ?></th>
				<?php endif; ?>
				<td><?php echo e($v); ?></td>
			</tr>
		<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
	</table>
	<h3>Payment Schedule</h3>
	<hr>
	<table class="table table-striped">
		<?php if(reset($payroll_deductions)): ?>
			<?php $__currentLoopData = $payroll_deductions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payroll => $_payroll_deductions): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				<?php if(count($_payroll_deductions) > 0): ?>
					<tr><th colspan=<?php echo e(count($_payroll_deductions)); ?>><h4 style='text-align:center;'>Salary Deduction: <?php echo e(ucwords(str_replace('_', ' ', $payroll))); ?></h4></th></tr>
					<tr>
					<?php $__currentLoopData = $_payroll_deductions[0]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
						<?php if($k == 'loan_id' or $k == 'created_at'): ?>
							<?php continue; ?>;
						<?php endif; ?>
						<th><?php echo e(ucwords(str_replace('_', ' ', $k))); ?></th>
					<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
					<th> Action </th>
					</tr>
					<?php $__currentLoopData = $_payroll_deductions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payroll_deduction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
						<?php if(!$payroll_deduction['month_year_applied']): ?>
							<?php if(Auth::User()->access_rights()->loans_edit): ?>
								<form action="<?php echo e(route('payment_schedule.update')); ?>" method="POST" id="<?php echo e($payroll .'_'. $payroll_deduction['payment_no']); ?>">
							<?php endif; ?>
						<?php endif; ?>
							<tr>
								<?php if(!$payroll_deduction['month_year_applied']): ?>
									<?php if(Auth::User()->access_rights()->loans_edit): ?>
										<?php echo e(Form::hidden('_token', csrf_token(), ['form' => $payroll .'_'. $payroll_deduction['payment_no']])); ?>

										<?php echo e(Form::hidden('loan_id', $payroll_deduction['loan_id'], ['form' => $payroll .'_'. $payroll_deduction['payment_no']])); ?>

										<?php echo e(Form::hidden('payroll', $payroll, ['form' => $payroll .'_'. $payroll_deduction['payment_no']])); ?>

									<?php endif; ?>
								<?php endif; ?>
								<?php $__currentLoopData = $payroll_deduction; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k1 => $v1): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
									<?php if($k1 == 'loan_id' or $k1 == 'created_at'): ?>
										<?php continue; ?>;
									<?php elseif(strpos($k1, 'month') !== false and strpos($k1, 'year') !== false and strpos($k1, 'applied') !== false): ?>
										<?php if(!$payroll_deduction['month_year_applied']): ?>
											<td><?php echo e(Form::date($v1, ((\Carbon\Carbon::parse($payroll_deduction['expected_date_of_payment']) > \Carbon\Carbon::now('Asia/Manila')) ? $payroll_deduction['expected_date_of_payment'] : \Carbon\Carbon::now('Asia/Manila')), ['name' => $k1, 'form' => ($payroll .'_'. $payroll_deduction['payment_no']), 'style' => 'text-align:center;background-color:rgba(0,0,0,0)', 'required' => ''])); ?></td>
										<?php else: ?>
											<td><?php echo e(Form::date($v1, ((\Carbon\Carbon::parse($payroll_deduction['expected_date_of_payment']) > \Carbon\Carbon::now('Asia/Manila')) ? $payroll_deduction['expected_date_of_payment'] : \Carbon\Carbon::now('Asia/Manila')), ['name' => $k1, 'form' => ($payroll .'_'. $payroll_deduction['payment_no']), 'style' => 'text-align:center;border:0px;background-color:rgba(0,0,0,0)', 'readonly' => '', 'required' => ''])); ?></td>
										<?php endif; ?>
										<?php continue; ?>
									<?php elseif(strpos($k1, 'penalty') !== false and strpos($k1, 'interest') !== false): ?>
										<?php if(!$payroll_deduction['month_year_applied']): ?>
											<?php if(\Carbon\Carbon::now('Asia/Manila') > $payroll_deduction['expected_date_of_payment']): ?>
												<td><?php echo e(Form::number($v1, round((((floor(\Carbon\Carbon::now('Asia/Manila')->diffInDays($payroll_deduction['expected_date_of_payment'])/30.0)*.05))*$payroll_deduction['periodic_payment']), 2), ['name' => $k1, 'form' => ($payroll .'_'. $payroll_deduction['payment_no']), 'style' => 'text-align:center;background-color:rgba(0,0,0,0)', 'required' => '', 'step' => '0.01'])); ?></td>
											<?php else: ?>
												<td><?php echo e(Form::number($v1, 0.00, ['name' => $k1, 'form' => ($payroll .'_'. $payroll_deduction['payment_no']), 'style' => 'text-align:center;background-color:rgba(0,0,0,0)', 'required' => '', 'step' => '0.01'])); ?></td>
											<?php endif; ?>
										<?php else: ?>
											<td><?php echo e(Form::number($v1, $v1, ['name' => $k1, 'form' => ($payroll .'_'. $payroll_deduction['payment_no']), 'style' => 'text-align:center;border:0px;background-color:rgba(0,0,0,0)', 'readonly' => '', 'required' => ''])); ?></td>
										<?php endif; ?>
										<?php continue; ?>
									<?php endif; ?>
									<td><?php echo e(Form::text($v1, $v1, ['name' => $k1, 'form' => ($payroll .'_'. $payroll_deduction['payment_no']), 'style' => 'text-align:center;border:0px;background-color:rgba(0,0,0,0)', 'readonly' => '', 'required' => ''])); ?></td>
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
								<td>
									<?php if(!$payroll_deduction['month_year_applied']): ?>
										<?php if(Auth::User()->access_rights()->loans_edit): ?>
											<?php echo e(Form::submit('Update', ['form' => $payroll .'_'. $payroll_deduction['payment_no'], 'class' => 'btn btn-primary'])); ?>

										<?php endif; ?>
									<?php endif; ?>
								</td>
							</tr>
						<?php echo e(Form::close()); ?>

					<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
				<?php endif; ?>
			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
		<?php else: ?>
			<tr><th> Empty </th></tr>
		<?php endif; ?>
	</table>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>