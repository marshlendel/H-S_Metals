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
    //  User Story 4.4.2
    function addCustomer ($bus_name, $contact, $phone, $email) {      //  Takes user input and inserts in sql query
        $servername = "localhost";
        $username = "mwithers";
        $password = "2270410";
        $dbname = "HandSMetals";

        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);

        // prepare and bind
        $stmt = $conn->prepare("INSERT INTO Customers (name, contact, phone, email) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("isi", $bus_namesql, $contactsql, $phonesql, $emailsql);

        // set parameters and execute
        $bus_namesql = (int)$bus_name;
        $contactsql = "".$contact."";
        $phonesql = (int)$phone;
        $emailsql = "".$email."";
        $stmt->execute();

        $stmt->close();
        $conn->close();
    }
?>
