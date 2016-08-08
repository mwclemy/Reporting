<?php require_once("includes/session.php"); ?>
<?php require_once("includes/db_connection.php"); ?>
<?php include("includes/validation_functions.php"); ?>
<?php include("includes/functions.php"); ?>
<?php

$userid = get_userid();
if (null !== filter_input(INPUT_POST, "submit")) {
    // validations 
    $required_fields = array("fname", "lname", "username", "taskoption", "username", "password", "tel", "email");
    validate_presences($required_fields);
    if (empty($errors)) {
        $firstname = filter_input(INPUT_POST, "fname");
        $lastname = filter_input(INPUT_POST, "lname");
        $taskoption = filter_input(INPUT_POST, "taskoption");
        $roleid = find_roleid_by_rolename($taskoption);
        if ($roleid === null) {
            $query = "INSERT INTO roles ( ";
            $query.="role_name";
            $query.= ") VALUES ( ";
            $query.=" '{$taskoption}' ";
            $query.=" ) ";
            $result = mysqli_query($connection, $query);
            confirm_query($result);
            $roleid = find_roleid_by_rolename($taskoption);
        }
        $username = filter_input(INPUT_POST, "username");
        $password = filter_input(INPUT_POST, "password");
        $email = filter_input(INPUT_POST, "email");
        $tel = filter_input(INPUT_POST, "tel");
        // Insert into the user table
        $query = "INSERT INTO users ( ";
        $query.="fname, lname, email, username, hashed_password,tel,role_id ";
        $query.= ") VALUES ( ";
        $query.=" '{$firstname}','{$lastname}','{$email}','{$username }', '{$password}','{$tel}', $roleid ";
        $query.=" ) ";
        $result = mysqli_query($connection, $query);
        confirm_query($result);
        redirect_to("user_permissions.php");
    } else {
        $_SESSION["message"] = "Please collect Your errors";
        redirect_to("add_user.php");
    }
}












