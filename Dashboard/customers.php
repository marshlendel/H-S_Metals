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
session_start();
require 'sql.php';

if (isset($_POST["update"], $_POST["updComp"], $_POST["updCont"], $_POST["updPhone"], $_POST["updEmail"])) {
    echo updateCustomer($_POST["updComp"], $_POST["updCont"], $_POST["updPhone"], $_POST["updEmail"]);
} else if (isset($_POST["delete"], $_POST["updComp"])) {
    echo removeCust($_POST["updComp"]);
}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Customers</title>
		 <link rel="stylesheet", href="styles.css">
		 <link href="https://fonts.googleapis.com/css2?family=Ramabhadra&display=swap" rel="stylesheet">
		 <!--<meta name="viewport" content="width=device-width, initial-scale=1.0">-->
         <style media="screen">
             #custTable {
                 display: flex;
                 margin-left: 10%;
                 margin-right: 10%;
                 max-height: 330px;
                 overflow: auto;
                 border-style: solid;
                 border-width: 2px;
                 border-color: #000000a3;
             }
         </style>
    </head>
	<body>
	<?php require 'navbar.php'; ?>

        <!-- Search bar -->
        <form action="" method="">
            Search:  <input type="text" name="user_input" />
        </form>

		<h1>Customers</h1>

        <!-- Customers table (User Story 4.3) -->
		<button id="myBtn">Add Customer</button>
		<br>
		<br>

        <!-- Button for User Story 4.4 -->

        <!-- The pop up -->
        <div id="addCust" class="modal">
          <!-- pop up content -->
          <div class="modal-content">
            <span class="close">&times;</span>
            <p>Add Customer</p>

            <!-- form for User Story 4.4.1 -->
            <form class="" action="" method="post">
                <label for="company"><b>Company</b></label>
                <input type="text" name="company" class="customerInput" required><br>

                <label for="contact"><b id="contact">Contact</b></label>
                <input type="text" name="contact" class="customerInput" required><br>

                <label for="phone"><b id="phone">Phone</b></label>
                <input type="number" name="phone" class="customerInput" required><br>

    		    <label for="email"><b id="email">E-mail</b></label>
                <input type="text" name="email" class="customerInput" required><br>

                <button type="submit" class="custBtn">Submit</button>
            </form>
            </div>
        </div>

		<button type="button" disabled id="edit">Edit</button>

		<div id="editDiv" class="modal">
    		<div id="editPad" class="modal-content">
        		<span id="editBox" class="close">X</span>
        		<p id="lotLabel"></p>
        		<form class="" action="" method="post">
                    <input type="hidden" id="lotInput" name="lotnum">
                    <label for="customer"><b>Company</b></label>
                    <input type="text" id="custInput" name="updComp" class="customerInput"><br>

                    <label for="contact"><b>Contact</b></label>
                    <input type="text" id="contactInput" name="updCont" class="ContactInput" required><br>

					<label for="phone"><b>Phone</b></label>
                    <input type="text" id="phoneInput" name="updPhone" class="PhoneInput" required><br>

					<label for="email"><b>Email</b></label>
                    <input type="text" id="emailInput" name="updEmail" class="EmailInput" required><br>

                    <button type="submit" class="submitBtn" name="delete">Delete</button>
                    <button type="reset" class="submitBtn">Cancel</button>
                    <button type="submit" class="submitBtn" name="update">Apply</button>
                </form>
    		</div>
		</div>

		<div id="custTable" class="">
        </div>

        <script type="module">
            import * as Script from './scripts.js';
            // Action for submit of form to add customer (User Story 4.4.2)
            <?php
            if (isset($_POST['company'], $_POST['contact'], $_POST['phone'], $_POST['email'])) {?>
                alert("Customer Added Successfully");
            <?php
                addCustomer($_POST['company'], $_POST['contact'], $_POST['phone'], $_POST['email']);
            }?>
            <?php $customers = get_customers(); ?>
            var rows = <?php echo json_encode(get_rows($customers)); ?>;
            var fields = <?php echo json_encode(get_fields($customers))?>;
            var headers = ["Company", "Contact", "Phone Number", "Email"];
            var tableId = "custTable";
            Script.makeTable(tableId, fields, rows, headers, "customers", "company");

			let editBtnId = "edit";
            let radioBtns = document.getElementsByClassName("radioButt");
            console.log(radioBtns.length);
            for (let index = 0; index < radioBtns.length; ++index) {
                let radioBtn = radioBtns[index];
                radioBtn.addEventListener('click', function() {
                    if (radioBtn.checked) {
                        let editBtn = document.getElementById(editBtnId);
                        editBtn.disabled = false;
                        console.log(rows);
                        let rowIndex = radioBtn.getAttribute('for');
                        editBtn.setAttribute('for', rowIndex);
                    }
                    else {
                        document.getElementById(editBtnId).disabled = true;
                    }
                });
            }
			Script.setupPopup("editDiv", "editBox", "edit");

            // US 9.3.2: Puts current customer and status values in inputs
            let editBtn = document.getElementById(editBtnId);
            editBtn.addEventListener('click', function() {
                let rowIndex = editBtn.getAttribute('for');
                document.getElementById("custInput").value = rows[rowIndex]["company"];
                document.getElementById("contactInput").value = rows[rowIndex]["contact"];
                document.getElementById("phoneInput").value = rows[rowIndex]["phone"];
                document.getElementById("emailInput").value = rows[rowIndex]["email"];
            }, false);
        </script>
        <!-- Link to JavaScript source file (User Story 4.4.1)-->
        <script src="addCustDialogue.js"> </script>

	</body>
</html>
