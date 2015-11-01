<?php
/**
 * Created by PhpStorm.
 * User: Vlex
 * Date: 3/7/2015
 * Time: 2:27 PM
 */
require_once 'db_connection.php';
$uname = mysql_real_escape_string($_POST['uname']);
$pass = md5($uname.mysql_real_escape_string($_POST['pass']));
$query_pass = mysqli_fetch_all(mysqli_query($connection, "SELECT pass FROM users WHERE uname = '".$uname."'"))[0][0];
if ($pass == $query_pass){
    session_start();
    $_SESSION['uname'] = $uname;
}
echo $pass;
echo "<br>";
echo $query_pass;

header('Location: index.php');
mysqli_close($connection);
?>