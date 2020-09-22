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
        if (is_numeric($input)) {
            $stmt = $conn->prepare("SELECT * FROM Lots WHERE lotnum = ?");
            $stmt->bind_param("i", $search);
            $search = (int)$input;
        } else {
            $stmt = $conn->prepare("SELECT * FROM Lots WHERE customer LIKE ?");
            $stmt->bind_param("s", $search);
            $search = '%' . $input . '%';
        }

        $stmt->execute();

        $res = $stmt->get_result();

        $stmt->close();

        $conn->close();

        return $res;
    }
?>
