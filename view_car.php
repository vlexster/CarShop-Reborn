<?php
/**
 * Created by PhpStorm.
 * User: Vlex
 * Date: 3/10/2015
 * Time: 9:45 PM
 */


require_once 'db_connection.php';
session_start();
$car_info = @mysqli_fetch_all(mysqli_query($connection, "SELECT * FROM cars WHERE id = ".$_GET['carid']), MYSQLI_ASSOC)[0];
$job_list = @mysqli_fetch_all(mysqli_query($connection, "SELECT * FROM jobs WHERE car_id = ".$car_info['id']), MYSQLI_ASSOC);
echo "<br><br>";
if(isset($_POST['car_id'])) echo "car_id is ".$_POST['car_id']."<br>";
if(isset($_POST['mech_id'])) echo "mech_id is ".$_POST['mech_id']."<br>";
if(isset($_POST['description'])) echo "description is ".$_POST['description']."<br>";
if(isset($_POST['date'])) echo "date is ".$_POST['date']."<br>";
if(isset($_POST['time'])) echo "time is ".$_POST['time']."<br>";
if(isset($_POST['duration'])) echo "duration is ".$_POST['duration']."<br>";
echo "<br><br>";
if (isset($_POST['make'])) echo $_POST['make']."<br>";
?>

<html>
<head>
    <link rel="stylesheet" type="text/css" href="style.css" />
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script src="//code.jquery.com/jquery-1.10.2.js"></script>
    <script src="//code.jquery.com/ui/1.11.3/jquery-ui.js"></script>
    <script>
        $(document).ready(function() {
            $(".add_btn").click(function () {
                $(".add_req").slideToggle("up");
                $(".add_btn").hide();
                $(".cls_btn").show();
            });
            $(".cls_btn").click(function () {
                $(".add_req").slideToggle("up");
                $(".cls_btn").hide();
                $(".add_btn").show();
            });
        });
    </script>
    <style>
        .info {text-align: right;}
    </style>
</head>
<body><center>
    <?php
        if(isset($car_info['img1']) || isset($car_info['img2']) || isset($car_info['img3'])) echo "<div style=\"width:100%; height: 300px;\"><center>";
        if(isset($car_info['img1'])) echo "<img src='".$car_info['img1']."' style='height:280px; margin:10px;'>";
        if(isset($car_info['img2'])) echo "<img src='".$car_info['img2']."' style='height:280px; margin:10px;'>";
        if(isset($car_info['img3'])) echo "<img src='".$car_info['img3']."' style='height:280px; margin:10px;'>";
    if(isset($car_info['img1']) || isset($car_info['img2']) || isset($car_info['img3'])) echo "</center></div>";
    $owner = @mysqli_fetch_assoc(mysqli_query($connection, "SELECT * FROM users WHERE id ='".$car_info['owner_id']."'"));
    echo "<div><strong>(".$car_info['year'].") ".$car_info['made']." ".$car_info['model']."</strong><br>
    <table border=0 style='width:300px;'><tr><td>Owner:</td><td class=\"info\">".$owner['fname']." ".$owner['lname']."</td></tr>
    <tr><td>Phone:</td><td class=\"info\">".$owner['phone']."</td></tr>
    <tr><td>City:</td><td class=\"info\">".$owner['city']."</td></tr></table>";
    if($_SESSION['uname']!=$owner['uname']) echo "<button class=\"add_btn\">Want to check this car personally out? Request to take a look here.</button>
    <button class=\"cls_btn\" style=\"display:none;\">Close.</button>
    <div class=\"add_req\" style=\"display:none;\">
    <form method=\"post\" action=\"add_req.php\" target=\"_self\">
    <input type=\"hidden\" name=\"car_id\" value=\"".$_GET['carid']."\">
    Hi, can I take a look at this car on<br><input type=\"datetime-local\" name=\"text\"><br>
    <input type=\"submit\" value=\"Send request\"></form></div></div><br><br>";?>

    <?php
    if(sizeof($job_list)==0) echo "No service events available for this vehicle.";
    else{
        echo "<h3>Service history:</h3><table class='my_cars'><tr><th>Date</th><th>Service description</th><th>Carried out by</th><th>Parts used</th></tr>";
        foreach ($job_list as $job) {
            $part =  @mysqli_fetch_assoc(mysqli_query($connection, "SELECT * FROM parts WHERE id ='".$job['part_id']."'"));
            $mechanic = mysqli_fetch_assoc(mysqli_query($connection, "SELECT * FROM users WHERE id ='".$job['mechanic_id']."'"));
            if ($job['status'] == "1") $status = "Complete"; else if ($job['status']=="0") $status = "In progress"; else $status="Pending";
            $comments = @mysqli_fetch_all(mysqli_query($connection, "SELECT * FROM comments WHERE job_id = '".$job['id']."' ORDER BY id"), MYSQLI_ASSOC);
            echo "<tr><td>".date("M jS Y", $job['timestamp'])."</td><td>".$job['description']."</td><td>".$mechanic['fname']." ".$mechanic['lname']." <br> ".$mechanic['address'].', '.$mechanic['address']."</td><td>Brand: ".$part['vendor']."</td>";
            echo "</tr>";
        }
        echo "</table><br/>\n\n";
    }

    ?>
</center>
</body>
</html>
