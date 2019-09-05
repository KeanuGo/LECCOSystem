 
<?php $__env->startSection('content'); ?>
    <div class="container">
        <div class="row">
            <?php if($message = Session::get('success')): ?>
 
                <div class="alert alert-success alert-block">
 
                    <button type="button" class="close" data-dismiss="alert">×</button>
 
                    <strong><?php echo e($message); ?></strong>
 
                </div>
 
            <?php endif; ?>
 
            <?php if(count($errors) > 0): ?>
                <div class="alert alert-danger">
                    <strong>Whoops!</strong> There were some problems with your input.<br><br>
                    <ul>
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><?php echo e($error); ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            <?php endif; ?>
        </div>
        <div class="justify-content-center">
            <div class="profile-header-container">
                <div class="profile-header-img">
                    <img class="img-rounded" src="/storage/avatars/<?php echo e($user->avatar); ?>" />
                    <!-- badge -->
                    <div class="rank-label-container">
                        <span class="label label-default rank-label"><?php echo e($user->name); ?></span>
                    </div>
                </div>
            </div>
 
        </div>
        <div class="justify-content-center">
            <form action="/profile" method="post" enctype="multipart/form-data">
                <?php echo e(csrf_field()); ?>

                <div class="form-group">
                    <input type="file" class="form-control-file" name="avatar" id="avatarFile" aria-describedby="fileHelp">
                    <small id="fileHelp" class="form-text text-muted">Please upload a valid image file. Size of image should not be more than 2MB.</small>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>