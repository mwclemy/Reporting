<?php require_once("includes/session.php"); ?>
<?php require_once("includes/db_connection.php"); ?>
<?php include("includes/validation_functions.php"); ?>
<?php include("includes/functions.php"); ?>
<?php

if (null !== filter_input(INPUT_POST, "submit")) {
    // validations 
    $required_fields = array("username", "password");
    validate_presences($required_fields);
    if (empty($errors)) {
// Attempt Login
        $username = filter_input(INPUT_POST, "username");
        $password = filter_input(INPUT_POST, "password");
        $found_user = attempt_login($username, $password);

        if ($found_user) {
// Mark user as logged in 
            $_SESSION["user_id"] = $found_user["user_id"];
            $_SESSION["fname"] = $found_user["fname"];
            $_SESSION["fname"] = $found_user["lname"];
            $_SESSION["role_id"] = $found_user["role_id"];

            redirect_to("main.php");
        } else {
            $_SESSION["message"] = "Email/password do not match";
            redirect_to("login.php");
        }
    } else {
        $_SESSION["message"] = "Email/password do not match";
        redirect_to("login.php");
    }
}












