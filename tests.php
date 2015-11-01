<?php
/**
 * Created by PhpStorm.
 * User: Vlex
 * Date: 3/10/2015
 * Time: 9:45 PM
 */

/*$my_array = array(1,3,5,7);

for ($i=0;$i<10;$i++){
    if (in_array($i,$my_array)) echo "fuck off<br>";
    else echo "oh well<br>";
}

echo mktime(9,30,0,3,10,2015)."<br><br>";
echo "sunday 0:0:0<br>";
echo strtotime('last sunday',strtotime('tomorrow'));
echo "<br>tuesday 0:0:0<br>";
echo strtotime('last sunday',strtotime('tomorrow'))+(1+1)*24*3600;
echo "<br>tuesday 9:0:0<br>";
echo strtotime('last sunday',strtotime('tomorrow'))+(1+1)*24*3600+(1+8)*3600;
echo "<br><br>";
echo strtotime('last sunday',strtotime('tomorrow'))+(1+1)*24*3600+(1+8+0.5)*3600;
echo "<br><br>";
echo strtotime('last sunday',strtotime('tomorrow'))+(1+1)*24*3600+8*3600+1*1800;
echo "<br><br>";
*/

require_once 'db_connection.php';
session_start();
$_SESSION['uname']='joro';

$car_list = mysqli_fetch_all(mysqli_query($connection, "SELECT * FROM cars WHERE owner_id IN (SELECT id FROM users WHERE uname='".$_SESSION['uname']."')"), MYSQLI_ASSOC);
$mech_list = mysqli_fetch_all(mysqli_query($connection, "SELECT * FROM users WHERE type=0"), MYSQLI_ASSOC);
//var_dump($mech_list);
echo "<br><br>";
if(isset($_POST['car_id'])) echo "car_id is ".$_POST['car_id']."<br>";
if(isset($_POST['mech_id'])) echo "mech_id is ".$_POST['mech_id']."<br>";
if(isset($_POST['description'])) echo "description is ".$_POST['description']."<br>";
if(isset($_POST['date'])) echo "date is ".$_POST['date']."<br>";
if(isset($_POST['time'])) echo "time is ".$_POST['time']."<br>";
if(isset($_POST['duration'])) echo "duration is ".$_POST['duration']."<br>";

?>

<html>
<head>

</head>
<body >
<form target="_self" action="tests.php" method="post">
    <?php
    if (count($car_list)!=0){
    echo "<select name='car_id' id='add_job'>";
    foreach ($car_list as $car){
        echo "<option name=".$car['id'].">".$car['made']." ".$car['model']."(".$car['year'].")</option>";
    }
    echo "</select><br/>";}
    else echo "Няма въведени коли. Въведете кола, преди да заявите поправка!<br>";
    echo "<select name='mech_id' id='add_job'>";
    foreach ($mech_list as $mech){
        echo "<option name=".$mech['id'].">".$mech['fname']." ".$mech['mname']." ".$mech['lname']." (".$mech['uname'].")</option>";
    }
    echo "</select><br/>";
    ?>
    <input type="text" name="description" maxlength="45" id='add_job'><br/>
    <input type="date" name="date" id='add_job' <?php echo "min=\"".date('Y-m-d',strtotime('today'))."\" value=\"".date('Y-m-d',strtotime('today'))."\"";?> ><br/>
    <input type="time" name="time" step="1800" value="09:00:00" min="09:00:00" max="17:30:00" id='add_job'><br/>
    <input type="submit" id='add_job' <?php if (count($car_list)==0) echo "disabled=\"disabled\"";?> >
    <br><br><br><br>

</form>
</body>
</html>