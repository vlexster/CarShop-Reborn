<?php
/**
 * Created by PhpStorm.
 * User: Vlex
 * Date: 3/7/2015
 * Time: 2:25 PM
 */
require_once 'db_connection.php';
session_start();
if (isset($_SESSION['uname']) && isset($_POST['job_id']) && isset($_POST['text'])) {
    $author = mysqli_fetch_assoc(mysqli_query($connection, "SELECT id FROM users WHERE uname='".$_SESSION['uname']."'"))['id'];
    $job_id = mysql_real_escape_string($_POST['job_id']);
    $text = mysql_real_escape_string($_POST['text']);
    mysqli_query($connection, "INSERT INTO comments(author_id, job_id, comment, timestamp) VALUES ('".$author."', '".$job_id."', '".$text."', '".time()."')");
}
header("Location: queue.php");
?>