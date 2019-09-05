<?php $__env->startSection('content'); ?>
<div align="center">
<h1 style='width:90%;text-align:left;' >Signatories</h1>
</div>
<div class="container">
	<?php echo $__env->make('partials.filter_bar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
	<table class="table table-striped" id="main-table">
		<tr>
			<?php if($signatories->first()): ?>
				<?php $__currentLoopData = $signatories->first(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
					<?php if(strpos($k, 'id') !== false): ?>
						<?php continue; ?>;
					<?php endif; ?>	
					<th><?php echo e(ucwords(str_replace('_', ' ', $k))); ?></th>
				<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
				<th class="no-print">Actions</th>
			<?php else: ?>
				<th> Empty </th>
			<?php endif; ?>
		</tr>
		<?php $__currentLoopData = $signatories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $signatory): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
			<tr>
			<?php $__currentLoopData = $signatory; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				<?php if(strpos($k, 'id') !== false): ?>
					<?php continue; ?>;
				<?php endif; ?>
				<td> <?php echo e($v); ?> </td>
			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
			<td no-search class="no-print">
			<?php if(Auth::User()->access_rights()->coa_edit): ?>
				<a href="<?php echo e(route('signatories.edit', ['id' => $signatory->id])); ?>" class="link-tag edit-a"> Edit</a>
			<?php endif; ?>
			<?php if(Auth::User()->access_rights()->coa_delete): ?>
				<a href="<?php echo e(route('signatories.delete', ['id' => $signatory->id])); ?>" class="link-tag delete-a"> Delete</a>
			<?php endif; ?>
			</td>
			</tr>
		<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
	</table>
	<div class="no-print">
		<?php if(Auth::User()->access_rights()->coa_create): ?>
			<a href="<?php echo e(route('signatories.create')); ?>" class="link-tag add-a"> Add Signatory </a>
		<?php endif; ?>
	</div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>