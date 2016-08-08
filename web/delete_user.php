<?php require_once("includes/session.php");?>
<?php require_once("includes/db_connection.php");?>
<?php require_once("includes/functions.php");?>
<?php confirm_logged_in(); ?>
<?php 
$user=find_user_by_id($_GET["id"]);
if(!$user)
{
redirect_to("manage_users.php");
}
$id=$user["user_id"];
$query="DELETE  FROM users WHERE user_id={$id} LIMIT 1 ";
$result=mysqli_query($connection,$query);
   if($result && mysqli_affected_rows($connection) ==1  )
   {
   $_SESSION["message"]="User deleted.";
   redirect_to("manage_users.php");
   }
   else{
   $_SESSION["message"]="User deletion failed.";
   redirect_to("manage_users.php");
   }
 ?>