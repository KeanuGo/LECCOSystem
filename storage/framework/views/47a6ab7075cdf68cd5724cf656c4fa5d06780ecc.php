<?php $__env->startSection('content'); ?>
<div align="center">
<h1 style='width:90%;text-align:left;' >Aging Loans</h1>
</div>
<div class="container">
	<div class="no-print" align="left">
		<?php echo Form::open(['url' => route('loans.view_aging_loans'), 'method' => 'GET']);; ?>

		<label for="late_by">Late by</label>
		<input type="number" name="late_by_amount" step="1" value=<?php echo e($late_by_amount); ?> style="max-width:50px;">
		<input type="radio" name="late_by" value="DAY" style="margin-right:10px;margin-left:10px"
		<?php if($late_by == 'DAY'): ?>
		<?php echo e('checked'); ?>

		<?php endif; ?>
		>Day/s
		<input type="radio" name="late_by" value="MONTH" style="margin-right:10px;margin-left:10px"
		<?php if($late_by == 'MONTH'): ?>
		<?php echo e('checked'); ?>

		<?php endif; ?>
		>Month/s
		<input type="radio" name="late_by" value="YEAR" style="margin-right:10px;margin-left:10px"
		<?php if($late_by == 'YEAR'): ?>
		<?php echo e('checked'); ?>

		<?php endif; ?>
		>Year/s
		&nbsp&nbsp<?php echo e(Form::submit('Filter', array('class' => 'btn btn-primary'))); ?>

		<a href="<?php echo e(route('loans.view_aging_loans')); ?>" class="link-tag view-a">Clear Filter</a>
		<br><br>
	</div>
	<div align="right">
	<input type="text" class="form-control" style="width:300px;display:inline" id = "searchbar" oninput="search()"></input>
	<button class= "btn btn-primary" onclick="search()">Search</button>
	</div>
	<br>
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