<?php $__env->startSection('content'); ?>
<div align="center">
<h1 style='width:90%;text-align:left;' >Shares</h1>
</div>
<div class="container">
	<table class="table table-striped">
		<tr>
			<?php if($shares->first()): ?>
				<?php $__currentLoopData = $shares->first(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
					<th><?php echo e(ucwords(str_replace('_', ' ', $k))); ?></th>
				<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
				<th>Actions</th>
			<?php else: ?>
				<th> Empty </th>
			<?php endif; ?>
		</tr>
		<?php $__currentLoopData = $shares; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $share): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
			<tr>
			<?php $__currentLoopData = $share; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				<td> <?php echo e($v); ?> </td>
			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
			
			</tr>
		<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
	</table>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>