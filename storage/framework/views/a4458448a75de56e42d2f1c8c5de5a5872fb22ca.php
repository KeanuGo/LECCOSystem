<?php $__env->startSection('content'); ?>
<div align="center">
<h1 style='width:90%;text-align:left;' >Loans</h1>
</div>
<div class="container">
	<?php echo $__env->make('partials.filter_bar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
	<table class="table table-striped" id='main-table'>
		<tr>
			<?php if($loans->first()): ?>
				<?php $__currentLoopData = $loans->first(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
					<th><?php echo e(ucwords(str_replace('_', ' ', $k))); ?></th>
				<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
				<th>Actions</th>
			<?php else: ?>
				<th> Empty </th>
			<?php endif; ?>
		</tr>
		<?php $__currentLoopData = $loans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $loan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
			<tr>
			<?php $__currentLoopData = $loan; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				<td> <?php echo e($v); ?> </td>
			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
			<td no-search>
			<?php if(Auth::User()->access_rights()->loans_view): ?>
				<a href="<?php echo e(route('loans.view', ['id' => $loan->id])); ?>" class="link-tag view-a">View</a>
			<?php endif; ?>
			<?php if(Auth::User()->access_rights()->loans_delete): ?>
				<a href="<?php echo e(route('loans.delete', ['id' => $loan->id])); ?>" class="link-tag delete-a">Delete</a>
			<?php endif; ?>
			</td>
			</tr>
		<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
	</table>
	<div>
		<?php if(Auth::User()->access_rights()->loans_create): ?>
			<a href="<?php echo e(route('loans.create')); ?>" class="link-tag add-a"> Add Loan </a>
			
		<?php endif; ?>
		<?php if(Auth::User()->access_rights()->loans_view): ?>
			<a href="<?php echo e(route('loans.view_aging_loans')); ?>" class="link-tag view-a"> View Aging Loans </a>
			<a href="<?php echo e(route('loans.lpds')); ?>" class="link-tag view-a">Loans Payment Deduction Schedule </a>
		<?php endif; ?>
	</div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>