<?php $__env->startSection('content'); ?>
<div align="center">
<h1 style='width:90%;text-align:left;' >Shares</h1>
</div>
<div class="container">
	<?php echo $__env->make('partials.filter_bar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
	<table class="table table-striped" id="main-table">
		<tr>
			<?php if($shares->first()): ?>
				<?php $__currentLoopData = $shares->first(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
					<th><?php echo e(ucwords(str_replace('_', ' ', $k))); ?></th>
				<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
				<th class="no-print">Actions</th>
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
	<div class="no-print">
		<?php if(Auth::User()->access_rights()->shares_create): ?>
			<a href="<?php echo e(route('shares.create')); ?>" class="link-tag add-a"> Add Shares </a>
		<?php endif; ?>
	</div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>