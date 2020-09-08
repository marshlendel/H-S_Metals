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
        <style>
            /* Table in User Story 4.2 */
            table {
              font-family: arial, sans-serif;
              border-collapse: collapse;
              width: 100%;
            }
            td, th {
              border: 1px solid #dddddd;
              text-align: left;
              padding: 8px;
            }
            tr:nth-child(even) {
              background-color: orange;
            }
            tr:nth-child(odd) {
                background-color: #F2F2F2;
            }
        </style>

        <!-- Trigger/Open The pop up box -->
        <div class="container">
            <button id="myBtnLot">Add Lot</button>
            <div id="addCust" class="modal">
                <!-- pop up content -->
                <div id="custbox" class="modal-content">
                    <span class="close">&times;</span>
                    <p>Add Customer</p>
                    <!-- form for User Story 4.4.1 -->
                    <form class="" action="" method="post">
                        <label for="company"><b>Company</b></label>
                        <input type="text" name="company" required>

                        <label for="contact"><b>Contact</b></label>
                        <input type="text" name="contact" required>

                        <label for="phone"><b>Phone</b></label>
                        <input type="number" name="phone" required>

            		    <label for="email"><b>E-mail</b></label>
                        <input type="text" name="email" required>

                        <button type="submit" class="btn">Submit</button>
                    </form>

                    <!-- Action for submit of form to add customer (User Story 4.4.2)-->
                    <?php if (isset($_POST['company'], $_POST['contact'], $_POST['phone'], $_POST['email'])) {
                        ?> <script>
                            alert("<?php echo addCustomer($_POST['company'], $_POST['contact'], $_POST['phone'], $_POST['email']); ?>");
                        </script>

                    <?php } ?>
                </div>
            </div>
            <!-- The pop up -->
            <div id="addLot" class="modal">
                <!-- pop up content -->
                <div id="lotbox" class="modal-content">
                    <span class="close">&times;</span>

                    <!-- Action for submit of form to add lot (US 3.1)-->
                    <?php if (isset($_POST['lotnum'], $_POST['cust'], ($_POST['amt']))) { ?>
                        <script> alert("Lot Added Successfully");</script>
                    <?php
                        addLot($_POST['lotnum'], $_POST['cust'], $_POST['amt']);}
                    ?>
                </div>
            </div>
            <script src="scripts.js"></script>
            <script type="text/javascript">
                let custList = <?php echo json_encode(get_customers_list()); ?>;
                createAddLotForm(lotDivId, palletsDivId, addCustBtnId, custList);
                setupBoth();
                let addCustBtn = document.getElementById(addCustBtnId);
                addCustBtn.addEventListener('click', function() {
                    var modalLot = document.getElementById("addLot");
                    modalLot.style.display = 'none';
                });
            </script>
            <!-- Buttons on the task bar without implementation -->
            <button onClick="location.href='history.php';">Lot History</button>
            <button onClick="location.href='reports.html';">Reports</button>
            <button onClick="location.href='customers.php';">Customers</button>
        	<button onClick="location.href='accounts.html';">Accounts</button>
			<a href="../LoginPage/login.html">Logout</a>

    	</div>
        <h1>Home</h1>
        <!-- US 5.3: JavaScript array to contain table values from db -->
        <div id="tableDiv" class="">

        </div>

        <!-- US 4.2, 5.3: Table of lot info from db -->
        <script type="text/javascript">
            function createLotTable(id, rows, fields) {
                console.log("createLotTable called");
                <?php
                    $result = get_lots();
                    $fields = get_fields($result);
                    $rows = get_rows($result);
                ?>
                fields = <?php echo json_encode($fields); ?>;
                console.log(fields);
                rows = <?php echo json_encode($rows); ?>;
                stringifyRows(fields, rows);
                sortRows(rows, 'customer');
                let table = document.createElement("TABLE");
                table.setAttribute("id", id);
                document.getElementById("tableDiv").appendChild(table);
                createHeaders(id, fields, rows);
                updateTable(id, fields, rows);
            }
            var rows;
            var fields;
            var tableId = "lotsTable";
            createLotTable(tableId, rows, fields);
        </script>

        <!-- Link to JavaScript source file -->
        <!-- <script src="addLotDialogue.js"></script> -->
    </body>
</html>
