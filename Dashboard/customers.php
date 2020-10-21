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
    require 'getCustomers.php';
    require 'addCustomer.php';
?>
<!DOCTYPE html> 
<html>
	<head>
		<title>Customers</title>
		 <link rel="stylesheet", href="styles.css">
		 <link href="https://fonts.googleapis.com/css2?family=Ramabhadra&display=swap" rel="stylesheet">
		 <!--<meta name="viewport" content="width=device-width, initial-scale=1.0">-->
	</head>
	<body>
	<nav class="navBar">
            <a href="main.php" id="logo"></a>
            <a href="addLot.php">Add Lot</a>
            <a href="history.php">Lot History</a>
            <a href="reports.html">Reports</a>
            <a href="#" id="highlight">Customers</a>
            <a href="accounts.html">Accounts</a>
            <a href="../LoginPage/login.html">Logout</a>
        </nav>


            <!-- Search bar -->
            <form action="" method="">
                Search:  <input type="text" name="user_input" />
            </form>


		<h1>Customers</h1>

        <!-- Customers table (User Story 4.3) -->
		<button id="myBtn">Add Customer</button>
		<br>
		<br>

		<table>
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
