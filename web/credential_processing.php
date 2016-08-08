<?php require_once("includes/session.php"); ?>
<?php require_once("includes/db_connection.php"); ?>
<?php include("includes/validation_functions.php"); ?>
<?php include("includes/functions.php"); ?>
<?php

$userid = get_userid();
if (null !== filter_input(INPUT_POST, "submit")) {
    // validations 
    $required_fields = array("repassword", "password");
    validate_presences($required_fields);
    if (empty($errors)) {
        $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_STRING);
        // update the user table
        $query = "UPDATE users ";
        $query.="SET  hashed_password='{$password}'  ";
        $query.="WHERE user_id=$userid ";
        $query.="LIMIT 1 ";
        $result = mysqli_query($connection, $query);
        confirm_query($result);
        if ($result && mysqli_affected_rows($connection) >= 0) {
            $_SESSION["message"] = "Password Changed";
            redirect_to("myprofile.php");
        } else {
            $_SESSION["message"] = "Password Update failed";
            redirect_to("change_password.php");
        }
    } else {
        $_SESSION["message"] = "Please collect Your errors";
        redirect_to("change_password.php");
    }
}












