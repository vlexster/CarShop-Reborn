<?php
/**
 * Created by PhpStorm.
 * User: Vlex
 * Date: 3/10/2015
 * Time: 9:45 PM
 */


require_once 'db_connection.php';
session_start();
echo "<br><br><br><br>";
if(isset($_GET['reqid']) && isset($_GET['action'])){
    if($_GET['action']=='deny') mysqli_query($connection, "UPDATE comments SET agree=2 WHERE id =".$_GET['reqid']);
    else if($_GET['action']=='agree') mysqli_query($connection, "UPDATE comments SET agree=1 WHERE id =".$_GET['reqid']);
}
$requests = @mysqli_fetch_all(mysqli_query($connection, "SELECT * FROM comments WHERE request = 1 AND job_id IN (SELECT id FROM cars WHERE owner_id = (SELECT id FROM users WHERE uname='".$_SESSION['uname']."'))"), MYSQLI_ASSOC);
$my_requests = @mysqli_fetch_all(mysqli_query($connection, "SELECT * FROM comments WHERE request = 1 AND author_id = (SELECT id FROM users WHERE uname='".$_SESSION['uname']."')"), MYSQLI_ASSOC);
?>

<html>
<head>
    <link rel="stylesheet" type="text/css" href="style.css" />
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script src="//code.jquery.com/jquery-1.10.2.js"></script>
    <script src="//code.jquery.com/ui/1.11.3/jquery-ui.js"></script>
    <style>
        .info {text-align: right;}
        a:link { color: #000;}
        a:active { color: #f00;}
        a:visited { color: #00f;}
        a:hover { color: #330;}
    </style>
</head>
<body><center>

    <?php
    if(sizeof($my_requests)!=0) {
        echo "<h3>Requests I've made</h3>";
        echo "<table border=\"1\"><tr><th>Request for</th><th>Request sent to</th><th>City</th><th>Phone of the owner</th><th>Currently requested time</th><th>Other party agreed?</th></tr>";
        foreach ($my_requests as $req){
            $car = @mysqli_fetch_assoc(mysqli_query($connection, "SELECT * FROM cars WHERE id = ".$req['job_id']));
            $owner = @mysqli_fetch_assoc(mysqli_query($connection, "SELECT * FROM users WHERE id = ".$car['owner_id']));
            if ($req['agree']==1) $agree = "<center><img src=\"./images/tick.png\"></center>"; else if($req['agree']==2) $agree = "Denied - better call the owner to schedule a visit"; else $agree = "No answer yet. Better call the owner";
            echo "<tr><td><a class='norm' href=\"view_car.php?carid=".$car['id']."\">(".$car['year'].") ".$car['made']." ".$car['model']."</a></td>
            <td>".$owner['fname']." ".$owner['lname']."</td>
            <td>".$owner['city']."</td>
            <td>".$owner['phone']."</td>
            <td><input type=\"datetime-local\" value=\"".$req['comment']."\"></td>
            <td>".$agree."</td></tr>";
        }
        echo "</table>";
    }
    else echo "<h3>There're no requests I've made so far</h3>";
    if(sizeof($requests)!=0)
    {
        echo "<h3>Requests others have made for any of my cars</h3>";
        echo "<table border=\"1\"><tr><th>Request for</th><th>Request made</th><th>Requestors city</th><th>Phone of the requestor</th><th>Currently requested time</th><th>Agree to the proposal?</th></tr>";
        foreach ($requests as $req){
            $car = @mysqli_fetch_assoc(mysqli_query($connection, "SELECT * FROM cars WHERE id = ".$req['job_id']));
            $requestor = @mysqli_fetch_assoc(mysqli_query($connection, "SELECT * FROM users WHERE id = ".$req['author_id']));
            echo "<tr><td><a class='norm' href=\"view_car.php?carid=".$car['id']."\">(".$car['year'].") ".$car['made']." ".$car['model']."</a></td>
            <td>".$requestor['fname']." ".$requestor['lname']."</td>
            <td>".$requestor['city']."</td>
            <td>".$requestor['phone']."</td>
            <td><input type=\"datetime-local\" value=\"".$req['comment']."\" disabled=\"true\"></td>
            <td><center><form target=\"_self\" action=\"view_req.php\" method=\"get\"><br><input type=\"hidden\" name=\"action\" value=\"deny\"><input type=\"hidden\" name=\"reqid\" value=\"".$req['id']."\"><input type=\"submit\" value=\"Deny\"";
            if($req['agree']!=null) echo"disabled='true'";
            if($req['agree']==2) echo"style='background-color:red;'";
            echo "></form>
            <form target=\"_self\" action=\"view_req.php\" method=\"get\"><input type=\"hidden\" name=\"action\" value=\"agree\"><input type=\"hidden\" name=\"reqid\" value=\"".$req['id']."\"><input type=\"submit\" value=\"Agree\"";
            if($req['agree']!=null) echo"disabled='true'";
            if($req['agree']==1) echo"style='background-color:green;'";
            echo "></form></center>
            </td></tr>";
        }
        echo "</table>";
    }
    else echo "<h3>There're no requests others have made for any of my vehicles</h3>";
?>
</center>
</body>
</html>
