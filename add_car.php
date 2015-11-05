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
    $forsale = mysql_real_escape_string($_POST['forsale']);
    $cat = strtolower(mysql_real_escape_string($_POST['type']));
    if (isset($_POST['img1'])) $img1=mysql_real_escape_string($_POST['img1']); else $img1 = null;
    if (isset($_POST['img2'])) $img2=mysql_real_escape_string($_POST['img2']); else $img2 = null;
    if (isset($_POST['img3'])) $img3=mysql_real_escape_string($_POST['img3']); else $img3 = null;
    mysqli_query($connection, "INSERT INTO cars(owner_id, made, model, year, cat, forsale, img1, img2, img3) VALUES ('".$owner."', '".$make."', '".$model."', '".$year."', '".$cat."', ".$forsale.", '".$img1."',  '".$img2."',  '".$img3."')");
}
header("Location: my_veh.php");
?>