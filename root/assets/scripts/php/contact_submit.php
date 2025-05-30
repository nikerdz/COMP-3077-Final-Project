<?php
// Include the constants.php file
require_once('../../../config/constants.php');

// Start the session to access user info
session_start();

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST["name"]);
    $email = htmlspecialchars($_POST["email"]);
    $message = htmlspecialchars($_POST["message"]);

    // Email settings
    $to = "khan661@uwindsor.ca";
    $subject = "New Contact Form Inquiry from $name";
    $headers = "From: $email\r\n";
    $headers .= "Reply-To: $email\r\n";
    $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

    $body = "Name: $name\n";
    $body .= "Email: $email\n\n";
    $body .= "Message:\n$message\n";

    // Send the email
    if (mail($to, $subject, $body, $headers)) {
        // Use the constant PUBLIC_URL for redirection
        echo "<script>alert('Message sent successfully!'); window.location.href='" . PUBLIC_URL . "contact.php';</script>";
    } else {
        echo "<script>alert('Error sending message. Please try again.'); window.history.back();</script>";
    }
} else {
    // Redirect if accessed directly, using PUBLIC_URL constant
    header("Location: " . PUBLIC_URL . "contact.php");
    exit();
}
?>
