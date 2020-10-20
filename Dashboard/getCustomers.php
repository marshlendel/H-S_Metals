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
    //  Code to connect to db and return data in Customers table (User Story 4.3)
    function get_customers () {
        require 'dbConnect.php';

        $conn = mysqli_connect($servername, $username, $password, $database);

        $stmt = $conn->prepare("SELECT * FROM Customers");

        $stmt->execute();

        $res = $stmt->get_result();

        $stmt->close();

        $conn->close();

        return $res;
    }

    $result = get_customers();
?>
