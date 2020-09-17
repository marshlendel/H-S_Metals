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
    	<style>
        	img {
            	position: absolute;
                z-index: 10;
                width:125px;
                max-height: 12%;
                top: 0px;
                left: 7.9px;
            }
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
		 <div class="container">
            <!-- Taskbar -->
			<a href="main.php"><img id="logo" src="../images/logo.jpg"></a>
            <button id="highlight">Lot History</button>
            <button onClick="location.href='reports.html';">Reports</button>
            <button onClick="location.href='customers.php';">Customers</button>
        	<button onClick="location.href='accounts.html';">Accounts</button>

            <!-- Search bar -->
            <form action="" method="post">
                Search:  <input type="text" name="user_input" />
                <button type="submit">Submit</button>
            <form/>
			<a href="../LoginPage/login.html">Logout</a>
		</div>

		<h1>Lot History</h1>
		<div id="tableDiv" class="">

        </div>
		<!-- Link to JavaScript source file -->
        <script src="scripts.js"> </script>
        <!-- Results of search -->
		<!-- US 6.1 uses the results of the search to extract the values of each row and field -->
		<script type="text/javascript">
            <?php $lots = search($_POST["user_input"]); ?> 
            var rows = <?php echo json_encode(get_rows($lots)); ?>;
            var fields = <?php echo json_encode(get_fields($lots)); ?>;
            var tableId = "lotsTable";
        </script>
		
		<?php if (isset($_POST["user_input"])) { ?>
			<script type="text/javascript">
				createLotTable(tableId, rows, fields);
			</script>
		<?php } ?>
	</body>
</html>
