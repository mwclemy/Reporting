<?php require_once("includes/db_connection.php"); ?>
<?php include("includes/functions.php"); ?>

<?PHP

function cleanData(&$str) {
    if ($str === 't') {
        $str = 'TRUE';
    }
    if ($str == 'f') {
        $str = 'FALSE';
    }
    if (preg_match("/^0/", $str) || preg_match("/^\+?\d{8,}$/", $str) || preg_match("/^\d{4}.\d{1,2}.\d{1,2}/", $str)) {
        $str = "'$str";
    }
    if (strstr($str, '"')) {
        $str = '"' . str_replace('"', '""', $str) . '"';
    }
    $str = mb_convert_encoding($str, 'UTF-16LE', 'UTF-8');
}

// filename for download
$userid = (int) filter_input(INPUT_GET, "user_id");
$start = filter_input(INPUT_GET, "start");
$end = filter_input(INPUT_GET, "end");
$type = filter_input(INPUT_GET, "type");
if ($type === "task") {
    $filename = date('Ymd') . "_Task_report_" . ".csv";
    $assignments = find_user_task($userid, $start, $end);
    $num_assignments = count($assignments);
    $task_array = task_array($assignments, $num_assignments);
} else if ($type === "request") {
    $filename = date('Ymd') . "_Assignment_report_" . ".csv";
    $requests = find_user_assignments($userid, $start, $end);
    $num_requests = count($requests);
    $task_array = task_array($requests, $num_requests);
} else  {
    $filename = date('Ymd') . "_General_report_" . ".csv";
    $connections = find_all_connections($start, $end);
    $num_connections = count($connections);
    $task_array = report_array($connections, $num_connections);
    
}
header("Content-Disposition: attachment; filename=\"$filename\"");
header("Content-Type: text/csv; charset=UTF-16LE");

$out = fopen("php://output", 'w');
$flag = false;
foreach ($task_array as $value) {
    if ($value === 0) {
        $value = (string) $value;
    }
    if (!$flag) {
        // display field/column names as first row
        fputcsv($out, $value, ',', '"');
        $flag = true;
    } else {
        array_walk($value, 'cleanData');
        fputcsv($out, $value, ',', '"');
    }
}
fclose($out);
exit;
