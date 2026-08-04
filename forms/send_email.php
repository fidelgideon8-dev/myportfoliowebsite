<?php
header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize input
    $name    = htmlspecialchars(trim($_POST["name"] ?? ""));
    $email   = filter_var(trim($_POST["email"] ?? ""), FILTER_SANITIZE_EMAIL);
    $message = htmlspecialchars(trim($_POST["message"] ?? ""));

    // Validate
    if (empty($name) || empty($email) || empty($message)) {
        echo json_encode([
            "success" => false,
            "message" => "Please fill in all fields."
        ]);
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode([
            "success" => false,
            "message" => "Please enter a valid email address."
        ]);
        exit;
    }

    // Email settings
    $to      = "fidelgideon8@gmail.com";
    $subject = "New Client Inquiry from " . $name;

    // Email body
    $email_body  = "New Client Inquiry\n";
    $email_body .= "==================\n\n";
    $email_body .= "Name:    " . $name . "\n";
    $email_body .= "Email:   " . $email . "\n\n";
    $email_body .= "Message:\n" . $message . "\n";

    // Headers
    $headers  = "From: " . $name . " <" . $email . ">\r\n";
    $headers .= "Reply-To: " . $email . "\r\n";
    $headers .= "X-Mailer: PHP/" . phpversion();

    // Send email
    if (mail($to, $subject, $email_body, $headers)) {
        echo json_encode([
            "success" => true,
            "message" => "Thank you, " . $name . "! Your message has been sent successfully."
        ]);
    } else {
        echo json_encode([
            "success" => false,
            "message" => "There was an error sending your message. Please try again."
        ]);
    }
    exit;
} else {
    // Redirect back to form if accessed directly
    header("Location: contact.html");
    exit;
}
?>
