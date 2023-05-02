<?php
session_start();
// Unset user_id session variable
unset($_SESSION['user_id']);
// Destroy the session
session_destroy();

// Redirect to the login page or homepage
header('Location: ../pages/welcome.html');
exit;
