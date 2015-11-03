<?php
/**
 * Created by PhpStorm.
 * User: Vlex
 * Date: 3/7/2015
 * Time: 2:25 PM
 */
require_once 'db_connection.php';
session_start();
if (isset($_SESSION['uname']) && isset($_POST['car_id']) && isset($_POST['desc']) && isset($_POST['date']) && isset($_POST['for_mech'])) {
    $car_id = mysql_real_escape_string($_POST['car_id']);
    $desc = mysql_real_escape_string($_POST['desc']);
    $mech = mysql_real_escape_string($_POST['for_mech']);
    $date = strtotime(mysql_real_escape_string($_POST['date']));
    $part = mysql_real_escape_string($_POST['part']);
    $query = "INSERT INTO jobs(car_id, mechanic_id, description, status, timestamp, part) VALUES (".$car_id.", " . $mech . " , '".$desc."', 99, '".$date."', $part)";
    //var_dump($query);
    mysqli_query($connection, $query);
//    echo "INSERT INTO jobs(`car_id`, `mechanic_id`, `description`, `timestamp`) VALUES (".$car_id.", " . $mech . " , '".$desc."', '".time()."')";
}
header("Location: queue.php");
?>