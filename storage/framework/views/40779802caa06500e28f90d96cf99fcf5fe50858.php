<?php $__env->startSection('content'); ?>
<div align="center">
<h1 style='width:90%;text-align:left;' >Members</h1>
</div>
<div class="container">
	<td><img style=" display:block;height:150px;width:150px;" src="/storage/avatars/<?php echo e($member['avatar']); ?>" /></td>
	<table class="table table-striped">
		<?php $__currentLoopData = $member; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
			<?php if(strpos($k, 'created_at') !== false or strpos($k, 'updated_at') !== false or strpos($k, 'avatar') !== false): ?>
				<?php continue; ?>;
			<?php endif; ?>
			<tr>
				<?php if($k == 'id'): ?>
					<th>Member ID</th>
				<?php else: ?>
					<th><?php echo e(ucwords(str_replace('_', ' ', $k))); ?></th>
				<?php endif; ?>
				<?php if(strpos($k, 'no_of_subscribed_shares') !== false): ?>
					<td><div class="no-print"><a href="<?php echo e(route('shares.view', ['id' => $member['id']])); ?>" class="link-tag view-a">View Shares</a></td></div>
					<?php continue; ?>;
				<?php endif; ?>
				<td><?php echo e($v); ?></td>
			</tr>
		<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
	</table>
	<hr>
	<div class="no-print">
		<?php if(Auth::User()->access_rights()->member_edit): ?>
			<a href="<?php echo e(route('members.edit', ['id' => $member['id']])); ?>" class="link-tag edit-a"> Edit</a>
		<?php endif; ?>
		<?php if(Auth::User()->access_rights()->member_delete): ?>
			<a href="<?php echo e(route('members.delete', ['id' => $member['id']])); ?>" class="link-tag delete-a"> Delete</a>
		<?php endif; ?>
		<?php if(Auth::User()->access_rights()->member_view): ?>
			<a href="<?php echo e(route('members.index')); ?>" class="link-tag view-a"> View All Members </a>
		<?php endif; ?>
	</div>
	<br>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>