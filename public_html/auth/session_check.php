<?php
// Start session if it's not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Check if user_id is set in session and if user_role is 'owner' (as admin equivalent)
if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'owner') {
    // User is not authenticated as an admin (owner)
    // Store the intended destination to redirect after login if needed (optional)
    // $_SESSION['redirect_url'] = $_SERVER['REQUEST_URI'];

    // Set a message for the user (optional)
    if (!isset($_SESSION['user_id'])) {
        $_SESSION['error_message'] = "You need to log in to access this page.";
    } elseif ($_SESSION['user_role'] !== 'owner') {
        $_SESSION['error_message'] = "You do not have permission to access this page.";
    }

    // Redirect to the sign-in page.
    // Assuming sign-in.php is in the public_html root directory,
    // and session_check.php is in public_html/auth/
    // and admin pages including this file are in public_html/admin/
    // From public_html/admin/ (where the page including this is located),
    // ../sign-in.php would correctly point to public_html/sign-in.php
    header("Location: ../sign-in.php");
    exit(); // Important to prevent further script execution
}

// If the script reaches this point, the user is authenticated and has the 'owner' (admin) role.
// The including page can continue its execution.
?>
