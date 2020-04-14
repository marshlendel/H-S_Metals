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
<?php require 'addLot.php' ?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <!-- Overall page format -->
        <meta name="viewport" content="width=device-width, initial-scale=1" charset="utf-8">
        <!-- Link to CSS stylesheet -->
        <link rel="stylesheet", href="styles.css">
    </head>
    <body>
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
                <?php if (isset($_POST['lotnum'], $_POST['cust'], ($_POST['amt']))) {
                    ?> <script> alert("Lot Added Successfully");</script>
                <?php addLot($_POST['lotnum'], $_POST['cust'], $_POST['amt']);}?>

              </div>
            </div>

            <!-- Buttons on the task bar without implementation -->

            <button onClick="location.href='history.php';">Lot History</button>
            <button onClick="location.href='reports.html';">Reports</button>
            <button onClick="location.href='customers.php';">Customers</button>
        	<button onClick="location.href='accounts.html';">Accounts</button>
			<a href="../LoginPage/login.html">Logout</a>

            <!-- <?php echo "Lot #: " . $_POST['lotnum'] . " Customer: " . $_POST['cust'] . " Amount: " . $_POST['amt'];?> -->
    	</div>
        <h1>Home</h1>
		<table>
  <tr>
    <th>Lot Number</th>
    <th>Customer</th>
    <th>Amount</th>
  </tr>
  <tr>
    <td>12</td>
    <td>Bobby Boy</td>
    <td>155</td>
  </tr>
  <tr>
    <td>157</td>
    <td>Daniel</td>
    <td>157</td>
  </tr>
  <tr>
    <td>55</td>
    <td>Sam</td>
    <td>88</td>
  </tr>
</table>
	 <div id="addCust" class="modal">

              <!-- pop up content -->
              <div class="modal-content">
                <span class="close">&times;</span>
                <p>Add Customer</p>

                <!-- form for User Story 3.1 -->
                <form class="" action="" method="post">
                    <label for="company"><b>Compnay</b></label>
                    <input type="text" name="company" required>

                    <label for="contact"><b>Contact</b></label>
                    <input type="text" name="contact" required>

                    <label for="phone"><b>Phone</b></label>
                    <input type="number" name="phone" required>
					
					 <label for="email"><b>E-mail</b></label>
                    <input type="text" name="email" required>

                    <button type="submit" class="btn">Submit</button>
                </form>

                <!-- Action for submit of form to add lot (US 3.1)-->
                <?php if (isset($_POST['lotnum'], $_POST['cust'], ($_POST['amt']))) {
                    ?> <script> alert("Lot Added Successfully");</script>
                <?php addLot($_POST['lotnum'], $_POST['cust'], $_POST['amt']);}?>

              </div>
            </div>


        <!-- Link to JavaScript source file -->
        <script src="addCustDialogue.js"> </script>
    </body>
</html>
