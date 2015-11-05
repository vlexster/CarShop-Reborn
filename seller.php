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
    $forsale = intval(mysqli_fetch_assoc(mysqli_query($connection, "SELECT forsale FROM cars WHERE id=".$id))['forsale']);
    $owner = mysqli_fetch_assoc(mysqli_query($connection, "SELECT * FROM users WHERE id= (SELECT owner_id FROM cars WHERE id=".$id.")"));
    if ($_SESSION['uname']==$owner['uname']) {
        var_dump($forsale);
        if ($forsale == 1){
            mysqli_query($connection, "UPDATE cars SET forsale=0 WHERE id=".$id);
    } else {
        mysqli_query($connection, "UPDATE cars SET forsale=1 WHERE id=".$id);
    }
}
}
header("Location: my_veh.php");
?>