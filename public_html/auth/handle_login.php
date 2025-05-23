<?php
session_start();
require_once '../config/db.php'; // Include database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? ''; // No trim for password initially

    // Input validation
    $errors = [];
    if (empty($email)) {
        $errors[] = "Email address is required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format.";
    }
    if (empty($password)) {
        $errors[] = "Password is required.";
    }

    // If validation errors exist, redirect back to sign-in page
    if (!empty($errors)) {
        $_SESSION['error_message'] = implode("<br>", $errors);
        header("Location: ../sign-in.php"); // Adjust path as necessary
        exit();
    }

    // Prepare and execute SQL SELECT statement
    $stmt_get_user = $conn->prepare("SELECT id, name, email, password, role FROM users WHERE email = ?");
    if (!$stmt_get_user) {
        $_SESSION['error_message'] = "Database error (prepare failed): " . $conn->error;
        header("Location: ../sign-in.php");
        exit();
    }
    $stmt_get_user->bind_param("s", $email);

    if (!$stmt_get_user->execute()) {
        $_SESSION['error_message'] = "Database error (execute failed): " . $stmt_get_user->error;
        $stmt_get_user->close();
        header("Location: ../sign-in.php");
        exit();
    }

    $result_get_user = $stmt_get_user->get_result();

    if ($result_get_user->num_rows === 1) {
        $user = $result_get_user->fetch_assoc();

        // Verify password
        if (password_verify($password, $user['password'])) {
            // Password matches, set session variables
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['user_email'] = $user['email']; // Storing email might be useful
            $_SESSION['user_role'] = $user['role'];

            // Clear any previous error messages
            unset($_SESSION['error_message']);
            $_SESSION['success_message'] = "Login successful. Welcome, " . htmlspecialchars($user['name']) . "!";


            // Redirect based on role
            if ($user['role'] === 'owner') { // Assuming 'owner' is the admin-like role
                header("Location: ../admin/index.php"); // Path to owner/admin dashboard
                exit();
            } else { // For 'customer' or any other roles
                header("Location: ../index.php"); // Path to the main site or user dashboard
                exit();
            }
        } else {
            // Passwords don't match
            $_SESSION['error_message'] = "Invalid email or password.";
            header("Location: ../sign-in.php");
            exit();
        }
    } else {
        // No user found with that email
        $_SESSION['error_message'] = "Invalid email or password."; // Use a generic message for security
        header("Location: ../sign-in.php");
        exit();
    }

    $stmt_get_user->close();

} else {
    // Not a POST request, redirect to sign-in page
    $_SESSION['error_message'] = "Invalid request method.";
    header("Location: ../sign-in.php");
    exit();
}

// Close the database connection (optional)
// $conn->close();
?>
