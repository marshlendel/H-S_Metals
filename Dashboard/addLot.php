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
    require 'sql.php';
?>

<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="UTF-8">
    <title>Add Lot</title>
	<link href="styles2.css" rel="stylesheet">
</head>
    <body>
        <a href="main.php" id="temp"><h4>home</h4></a>
    	<nav>
    		<form id="navForm" method="post">
                <?php
                $submit = isset($_POST['lotnum'], $_POST['cust'], $_POST['gross'], $_POST['tare']);
                $lotnum = max(get_lots_list());
                ?>
                <script type="text/javascript">
                    console.log(<?php echo json_encode(get_lots_list()); ?> );
                    console.log("Lot Max: " + <?php echo json_encode($lotnum); ?> );
                </script>
                <?php
                if ($submit) {
                    if ((int) $_POST["lotnum"] > $lotnum) {
                        $result = addLot($_POST['lotnum'], $_POST['cust']);
                        ?>
                        <script type="text/javascript">
                            console.log("Add Lot: " + <?php echo json_encode($result); ?> );
                        </script>
                        <?php
                    }
                    $result = addPallet($_POST['lotnum'], $_POST['gross'], $_POST['tare']);
                    ?>
                    <script type="text/javascript">
                        console.log("Add Pallet: " + <?php echo json_encode($result); ?> );
                    </script>
                    <?php
                }
                ?>
        		<div id="lotBar">
        			<label for="lotNum">Lot No.</label>
                    <input type="number" name="lotnum" value=
                        <?php
                        if ($submit) {
                            echo json_encode($_POST['lotnum']);
                        }
                        else {
                            echo json_encode($lotnum+1);
                        }
                        ?>
                    ></input>
        		</div>
        		<div class="nav">
                    <label for="cust">Customer:</label>
        			<input type="search" name="cust" list="custList">
                    <datalist id="custList">
        			</datalist>

        			<label for="gross">Gross:</label>
        			<input type="number" name="gross"><br>

        			<label for="tare">Tare:</label>
        			<input type="number" name="tare"><br>

        			<button>New Pallet</button>

        		</div>
    		</form>
    	</nav>
        <br>
    	<div id="tableDiv">

        </div>
    </body>
    <script type="module" defer>
       import * as Script from './scripts.js';

       // US 7.2: obtain list of customers from db
       let custList = <?php echo json_encode(get_customers_list()); ?>;
       Script.custAdd("custList", custList);

       // US 7.5: create pallets table if submit button has been clicked
       <?php
       if ($submit) {
           $pallets = get_pallets($_POST['lotnum']);
       ?>
           var rows = <?php echo json_encode(get_rows($pallets)); ?>;
           var fields = <?php echo json_encode(get_fields($pallets)); ?>;
           var tableId = "pallets";
           Script.stringifyRows(fields, rows);
           Script.createTable("tableDiv", tableId, rows, ["palletnum", "gross", "tare", "net"]);
       <?php
       }
       ?>
   </script>
</html>
