<?php
/**
 * Created by PhpStorm.
 * User: Vlex
 * Date: 3/7/2015
 * Time: 2:25 PM
 */
require_once 'db_connection.php';
session_start();
if (isset($_SESSION['uname']) && isset($_GET['id'])) {
    $id = mysql_real_escape_string($_GET['id']);
    $owner = mysqli_fetch_assoc(mysqli_query($connection, "SELECT uname FROM users WHERE id = (SELECT mechanic_id FROM jobs WHERE id='".$id."')"));
    if ($_SESSION['uname']==$owner['uname']) mysqli_query($connection, "UPDATE jobs SET status=1 WHERE id='".$id."'");
}
header("Location: queue.php");
?>