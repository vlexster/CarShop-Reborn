<?php
/**
 * Created by PhpStorm.
 * User: Vlex
 * Date: 3/10/2015
 * Time: 9:45 PM
 */


require_once 'db_connection.php';
session_start();
$car_list = @mysqli_fetch_all(mysqli_query($connection, "SELECT * FROM cars WHERE owner_id IN (SELECT id FROM users WHERE uname='".$_SESSION['uname']."')"), MYSQLI_ASSOC);
$mech_list = @mysqli_fetch_all(mysqli_query($connection, "SELECT * FROM users WHERE type=0"), MYSQLI_ASSOC);
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
        $(document).ready(function(){
            $(".add").click(function(){
                $(".add_form").slideToggle("up");
            });
        });

        function del_car(make, model, year, id, type){
            var conf = window.parent.window.confirm("Are you sure, you want to delete your "+ type +" "+make+" "+model+" ("+year+") with global ID "+id+"?");
            if (conf){
                window.location = "del_car.php?id="+id;
                //Because the check is JS based, we need to use GET as var passing method.
            }
        }

        function add_car(){
            var make = document.getElementById('make').value;
            var model = document.getElementById('model').value;
            var year = document.getElementById('year').value;
            var type = document.getElementById('type').options[document.getElementById('type').selectedIndex].text;
            if (make !="" && model != "" && year != "") document.forms["add_car"].submit();
            else window.alert("Missing required information!");
        }

    </script>
</head>
<body >

    <?php
    if (count($car_list)==0){
        echo "No vehicles have been entered for this user yet. If you want to add one - click on the button bellow.<br><br>";}
    else {
        echo "<table class='my_cars'><tr><th>Make</th><th>Model</th><th>Year of production</th><th>Vehicle type</th><th>Delete?</th></tr>";
        foreach ($car_list as $car){
            echo "<tr><td>".$car['made']."</td><td>".$car['model']."</td><td>".$car['year']."</td><td>".$car['cat']."</td><td align='center'><img src='images/deleteX.gif' onclick=\"del_car('".$car['made']."', '".$car['model']."', '".$car['year']."', '".$car['id']."', '".$car['cat']."')\"/></td></tr>";
        }
        echo "</table>";
    }
    ?>
    <button type="button" class="add">Add a new car</button>
    <div class="add_form" style="display:none">
        <form target="_self" action="add_car.php" id="add_car" method="post">
            <label for="make">Make</label><input type="text" name="make" id="make"/> <br/>
            <label for="model">Model</label><input type="text" name="model" id="model"/> <br/>
            <label for="year">Year of production</label><input type="text" name="year" id="year"/> <br/>
            <label for="type">Type of vehicle</label>
            <select name="type" id="type">
                <option value="car">Car</option>
                <option value="truck">Truck</option>
                <option value="bus">Bus</option>
            </select> <br/>
            <input type="button" value="Add" onclick="add_car()"/>
        </form>
    </div>
    <?php /*
    echo "<select name='car_id' id='add_job'>";
    foreach ($car_list as $car){
        echo "<option name=".$car['id'].">".$car['made']." ".$car['model']."(".$car['year'].")</option>";
    }
    echo "</select><br/>";

    echo "<select name='mech_id' id='add_job'>";
    foreach ($mech_list as $mech){
        echo "<option name=".$mech['id'].">".$mech['fname']." ".$mech['mname']." ".$mech['lname']." (".$mech['uname'].")</option>";
    }
    echo "</select><br/>";
    <input type="text" name="description" maxlength="45" id='add_job'><br/>
    <input type="date" name="date" id='add_job' <?php echo "min=\"".date('Y-m-d',strtotime('today'))."\" value=\"".date('Y-m-d',strtotime('today'))."\"";?> ><br/>
    <input type="time" name="time" step="1800" value="09:00:00" min="09:00:00" max="17:30:00" id='add_job'><br/>
    <input type="submit" id='add_job' <?php if (count($car_list)==0) echo "disabled=\"disabled\"";?> >
 */
    ?>
</form>
</body>
</html>