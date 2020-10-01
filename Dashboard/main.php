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
          <nav class="navBar">
			<a href="addLot.php">Add Lot</a>
            <a href="history.php">Lot History</a>
            <a href="reports.html">Reports</a>
            <a href="customers.php">Customers</a>
            <a href="accounts.html">Accounts</a></li>
            <a href="../LoginPage/login.html">Logout</a>
           </nav>

		<main class="container">
            <!-- Import JS functions -->
            <script type="module" defer>
                import * as Script from './scripts.js';

                // US 4.2, 5.3: Table of lot info from db
                <?php $lots = get_lots(); ?>
                var rows = <?php echo json_encode(get_rows($lots)); ?>;
                var fields = <?php echo json_encode(get_fields($lots)); ?>;
                var tableId = "lotsTable";
                Script.stringifyRows(fields, rows);
                Script.createTable("tableDiv", tableId, rows, fields);
                Script.sortRows(rows, 'lotnum', false);
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
