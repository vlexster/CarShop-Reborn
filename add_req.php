<?php
/**
 * Created by PhpStorm.
 * User: Vlex
 * Date: 3/7/2015
 * Time: 2:25 PM
 */
require_once 'db_connection.php';
session_start();
if (isset($_SESSION['uname']) && isset($_POST['car_id']) && isset($_POST['text'])) {
    $author = mysqli_fetch_assoc(mysqli_query($connection, "SELECT id FROM users WHERE uname='".$_SESSION['uname']."'"))['id'];
    $car_id = mysql_real_escape_string($_POST['car_id']);
    $text = mysql_real_escape_string($_POST['text']);
    $query = "INSERT INTO comments(author_id, request, job_id, comment, timestamp) VALUES ('".$author."', 1, '".$car_id."', '".$text."', '".time()."')";
//    var_dump($query);
    mysqli_query($connection, $query);
}
header("Location: bazaar.php");
?>