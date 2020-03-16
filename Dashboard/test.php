<?php
$servername = "localhost";
$username = "mwithers";
$password = "2270410";
$database = "HandSMetals";

// Create connection
// $conn = mysqli_connect($servername, $username, $password);
//
// // Check connection
// if (!$conn) {
//     die("Connection failed: " . mysqli_connect_error());
// }
// echo "Connected successfully";
//
// // Create database
// $sql = "CREATE DATABASE  HandSMetals";
// if ($conn->query($sql) === TRUE) {
//     echo "Database created successfully";
// } else {
//     echo "Error creating database: " . $conn->error;
// }
// $conn->close();

$conn = mysqli_connect($servername, $username, $password, $database);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
echo "Connected successfully<br>";

// sql to create table
// $sql = "CREATE TABLE MyGuests (
// id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
// firstname VARCHAR(30) NOT NULL,
// lastname VARCHAR(30) NOT NULL,
// email VARCHAR(50),
// reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
// )";

// if (mysqli_query($conn, $sql)) {
//     echo "Table MyGuests created successfully";
// } else {
//     echo "Error creating table: " . mysqli_error($conn);
// }

// if ($conn->query($sql) === TRUE) {
//     echo "Table MyGuests created successfully";
// } else {
//     echo "Error creating table: " . $conn->error;
// }

// // prepare and bind
// $stmt = $conn->prepare("INSERT INTO MyGuests (firstname, lastname, email) VALUES (?, ?, ?)");
// $stmt->bind_param("sss", $firstname, $lastname, $email);
//
// // set parameters and execute
// $firstname = "John";
// $lastname = "Doe";
// $email = "john@example.com";
// $stmt->execute();
//
// $firstname = "Mary";
// $lastname = "Moe";
// $email = "mary@example.com";
// $stmt->execute();
//
// echo "New records created successfully";
//
// $stmt->close();
//

// $tableName = "MyGuests";
//
// $sql = "SELECT * FROM " . $tableName;
//
// function viewGuests($conn, $sql) {
//     $result = $conn->query($sql);
//
//     if ($result->num_rows > 0) {
//         // output data of each row
//         while($row = $result->fetch_assoc()) {
//             echo "id: " . $row["id"]. " - Name: " . $row["firstname"]. " " . $row["lastname"]. " - Email: " . $row["email"]. "<br>";
//         }
//     } else {
//         echo "0 results";
//     }
// }
//
// viewGuests($conn, $sql);


$stmt = $conn->prepare("SELECT * FROM `MyGuests` WHERE firstname LIKE ?");
$stmt->bind_param("s", $search);

// set parameters and execute
$search = "John";
$stmt->execute();

$res = $stmt->get_result();

$stmt->close();

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

viewGuests($res);

$conn->close();
?>
