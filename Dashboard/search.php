<?php
    function viewGuests($result) {
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

    function search($sql) {
        $servername = "localhost";
        $username = "mwithers";
        $password = "2270410";
        $database = "HandSMetals";

        $conn = mysqli_connect($servername, $username, $password, $database);

        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }
        echo "Connected successfully<br>";

        // prepare and bind
        $stmt = $conn->prepare("SELECT * FROM MyGuests WHERE firstname LIKE ?");
        $stmt->bind_param("s", $search);

        // set parameters and execute
        $search = $sql;
        $stmt->execute();

        $res = $stmt->get_result();

        $stmt->close();

        $conn->close();

        return viewGuests($res);
    }

    if (isset($_POST['user_input'])) {
        $result = search($_POST['user_input']);
    }
?>
