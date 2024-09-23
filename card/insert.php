
<?php
include ("connection.php");

// Check if the form is submitted
if (isset($_POST['save'])) {
    // Retrieve form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];

    // Connect to the database (replace 'hostname', 'username', 'password', and 'database' with your actual credentials)

    // Check connection
    if (!$connection) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Escape special characters to prevent SQL injection
    $name = mysqli_real_escape_string($connection, $name);
    $email = mysqli_real_escape_string($connection, $email);
    $subject = mysqli_real_escape_string($connection, $subject);
    $message = mysqli_real_escape_string($connection, $message);

    // Insert form data into the database
    $sql = "INSERT INTO contact_messages (name, email, subject, message) VALUES ('$name', '$email', '$subject', '$message')";

    if (mysqli_query($connection, $sql)) {
        echo "<script>alert('Your message has been sent. Thank you!')</script>";
        echo "<script>window.location.href='index.php'</script>";
    } else {
        echo "<script>alert('Error: " . $sql . "<br>" . mysqli_error($connection) . "')</script>";
    }

    // Close database connection
    mysqli_close($connection);
}
?>
