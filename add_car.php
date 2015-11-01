<?php
/**
 * Created by PhpStorm.
 * User: Vlex
 * Date: 3/7/2015
 * Time: 2:25 PM
 */
require_once 'db_connection.php';
session_start();
if (isset($_SESSION['uname']) && isset($_POST['make']) && isset($_POST['model']) && isset($_POST['year'])) {
    $owner = mysqli_fetch_assoc(mysqli_query($connection, "SELECT id FROM users WHERE uname='".$_SESSION['uname']."'"))['id'];
    $make = mysql_real_escape_string($_POST['make']);
    $model = mysql_real_escape_string($_POST['model']);
    $year = mysql_real_escape_string($_POST['year']);
    $cat = strtolower(mysql_real_escape_string($_POST['type']));
    mysqli_query($connection, "INSERT INTO cars(owner_id, made, model, year, cat) VALUES ('".$owner."', '".$make."', '".$model."', '".$year."', '".$cat."')");
}
header("Location: my_veh.php");
?>