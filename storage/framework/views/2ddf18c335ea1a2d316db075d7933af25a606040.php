<?php $__env->startSection('content'); ?>
<div align="center">
<h1 style='width:90%;text-align:left;' >Signatories</h1>
</div>
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Add Signatory</div>
				<?php echo Form::open(['url' => route('signatories.store')]);; ?>

                <div class="panel-body">
				<table class='table table-striped'>
                        <?php echo e(csrf_field()); ?>

						<?php $__currentLoopData = $columns; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $column): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
						<tr>
							<?php if($column->COLUMN_NAME == 'id' or strpos($column->COLUMN_NAME, 'created_at') !== false or strpos($column->COLUMN_NAME, 'updated_at') !== false): ?>
								<?php continue; ?>;
							<?php endif; ?>
							<!--<div class="form-group">-->
								<td colspan="2">
								<?php echo e(Form::label($column->COLUMN_NAME, ucwords(str_replace('_', ' ', $column->COLUMN_NAME)), array('class' => 'col-md-4 control-label'))); ?>

								
								<div class="col-md-6">
									<?php if(strpos($column->COLUMN_NAME, 'avatar') !== false): ?>
										<?php echo e(Form::text($column->COLUMN_NAME, 'FILECHOOSER HERE', array('class' => 'form-control', 'required' => ''))); ?>

									<?php elseif(strpos($column->TYPE_NAME, 'date') !== false): ?>
										<?php if($column->NULLABLE == 1): ?>
											<?php echo e(Form::date($column->COLUMN_NAME, \Carbon\Carbon::now(), array('class' => 'form-control'))); ?>

										<?php else: ?>
											<?php echo e(Form::date($column->COLUMN_NAME, \Carbon\Carbon::now(), array('class' => 'form-control', 'required' => ''))); ?>

										<?php endif; ?>
									<?php elseif(strpos($column->TYPE_NAME, 'int') !== false): ?>
										<?php if($column->NULLABLE == 1): ?>
											<?php echo e(Form::number($column->COLUMN_NAME, null, array('class' => 'form-control'))); ?>

										<?php else: ?>
											<?php echo e(Form::number($column->COLUMN_NAME, null, array('class' => 'form-control'))); ?>

										<?php endif; ?>
									<?php elseif(strpos($column->TYPE_NAME, 'money') !== false or strpos($column->TYPE_NAME, 'decimal') !== false): ?>
										<?php if($column->NULLABLE == 1): ?>
											<?php echo e(Form::number($column->COLUMN_NAME, null, array('class' => 'form-control', 'step' => '0.01'))); ?>

										<?php else: ?>
											<?php echo e(Form::number($column->COLUMN_NAME, null, array('class' => 'form-control', 'step' => '0.01', 'required' => ''))); ?>

										<?php endif; ?>
									<?php elseif(strpos($column->TYPE_NAME, 'real') !== false): ?>
										<?php if($column->NULLABLE == 1): ?>
											<?php echo e(Form::number($column->COLUMN_NAME, null, array('class' => 'form-control', 'step' => 'any'))); ?>

										<?php else: ?>
											<?php echo e(Form::number($column->COLUMN_NAME, null, array('class' => 'form-control', 'step' => 'any', 'required' => ''))); ?>

										<?php endif; ?>
									<?php elseif(strpos($column->TYPE_NAME, 'float') !== false): ?>
										<?php if($column->NULLABLE == 1): ?>
											<?php echo e(Form::number($column->COLUMN_NAME, null, array('class' => 'form-control', 'step' => 'any'))); ?>

										<?php else: ?>
											<?php echo e(Form::number($column->COLUMN_NAME, null, array('class' => 'form-control', 'step' => 'any', 'required' => ''))); ?>

										<?php endif; ?>
									<?php elseif(strpos($column->TYPE_NAME, 'binary') !== false): ?>
										<?php if($column->NULLABLE == 1): ?>
											<?php echo e(Form::number($column->COLUMN_NAME, null, array('class' => 'form-control', 'step' => 'any'))); ?>

										<?php else: ?>
											<?php echo e(Form::number($column->COLUMN_NAME, null, array('class' => 'form-control', 'step' => 'any', 'required' => ''))); ?>

										<?php endif; ?>
									<?php else: ?>
										<?php if($column->NULLABLE == 1): ?>
											<?php echo e(Form::text($column->COLUMN_NAME, '', array('class' => 'form-control' ))); ?>

										<?php else: ?>
											<?php echo e(Form::text($column->COLUMN_NAME, '', array('class' => 'form-control', 'required' => ''))); ?>

										<?php endif; ?>
									<?php endif; ?>
								</div>
								</td>
							<!--</div>-->
						</tr>
						<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						<tr>
						<!--<div class="form-group">-->
							<td colspan="2">
                            <div class="col-md-8 col-md-offset-4">
                                <?php echo e(Form::submit('Add', array('class' => 'btn btn-primary'))); ?>

								<a href="<?php echo e(url()->previous()); ?>" class="btn btn-default btn-close"> Cancel </a>
                            </div>
							</td>
                        <!--</div>-->
						</tr>
				</table>
                </div>
				<?php echo e(Form::close()); ?>

            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>