<?php
session_start();
include("php/config.php"); // Ensure this path is correct

echo 'Hello';

// Check if form is submitted
if (isset($_POST['submit'])) {
    $username = mysqli_real_escape_string($con, $_POST['username']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $age = mysqli_real_escape_string($con, $_POST['age']);
    $password = mysqli_real_escape_string($con, $_POST['password']);

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<div class='message'>
                  <p>Invalid email format. Please try again.</p>
              </div> <br>";
        echo "<a href='javascript:self.history.back()'><button class='btn'>Go Back</button></a>";
        exit(); // Prevent further execution if email is invalid
    }

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Verifying the unique email
    $verify_query = mysqli_query($con, "SELECT email FROM users WHERE email='$email'");

    if (mysqli_num_rows($verify_query) != 0) {
        echo "<div class='message'>
                  <p>This email is already used, try another one please!</p>
              </div> <br>";
        echo "<a href='javascript:self.history.back()'><button class='btn'>Go Back</button></a>";
    } else {
        // Insert the new user into the database
        $insert_query = "INSERT INTO users (username, email, age, password)
                         VALUES ('$username', '$email', '$age', '$hashed_password')";

        if (mysqli_query($con, $insert_query)) {
            // Registration successful, redirect to home page
            header("Location: home.php");
            exit(); // Ensure no further code is executed
        } else {
            // Print MySQL error for debugging
            die("Error inserting user into database: " . mysqli_error($con));
        }
    }
} else {
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="style/style.css">
        <title>Register</title>
    </head>
    <body>
    <div class="container">
        <div class="box form-box">
            <header>Sign Up</header>
            <form action="" method="post">
                <div class="field input">
                    <label for="username">Username</label>
                    <input type="text" name="username" id="username" autocomplete="off" required>
                </div>
                <div class="field input">
                    <label for="email">Email</label>
                    <input type="text" name="email" id="email" autocomplete="off" required>
                </div>
                <div class="field input">
                    <label for="age">Age</label>
                    <input type="number" name="age" id="age" autocomplete="off" required>
                </div>
                <div class="field input">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" autocomplete="off" required>
                </div>
                <div class="field">
                    <input type="submit" class="btn" name="submit" value="Register" required>
                </div>
                <div class="links">
                    Already a member? <a href="index.php">Sign In</a>
                </div>
            </form>
        </div>
    </div>
    </body>
    </html>
<?php } ?>