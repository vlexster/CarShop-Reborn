<?php
/**
 * Created by PhpStorm.
 * User: Vlex
 * Date: 3/7/2015
 * Time: 12:02 AM
 */

$host = "localhost";
$username = "carshop_user";
$pass = "GdHqBG6zcfyS85QU";
$db_name = "carshop";
$connection = new mysqli($host, $username, $pass, $db_name);
if ($connection->connect_error){
    die ("Connection failed: ". $connection->connect_error);
} else mysqli_set_charset($connection, 'utf8');
mysqli_select_db($connection, $db_name);

?>