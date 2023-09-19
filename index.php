<?php
session_start();

// Function to validate name
function validateName($name) {
    return preg_match('/^[a-zA-Z ]+$/', $name);
}

// Function to validate email
function validateEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

// Function to validate password
function validatePassword($password) {
    return (strlen($password) >= 8 && preg_match('/[A-Za-z]/', $password) && preg_match('/\d/', $password) && preg_match('/[^A-Za-z\d]/', $password));
}

// Initialize variables
$name = $email = $password = $confirm_password = "";
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and validate user inputs
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $password = htmlspecialchars($_POST['password']);
    $confirm_password = htmlspecialchars($_POST['confirm_password']);

    // Validate name
    if (!validateName($name)) {
        $errors['name'] = "Name is not valid";
    }

    // Validate email
    if (!validateEmail($email)) {
        $errors['email'] = "Email is not valid";
    }

    // Validate password
    if (!validatePassword($password)) {
        $errors['password'] = "Password must be at least 8 characters long and contain letters, numbers, and special characters";
    }

    // Confirm Password
    if ($password !== $confirm_password) {
        $errors['confirm_password'] = "Passwords do not match";
    }

    // If there are no errors, redirect to the welcome page
    if (empty($errors)) {
        $_SESSION['name'] = $name;
        $_SESSION['email'] = $email;
        header('Location: welcome.php');
        exit;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Registration Form</title>
    <link rel="stylesheet" href="style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,800&display=swap" rel="stylesheet">
</head>
<body>
    <h2>Registration Form</h2>
    <form action="" method="post" class = "container_form">
        <label for="name">Name:</label>
        <input type="text" name="name" id="name" required>
        <?php if (isset($errors['name'])) { echo '<span class="error">' . $errors['name'] . '</span>'; } ?><br><br>

        <label for="email">Email:</label>
        <input type="email" name="email" id="email" required>
        <?php if (isset($errors['email'])) { echo '<span class="error">' . $errors['email'] . '</span>'; } ?><br><br>

        <label for="password">Password:</label>
        <input type="password" name="password" id="password" required>
        <?php if (isset($errors['password'])) { echo '<span class="error">' . $errors['password'] . '</span>'; } ?><br><br>

        <label for="confirm_password">Confirm Password:</label>
        <input type="password" name="confirm_password" id="confirm_password" required>
        <?php if (isset($errors['confirm_password'])) { echo '<span class="error">' . $errors['confirm_password'] . '</span>'; } ?><br><br>

        <input type="submit" name="submit" value="Register">
    </form>
</body>
</html>
