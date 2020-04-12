<!-- **************************************************************************
* Copyright 2020 Marshall Brown, Josiah Schmidt, Micah Withers
*
* Unless required by applicable law or agreed to in writing, software
* distributed under the License is distributed on an "AS IS" BASIS,
* WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or
* See the License for the specific language governing permissions and
* limitations under the License.
************************************************************************** -->
<?php require 'getCustomers.php' ?>
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
        table, th, td {
            border: 1px solid black;
        }
        td {
            text-align: center;
        }
        tr:nth-child(even){
            background-color: #f2f2f2;
        }
        tr:nth-child(odd) {
            background-color: #FFA500;
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
                echo "</table>";
		    ?>

        <!-- Link to JavaScript source file -->
        <script src="scripts.js"> </script>
	</body>
</html>
