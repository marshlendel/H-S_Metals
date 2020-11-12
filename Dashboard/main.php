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
session_start();
require 'dbConnect.php';
$_SESSION["username"] = $username;
$_SESSION["password"] = $password;
require 'sql.php';

// Checks if user chose to edit or update the lot, then performs the action
if (isset($_POST["update"], $_POST["lotnum"], $_POST["customer"], $_POST["status"])) {
    updateLot($_POST["lotnum"], $_POST["customer"], $_POST["status"]);
} else if (isset($_POST["delete"], $_POST["lotnum"])) {
    removeLot($_POST["lotnum"]);
}
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <!-- Overall page format -->
        <meta name="viewport" content="width=device-width, initial-scale=1" charset="utf-8">
		<!-- Adjusts viewport to size of screen-->
		<!--<meta name="viewport" content="width=device-width, initial-scale=1.0">-->
        <!-- Link to CSS stylesheet -->
        <link rel="stylesheet", href="styles.css">
		<link href="https://fonts.googleapis.com/css2?family=Ramabhadra&display=swap" rel="stylesheet">
    </head>

    <body>
        <?php require 'navbar.php'; ?>
		<h1 id="home">Home</h1>
        <form class="btnform" action="addLot.php" method="post">
            <!-- US 9.1: Edit button can be clicked after selecting a row -->
    		<button type="button" disabled id="edit">Edit</button>
            <input type="hidden" name="lotnum" id="lotnumInput" value="" required>
            <button type="submit" id="view" disabled>View Pallets</button>
        </form>

        <!-- US 5.3: Table will be here -->
        <div id="lotTable" class="">
        </div>

        <!-- US 9.2: Popup that appears after selecting a row and clicking "Edit" -->
		<div id="editDiv" class="modal">
    		<div id="editPad" class="modal-content">
        		<span id="editBox" class="close">X</span>
        		<p id="lotLabel"></p>
        		<form class="" action="" method="post">
                    <input type="hidden" id="lotInput" name="lotnum">
                    <label for="customer"><b>Customer</b></label>
                    <input type="search" id="custInput" name="customer" class="customerInput"
                        list="custList"><br>
    				<datalist id="custList">
            		</datalist>

                    <label for="status"><b id="status">Status</b></label>
                    <select id="statusInput" name="status" class="StatusInput"><br>
					  <option value="DIRTY">DIRTY</option>
					  <option value="CLEAN">CLEAN</option>
					  <option value="PARTIALLY-SHIPPED">PARTIALLY-SHIPPED</option>
					  <option value="SHIPPED">SHIPPED</option>
                    </select><br>
				<div id="editButts">
                    <button type="submit" class="submitBtn" name="delete">Delete</button>
                    <button type="reset" class="submitBtn" id="cancel">Cancel</button>
                    <button type="submit" class="submitBtn" name="update">Apply</button>
				</div>

                </form>
    		</div>
		</div>

        <!-- Import JS functions -->
        <script type="module" defer>
            import * as Script from './scripts.js';

            // US 4.2, 5.3: Table of lot info from db
            <?php
            $lots = simpleSelect("
                SELECT l.lotnum, customer, SUM(p.gross) gross,
                    SUM(p.tare) tare, (SUM(p.gross) - SUM(p.tare)) net,
                    status
                FROM lots AS l
                INNER JOIN pallets AS p
                USING (lotnum)
                GROUP BY (lotnum)
            ");
            ?>
            var rows = <?php echo json_encode(get_rows($lots)); ?>;
            var fields = <?php echo json_encode(get_fields($lots))?>;
            var headers = ["Lot", "Customer", "Gross", "Tare", "Net", "Status"];
            var tableId = "lotTable";
            Script.makeTable(tableId, fields, rows, headers, "lots", "lotnum");

            // ID to select the Edit button
            let editBtnId = "edit";
            let viewBtnId = "view";
            let radioBtns = document.getElementsByClassName("radioButt");
            // Click listeners are added to radio buttons to enable the Edit button
            for (let index = 0; index < radioBtns.length; ++index) {
                let radioBtn = radioBtns[index];
                radioBtn.addEventListener('click', function() {
                    if (radioBtn.checked) {
                        let editBtn = document.getElementById(editBtnId);
                        let viewBtn = document.getElementById(viewBtnId);
                        editBtn.disabled = false;
                        viewBtn.disabled = false;
                        console.log(rows);
                        let rowIndex = radioBtn.getAttribute('for');
                        editBtn.setAttribute('for', rowIndex);
                        document.getElementById("lotnumInput").value = rows[rowIndex]["lotnum"];
                    }
                    else {
                        document.getElementById(editBtnId).disabled = true;
                        document.getElementById(viewBtnId).disabled = true;
                        document.getElementById("lotnumInput").value = "";
                    }
                });
            }
            // Allows popup to toggle between visible and hidden
            let popupId = "editDiv";
			Script.setupPopup(popupId, "editBox", "edit");
            let cancelBtn = document.getElementById("cancel");
            cancelBtn.addEventListener('click', function() {
                document.getElementById(popupId).style.display = "none";
            });

            // US 9.2.2: Puts current customer and status values in inputs
            let editBtn = document.getElementById(editBtnId);
            editBtn.addEventListener('click', function() {
                let rowIndex = editBtn.getAttribute('for');
                document.getElementById("lotLabel").innerHTML = "Lot "+rows[rowIndex]["lotnum"];
                document.getElementById("lotInput").value = rows[rowIndex]["lotnum"];
                document.getElementById("custInput").value = rows[rowIndex]["customer"];
                let status = rows[rowIndex]["status"];
                let statusSelect = document.getElementById("statusInput");
                let options = statusSelect.getElementsByTagName('option');
                for (let i = 0; i < options.length; ++i) {
                    if (options[i].value == status) {
                        options[i].selected = true;
                    } else {
                        options[i].selected = false;
                    }
                }
            }, false);

            let customers = <?php echo json_encode(get_customers_list()); ?>;
            Script.custAdd("custList", customers);
        </script>
    </body>
</html>
