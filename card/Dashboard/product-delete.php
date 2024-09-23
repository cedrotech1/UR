<?php
include('connection.php');

// Check if 'regnumber' is set in the query string
if (!isset($_GET['regnumber'])) {
    echo "<script>window.location.href='stockstatus.php'</script>";
    exit();
}

$id = $_GET['regnumber'];

// Prepare the SQL statement to prevent SQL injection
$stmt = $connection->prepare("DELETE FROM info WHERE regnumber = ?");
$stmt->bind_param("s", $id);

if ($stmt->execute()) {
    echo "<script>alert('Record deleted successfully.')</script>";
} else {
    echo "<script>alert('Error deleting record: " . $stmt->error . "')</script>";
}

// Redirect to stockstatus.php
echo "<script>window.location.href='stockstatus.php'</script>";

// Close statement and connection
$stmt->close();
$connection->close();
?>
