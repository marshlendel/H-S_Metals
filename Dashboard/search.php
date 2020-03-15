<?php
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

    function search($conn, $sql) {
        // prepare and bind
        $stmt = $conn->prepare("SELECT * FROM MyGuests WHERE firstname LIKE '?%' OR lastname LIKE '?%'");
        $stmt->bind_param("ss", $sql, $sql);

        // set parameters and execute
        $search = $sql;
        $stmt->execute();

        $res = stmt->get_result();

        $stmt->close();

        return $res;
    }

    function viewGuests($result) {

        if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
                echo "id: " . $row["id"]. " - Name: " . $row["firstname"]. " " . $row["lastname"]. " - Email: " . $row["email"]. "<br>";
            }
        } else {
            echo "0 results";
        }
    }

    if (isset($_POST['usr_input'])) {
        $result = viewGuests($conn, $_POST['user_input']);
    }
?>
