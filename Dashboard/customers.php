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
    // require 'getCustomers.php';
    // require 'addCustomer.php';
    require 'getCustomers.php';
    require 'addCustomer.php';
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Customers</title>
		 <link rel="stylesheet", href="styles.css">
	</head>
	<body>
	<style>
    	img {
        	position: absolute;
            z-index: 10;
            width:125px;
            max-height: 12%;
            top: 0px;
            left: 7.9px;
        }

        /* Styling for table in User Story 4.3 */
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

		<div class="container">
            <!-- Taskbar -->
			<a href="main.php"><img id="logo" src="../images/logo.jpg"></a>
            <button onClick="location.href='history.php'">Lot History</button>
            <button onClick="location.href='reports.html';">Reports</button>
            <button id="highlight">Customers</button>
         	<button onClick="location.href='accounts.html';">Accounts</button>

            <!-- Search bar -->
            <form action="" method="post">
                Search:  <input type="text" name="user_input" />
            <form/>
            <a href="../LoginPage/login.html">Logout</a>
		</div>
		<h1>Customers</h1>

        <!-- Customers table (User Story 4.3) -->
		<table style="width:100%">
    				<tr>
        				<th> Company </th>
        				<th> Contact </th>
        				<th> Phone Number </th>
						<th> Email </th>
    				</tr>
            <?php
                while($row = $result-> fetch_assoc()){
                    echo "<tr><td>" . $row["company"] . "</td><td>" . $row["contact"] . "</td><td>" . $row["phone"] . "</td><td>" . $row["email"] . "</td></tr>";
                }
		    ?>
        </table>

        <!-- Button for User Story 4.4 -->
        <button id="myBtn">Add Customer</button>
        <!-- The pop up -->
        <div id="addCust" class="modal">
          <!-- pop up content -->
          <div class="modal-content">
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
            <?php if (isset($_POST['company'], $_POST['contact'], $_POST['phone'], $_POST['email'])) {?> 
                <script> alert("Customer Added Successfully");</script>
            <?php
                addCustomer($_POST['company'], $_POST['contact'], $_POST['phone'], $_POST['email']);
                $result = get_customers();
            }?>
            </div>
        </div>


        <!-- Link to JavaScript source file (User Story 4.4.1)-->
        <script src="addCustDialogue.js"> </script>
	</body>
</html>
