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

    function addLot ($lotnum, $cust, $amt) {      //  Takes user input and inserts in sql query
        $servername = "localhost";  //      and returns the result
        $username = "mwithers";
        $password = "2270410";
        $database = "HandSMetals";

        $conn = mysqli_connect($servername, $username, $password, $database);

        // Check connection
        // if (!$conn) {
        //     die("Connection failed: " . mysqli_connect_error());
        // }
        // echo "Connected successfully<br>";

        // prepare and bind
        $stmt = $conn->prepare("INSERT INTO Lots (`lotnum`, `cutomer`, `amount`) VALUES (?, ?, ?)");
        $stmt->bind_param("isd", $lotnum, $cust, $amt);

        // set parameters and execute
        $stmt->execute();

        $res = $stmt->get_result();

        $stmt->close();

        $conn->close();

        return $res;
    }

    if (isset($_POST['lotnum']) && isset($_POST['cust']) && isset($_POST['amt'])) {
        $result = addLOt($_POST['lotnum'], $_POST['cust'], $_POST['amt']));
    }
?>
