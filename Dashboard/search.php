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
    function viewGuests($result) {  // Takes a mysqli result query and returns rows
        $tuples = "";
        if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
                $tuples = $tuples . "id: " . $row["id"]. " - Name: " . $row["firstname"]. " " . $row["lastname"]. " - Email: " . $row["email"]. "<br>";
            }
            return $tuples;
        } else {
            return "0 results";
        }
    }

    function search ($input) {      //  Takes user input and inserts in sql query
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
        $stmt = $conn->prepare("SELECT * FROM MyGuests WHERE firstname LIKE ?");
        $stmt->bind_param("s", $search);

        // set parameters and execute
        $search = $input;
        $stmt->execute();

        $res = $stmt->get_result();

        $stmt->close();

        $conn->close();

        return $res;
    }

    if (isset($_POST['user_input'])) {
        $result = viewGuests(search($_POST['user_input']));
    }
?>
