<?php
/**
 * Created by PhpStorm.
 * User: Vlex
 * Date: 3/7/2015
 * Time: 12:55 PM
 */

require_once 'db_connection.php';
$uname = mysql_real_escape_string($_POST['uname']);
$fname = mysql_real_escape_string($_POST['fname']);
$mname = mysql_real_escape_string($_POST['mname']);
$lname = mysql_real_escape_string($_POST['lname']);
$pass = md5($uname.mysql_real_escape_string($_POST['pass']));
$email = mysql_real_escape_string($_POST['email']);
$address = mysql_real_escape_string($_POST['address']);
$phone = mysql_real_escape_string($_POST['phone']);
if ($_POST['role'] == "cust" ? $role = 1 : $role = 0);
$query = "INSERT INTO `users`(`uname`, `fname`, `mname`, `lname`, `type`, `phone`, `address`, `pass`, `email`) VALUES ('".$uname."','".$fname."','".$mname."','".$lname."',".$role.",'".$phone."','".$address."','".$pass."','".$email."')";
mysqli_query($connection, $query);
session_start();
$_SESSION['uname'] = $uname;
header('Location: index.php');
?>