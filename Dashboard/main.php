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
            <button id="myBtn">Add Lot</button>
            <!-- The pop up -->
            <div id="addLot" class="modal">

              <!-- pop up content -->
              <div class="modal-content">
                <span class="close">&times;</span>
                <p>Add Lot</p>

                <!-- form for User Story 3.1 -->
                <form class="" action="" method="post">
                    <label for="lotnum"><b>Lot #</b></label>
                    <input type="number" name="lotnum" required>

                    <label for="cust"><b>Customer</b></label>
                    <input type="text" name="cust" required>

                    <label for="amt"><b>Amount</b></label>
                    <input type="number" name="amt" required>

                    <button type="submit" class="btn">Submit</button>
                </form>

                <!-- Action for submit of form to add lot (US 3.1)-->
                <?php if (isset($_POST['lotnum'], $_POST['cust'], ($_POST['amt']))) { ?>
                    <script> alert("Lot Added Successfully");</script>
                <?php
                    addLot($_POST['lotnum'], $_POST['cust'], $_POST['amt']);}
                ?>
              </div>
            </div>
            <!-- Buttons on the task bar without implementation -->
            <button onClick="location.href='history.php';">Lot History</button>
            <button onClick="location.href='reports.html';">Reports</button>
            <button onClick="location.href='customers.php';">Customers</button>
        	<button onClick="location.href='accounts.html';">Accounts</button>
			<a href="../LoginPage/login.html">Logout</a>

    	</div>
        <h1>Home</h1>
        <!-- US 5.2: JavaScript array to contain table values from db -->
        <div id="tableDiv" class="">

        </div>

        <!-- Table of lot info from db (User Story 4.2) -->
        <script src="scripts.js"></script>
        <script type="text/javascript">
            console.log("Script2 has been read");
            function createLotTable() {
                console.log("createLotTable() called");
                <?php
                    $result = get_lots();
                    $fields = get_fields($result);
                    $rows = get_rows($result, $fields);
                ?>
                let fields = <?php echo json_encode($fields); ?>;
                console.log(fields);
                let rows = <?php echo json_encode($rows); ?>;
                console.log(rows);
                let tableId = "lotsTable";
                let table = document.createElement("TABLE");
                table.setAttribute("id", tableId);
                document.getElementById("tableDiv").appendChild(table);
                createHeaders(tableId, fields);
                updateTable(tableId, fields, rows);
            }
            createLotTable();
        </script>

        <!-- Link to JavaScript source file -->
        <script src="addLotDialogue.js"> </script>
    </body>
</html>
