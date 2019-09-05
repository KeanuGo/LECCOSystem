<!DOCTYPE HTML>
<html>
	<head>
<style>
	div.accounts-th-div {
		border-bottom: 1px solid black;
		border-top: 1px solid black;
	}

	div.date-div {
		text-align: right;
	}

	div.date-div label {
		margin-right: 12px;
	}

	div.desc-div, #money-in-words {
		text-align: center;
		border: 3px solid black;
		line-height: 80%;
	}

	div.desc-panel {
		margin-top: 10px;
		margin-bottom: 10px;
	}

	div.receipt-div {
		border: 1px solid black;
	}

	div.main {
		font-weight: bold;
		font-family: sans-serif;
		width: 750px;
		margin-right: auto;
		margin-left: auto;
		padding: 2em;
		box-shadow: 0 0 5px black;
	}

	label {
		font-weight: bold;
	}

	label#description {
		font-size: 13px;
	}

	label#money-word {
		font-size: 13px;
		font-family: arial black;
	}

	table {
		text-align: center;
	}

	table.top-table, #accounts-table, .signatories-table, .cheque-sign-table, 
		 .cheque-table, .receipt-table, .cheque-desc-table, .bottom-cd-table {
		width: 100%;
	}

	table#accounts-table td {
		border: 1px solid black;
		font-weight: bold;
	}

	table.signatories-table td {
		line-height: 150%;
	}

	table.cheque-sign-table span {
		text-align: left;
	}

	table.cheque-table {
		text-align: left;
	}

	 table.cheque-table {
		text-align: left;
	}

	table.receipt-table td, th {
		font-size: 12px;;
	}

	table.cheque-desc-table label {
		font-size: 16px;
	}

	table.signatories-table, .cheque-sign-table {
		font-size: 15px;
	}

	table.top-table td {
		text-align: left;
	}
	 input.signature {
		 border:0;
		 border-bottom:2px solid #000;
		 text-align:center;
	 }
</style>
	</head>
