<?php
session_start();
require_once '../config/db.php'; // Assuming db.php is in the config folder at the root of public_html

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? ''; // No trim for password initially, can be done after length check

    // Input validation
    $errors = [];
    if (empty($name)) {
        $errors[] = "Full name is required.";
    }
    if (empty($email)) {
        $errors[] = "Email address is required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format.";
    }
    if (empty($password)) {
        $errors[] = "Password is required.";
    } elseif (strlen($password) < 6) {
        $errors[] = "Password must be at least 6 characters long.";
    }

    // If validation errors exist, redirect back to sign-up page
    if (!empty($errors)) {
        $_SESSION['error_message'] = implode("<br>", $errors);
        header("Location: ../sign-up.php"); // Adjust path as necessary
        exit();
    }

    // Check if email already exists
    $stmt_check_email = $conn->prepare("SELECT id FROM users WHERE email = ?");
    if (!$stmt_check_email) {
        $_SESSION['error_message'] = "Database error (prepare failed): " . $conn->error;
        header("Location: ../sign-up.php");
        exit();
    }
    $stmt_check_email->bind_param("s", $email);
    if (!$stmt_check_email->execute()) {
        $_SESSION['error_message'] = "Database error (execute failed): " . $stmt_check_email->error;
        $stmt_check_email->close();
        header("Location: ../sign-up.php");
        exit();
    }
    $result_check_email = $stmt_check_email->get_result();
    if ($result_check_email->num_rows > 0) {
        $_SESSION['error_message'] = "Email address already registered. Please use a different email or login.";
        $stmt_check_email->close();
        header("Location: ../sign-up.php");
        exit();
    }
    $stmt_check_email->close();

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);
    if ($hashed_password === false) {
        $_SESSION['error_message'] = "Error hashing password. Please try again.";
        header("Location: ../sign-up.php");
        exit();
    }

    // Prepare and execute SQL INSERT statement
    // Default role is 'customer' as per the initial database schema discussion (users can be 'owner' or 'customer')
    $default_role = 'customer';
    $stmt_insert_user = $conn->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)");
    if (!$stmt_insert_user) {
        $_SESSION['error_message'] = "Database error (prepare failed for insert): " . $conn->error;
        header("Location: ../sign-up.php");
        exit();
    }
    $stmt_insert_user->bind_param("ssss", $name, $email, $hashed_password, $default_role);

    if ($stmt_insert_user->execute()) {
        $_SESSION['success_message'] = "Registration successful! Please login.";
        header("Location: ../sign-in.php"); // Adjust path as necessary
        exit();
    } else {
        // Check for specific duplicate entry error (though email check should prevent this)
        if ($conn->errno == 1062) { // Error number for duplicate entry
             $_SESSION['error_message'] = "This email address is already registered.";
        } else {
            $_SESSION['error_message'] = "Registration failed. Please try again. Error: " . $stmt_insert_user->error;
        }
        header("Location: ../sign-up.php");
        exit();
    }
    $stmt_insert_user->close();

} else {
    // Not a POST request, redirect to sign-up page or show an error
    $_SESSION['error_message'] = "Invalid request method.";
    header("Location: ../sign-up.php"); // Adjust path as necessary
    exit();
}

// Close the database connection (optional, as PHP usually closes it at the end of script execution)
// $conn->close();
?>
