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
<html lang="en-US">
<head>
    <meta charset="UTF-8">
    <title>Add Lot</title>
	<link href="styles.css" rel="stylesheet">
</head>
<body>
<a href="main.php" id="temp"><h4>home</h4></a>
	<nav>
		<form id="navForm">
		<div id="lotBar">
			<label for="lotNum">Lot No.</label>
			<input type="number" name= "lotNo"><br>
		</div>
		<div class="nav">
			<label for="gross">Gross</label>
			<input type="number" name="gross"><br>
			
			<label for="tare">Tare</label>
			<input type="number" name="tare"><br>
			
			<label for="cust">Customer</label>
			<input type="search" name="cust" list="custList">
			
			<button>Add Pallet</button>
			
			<datalist id="custList">
			</datalist>
			<button>Add Pallet</button>

		</div>
		</form>
	</nav>
	
	<div>
	</div>
</body>
</html>
