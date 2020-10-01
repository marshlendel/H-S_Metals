<!-- **************************************************************************
* Copyright 2020 Marshall Brown, Josiah Schmidt, Micah Withers
*
* Unless required by applicable law or agreed to in writing, software
* distributed under the License is distributed on an "AS IS" BASIS,
* WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or
* See the License for the specific language governing permissions and
* limitations under the License.
************************************************************************** -->
<?php
    require 'sql.php';
?>

<!DOCTYPE html>
<html lang="en-US">
    <head>
        <meta charset="UTF-8">
        <title>Add Lot</title>
    	<link href="styles2.css" rel="stylesheet">
    </head>
    <body>
        <nav class="navBar">
            <a href="main.php" id="logo"></a>
            <a href="addLot.php" id="highlight">Add Lot</a>
            <a href="history.php">Lot History</a>
            <a href="reports.html">Reports</a>
            <a href="customers.php">Customers</a>
            <a href="accounts.html">Accounts</a>
        </nav>
    	<section>
    		<form id="navForm" method="post">
                <?php
                $submit = isset($_POST['lotnum'], $_POST['cust'], $_POST['gross'], $_POST['tare']);
                $lotnum = max(get_lots_list());
                ?>
                <script type="text/javascript">
                    console.log("<?php echo $_POST['lotnum'] ?>");
                    console.log("<?php echo $_POST['cust'] ?>");
                    console.log("<?php echo $_POST['gross'] ?>");
                    console.log("<?php echo $_POST['tare'] ?>");
                    console.log(<?php echo json_encode($submit); ?>);
                    console.log(<?php echo json_encode(get_lots_list()); ?> );
                    console.log("Lot Max: " + <?php echo json_encode($lotnum); ?> );
                </script>
                <?php
                if ($submit) {
                    if ((int) $_POST["lotnum"] > $lotnum) {
                        $result = addLot($_POST['lotnum'], $_POST['cust']);
                        ?>
                        <script type="text/javascript">
                            console.log("Add Lot: " + <?php echo json_encode($result); ?> );
                        </script>
                        <?php
                    }
                    $result = addPallet($_POST['lotnum'], $_POST['gross'], $_POST['tare']);
                    ?>
                    <script type="text/javascript">
                        console.log("Add Pallet: " + <?php echo json_encode($result); ?> );
                    </script>
                    <?php
                }
                ?>
        		<div id="lotBar">
        			<label for="lotNum">Lot No.</label>
                    <input type="number" name="lotnum" value=
                        <?php
                        if ($submit) {
                            echo json_encode($_POST['lotnum']);
                        }
                        else {
                            echo json_encode($lotnum+1);
                        }
                        ?>
                    required></input>
        		</div>
        		<div class="nav">
                    <label for="cust">Customer:</label>
        			<input type="search" name="cust" list="custList" required>
                    <datalist id="custList">
        			</datalist>

        			<label for="gross">Gross:</label>
        			<input type="number" name="gross" required><br>

        			<label for="tare">Tare:</label>
        			<input type="number" name="tare" required><br>

        			<button type="submit" id="submit" disabled>New Pallet</button>
        		</div>
    		</form>
    	</section>
        <br>
    	<div id="tableDiv">

        </div>
    </body>
    <script type="module" defer>
       import * as Script from './scripts.js';

       // US 7.2: obtain list of customers from db
       var custList = <?php echo json_encode(get_customers_list()); ?>;
       Script.custAdd("custList", custList);

       function checkInputs() {
           var submitBtn = document.getElementById("submit");
           var custInput = document.getElementsByName("cust")[0];
           var grossInput = document.getElementsByName("gross")[0];
           var tareInput = document.getElementsByName("tare")[0];

           let validCust = false;
           for (let index = 0; index < custList.length; ++index) {
               if (custInput.value == custList[index]["company"]) {
                   validCust = true;
               }
           }
           if (validCust && parseFloat(grossInput.value) > parseFloat(tareInput.value)) {
               submitBtn.disabled = false;
           }
           else {
               submitBtn.disabled = true;
           }
       }

       var lotInput = document.getElementsByName("lotnum")[0];
       var custInput = document.getElementsByName("cust")[0];
       var grossInput = document.getElementsByName("gross")[0];
       var tareInput = document.getElementsByName("tare")[0];

       let formSubmit = <?php echo json_encode($submit); ?>;
       if (formSubmit) {
           custInput.setAttribute('value', <?php echo json_encode($_POST['cust']); ?>);
           custInput.setAttribute('readonly', 'readonly');
           lotInput.setAttribute('readonly', 'readonly');
       }
       else {
           tareInput.addEventListener('focusout', function() {
               checkInputs();
           }, false);
           custInput.addEventListener('focusout', function() {
               checkInputs();
           }, false);
       }
       grossInput.addEventListener('focusout', function() {
           checkInputs();
       }, false);
       tareInput.addEventListener('focusout', function() {
           checkInputs();
       }, false);


       // US 7.5, 7.6: create pallets table and retrieves pallets of the lot if submit button has been clicked
       <?php
       if ($submit) {
           $pallets = get_pallets($_POST['lotnum']);
       ?>
           var rows = <?php echo json_encode(get_rows($pallets)); ?>;
           var fields = <?php echo json_encode(get_fields($pallets)); ?>;
           var tableId = "pallets";
           Script.stringifyRows(fields, rows);
           Script.createTable("tableDiv", tableId, rows, ["palletnum", "gross", "tare", "net"]);
       <?php
       }
       ?>
   </script>
</html>
