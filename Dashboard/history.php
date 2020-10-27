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
    require 'search.php';
	require 'sql.php';
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Lot History</title>
		 <link rel="stylesheet", href="styles.css">
		 <link href="https://fonts.googleapis.com/css2?family=Ramabhadra&display=swap" rel="stylesheet">
		 <!--<meta name="viewport" content="width=device-width, initial-scale=1.0">-->
         <style media="screen">
             #tableDiv {
                 display: flex;
                 margin-left: 10%;
                 margin-right: 10%;
             }
         </style>
    </head>
	<body>
    	<nav class="navBar">
			<a href="main.php" id="logo"></a>
			<a href="addLot.php">Add Lot</a>
            <a href="#" id="highlight">Lot History</a>
            <a href="reports.html">Reports</a>
            <a href="customers.php">Customers</a>
        	<a href="accounts.html">Accounts</a>
            <a href="../LoginPage/login.html">Logout</a>
		</nav>

		<h1>Lot History</h1>
            <!-- Search bar -->
            <form action="" method="post">
                Search:  <input type="text" name="user_input" />
                <button type="submit">Submit</button>
            </form>

		<div id="tableDiv" class="">

        </div>

        <!-- Results of search -->
		<!-- US 6.1 uses the results of the search to extract the values of each row and field -->
		<script type="module">
            <?php if (isset($_POST["user_input"])) { ?>
            import * as Script from './scripts.js'
            <?php $lots = simpleSelect("
                            SELECT l.lotnum, customer, SUM(p.gross) gross,
                                SUM(p.tare) tare, (SUM(p.gross) - SUM(p.tare)) net,
                                status
                            FROM Lots AS l
                            INNER JOIN Pallets AS p
                            USING (lotnum)
                            GROUP BY (lotnum)
                        "); ?>
            var rows = <?php echo json_encode(get_rows($lots)); ?>;
            var fields = <?php echo json_encode(get_fields($lots)); ?>;
            var headers = ["Lot", "Customer", "Gross", "Tare", "Net", "Status"];
            var tableId = "tableDiv";
			Script.makeTable(tableId, fields, rows, headers, "lotnum");
    		<?php } ?>
        </script>
	</body>
</html>
