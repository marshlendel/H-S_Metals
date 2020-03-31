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
        $servername = "localhost";
        $username = "mwithers";
        $password = "2270410";
        $dbname = "HandSMetals";

        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);

        // prepare and bind
        $stmt = $conn->prepare("INSERT INTO Lots (lotnum, customer, amount) VALUES (?, ?, ?)");
        $stmt->bind_param("isi", $lotnumsql, $custsql, $amtsql);

        // set parameters and execute
        $lotnumsql = (int)$lotnum;
        $custsql = "".$cust."";
        $amtsql = (int)$amt;
        $stmt->execute();

        $stmt->close();
        $conn->close();
    }
    //
    // if (isset($_POST['lotnum'], $_POST['cust'], ($_POST['amt']))) {
    //     addLot($_POST['lotnum'], $_POST['cust'], $_POST['amt']);
    // }
?>
