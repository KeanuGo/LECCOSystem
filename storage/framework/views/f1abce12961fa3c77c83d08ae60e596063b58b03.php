<?php $__env->startSection('content'); ?>
<div align="center">
<h1 style='width:90%;text-align:left;' >Members</h1>
</div>
<div class="container">
	<?php echo $__env->make('partials.filter_bar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
	<table class="table table-striped" id="main-table">
		<tr>
			<?php if($members->first()): ?>
				<?php $__currentLoopData = $members->first(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
					<th><?php echo e(ucwords(str_replace('_', ' ', $k))); ?></th>
				<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
				<th class="no-print">Actions</th>
			<?php else: ?>
				<th> Empty </th>
			<?php endif; ?>
		</tr>
		<?php $__currentLoopData = $members; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $member): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
			<tr>
			<?php $__currentLoopData = $member; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				<td> <?php echo e($v); ?> </td>
			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
			<td no-search class= "no-print">
			<?php if(Auth::User()->access_rights()->member_view): ?>
				<a href="<?php echo e(route('members.view', ['id' => $member->id])); ?>" class="link-tag view-a">View</a>
			<?php endif; ?>
			<?php if(Auth::User()->access_rights()->member_edit): ?>
				<a href="<?php echo e(route('members.edit', ['id' => $member->id])); ?>" class="link-tag edit-a"> Edit</a>
			<?php endif; ?>
			<?php if(Auth::User()->access_rights()->member_delete): ?>
				<a href="<?php echo e(route('members.delete', ['id' => $member->id])); ?>" class="link-tag delete-a"> Delete</a>
			<?php endif; ?>
			</td>
			</tr>
		<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
	</table>
	<div class= "no-print">
		<?php if(Auth::User()->access_rights()->member_create): ?>
			<a href="<?php echo e(route('members.create')); ?>" class="link-tag add-a"> Add Member </a>
		<?php endif; ?>
	</div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>