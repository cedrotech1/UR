<?php
include('connection.php'); // Make sure this file contains your database connection settings

// Get the data sent from JavaScript
$input = file_get_contents("php://input");
$data = json_decode($input, true);

// Output the received data for debugging
var_dump($data);

// Insert data into the MySQL database
foreach ($data['data'] as $row) {
    // Ensure the row has enough columns and is not empty
    if (!empty($row[0]) && !empty($row[1])) {
        // Assign variables for each column
        $regnumber = $connection->real_escape_string($row[0]);
        $campus = $connection->real_escape_string($row[1]);
        $college = $connection->real_escape_string($row[2]);
        $names = $connection->real_escape_string($row[3]);
        $school = $connection->real_escape_string($row[4]);
        $program = $connection->real_escape_string($row[5]);
        $yearofstudy = (int) $connection->real_escape_string($row[6]);
        $expireddate = $connection->real_escape_string($row[7]);

        // Insert data into the MySQL database
        $sql = "INSERT INTO info (regnumber, campus, college, names, school, program, yearofstudy, expireddate)
                VALUES ('$regnumber', '$campus', '$college', '$names', '$school', '$program', $yearofstudy, '$expireddate')";

        if (!$connection->query($sql)) {
            echo "SQL Error: " . $connection->error;
        } else {
            echo "Data inserted for $names!<br>";
            // echo "<script>alert('Data inserted successfully.')</script>";
        }
    } else {
        echo "Empty row found, skipping.<br>";
    }
}

$connection->close();
?>
