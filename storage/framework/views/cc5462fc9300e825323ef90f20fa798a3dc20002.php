<?php $__env->startSection('content'); ?>
<div align="center">
<h1 style='width:90%;text-align:left;' >Loan Types</h1>
</div>
<div class="container">
	<table class="table table-striped">
		<?php $__currentLoopData = $loan_type; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
			<?php if(strpos($k, 'created_at') !== false or strpos($k, 'updated_at') !== false): ?>
				<?php continue; ?>;
			<?php endif; ?>
			<tr>
				<?php if($k == 'id'): ?>
					<th>Loan Type ID</th>
				<?php else: ?>
					<th><?php echo e(ucwords(str_replace('_', ' ', $k))); ?></th>
				<?php endif; ?>
				<td><?php echo e($v); ?></td>
			</tr>
		<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
	</table>
	<hr>
	<div class="no-print">
		<?php if(Auth::User()->access_rights()->loans_types_edit): ?>
			<a href="<?php echo e(route('loan_types.edit', ['id' => $loan_type['id']])); ?>" class="link-tag edit-a"> Edit</a>
		<?php endif; ?>
		<?php if(Auth::User()->access_rights()->loans_types_delete): ?>
			<a href="<?php echo e(route('loan_types.delete', ['id' => $loan_type['id']])); ?>" class="link-tag delete-a"> Delete</a>
		<?php endif; ?>
		<?php if(Auth::User()->access_rights()->loans_view): ?>
			<a href="<?php echo e(route('loan_types.index')); ?>" class="link-tag view-a"> View All Loan Types </a>
		<?php endif; ?>
	</div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>