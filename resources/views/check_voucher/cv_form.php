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
                <td><label>CV NO: &nbsp&nbsp&nbsp&nbsp</label>
                    <label>2018065</label></td>
                <td style="text-align:right"><label>DATE: &nbsp&nbsp&nbsp&nbsp</label>
                    <label>18-Apr-18</label></td>
            </tr>
            <tr>
                <td><label>PAYEE: &nbsp&nbsp&nbsp&nbsp</label> 
                    <label>MARK GIL NATAN</label></td>
            </tr>
        </table>
        
    </div>
    <div class="desc-panel">
        <label>DESCRIPTION:</label>
        <div class="desc-div">
            <br><label id="description">In payment of interest on share capital.</label><br><br>
        </div>
    </div>
    <div class="accounts-div" align="center">
        <table id="accounts-table">
            <!-- headers can be fetched from database too -->
            <th>Account Title</th>
            <th>Code</th>
            <th>Debit</th>
            <th>Credit</th>
            @for($i = 0; $i < 5; $i++)
                <tr>
                    <!-- cv_entries table values -->
                    <td><i> PATRONAGE REFUND </i></td>
                    <td> 22600 </td>
                    <td> 180,936.43 </td>
                    <td> 544,899.00 </td>
                </tr>
            @endfor
        </table>
        <div id="money-in-words">
           <br><label id="money-word">SIX-HUNDRED THOUSAND PESOS ONLY</label><br><br>
        </div>
    </div><br>
    <div class="signatories-div">
        <table class="signatories-table">
            <tr>
                <td>Processed by:<br><b>______________________</b><br>Staff</td>
                <td>Pre-Audited by:<br><b>______________________</b><br>Audit-Committee Chairman</td>
            </tr>
            <tr>
                <td>Funds Available:<br><b>______________________</b><br>Treasurer</td>
                <td>Approved by:<br><b>______________________</b><br>General Manager</td>
            </tr>
        </table>
    </div><br>
    <div class="cheque-div">
        <!-- Board President/General Manager -->
        <table class="cheque-table">
            <tr>
                <td>
                    <label>Check No: &nbsp&nbsp&nbsp&nbsp</label>
                    <label>148885</label>
                </td>
            </tr>
            <tr>
                <td>
                    <label>Check Date: &nbsp&nbsp&nbsp&nbsp</label>
                    <label>4/18/2018</label>
                </td>
            </tr>
        </table>
    </div><br>
    <div class="cheque-sign-div">
        <table class="cheque-sign-table">
            <tr>
                <td>Received by:<br>_____________________________________________<br>Signature Over Printed Name</td>
                <td>Date Disbursed:<br>______________________<br>&nbsp</td>
            </tr>
        </table>
    </div>
    <br>
    <hr style="border-top: 3px solid black">
    <br>
    <div class="receipt-div">
        <table class="receipt-table">
            <tr>
                <th>Account No.</th>
                <th>Account Name</th>
                <th>Check No.</th>
            </tr>            
            <tr>
                <td><label>64-362-820001-2</label></td>
                <td><label>LEYECO II EMPLOYEES CREDIT COOPERATIVE</label></td>
                <td><label>148885</label></td>
            </tr>
        </table><br>
        <div class="date-div">
            <label>Date: &nbsp&nbsp&nbsp&nbsp</label><label>_____________________</label>
        </div><br>
        <div class="cheque-desc-div">
            <table class="cheque-desc-table">
                <tr>
                    <td><label>Pay the order of &nbsp&nbsp</label></td>
                    <td><label>____________________________</label>
                    <label>&nbsp&nbsp&nbspPhp</label></td>
                    <td><label>____________________________</label></td>
                </tr>
                <tr>
                    <td><label>Pesos &nbsp&nbsp</label></td>
                    <td><label>____________________________</label></td>
                </tr>
            </table><br>
            <table class="bottom-cd-table">
                 <tr>
                    <td><label>Bank</label></td>
                    <td><label>MARK GIL G. NATAN<br>Treasurer</label></td>
                    <td><label>NELSON GO<br>Board President/General Manager</label></td>
                </tr>
            </table>
        </div>
    </div>
</div>

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
</style>

<script>
    function moneyToWords() {

    }
</script>