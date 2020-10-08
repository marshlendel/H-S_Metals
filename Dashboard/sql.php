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
    function removeLot ($lotnum) {
        $servername = "localhost";
        $username = "mwithers";
        $password = "2270410";
        $dbname = "HandSMetals";

        $conn = new mysqli($servername, $username, $password, $dbname);

        // prepare and bind
        $stmt = $conn->prepare("DELETE FROM Lots WHERE lotnum = ?");
        $stmt->bind_param("i", $lotnumsql);

        $lotnumsql = (int) $lotnum;

        $result = $stmt->execute();

        $stmt->close();

        $conn->close();

        return $result;
    }

    function removeCust($cust) {
        $servername = "localhost";
        $username = "mwithers";
        $password = "2270410";
        $dbname = "HandSMetals";

        $conn = new mysqli($servername, $username, $password, $dbname);

        // prepare and bind
        $stmt = $conn->prepare("DELETE FROM Customers WHERE company = ?");
        $stmt->bind_param("s", $custsql);

        $custsql = "".$cust."";

        $result = $stmt->execute();

        $stmt->close();

        $conn->close();

        return $result;
    }

    function addLot ($lotnum, $cust) {      //  Takes user input and inserts in sql query
        $servername = "localhost";
        $username = "mwithers";
        $password = "2270410";
        $dbname = "HandSMetals";

        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);

        // prepare and bind
        $stmt = $conn->prepare("INSERT INTO Lots (lotnum, customer) VALUES (?, ?)");
        $stmt->bind_param("is", $lotnumsql, $custsql);

        // set parameters and execute
        $lotnumsql = (int)$lotnum;
        $custsql = "".$cust."";
        $result = $stmt->execute();
        $error = $stmt->error;

        $stmt->close();
        $conn->close();

        // US 6.3: Returns success statement or description of the error
        if (!$result) {
            return $error;
        }
        return "Success";
    }

    // US 7.6: Add pallet to database
    function addPallet($lotnum, $gross, $tare) {
        $servername = "localhost";
        $username = "mwithers";
        $password = "2270410";
        $dbname = "HandSMetals";

        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);

        // prepare and bind
        $stmt = $conn->prepare("INSERT INTO Pallets (lotnum, gross, tare) VALUES (?, ?, ?)");
        $stmt->bind_param("idd", $lotnumsql, $grosssql, $taresql);

        // set parameters and execute
        $lotnumsql = (int)$lotnum;
        $grosssql = (double)$gross;
        $taresql = (double)$tare;
        $result = $stmt->execute();
        $error = $stmt->error;

        $stmt->close();
        $conn->close();

        // Returns success statement or description of the error
        if (!$result) {
            return $error;
        }
        return "Success";
    }

    //  User Story 4.4.2
    function addCustomer ($company, $contact, $phone, $email) {      //  Takes user input and inserts in sql query
        $servername = "localhost";
        $username = "mwithers";
        $password = "2270410";
        $dbname = "HandSMetals";

        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);

        // prepare and bind
        $stmt = $conn->prepare("INSERT INTO Customers (company, contact, phone, email) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssis", $companysql, $contactsql, $phonesql, $emailsql);

        // set parameters and execute
        $companysql = "".$company."";
        $contactsql = "".$contact."";
        $phonesql = (int)$phone;
        $emailsql = "".$email."";
        $result = $stmt->execute();
        $error = $stmt->error;

        $stmt->close();
        $conn->close();
        if (!$result) {
            return $error;
        }
        return "Success";
    }

    //  Code to connect to db and return data in Customers table (User Story 4.3)
    function get_customers () {
        $servername = "localhost";
        $username = "mwithers";
        $password = "2270410";
        $database = "HandSMetals";

        $conn = mysqli_connect($servername, $username, $password, $database);

        $stmt = $conn->prepare("SELECT * FROM Customers");

        $stmt->execute();

        $res = $stmt->get_result();

        $stmt->close();

        $conn->close();

        return $res;
    }

    //  Code to connect to db and return data in Lots table (User Story 3.2)
    function get_lots () {
        $servername = "localhost";
        $username = "mwithers";
        $password = "2270410";
        $database = "HandSMetals";

        $conn = mysqli_connect($servername, $username, $password, $database);

        // prepare and bind
        $stmt = $conn->prepare("SELECT * FROM Lots");

        $stmt->execute();

        $res = $stmt->get_result();

        $stmt->close();

        $conn->close();

        return $res;
    }

    // US 7.6: connect to db and return data in pallets table
    function get_pallets ($lotnum) {
        $servername = "localhost";
        $username = "mwithers";
        $password = "2270410";
        $dbname = "HandSMetals";

        $conn = new mysqli($servername, $username, $password, $dbname);

        // prepare and bind
        $stmt = $conn->prepare("SELECT * FROM Pallets WHERE lotnum = ?");
        $stmt->bind_param("i", $lotnumsql);

        $lotnumsql = (int) $lotnum;

        $stmt->execute();

        $result = $stmt->get_result();

        $stmt->close();

        $conn->close();

        return $result;
    }

    function get_num_pallets() {
        $servername = "localhost";
        $username = "mwithers";
        $password = "2270410";
        $database = "HandSMetals";

        $conn = mysqli_connect($servername, $username, $password, $database);

        // prepare and bind
        $stmt = $conn->prepare("SELECT lotnum, MAX(palletnum) AS palletnum FROM Pallets GROUP BY lotnum");

        $stmt->execute();

        $res = $stmt->get_result();

        $stmt->close();

        $conn->close();

        $rows = array();
        while($row = $res->fetch_assoc()) {
            $rows[(int)$row['lotnum']] = (int)$row['palletnum'];
        }
        return $rows;
    }

    // US 7.2: get list of customers from db
    function get_customers_list() {
        $servername = "localhost";
        $username = "mwithers";
        $password = "2270410";
        $database = "HandSMetals";

        $conn = mysqli_connect($servername, $username, $password, $database);

        // prepare and bind
        $stmt = $conn->prepare("SELECT company FROM Customers");

        $stmt->execute();

        $res = $stmt->get_result();

        $stmt->close();

        $conn->close();

        $rows = array();
        $rowInt = 0;
        while($row = $res->fetch_assoc()) {
            $rows[$rowInt] = $row;
            ++$rowInt;
        }
        return $rows;
    }

    function get_lots_list() {
        $servername = "localhost";
        $username = "mwithers";
        $password = "2270410";
        $database = "HandSMetals";

        $conn = mysqli_connect($servername, $username, $password, $database);

        // prepare and bind
        $stmt = $conn->prepare("SELECT lotnum FROM Lots");

        $stmt->execute();

        $res = $stmt->get_result();

        $stmt->close();

        $conn->close();

        $rows = array();
        $rowInt = 0;
        while($row = $res->fetch_assoc()) {
            $rows[$rowInt] = (int)$row['lotnum'];
            ++$rowInt;
        }
        return $rows;
    }

    function get_fields($result) {
        // echo "Getting result...";
        $fieldsArray = array();
        // echo "Created array";
        $finfo = $result->fetch_fields();
        // echo "fetched results";
        $index = 0;
        foreach ($finfo as $field) {
            $fieldsArray[$index] = $field->name;
            ++$index;
        }
        // echo "Fields array: ";
        // echo $fieldsArray;
        return $fieldsArray;
    }

    function get_rows($result) {
        $rows = array();
        $rowInt = 0;
        while($row = $result->fetch_assoc()) {
            $rows[$rowInt] = $row;
            ++$rowInt;
        }
        return $rows;
    }
?>
