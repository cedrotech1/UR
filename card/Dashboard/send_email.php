<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $to = $_POST['to'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];

    // Your SendGrid API key
    $sendgrid_api_key = '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'; // Replace with your actual SendGrid API Key

    // Prepare the email data
    $email_data = [
        'personalizations' => [
            [
                'to' => [
                    ['email' => $to]
                ],
                'subject' => $subject
            ]
        ],
        'from' => ['email' => 'cedrotech1@gmail.com'], // Replace with your verified sender email
        'content' => [
            [
                'type' => 'text/plain',
                'value' => $message
            ]
        ]
    ];

    // Initialize cURL
    $ch = curl_init('https://api.sendgrid.com/v3/mail/send');

    // Set the cURL options
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Authorization: Bearer ' . $sendgrid_api_key,
        'Content-Type: application/json'
    ]);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($email_data));

    // Execute the request
    $response = curl_exec($ch);

    // Get HTTP response code
    $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    // Check for errors
    if (curl_errno($ch)) {
        echo 'Error: ' . curl_error($ch);
    } else {
        if ($http_status === 202) {
            // 202 status means accepted by SendGrid
            echo '<p>Email sent successfully!</p>';
        } else {
            // Output response and HTTP status for debugging
            echo '<p>Failed to send email.</p>';
            echo '<p>HTTP Status: ' . $http_status . '</p>';
            echo '<p>Response: ' . $response . '</p>';
        }
    }

    // Close the cURL session
    curl_close($ch);
}
?>
