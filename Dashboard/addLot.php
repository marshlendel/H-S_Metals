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
<!-- For Development Cycle 7 -->
<!DOCTYPE html>
<html lang="en-US">
    <head>
        <meta charset="UTF-8">
        <title>Add Lot</title>
		<!--<meta name="viewport" content="width=device-width, initial-scale=1.0">-->
    	<link href="styles2.css" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css2?family=Ramabhadra&display=swap" rel="stylesheet">

		<!-- Styling for normal display -->
        <style media="screen">
            .printable { display:none; }
            #tableParent {
                margin: auto;
                display: flex;
                flex-direction: column;
            }
            #tableDiv {
                margin-top: 50px;
                display: flex;
                margin-left: 10%;
                margin-right: 10%;
            }
            #totalNet {
                align-self: flex-end;
                margin-right: 10%;
            }
        </style>
        <!-- US 8.3: Styling for printing. Only elements with "printable" classes are visible -->
        <style media="print">
            .non-printable { display:none; }
            .printable {
                display:block;
            }
            div {
                width: 800px;
                white-space: nowrap;
                overflow: hidden;
            }
			label {
                display: inline-block;
				font-size: 48px;
			}
            .field {
                width: 35%;
            }

        </style>
    </head>
    <body>
        <nav class="navBar non-printable">
            <a href="main.php" id="logo"></a>
            <a href="addLot.php" id="highlight">Add Lot</a>
            <a href="history.php">Lot History</a>
            <a href="reports.html">Reports</a>
            <a href="customers.php">Customers</a>
            <a href="accounts.html">Accounts</a>
            <a href="../LoginPage/login.html">Logout</a>
        </nav>

		<h1 class="non-printable">Add Lot</h1>

    	<section class="non-printable">
    		<form id="navForm" method="post">
                <?php
                // US 7.6: checks if fields have been filled on page load/form submit
                $submit = isset($_POST['lotnum'], $_POST['cust'], $_POST['gross'], $_POST['tare']);
                // US 7.1: retrieves the highest lot number value from database
                $lotnum = max(get_lots_list());
                ?>
                <script type="text/javascript">
                // US 7.6: debugging info
                    // console.log("<?php //echo $_POST['lotnum'] ?>");
                    // console.log("<?php //echo $_POST['cust'] ?>");
                    // console.log("<?php //echo $_POST['gross'] ?>");
                    // console.log("<?php //echo $_POST['tare'] ?>");
                    // console.log(<?php //echo json_encode($submit); ?>);
                    // console.log(<?php //echo json_encode(get_lots_list()); ?> );
                    // console.log("Lot Max: " + <?php //echo json_encode($lotnum); ?> );
                </script>
                <?php
                // US 7.6: if form has been filled, data is added to database
                if ($submit) {
                    // US 7.6: if the lot number submitted is greater than the highest value lot number in database,
                    //      a new lot is created
                    if ((int) $_POST["lotnum"] > $lotnum) {
                        $result = addLot($_POST['lotnum'], $_POST['cust']);
                        ?>
                        <script type="text/javascript">
                            console.log("Add Lot: " + <?php echo json_encode($result); ?> );
                        </script>
                        <?php
                    }
                    // US 7.6: pallet is added to database
                    $result = addPallet($_POST['lotnum'], $_POST['gross'], $_POST['tare']);
                    ?>
                    <script type="text/javascript">
                        console.log("Add Pallet: " + <?php echo json_encode($result); ?> );
                    </script>
                    <?php
                }
                ?>
                <!-- US 7.1: lot label and lot number -->
        		<div id="lotBar">
        			<label for="lotNum">Lot No.</label>
                    <input type="number" name="lotnum" value=
                        <?php
                        // US 7.1: if a form has been submitted, the lot number displayed is the lot number submitted,
                        //      otherwise it is one greater than the highest value in the database
                        if ($submit) {
                            echo json_encode($_POST['lotnum']);
                        }
                        else {
                            echo json_encode($lotnum+1);
                        }
                        ?>
                    required></input>
        		</div>
                <!-- US 7.2-7.5: labels and inputs for Customer, Gross, and Tare -->
        		<div class="nav">
                    <label for="cust">Customer:</label>
        			<input type="search" name="cust" list="custList" required>
                    <datalist id="custList">
        			</datalist>

        			<label for="gross">Gross:</label>
        			<input type="number" name="gross" required><br>

        			<label for="tare">Tare:</label>
        			<input type="number" name="tare" required><br>

                    <button type="button" id="printBtn" disabled>Print</input>
        			<button type="submit" id="submit" disabled>New Pallet</button>
        		</div>
    		</form>
    	</section>
        <br>
        <div id="tableParent" class="non-printable">
        	<div id="tableDiv">
            </div>
            <!-- US 8.4: Creates Total Net label and fetches lot net from DB -->
            <?php
            if(isset($_POST['lotnum'])) {
                echo "<label id=\"totalNet\">Total Net: ".getLotNet($_POST['lotnum'])."</label>";
            }
            ?>
        </div>
        <p id="toPrint" class="printable">
        </p>
    </body>
    <script type="module" defer>
        // imports functions to create the table and list of customers
        import * as Script from './scripts.js';

        // US 7.2: obtain list of customers from db
        var custList = <?php echo json_encode(get_customers_list()); ?>;
        Script.custAdd("custList", custList);

        // US 7.2: obtains dictionary of lot : customer values
        var lotsList = <?php echo json_encode(getLotsCustomerList()); ?>;

        function checkLot(lotnum) {
            if (lotsList[lotnum] != undefined) {
                return true;
            }
            return false;
        }

        // US 7.6: checks that user input is valid
        function checkInputs() {
           var printBtn = document.getElementById("printBtn");
           var submitBtn = document.getElementById("submit");
           var lotInput = document.getElementsByName("lotnum")[0];
           var custInput = document.getElementsByName("cust")[0];
           var grossInput = document.getElementsByName("gross")[0];
           var tareInput = document.getElementsByName("tare")[0];

           // Checks that user input for Customer exists in the database
           let validCust = false;
           for (let index = 0; index < custList.length; ++index) {
               if (custInput.value == custList[index]["company"]) {
                   validCust = true;
               }
           }

           // Checks that user input for lot number is greater than 0, Gross is greater than 0,
           //       and Gross is greater than Tare
           if (validCust && parseFloat(lotInput.value) > 0 && parseFloat(grossInput.value) > 0 && parseFloat(grossInput.value) > parseFloat(tareInput.value)) {
               printBtn.disabled = false;
               submitBtn.disabled = false;
           }
           else {
               printBtn.disabled = true;
               submitBtn.disabled = true;
           }
        }

        // Retrieves input elements
        var lotInput = document.getElementsByName("lotnum")[0];
        var custInput = document.getElementsByName("cust")[0];
        var grossInput = document.getElementsByName("gross")[0];
        var tareInput = document.getElementsByName("tare")[0];

        // Does not allow user to change the lot number or customer name if a form was previously submitted
        let formSubmit = <?php echo json_encode($submit); ?>;
        if (formSubmit) {
           custInput.setAttribute('value', <?php  if ($submit) echo json_encode($_POST['cust']); ?>);
           custInput.setAttribute('readonly', 'readonly');
           lotInput.setAttribute('readonly', 'readonly');
        }
        else {
            lotInput.addEventListener('focusout', function() {
                if (checkLot(lotInput.value)) {
                    custInput.value = lotsList[lotInput.value];
                    custInput.setAttribute('readonly', 'readonly');
                }
                else {
                    custInput.removeAttribute('readonly');
                }
            }, false);
            lotInput.addEventListener('input', function() {
                checkInputs();
            }, false);
            custInput.addEventListener('input', function() {
               checkInputs();
           }, false);
        }
        grossInput.addEventListener('input', function() {
           checkInputs();
        }, false);
        tareInput.addEventListener('input', function() {
           checkInputs();
        }, false);


        // US 7.5, 7.6: create pallets table and retrieves pallets of the lot if submit button has been clicked
        <?php
        if ($submit) {
           $pallets = get_pallets($_POST['lotnum']);
        ?>
           var rows = <?php echo json_encode(get_rows($pallets)); ?>;
           var fields = <?php echo json_encode(get_fields($pallets)); ?>;
           console.log(fields);
           console.log(rows);
           var headers = ["Pallet", "Gross", "Tare", "Net"];
           var tableId = "tableDiv";
           Script.makeTable(tableId, fields, rows, headers, "palletnum");
        <?php
        }
        ?>
        // US 8.3: gets number of pallets from DB
        var maxPallets = <?php echo json_encode(get_num_pallets()); ?>;

        // US 8.3: alters HTML for when a pallet is printed
        function printPallet() {
            console.log("Printing");
            let printP = document.getElementById("toPrint");
            let custName = document.getElementsByName("cust")[0].value;
            let lotNum = document.getElementsByName("lotnum")[0].value;
            // let pallets = document.getElementsByClassName('print');
            let gross = document.getElementsByName("gross")[0].value;
            let tare = document.getElementsByName("tare")[0].value;
            let palletNum = maxPallets.hasOwnProperty(lotNum) ? maxPallets[lotNum]+1 : 1;

            console.log(gross);
            console.log(tare);
            console.log(gross-tare);
            console.log(palletNum);
            printP.innerHTML = "<div><label class=\"field\">Customer</label><label>"+custName+"</label></div>"+
                    "<br><div><label class=\"field\">Lot#</label><label>"+lotNum.toString()+"</label></div>"+
                    "<br><div><label class=\"field\">Gross</label><label>"+gross.toString()+"</label></div>"+
                    "<br><div><label class=\"field\">Tare</label><label>"+tare.toString()+"</label></div>"+
                    "<br><div><label class=\"field\">Net</label><label>"+(gross-tare).toString()+"</label></div>"+
                    "<br><div><label class=\"field\">Pallet#</label><label>"+(palletNum).toString()+"</label>";
            window.print();
        }

        // US 8.3: sets click listener for Print button. Calls printPallet when clicked
        var printBtn = document.getElementById("printBtn");
        printBtn.addEventListener('click', function() {
            printPallet();
        }, false);
   </script>
</html>
