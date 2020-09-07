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
                <!-- form for User Story 3.1 -->
                <form class="" action="" method="post">
                    <label for="lotnum"><b>Lot No.</b></label>
                    <input type="number" name="lotnum" required>
					<br></br>
    				 <!-- User story 5.1.1-->
    				<form>
                        <label for="cust"><b>Customer</b></label>
                        <select name="cust" id="cust">
    						<option value="Danny">Danny</option>
    						<option value="Dad">Dad</option>
    						<option value="Bobby Darin">Bobby Darin</option>
    					</select>
    				</form>
    				<br></br>
					
					<div id="pallets">
						<!--User story 5.1.2-->
						<label><b>Pallet 1</b></label>
						<br></br>
							<label for="amt"><b>Amount</b></label>
							<input type="number" name="amt" required>
						<br></br>
						<!--User story 5.1.3-->
						<form>
							<label for="type"><b>Type</b></label>
							<select name="type" id="type">
								<option value="Ingot">Ingot</option>
								<option value="S">S</option>
								<option value="MS">MS</option>
							</select>
						</form>
						<br></br>
						<form>
							<label for="Status"><b>Status</b></label>
							<select name="Status" id="Status">
								<option value="Dirty">Dirty</option>
								<option value="Clean">Clean</option>
								<option value="Finished">Finished</option>
								<option value="Gone">Gone</option>
							</select>
						</form>
					</div>
					<button onclick="addPallet()">Add Pallet</button> <!-- new button addition --> 

						<!-- script displays pallet 2 for user story -->
						<script>
						
						function addPallet() {
							 if (typeof(Storage) !== "undefined") {
								if (localStorage.clickcount) {
								  localStorage.clickcount = Number(localStorage.clickcount)+1;
								} else {
								  localStorage.clickcount = 1;
								}

								document.getElementById("pallets").innerHTML += 
								"<p><b> Pallet </b> localStorage.clickcount</p>	<label for=\"amt\"><b>Amount</b></label><input type=\"number\" name=\"amt\" required><button onclick=\"removePallet()\"> Remove Pallet</button><form><label for=\"type\"><b>Type</b></label><select name=\"type\" id=\"type\"><option value=\"Ingot\">Ingot</option><option value=\"S\">S</option><option value=\"MS\">MS</option></select></form><br></br><form><label for=\"Status\"><b>Status</b></label><select name=\"Status\" id=\"Status\"><option value=\"Dirty\">Dirty</option><option value=\"Clean\">Clean</option><option value=\"Finished\">Finished</option><option value=\"Gone\">Gone</option></select></form>"
						};
						</script>
						
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
        <!-- US 5.3: JavaScript array to contain table values from db -->
        <div id="tableDiv" class="">

        </div>

        <!-- US 4.2, 5.3: Table of lot info from db -->
        <script src="scripts.js"></script>
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
        <script src="addLotDialogue.js"></script>
    </body>
</html>
