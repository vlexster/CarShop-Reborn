<?php
/**
 * Created by PhpStorm.
 * User: Vlex
 * Date: 3/7/2015
 * Time: 2:25 PM
 */
require_once 'db_connection.php';
session_start();
if (isset($_SESSION['uname']) && isset($_GET['id'])) mysqli_query($connection, "DELETE FROM cars WHERE id='".$_GET['id']."'");
header("Location: my_veh.php");
?>