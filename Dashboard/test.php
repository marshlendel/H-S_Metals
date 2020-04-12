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

    // function addLot ($input_lotnum, $input_cust, $input_amt) {      //  Takes user input and inserts in sql query
    //     $servername = "localhost";  //      and returns the result
    //     $username = "mwithers";
    //     $password = "2270410";
    //     $database = "HandSMetals";
    //
    //     $conn = mysqli_connect($servername, $username, $password, $database);
    //
    //     // Check connection
    //     if (!$conn) {
    //         die("Connection failed: " . mysqli_connect_error());
    //     }
    //     echo "Connected successfully<br>";
    //
    //     // prepare and bind
    //     $stmt = $conn->prepare("INSERT INTO Lots (lotnum, customer, amount) VALUES (?, ?, ?)");
    //     $stmt->bind_param("isd", $lotnum, $cust, $amt);
    //
    //     // set parameters and execute
    //     $lotnum = (int)$input_lotnum;
    //     $cust = $input_cust;
    //     $amt = (double)$input_amt;
    //     $stmt->execute();
    //
    //     echo "New records created successfully";
    //
    //     $stmt->close();
    //
    //     $conn->close();
    // }

    // if (isset($_POST['lotnum']) && isset($_POST['cust']) && isset($_POST['amt'])) {
    //     addLOt($_POST['lotnum'], $_POST['cust'], $_POST['amt']));
    // }

    // addLot(456, `Micah`, 78910);

    function viewGuests($result) {  // Takes a mysqli result query and returns rows
        $tuples = "";
        if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
                $tuples = $tuples . "company: " . $row["company"]. " - contact: " . $row["contact"]. " - phone: " . $row["phone"]. "<br>";
            }
            return $tuples;
        } else {
            return "0 results";
        }
    }

    function search () {      //  Takes user input and inserts in sql query
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
        $stmt = $conn->prepare("SELECT * FROM Customers");

        $stmt->execute();

        $res = $stmt->get_result();

        $stmt->close();

        $conn->close();

        return $res;
    }
?>
<?php
    function addLot ($lotnum, $cust, $amt) {
        $servername = "localhost";
        $username = "mwithers";
        $password = "2270410";
        $dbname = "HandSMetals";

        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // prepare and bind
        $stmt = $conn->prepare("INSERT INTO Lots (lotnum, customer, amount) VALUES (?, ?, ?)");
        $stmt->bind_param("isi", $lotnumsql, $custsql, $amtsql);

        // set parameters and execute
        $lotnumsql = (int)$lotnum;
        $custsql = "".$cust."";
        $amtsql = (int)$amt;
        // $stmt->execute();

        // $lotnumsql = 111;
        // $custsql = "Josiah";
        // $amtsql = 5678;
        $stmt->execute();
        //
        // $lotnum = 3;
        // $cust = "Marshmellow";
        // $amt = 91011;
        // $stmt->execute();

        echo "New records created successfully";

        $stmt->close();
        $conn->close();
    }
    // addLot(222, `Micah`, 4567);

    echo viewGuests(search());
?>
