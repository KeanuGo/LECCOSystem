<?php $__env->startSection('content'); ?>
<div class="container">
	<table class="table table-striped">
		<tr>
			<?php if($users->first()): ?>
				<?php $__currentLoopData = $users->first(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
					<th><?php echo e(ucwords(str_replace('_', ' ', $k))); ?></th>
				<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
				<th>Actions</th>
			<?php else: ?>
				<th> Empty </th>
			<?php endif; ?>
		</tr>
		<?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
			<tr>
			<?php $__currentLoopData = $user; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				<?php if(strpos($k, 'avatar') !== false): ?>
					<td><img class="img-rounded" style=" display:block;height:auto;width:3px;" src="/storage/avatars/<?php echo e($user->avatar); ?>" /></td>
					<?php continue; ?>;
				<?php endif; ?>
				<td> <?php echo e($v); ?> </td>
			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
			<td>
			<?php if(Auth::User()->access_rights()->invoke_rights): ?>
				<a href="<?php echo e(route('users.view_rights', ['id' => $user->id])); ?>" class="link-tag edit-a">Edit Privileges</a>
			<?php endif; ?>
			<?php if(Auth::User()->access_rights()->users_delete and Auth::User()->id != $user->id): ?>
				<a href="<?php echo e(route('users.delete', ['id' => $user->id])); ?>" class="link-tag delete-a"> Delete </a>
			<?php endif; ?>
			</td>
			</tr>
		<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
	</table>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>