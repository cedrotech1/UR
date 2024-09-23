<?php
// Load Composer's autoloader
require '../vendor/autoload.php';

// Import PHPMailer classes into the global namespace
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

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
    $mail->addAddress('cedrotech1@gmail.com');            // Add a recipient

    // Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = 'Welcome to Our Service';
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
            .button {
                display: inline-block;
                padding: 10px 20px;
                font-size: 16px;
                color: #fff;
                background-color: #1a73e8;
                text-decoration: none;
                border-radius: 5px;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="header">
                <h1>AUTHANTICATION MESSAGE UR HUYE</h1>
            </div>
            <div class="content">
                <p>Dear User,</p>
                <p>Thank you for signing up for our service. We\'re excited to have you on board!</p>
                <p>To get started, please click the button below:</p>
                <a href="https://example.com/start" class="button">Get Started</a>
                <p>If you have any questions, feel free to <a href="mailto:support@example.com">contact us</a>.</p>
            </div>
            <div class="footer">
                <p>&copy; ur-huye. All rights reserved.</p>
            </div>
        </div>
    </body>
    </html>';
    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    // Send email
    $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
?>
