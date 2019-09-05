<?php $__env->startSection('content'); ?>
<div class="container">
	<div align="right">
	<input type="text" class="form-control" style="width:300px;display:inline" id = "searchbar" oninput="search()"></input>
	<button class= "btn btn-primary" onclick="search()">Search</button>
	</div>
	<br>
	<table class="table table-striped" id="main-table">
		<tr>
			<?php if(count($payroll_deductions) > 0): ?>
				<?php $__currentLoopData = $payroll_deductions[0]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
					<th><?php echo e(ucwords(str_replace('_', ' ', $k))); ?></th>
				<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
				<th>Actions</th>
			<?php else: ?>
				<th> Empty </th>
			<?php endif; ?>
		</tr>
		<?php $__currentLoopData = $payroll_deductions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payroll_deduction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
			<tr>
			<?php $__currentLoopData = $payroll_deduction; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				<?php if(strpos($k, 'month') !== false and strpos($k, 'year') !== false and strpos($k, 'applied') !== false): ?>
					<td><?php echo e(\Carbon\Carbon::parse($v)->format('F Y')); ?></td>
					<?php continue; ?>;
				<?php endif; ?>
				<td> <?php echo e(ucwords(str_replace('_', ' ', $v))); ?> </td>
			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
			<td no-search>
				<a href="<?php echo e(route('loans.viewschedule', ['id' => $payroll_deduction->payroll, 'id2' => $payroll_deduction->month_year_applied])); ?>" class="link-tag view-a">View</a>
			</td>
			</tr>
		<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
	</table>
</div>

<script>
	function search(){
		var searchbar = document.getElementById("searchbar");
		var tosearch = searchbar.value.toLowerCase();
		var table = document.getElementById("main-table");
		if(table && searchbar){
			var rows = table.rows;
			for(var i = 1; i < rows.length; i++){
				var cells = rows[i].cells;
				var includes = false;
				for(var j = 0; j < cells.length; j++){
					if(cells[j].innerHTML.toLowerCase().includes(tosearch) && !cells[j].hasAttribute("no-search")){
						includes = true;
						break;
					}
				}
				if(includes){
					rows[i].style.display = 'table-row';
				}else{
					rows[i].style.display = 'none';
				}
			}
		}
	}
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>