<?php $__env->startSection('content'); ?>
<div class="container">
	<div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Access Rights</div>

                <div class="panel-body">
					<?php echo e(Form::open(['url' => route('users.update_rights', ['id' => $access_rights['user_id']]) ] )); ?>

					<?php echo e(csrf_field()); ?>

					<table class='table table-striped'>
						<?php $__currentLoopData = $columns; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $column): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<tr>
								<div class="form-group">
									<?php if(strpos($column->COLUMN_NAME, 'created_at') !== false or strpos($column->COLUMN_NAME, 'updated_at') !== false): ?>
										<?php continue; ?>;
									<?php endif; ?>
									<td><?php echo e(Form::label($column->COLUMN_NAME, ucwords(str_replace('_', ' ', $column->COLUMN_NAME)), array('class' => 'col-md-4 control-label'))); ?></td>
									<td>
										<div class="col-md-6">
											<?php if(strpos($column->COLUMN_NAME, 'id') == true): ?>
													<?php if($column->NULLABLE == 1): ?>
														<?php echo e(Form::number($column->COLUMN_NAME, $access_rights[$column->COLUMN_NAME], array('class' => 'form-control', 'readonly' => ''))); ?>

													<?php else: ?>
														<?php echo e(Form::number($column->COLUMN_NAME, $access_rights[$column->COLUMN_NAME], array('class' => 'form-control', 'readonly' => ''))); ?>

													<?php endif; ?>
												<?php elseif(strpos($column->TYPE_NAME, 'date') !== false): ?>
													<?php if($column->NULLABLE == 1): ?>
														<?php echo e(Form::date($column->COLUMN_NAME, $access_rights[$column->COLUMN_NAME], array('class' => 'form-control'))); ?>

													<?php else: ?>
														<?php echo e(Form::date($column->COLUMN_NAME, $access_rights[$column->COLUMN_NAME], array('class' => 'form-control', 'required' => ''))); ?>

													<?php endif; ?>
												<?php elseif(strpos($column->TYPE_NAME, 'int') !== false): ?>
													<?php if($column->NULLABLE == 1): ?>
														<?php echo e(Form::number($column->COLUMN_NAME, $access_rights[$column->COLUMN_NAME], array('class' => 'form-control'))); ?>

													<?php else: ?>
														<?php echo e(Form::number($column->COLUMN_NAME, $access_rights[$column->COLUMN_NAME], array('class' => 'form-control'))); ?>

													<?php endif; ?>
												<?php elseif(strpos($column->TYPE_NAME, 'bit') !== false): ?>
													<?php if($column->NULLABLE == 1): ?>
														<?php echo e(Form::checkbox($column->COLUMN_NAME, 1,$access_rights[$column->COLUMN_NAME], array('class' => 'form-control'))); ?>

													<?php else: ?>
														<?php echo e(Form::checkbox($column->COLUMN_NAME, 1, $access_rights[$column->COLUMN_NAME], array('class' => 'form-control'))); ?>

													<?php endif; ?>
												<?php elseif(strpos($column->TYPE_NAME, 'money') !== false): ?>
													<?php if($column->NULLABLE == 1): ?>
														<?php echo e(Form::number($column->COLUMN_NAME, $access_rights[$column->COLUMN_NAME], array('class' => 'form-control', 'step' => '0.01'))); ?>

													<?php else: ?>
														<?php echo e(Form::number($column->COLUMN_NAME, $access_rights[$column->COLUMN_NAME], array('class' => 'form-control', 'step' => '0.01', 'required' => ''))); ?>

													<?php endif; ?>
												<?php elseif(strpos($column->TYPE_NAME, 'real') !== false): ?>
													<?php if($column->NULLABLE == 1): ?>
														<?php echo e(Form::number($column->COLUMN_NAME, $access_rights[$column->COLUMN_NAME], array('class' => 'form-control', 'step' => 'any'))); ?>

													<?php else: ?>
														<?php echo e(Form::number($column->COLUMN_NAME, $access_rights[$column->COLUMN_NAME], array('class' => 'form-control', 'step' => 'any', 'required' => ''))); ?>

													<?php endif; ?>
												<?php elseif(strpos($column->TYPE_NAME, 'float') !== false): ?>
													<?php if($column->NULLABLE == 1): ?>
														<?php echo e(Form::number($column->COLUMN_NAME, $access_rights[$column->COLUMN_NAME], array('class' => 'form-control', 'step' => 'any'))); ?>

													<?php else: ?>
														<?php echo e(Form::number($column->COLUMN_NAME, $access_rights[$column->COLUMN_NAME], array('class' => 'form-control', 'step' => 'any', 'required' => ''))); ?>

													<?php endif; ?>
												<?php elseif(strpos($column->TYPE_NAME, 'binary') !== false): ?>
													<?php if($column->NULLABLE == 1): ?>
														<?php echo e(Form::number($column->COLUMN_NAME, $access_rights[$column->COLUMN_NAME], array('class' => 'form-control', 'step' => 'any'))); ?>

													<?php else: ?>
														<?php echo e(Form::number($column->COLUMN_NAME, $access_rights[$column->COLUMN_NAME], array('class' => 'form-control', 'step' => 'any', 'required' => ''))); ?>

													<?php endif; ?>
												<?php else: ?>
													<?php if($column->NULLABLE == 1): ?>
														<?php echo e(Form::text($column->COLUMN_NAME, $access_rights[$column->COLUMN_NAME], array('class' => 'form-control' ))); ?>

													<?php else: ?>
														<?php echo e(Form::text($column->COLUMN_NAME, $access_rights[$column->COLUMN_NAME], array('class' => 'form-control', 'required' => ''))); ?>

													<?php endif; ?>
												<?php endif; ?>
										</div>
									</td>
								</div>
							</tr>
						<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						<tr>
						<div class="form-group">
							<div class="col-md-8 col-md-offset-4">
								<td colspan="2">
								<?php echo e(Form::submit('Save', array('class' => 'btn btn-primary'))); ?>

								<a class="btn btn-default btn-close" href="<?php echo e(route('home')); ?>">Cancel</a>
								</td>
							</div>
						</div>
						</tr>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>