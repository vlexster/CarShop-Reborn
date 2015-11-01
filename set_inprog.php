<?php
/**
 * Created by PhpStorm.
 * User: Vlex
 * Date: 3/7/2015
 * Time: 2:25 PM
 */
require_once 'db_connection.php';
session_start();
print_r($_POST);
if (isset($_SESSION['uname']) && isset($_GET['id']) && isset($_POST['new_price']) && isset($_POST['new_time'])) {
    $id = mysql_real_escape_string($_GET['id']);
    $owner = mysqli_fetch_assoc(mysqli_query($connection, "SELECT uname FROM users WHERE id = (SELECT mechanic_id FROM jobs WHERE id='".$id."')"));
    $new_time = strtotime(mysql_real_escape_string($_POST['new_time']));
    $new_price= mysql_real_escape_string($_POST['new_price']);
    if ($_SESSION['uname']==$owner['uname']){
        mysqli_query($connection, "UPDATE jobs SET status=0, timestamp=".$new_time.",price=".$new_price." WHERE id='".$id."'");
    }
}
header("Location: queue.php");
?>