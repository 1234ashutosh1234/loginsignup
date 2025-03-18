<?php
session_start();
include('db.php');

if (isset($_POST['submit'])) {
    $email_username = $_POST['email_username'];
    $password = $_POST['password'];

    // Check if the user is registered by searching for email or username
    $sql = "SELECT * FROM users WHERE email = '$email_username' OR username = '$email_username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        // Verify the password
        if (password_verify($password, $row['password'])) {
            // Start the session
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['username'] = $row['username'];

            echo "Login successful!";
            header('Location: dashboard.php'); // Redirect to dashboard after successful login
        } else {
            echo "Invalid password!";
        }
    } else {
        echo "No user found with that email/username!";
    }
}
?>
