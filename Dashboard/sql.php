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
        $stmt->execute();

        $stmt->close();
        $conn->close();
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

    $result = get_customers();

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

    function get_rows($result, $fields) {
        $rows = array();
        $rowInt = 0;
        while($row = $result->fetch_assoc()) {
            $rows[$rowInt] = $row;
            ++$rowInt;
        }
        // $rowData = $result->fetch_assoc();
        // $rowInt = 0;
        // foreach($rowData as $row) {
        //     $rowArray = array();
        //     $fieldInt = 0;
        //     foreach($fields as $field) {
        //         $rowArray[$field] = $rowData[$field];
        //         ++$fieldInt;
        //     }
        //     $rows[$rowInt] = $rowArray;
        //     ++$rowInt;
        // }
        return $rows;
    }
?>
