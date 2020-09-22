<!-- **************************************************************************
* Copyright 2020 Marshall Brown, Josiah Schmidt, Micah Withers
*
* Unless required by applicable law or agreed to in writing, software
* distributed under the License is distributed on an "AS IS" BASIS,
* WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or
* See the License for the specific language governing permissions and
* limitations under the License.
************************************************************************** -->

<!-- php file required to insert new lots into database (US 3.1) -->
<?php
    require 'sql.php';
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <!-- Overall page format -->
        <meta name="viewport" content="width=device-width, initial-scale=1" charset="utf-8">
        <!-- Link to CSS stylesheet -->
        <link rel="stylesheet", href="styles.css">
    </head>

    <body>
          <nav>
            <ul>
				<li><button id="myBtnLot">Add Lot</button></li>
                <li><a href="history.php">Lot History</a></li>
                <li><a href="reports.html">Reports</a></li>
                <li><a href="customers.php">Customers</a></li>
                <li><a href="accounts.html">Accounts</a></li>
                <li><a href="../LoginPage/login.html">Logout</a></li>
            </ul>
         </nav>

		  <main class="container">
            <div id="addCust" class="modal">
                <!-- pop up content -->
                <div id="custbox" class="modal-content">
                    <span id="spanCust" class="close">&times;</span>
                    <p>Add Customer</p>
                    <!-- form for User Story 4.4.1 -->
                    <form class="" action="" method="post">
                        <label for="company">Company</label>
                        <input type="text" name="company" required>
						<br>

                        <label for="contact">Contact</label>
                        <input type="text" name="contact" required>
						<br>

                        <label for="phone">Phone</label>
                        <input type="number" name="phone" required>
						<br>

            		    <label for="email">E-mail</label>
                        <input type="text" name="email" required>
						<br>

                        <button type="submit" class="btn">Submit</button>
                    </form>

                    <!-- Action for submit of form to add customer (User Story 4.4.2)-->
                    <?php if (isset($_POST['company'], $_POST['contact'], $_POST['phone'], $_POST['email'])) { ?>
                        <script>
                            alert("<?php echo addCustomer($_POST['company'], $_POST['contact'], $_POST['phone'], $_POST['email']); ?>");
                        </script>
                    <?php } ?>
                </div>
            </div>
            <!-- US 2.1, 5.1-5.2: The pop up -->
            <div id="addLot" class="modal">
                <!-- pop up content -->
                <div id="lotbox" class="modal-content">
                    <span id="spanLot" class="close">&times;</span>
                    <form class="" method="post">
                        <label for="lotnum">Lot No.</label>
    					<input name="lotnum" type="number" required=true > <br>

    					<label for="cust">Customer</label>
    					<input type="search" name="cust" list="custList">

    					<!--Lets names pop up with search-->
    					<datalist id="custList">
    					</datalist>

    					<button type="button" id="myBtnCust">+</button>

                        <div id="pallets-div">
                            <!-- All pallets will be added here -->
                        </div>
                        <button type="button" id="addPal">Add Pallet</button>
                        <button type="button" id="rmvPal" disabled=true>Remove</button>
                        <button type="submit" class="btnLot">Submit</button>

    					<!-- Action for submit of form to add lot (US 3.1, 6.3)-->
                        <script type="text/javascript">
                        <?php
                            if (isset($_POST['lotnum'], $_POST['cust'], $_POST['amt1'])) {
                                $result = addLot($_POST['lotnum'], $_POST['cust'], $_POST['amt1']);
                                if ($result == 'Success') {
                                    echo "alert(".json_encode($_POST['cust']."'s Lot ".$_POST['lotnum']." was successfully added to the database").');';
                                }
                                else {
                                    echo "alert(".json_encode($result).");";
                                }
                            }
                        ?>
                        </script>
                    </form>
                </div>
            </div>
            <!-- Import JS functions -->
            <script type="module" defer>
                import * as Script from './scripts.js';
                let custList = <?php echo json_encode(get_customers_list()); ?>;
                Script.custAdd("custList", custList);
                Script.setupBoth();
                Script.addPallet(Script.palletsDivId);
                let addCustBtn = document.getElementById(Script.addCustBtnId);
                addCustBtn.addEventListener('click', function() {
                    var modalLot = document.getElementById("addLot");
                    modalLot.style.display = 'none';
                    var modalCust = document.getElementById("addCust");
                    modalCust.style.display = "block";
                });
                let addPalBtn = document.getElementById(Script.addPalBtnId);
                addPalBtn.addEventListener('click', function() {
                    console.log("Add Pallet clicked");
                    Script.addPallet(Script.palletsDivId);
                });
                let rmvPalBtn = document.getElementById(Script.rmvPalBtnId);
                rmvPalBtn.addEventListener('click', function() {
                    Script.removePallet(Script.palletsDivId)
                });

                // US 4.2, 5.3: Table of lot info from db
                <?php $lots = get_lots(); ?>
                var rows = <?php echo json_encode(get_rows($lots)); ?>;
                var fields = <?php echo json_encode(get_fields($lots)); ?>;
                var tableId = "lotsTable";
                Script.createLotTable(tableId, rows, fields);
            </script>
		</main>

		<h1>Home</h1>
        <!-- US 5.3: JavaScript array to contain table values from db -->
        <div id="tableDiv" class="">

        </div>

        <!-- Link to JavaScript source file -->
        <!-- <script src="addLotDialogue.js"></script> -->
    </body>
</html>
