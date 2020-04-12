<!-- **************************************************************************
* Copyright 2020 Marshall Brown, Josiah Schmidt, Micah Withers
*
* Unless required by applicable law or agreed to in writing, software
* distributed under the License is distributed on an "AS IS" BASIS,
* WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or
* See the License for the specific language governing permissions and
* limitations under the License.
************************************************************************** -->
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
		
		<table style="width:100%">
    				<tr>
        				<th> Company </th>
        				<th> Contact </th>
        				<th> Phone Number </th>
						<th> Email </th>
    				</tr>
            <?php
        			if($result-> num_rows > 0){
        				while($row = $result-> fetch_assoc()){
        					echo "<tr><td>" . $row["lotnum"] . "</td><td>" . $row["customer"] . "</td><td>" . $row["amount"] . "</td></tr>";
        				}
        				echo "</table>";
        			}
                }
		    ?>


        <!-- Link to JavaScript source file -->
        <script src="scripts.js"> </script>
	</body>
</html>
