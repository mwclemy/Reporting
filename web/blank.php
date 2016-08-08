<?php require_once("includes/session.php"); ?>
<?php require_once("includes/db_connection.php"); ?>
<?php include("../ussd/functions.php"); ?>
<?php
//$menus = find_menus_for_user(6);
//$result = find_menuids($menus);
//echo $result;
//echo count(null);
//$assignments = find_assignments_by_requestid(6);
//$num_assignments = count($assignments);
//echo $num_assignments;
//$assignment = find_assignment_by_id(2);
//$assigned_task = $assignment[0]['assigned_task'];
//echo $assigned_task;
//echo Update_assignments(2, 'pending');
//echo Update_requests(2, 'pending');
//$user = find_user_by_id(1);
//echo $user['fname'];
//$requests = find_all_requests();
//print_r($requests);
//$fields = find_all_customer_fields();
//$connections=find_all_connections();
$user_tasks = find_user_task(15, "in progress");
echo $num_task = count($user_tasks);
//echo count(find_all_connections());
//$connections = find_all_connections("2015-07-02", "2015-08-07");
//$num_connections = count($connections);
//echo $num_connections;
//$users = find_all_assignments(5, 'true');
//print_r($users);
//$num_menus = count($users);
//
//$menuids = array();
//for ($count = 0; $count < $num_menus; $count++) {
//    $menuids[] = $users[$count]['menu_id'];
//}
//if (in_array(10, $menuids)) {
//    echo 'yes';
//}
//print_r($menuids);
//echo in_array($users, $haystack)
?>
<!DOCTYPE html>
<html lang = "en">
    <head>
        <title> Test page</title>
    </head>
    <body>
        <!--<input  type="checkbox" id="whatever" checked> -->

        <?php //echo true ?>
        <?php //echo update_user_menus(1, 1); ?>
        <?php
//        if (does_this_exist(1, 100) === null) {
//            //echo 'yes';
//        }
        ?>
        <div><?php //echo report_table($connections, $num_connections);   ?> </div>
    </body>
</html>

