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
	</head>
	<body>
    	<nav class="navBar">
			<a href="main.php" id="logo"></a>
			<a href="addLot.php">Add Lot</a>
            <a href="#" id="highlight">Lot History</a>
            <a href="reports.html">Reports</a>
            <a href="customers.php">Customers</a>
        	<a href="accounts.html">Accounts</a>
		</nav>
            <!-- Search bar -->
            <form action="" method="post">
                Search:  <input type="text" name="user_input" />
                <button type="submit">Submit</button>
            </form>

		<h1>Lot History</h1>
		<div id="tableDiv" class="">

        </div>

        <!-- Results of search -->
		<!-- US 6.1 uses the results of the search to extract the values of each row and field -->
		<script type="module">
            import * as Script from './scripts.js'
            <?php $lots = search($_POST["user_input"]); ?>
            var rows = <?php echo json_encode(get_rows($lots)); ?>;
            var fields = <?php echo json_encode(get_fields($lots)); ?>;
            var tableId = "lotsTable";
            <?php if (isset($_POST["user_input"])) { ?>
    				Script.createLotTable(tableId, rows, fields);
    		<?php } ?>
        </script>

		<?php if (isset($_POST["user_input"])) { ?>
			<script type="text/javascript">
				Script.createLotTable(tableId, rows, fields);
			</script>
		<?php } ?>
	</body>
</html>
