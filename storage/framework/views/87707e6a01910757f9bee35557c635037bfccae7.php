<?php $__env->startSection('content'); ?>
<div align="center">
<h1 style='width:90%;text-align:left;' >
<?php if(isset($page_title)): ?>
	<?php echo e($page_title); ?>

<?php else: ?>
	Check Voucher
<?php endif; ?>
</h1>
</div>
<div class="container">
	<?php echo $__env->make('partials.filter_bar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
	<table class="table table-striped" id="main-table">
		<tr>
			<?php if($summary_of_accounts->first()): ?>
				<?php $__currentLoopData = $summary_of_accounts->first(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
					<?php if(strpos($k, 'id') !== false): ?>
						<?php continue; ?>;
					<?php endif; ?>	
					<th><?php echo e(ucwords(str_replace('_', ' ', $k))); ?></th>
				<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
			<?php else: ?>
				<th> Empty </th>
			<?php endif; ?>
		</tr>
		<?php $__currentLoopData = $summary_of_accounts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cv): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
			<tr>
			<?php $__currentLoopData = $cv; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				<?php if(strpos($k, 'id') !== false): ?>
					<?php continue; ?>;
				<?php endif; ?>
				<td> <?php echo e($v); ?> </td>
			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
			</tr>
		<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
	</table>
	<!--<div>
		<?php if(Auth::User()->access_rights()->coa_create): ?>
			<a href="<?php echo e(route('check_voucher.create')); ?>" class="link-tag add-a"> Add CV </a>
		<?php endif; ?>
	</div>-->
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>