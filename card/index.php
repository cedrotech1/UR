<?php
// Start the session
session_start();

// Include database connection file
include("connection.php");

// Load Composer's autoloader
require './vendor/autoload.php';

// Import PHPMailer classes into the global namespace
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Initialize the error and success message variables
$error = "";
$successMessage = "";

// Check if form is submitted
if (isset($_POST["submit"])) {
  // Define email and registration number variables and prevent SQL injection
  $email = mysqli_real_escape_string($connection, $_POST['email']);
  $regnumber = mysqli_real_escape_string($connection, $_POST['regnumber']);

  // Fetch user from database based on email and registration number
  $sql = "SELECT id, email, regnumber FROM info WHERE email='$email' AND regnumber='$regnumber'";
  $result = mysqli_query($connection, $sql);
  $row = mysqli_fetch_assoc($result);
  $count = mysqli_num_rows($result);

  // If user exists and registration number matches
  if ($count == 1) {
    // Generate a unique token
    $token = bin2hex(random_bytes(16));
$encodedToken = base64_encode($token . '|' . $regnumber);
    
    // Update the database with the token (optional, if you want to store it)
    $update_sql = "UPDATE info SET token='$encodedToken' WHERE email='$email'";
    mysqli_query($connection, $update_sql);

    // Create a new PHPMailer instance
    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->Host = 'smtp.gmail.com';                       // Specify main SMTP server
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        $mail->Username = 'cedrickhakuzimana@gmail.com';      // SMTP username
        $mail->Password = 'wqcb yrye bwrn apvj';              // SMTP password
        $mail->SMTPSecure = 'tls';                            // Enable TLS encryption
        $mail->Port = 587;                                    // TCP port to connect to

        // Recipients
        $mail->setFrom('cedrickhakuzimana@gmail.com', 'Cedrick');
        $mail->addAddress($email);                           // Add recipient

        // Content
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = 'Your Token';
        $mail->Body    = '
        <!DOCTYPE html>
        <html>
        <head>
            <style>
                body {
                    margin: 0;
                    padding: 0;
                    font-family: Arial, sans-serif;
                }
                .container {
                    width: 100%;
                    max-width: 600px;
                    margin: auto;
                    background-color: #f4f4f4;
                    padding: 20px;
                }
                .header {
                    background-color: skyblue;
                    color: #fff;
                    padding: 10px;
                    text-align: center;
                }
                .content {
                    background-color: #fff;
                    padding: 20px;
                    border-radius: 5px;
                }
                .footer {
                    background-color: skyblue;
                    color: #fff;
                    text-align: center;
                    padding: 10px;
                    font-size: 12px;
                }
                a {
                    color: #1a73e8;
                    text-decoration: none;
                }
            </style>
        </head>
        <body>
            <div class="container">
                <div class="header">
                    <h1>Your Authentication Token</h1>
                </div>
                <div class="content">
                    <p>Dear User,</p>
                    <p>Thank you for your request. Your authentication token is:</p>
                  <p><a href="http://localhost/ur-student-cardMs/Students/imageupload.php?token=' . urlencode($encodedToken) . '">Click here to proceed</a></p>
                <div class="footer">
                    <p>&copy; Your Company. All rights reserved.</p>
                </div>
            </div>
        </body>
        </html>';
        $mail->AltBody = 'Your authentication token is: ' . $encodedToken;

        // Send email
        $mail->send();
        $successMessage = 'An email with your authentication token has been sent to your email address.';
    } catch (Exception $e) {
        $error = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
  } else {
    $error = "Email and registration number do not match.";
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>UR-HUYE</title>
  <meta content="" name="description">
  <meta content="" name="keywords">
  <link href="./icon1.png" rel="icon">
  <link href="./icon1.png" rel="apple-touch-icon">
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
  <link href="./Dashboard/assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="./Dashboard/assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="./Dashboard/assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="./Dashboard/assets/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="./Dashboard/assets/vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="./Dashboard/assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="./Dashboard/assets/vendor/simple-datatables/style.css" rel="stylesheet">
  <link href="./Dashboard/assets/css/style.css" rel="stylesheet">
</head>
<body>
  <main>
    <div class="container">
      <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">
              <div class="card mb-3">
                <div class="card-body">
                  <div class="pt-4 pb-2">
                    <h5 class="card-title text-center pb-0 fs-4">Request Authentication Token</h5>
                    <?php if (!empty($error)): ?>
                    <div class="alert alert-danger" role="alert">
                      <?php echo $error; ?>
                    </div>
                    <?php endif; ?>
                    <?php if (!empty($successMessage)): ?>
                    <div class="alert alert-success" role="alert">
                      <?php echo $successMessage; ?>
                    </div>
                    <?php endif; ?>
                  </div>
                  <form class="row g-3 needs-validation" novalidate method="post" action="">
                    <div class="col-12">
                      <label for="yourEmail" class="form-label">Email</label>
                      <div class="input-group has-validation">
                        <input type="email" name="email" class="form-control" id="yourEmail" required>
                        <div class="invalid-feedback">Please enter your email.</div>
                      </div>
                    </div>
                    <div class="col-12">
                      <label for="yourRegNumber" class="form-label">Registration Number</label>
                      <div class="input-group has-validation">
                        <input type="text" name="regnumber" class="form-control" id="yourRegNumber" required>
                        <div class="invalid-feedback">Please enter your registration number.</div>
                      </div>
                    </div>
                    <div class="col-12">
                      <button class="btn btn-primary w-100" name='submit' type="submit">Submit</button>
                    </div>
                    <div class="col-12">
                      <p class="small mb-0"><a href="login.php">Click for internal user login</a></p>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>
  </main>
</body>
</html>
