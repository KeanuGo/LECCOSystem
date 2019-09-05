<?php $__env->startSection('content'); ?>
<div class="container">
	<?php echo $__env->make('partials.filter_bar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
	<br>
	<table class="table table-striped" id="main-table">
		<?php if(count($scheds)>0): ?>
			<tr><th colspan="<?php echo e(count($scheds[0])); ?>" no-search><h3 style='text-align:center;'><?php echo e(ucwords(str_replace('_', ' ', $payroll))); ?> for <?php echo e(\Carbon\Carbon::parse($day)->format('F Y')); ?></h3></th></tr>
			<tr>
				<?php $__currentLoopData = $scheds[0]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
					<th no-search><?php echo e(ucwords(str_replace('_', ' ', $k))); ?></th>
				<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
			</tr>
		<?php else: ?>
			<tr><th no-search> Empty </th></tr>
		<?php endif; ?>
		<?php $__currentLoopData = $scheds; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sched): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
			<tr>
			<?php $__currentLoopData = $sched; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				<td> <?php echo e(($v== null? '0.00' :$v)); ?> </td>
			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
			
			</tr>
		<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
	</table>
	<div class="no-print">
		<a href="" onclick="return printDiv()" class="btn btn-default"> Print </a>
		<a href="<?php echo e(route('loans.lpds')); ?>" class="link-tag view-a"> Back </a>
	</div>
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
				var all_no_search = true;
				for(var j = 0; j < cells.length; j++){
					if(tosearch == ""){
						includes = true;
						break;
					}
					if(!cells[j].hasAttribute("no-search")){
						all_no_search = false;
						if(cells[j].innerHTML.toLowerCase().includes(tosearch)){
							includes = true;
							break;
						}
					}
				}
				if(includes || all_no_search){
					rows[i].style.display = 'table-row';
				}else{
					rows[i].style.display = 'none';
				}
			}
		}
	}
	
	function printDiv(){
		var divToPrint = document.getElementById('main-table');
		newWin = window.open("");
		newWin.document.write('<div align="center">');
		newWin.document.write('<table>');
		newWin.document.write('<tr>');
		newWin.document.write('<td>');
		newWin.document.write('<img src="/storage/others/lecco_logo.jpg" style="max-width: 80px; max-height: 80px; margin-right: 0px">');
		newWin.document.write('</td>');
		newWin.document.write('<td style="text-align:center">');
		newWin.document.write('<label>LEYECO II EMPLOYEES CREDIT COOPERATIVE (LECCO)</label>');
		newWin.document.write('<br><label style="font-size:12px">LEYECO II, Real St., Sagkahan, Tacloban City</label>');
		newWin.document.write('</td>');
		newWin.document.write('</tr>');
		newWin.document.write('</table>');
		newWin.document.write('</div>');
		newWin.document.write("<h3 style='text-align:center;'> <?php echo e(ucwords(str_replace('_', ' ', $payroll))); ?> for <?php echo e(\Carbon\Carbon::parse($day)->format('F Y')); ?> </h3>");
		newWin.document.write("<hr>");
		newWin.document.write("<table border = 1 style='text-align:center;'>");
		var total_per_type = {};
		<?php if(count($scheds)>0): ?>
			newWin.document.write("<tr>");
			<?php $__currentLoopData = $scheds[0]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				newWin.document.write("<th><?php echo e(ucwords(str_replace('_', ' ', $k))); ?></th>");
			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
			newWin.document.write("<th> Total </th>");
			newWin.document.write("</tr>");
			<?php $__currentLoopData = $scheds; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sched): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				var total = 0;
				newWin.document.write("<tr>");
				<?php $__currentLoopData = $sched; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
					newWin.document.write("<td> <?php echo e(($v== null? '0.00' :$v)); ?> </td>");
					<?php if(!($k == 'member_id' or $k == 'name')): ?>
						total_per_type['<?php echo e($k); ?>'] = (total_per_type['<?php echo e($k); ?>'] || 0.0);
						total_per_type['<?php echo e($k); ?>'] += total_per_type['<?php echo e($k); ?>'] + Number(<?php echo e(($v== null? '0.00' :$v)); ?>);
						total += Number(<?php echo e(($v== null? '0.00' :$v)); ?>);
					<?php endif; ?>
				<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
				newWin.document.write("<td>" + total + "</td>");
				newWin.document.write("</tr>");
			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
		<?php endif; ?>
		newWin.document.write("<th colspan = 2> Totals </td>");
		var total = 0;
		for(var k in total_per_type){
			newWin.document.write("<th>" + total_per_type[k] + "</td>");
			total += total_per_type[k];
		}
		newWin.document.write("<th>" + total + "</td>");
		newWin.document.write("</table>");
		newWin.print();
		newWin.close();
	}
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>