<?php
// submit.php

// Enable error reporting for debugging (remove in production)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Only process POST requests
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Collect and sanitize form data
    $name    = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
    $email   = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $subject = filter_input(INPUT_POST, 'subject', FILTER_SANITIZE_STRING);
    $message = filter_input(INPUT_POST, 'message', FILTER_SANITIZE_STRING);

    // Basic validation
    if (empty($name) || empty($email) || empty($message)) {
        echo '<p style="color:red;">Please fill in all required fields.</p>';
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo '<p style="color:red;">Invalid email address.</p>';
        exit;
    }

    // Recipient email
    $to = "dilshan.uoj@example.com"; // <- change this to your email

    // Email headers
    $headers = "From: $name <$email>\r\n";
    $headers .= "Reply-To: $email\r\n";
    $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

    // Email body
    $body = "<h2>Contact Form Submission</h2>
             <p><strong>Name:</strong> $name</p>
             <p><strong>Email:</strong> $email</p>
             <p><strong>Subject:</strong> $subject</p>
             <p><strong>Message:</strong><br/>" . nl2br($message) . "</p>";

    // Send email
    if (mail($to, $subject ?: "New Contact Form Submission", $body, $headers)) {
        echo '<p style="color:green;">Thank you! Your message has been sent successfully.</p>';
    } else {
        echo '<p style="color:red;">Oops! Something went wrong. Please try again later.</p>';
    }

} else {
    // Invalid request method
    echo '<p style="color:red;">Invalid request.</p>';
}
?>