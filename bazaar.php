<?php
/**
 * Created by PhpStorm.
 * User: Vlex
 * Date: 3/10/2015
 * Time: 9:45 PM
 */


require_once 'db_connection.php';
session_start();
$car_list = @mysqli_fetch_all(mysqli_query($connection, "SELECT * FROM cars WHERE forsale = 1"), MYSQLI_ASSOC);
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
    <style>
        .info {text-align: right;}
        a:link { color: #000;}
        a:active { color: #f00;}
        a:visited { color: #00f;}
        a:hover { color: #330;}
    </style>
</head>
<body >
<?php
if (count($car_list)==0){
    echo "Currently there are no cars being sold.<br><br>";}
else {
    echo "<table class='my_cars'><tr><th>Make</th><th>Model</th><th>Year of production</th><th>Vehicle type</th><th>More information</th></tr>";
    foreach ($car_list as $car){
        echo "<tr><td>".$car['made']."</td><td>".$car['model']."</td><td>".$car['year']."</td><td>".$car['cat']."</td><td align='center'><a href=\"view_car.php?carid=".$car['id']."\">Service history</a></td></tr>";
    }
    echo "</table>";
}
?>

</body>
</html>