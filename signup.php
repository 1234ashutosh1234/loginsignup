<?php
session_start();
include('db.php');

if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Hash the password for security
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Check if the email or username already exists
    $sql = "SELECT * FROM users WHERE email = '$email' OR username = '$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // If user already exists, show an error message
        echo '<center><div class="alert alert-danger text-center" role="alert">
                <h4 class="alert-heading">User Already Exists!</h4>
                <p>The username or email is already taken. Please try again with a different one.</p>
                <hr>
                <p class="mb-0">You will be redirected to the signup page shortly.</p>
                <p class="mt-3"><a href="signup.html" class="btn btn-danger">Go to Signup</a></p>
            </div></center>';

        // Redirect after 10 seconds using JavaScript
        echo '<script>
                setTimeout(function(){
                    window.location.href = "signup.html";
                }, 10000);
              </script>';
    } else {
        // Insert the new user into the database
        $sql = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$hashed_password')";
        
        if ($conn->query($sql) === TRUE) {
            // Registration successful, show success message
            echo '<center><div class="alert alert-success text-center" role="alert">
                    <h4 class="alert-heading">Registration Successful!</h4>
                    <p>Your account has been created successfully.</p>
                    <hr>
                    <p class="mb-0">You will be redirected to the login page shortly.</p>
                    <p class="mt-3"><a href="login.html" class="btn btn-success">Go to Login</a></p>
                </div></center>';

            // Redirect after 10 seconds using JavaScript
            echo '<script>
                    setTimeout(function(){
                        window.location.href = "login.html";
                    }, 10000);
                  </script>';
        } else {
            // Database error
            echo '<center><div class="alert alert-danger text-center" role="alert">
                    <h4 class="alert-heading">Error!</h4>
                    <p>Something went wrong. Please try again later.</p>
                    <hr>
                    <p class="mb-0">You will be redirected to the signup page shortly.</p>
                    <p class="mt-3"><a href="signup.html" class="btn btn-danger">Go to Signup</a></p>
                </div></center>';

            // Redirect after 10 seconds using JavaScript
            echo '<script>
                    setTimeout(function(){
                        window.location.href = "signup.html";
                    }, 10000);
                  </script>';
        }
    }
}
?>
