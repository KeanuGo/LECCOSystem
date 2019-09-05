<?php $__env->startSection('content'); ?>
<div align="center">
<h1 style='width:90%;text-align:left;' >Shares</h1>
</div>
<div class="container">
	<div align="center">
	<table class="table table-striped" style="width:50%;">
		<tr>
			<th>Member ID</th><td><?php echo e($member->id); ?></td>
		</tr>
		<tr>
			<th>Member Name</th><td><?php echo e($member->first_name . ' ' . $member->last_name); ?></td>
		</tr>
	</table>
	</div>
	<table class="table table-striped">
		<tr>
			<?php if($shares->first()): ?>
				<?php $__currentLoopData = $shares->first(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
					<th><?php echo e(ucwords(str_replace('_', ' ', $k))); ?></th>
				<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
			<?php else: ?>
				<th> Empty </th>
			<?php endif; ?>
		</tr>
		<?php $__currentLoopData = $shares; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $share): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
			<tr>
			<?php $__currentLoopData = $share; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				<?php if($k == 'month'): ?>
					<td> <?php echo e(DateTime::createFromFormat('!m', $v)->format('F')); ?> </td>
				<?php else: ?>
					<td> <?php echo e($v); ?> </td>
				<?php endif; ?>
			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
			
			</tr>
		<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
		<tr>
		<td><strong>Total:</strong></td><td></td>
		<?php for($i=0; $i<3; $i++): ?>
			
			<td> <?php echo e($totals[$i]); ?> </td>
			
			
		<?php endfor; ?>
		</tr>
	</table>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>