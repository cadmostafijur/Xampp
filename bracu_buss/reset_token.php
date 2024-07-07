<?php
include 'config.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    // check if the email exists in the database
    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = $conn->query($sql);
    if ($result->num_rows == 1) {
        // generate a unique token for resetting the password
        $token = md5(uniqid(rand(), true));
        //update the user's record with the token
        $update_sql = "UPDATE users SET reset_token='$token' WHERE email='$email'";
        if ($conn->query($update_sql) === TRUE) {
            // Send an email to the user with instructions for resetting the password
            // in future, implement email sending functionality here
            // Example:
            // mail($email, "Password Reset", "Click the link to reset your password: reset_password.php?token=$token");

            // Redirect the user to a page indicating that the reset instructions have been sent
            header("Location: reset_instructions_sent.php");
            exit();
        } else {
            echo "Error updating record: " . $conn->error;
        }
    } else {
        // Email doesn't exist in the database
        // Redirect the user back to the forgot password page with an error message
        header("Location: forget.php?error=email_not_found");
        exit();
    }
}

$conn->close();
?>
