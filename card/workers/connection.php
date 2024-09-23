<?php

session_start();

if(!isset($_SESSION['loggedin'])){
    echo"<script>window.location.href='../login.php'</script>";

}


$connection=mysqli_connect('localhost','root','','garage');
if($connection){
// echo'connected';
}


function formatMoney($amount) {
    // Check if the amount is not a number
    if (!is_numeric($amount)) {
        return "Invalid amount";
    }

    // Format the amount with two decimal places and commas for thousands separator
    $formatted_amount = number_format($amount, 2, '.', ',');

    // Return the formatted amount with a currency symbol
    return  $formatted_amount. ' Rwf';
}

// Example usage
$amount = 1234567.89;
 formatMoney($amount); // Output: $1,234,567.89



 function checkPrivilege($required_privilege) {
    if (!isset($_SESSION['id'])) {
        // If the user is not logged in, redirect to the login page
        header('Location: login.php');
        exit();
    }

    $id = $_SESSION['id'];
    global $connection;

    // Retrieve user privileges from the database
    $privileges_query = "SELECT title FROM privilages WHERE uid = $id";
    
    $privileges_result = mysqli_query($connection, $privileges_query);
    $privileges = [];
    while ($privilege_row = mysqli_fetch_assoc($privileges_result)) {
        $privileges[] = $privilege_row['title'];
    }

    // Check if the required privilege is in the user's privileges
    if (!in_array($required_privilege, $privileges) || !in_array('active', $privileges)) {
        // If not, display an error message and stop script execution
        echo "<script>alert('You do not have permission to access this page.')</script>";
        echo "<script>window.location.href='users-profile.php'</script>";
        exit();
    }
}
?>