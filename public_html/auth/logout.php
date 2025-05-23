<?php
// Start the session
session_start();

// Unset all session variables
// It's good practice to unset each specific session variable if known,
// but for a full logout, clearing the entire $_SESSION array is common.
$_SESSION = array();

// If it's desired to kill the session, also delete the session cookie.
// Note: This will destroy the session, and not just the session data!
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Finally, destroy the session.
session_destroy();

// Redirect to the homepage
// Ensure no output is sent before this header call.
header("Location: ../index.php");
exit(); // Ensure no further script execution after redirect
?>