<body>
<div class="main">
	<div align="center">
		<table>
			<tr>
				<td>
					<img src="/storage/lecco_logo.jpg" style="max-width: 80px; max-height: 80px; margin-right: 20px">
				</td>
				<td style="text-align:center">
					<label>LEYECO II EMPLOYEES CREDIT COOPERATIVE (LECCO)</label>
					<br><label style="font-size:12px">LEYECO II, Real St., Sagkahan, Tacloban City</label>
				</td>
			</tr>
		</table>
	</div>
	<div align="center" class="panel-body">
		<label>CHECK VOUCHER</label>
		<table class="top-table">
			<tr>
				<td><label>CV NO:     </label>
					<label> <?php echo e($check_voucher['cv_no']); ?></label></td>
				<td style="text-align:right"><label>DATE:     </label>
					<label><?php echo e(\Carbon\Carbon::parse($check_voucher['created_at'])->format('d-F-Y')); ?></label></td>
			</tr>
			<tr>
				<td><label>PAYEE:     </label> 
					<label><?php echo e($check_voucher['payee']); ?></label></td>
			</tr>
		</table>
		
	</div>
	<div class="desc-panel">
		<label>DESCRIPTION:</label>
		<div class="desc-div">
			<br><label id="description"><?php echo e($check_voucher['description']); ?></label><br><br>
		</div>
	</div>
	<div class="accounts-div" align="center">
		<table id="accounts-table">
			<!-- headers can be fetched from database too -->
			<th>Account Title</th>
			<th>Code</th>
			<th>Debit</th>
			<th>Credit</th>
			<?php for($i = 0; $i < count($cv_entries); $i++): ?>
				<tr>
					<!-- $cv_entries table values -->
					<td><i><?php echo e($cv_entries[$i]['account_title']); ?></i>
				  <?php if((strpos(strtolower($cv_entries[$i]['account_title']), 'cash') !== false) and (strpos(strtolower($cv_entries[$i]['account_title']), 'bank') !== false)): ?>
						  <script>var to_word = "<?php echo e(abs($cv_entries[$i]["debit"] - $cv_entries[$i]["credit"])); ?>";</script>
				  <?php endif; ?>
					 </td>
					<td> <?php echo e($cv_entries[$i]['account_code']); ?>

					<td> <?php echo e($cv_entries[$i]['debit']); ?> </td>
					<td> <?php echo e($cv_entries[$i]['credit']); ?> </td>
				</tr>
			<?php endfor; ?>
		</table>
		<div id="money-in-words">
		   <br><label id="money-word">SIX-HUNDRED THOUSAND PESOS ONLY</label><br><br>
		</div>
	</div><br>
	<div class="signatories-div">
		<table class="signatories-table">
			<tr>
				<td>Processed by:<br><br><input type="text" class="signature"><br><input type="text" style="text-align:center;border:0;" value="Staff"></td>
				<td>Pre-Audited by:<br><b>______________________</b><br>Audit-Committee Chairman</td>
			</tr>
			<tr>
				<td>Funds Available:<br><br><input type="text" class="signature"><br><input type="text" style="text-align:center;border:0;" value="Treasurer"></td>
				<td>Approved by:<br><b>______________________</b><br>General Manager</td>
			</tr>
		</table>
	</div><br>
	<div class="cheque-div">
		<!-- Board President/General Manager -->
		<table class="cheque-table">
			<tr>
				<td>
					<label>Check No:     </label>
					<label><?php echo e($check_voucher['check_no']); ?></label>
				</td>
			</tr>
			<tr>
				<td>
					<label>Check Date:     </label>
					<label><?php echo e(\Carbon\Carbon::parse($check_voucher['created_at'])->format('d-F-Y')); ?></label>
				</td>
			</tr>
		</table>
	</div><br>
	<div class="cheque-sign-div">
		<table class="cheque-sign-table">
			<tr>
				<td>Received by:<br>_____________________________________________<br>Signature Over Printed Name</td>
				<td>Date Disbursed:<br><?php echo e($check_voucher['date_disbursed']); ?><br> </td>
			</tr>
		</table>
	</div>
	<br>
	<hr style="border-top: 3px solid black">
	<br>
	<?php if(!$check_voucher['attachment']): ?>
	<div class="receipt-div">
		<table class="receipt-table">
			<tr>
				<th>Account No.</th>
				<th>Account Name</th>
				<th>Check No.</th>
			</tr>            
			<tr>
				<td><label><input type="text" style="border:0;text-align:center;" placeholder ="Enter account_no" autofocus/></label></td>
				<td><label>LEYECO II EMPLOYEES CREDIT COOPERATIVE</label></td>
				<td><label><?php echo e($check_voucher['check_no']); ?></label></td>
			</tr>
		</table><br>
		<div class="date-div">
			<label>Date:     </label><label>_____________________</label>
		</div><br>
		<div class="cheque-desc-div">
			<table class="cheque-desc-table">
				<tr>
					<td><label>Pay the order of   </label></td>
					<td><label><u><?php echo e($check_voucher['payee']); ?></u></label>
					<label>   Php</label></td>
					<td><input type="text" id="check_amount_field" style="border:0;text-align:center;" placeholder ="Enter amount" oninput="toWords(this.value, 'check-to-words')" autofocus/></td>
				</tr>
				<tr>
					<td><label>Pesos   </label></td>
					<td><label id="check-to-words">____________________________</label></td>
				</tr>
			</table><br>
			<table class="bottom-cd-table">
				 <tr>
					<td><label><input type="text" style="border:0;text-align:center;" placeholder ="Enter bank" autofocus/></label></td>
					<td><label><input type="text" style="border:0;text-align:center;" placeholder ="Enter treasurer name" autofocus/><br>Treasurer</label></td>
					<td><label><input type="text" style="border:0;text-align:center;" placeholder ="Enter bp/gm name" autofocus/><br>Board President/General Manager</label></td>
				</tr>
			</table>
		</div>
	</div>
	</div>
	<?php else: ?>
		<img style=" display:block;height:450px;width:750px;" src="/storage/attachments/<?php echo e($check_voucher['attachment']); ?>" />
	<?php endif; ?>
	<script>
	function toWords(value, id_to_print_result){
	value = value.replace(/,/g, '');
	var num = Number(value).toFixed(2);
	var decimal = ((num%1).toFixed(2))*100;
	num = Math.floor(num);
	var words = "";
	var w1 = ['', 'thousand', 'million', 'billion', 'trillion', 'quadrillion', 'quintillion', 'sextillion'];
	var w2 = ['', '', 'twenty','thirty','forty','fifty', 'sixty','seventy','eighty','ninety'];
	var w3 = ['','one ','two ','three ','four ', 'five ','six ','seven ','eight ','nine ','ten ','eleven ','twelve ','thirteen ','fourteen ','fifteen ','sixteen ','seventeen ','eighteen ','nineteen '];
	var level = 0;
	if(num > 0){
	while(num > 0){
			var thousand = num%1000;
			num = Math.floor(num/1000);
			var words_level = "";
			if(thousand >= 100){
			var hundreds = Math.floor(thousand/100);
				words_level += w3[hundreds] + "hundred ";
				thousand = thousand - (hundreds*100);
			}
			if(thousand >= 20){
				var tens = Math.floor(thousand/10);
				words_level += w2[tens] + " ";
				thousand = thousand - (tens*10);
			}else{
				words_level += w3[thousand] + " ";
				thousand = thousand - thousand;
			}
			if(thousand < 10){
				words_level += w3[thousand];
			}
			words_level += w1[level] + " ";
			level++;
			words = words_level + words;
		}
	}else{
		words += "zero ";
	}
	words += "and " + decimal + "/100 only";
	if(document.getElementById(id_to_print_result)){document.getElementById(id_to_print_result).innerHTML = "<u>" + words.toUpperCase() + "<u>";}
	if(document.getElementById("money-word")){document.getElementById("money-word").innerHTML = words.toUpperCase();}
	}
	function numberWithCommas(n) {
	var parts=n.toString().split(".");
	return parts[0].replace(/\\B(?=(\\d{3})+(?!\\d))/g, ",") + (parts[1] ? "." + parts[1] : ".00");
	}
	toWords(to_word, "check-to-words");
	if(document.getElementById("check_amount_field")){document.getElementById("check_amount_field").value = numberWithCommas(to_word);document.getElementById("check_amount_field").setAttribute( "value", numberWithCommas(to_word));}
</script>
</body>
</html>