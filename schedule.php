<?php
/**
 * Created by PhpStorm.
 * User: Vlex
 * Date: 3/7/2015
 * Time: 11:15 PM
 */

require_once 'db_connection.php';
session_start();
//$_SESSION['uname']="ivan";
if (isset($_SESSION['uname'])){
    $uid = intval(mysqli_fetch_array(mysqli_query($connection, "SELECT id FROM users WHERE uname ='".$_SESSION['uname']."'"))['id']);
    $role = boolval(mysqli_fetch_array(mysqli_query($connection, "SELECT type FROM users WHERE uname ='".$_SESSION['uname']."'"))['type']);
//    if ($role == false) $tstamps = mysqli_fetch_all(mysqli_query($connection, "SELECT timestamp FROM jobs WHERE mechanic_id='".$uid."'"));
//    else $tstamps = mysqli_fetch_all(mysqli_query($connection, "SELECT timestamp FROM jobs WHERE car_id IN (SELECT id FROM cars WHERE owner_id ='".$uid."')"));
    if ($role == false) $tstamps = mysqli_fetch_all(mysqli_query($connection, "SELECT * FROM jobs WHERE mechanic_id='".$uid."'"));
    else $tstamps = mysqli_fetch_all(mysqli_query($connection, "SELECT * FROM jobs WHERE car_id IN (SELECT id FROM cars WHERE owner_id ='".$uid."')"));}
else $tstamps = mysqli_fetch_all(mysqli_query($connection, "SELECT * FROM jobs"));
$tstamps2=array();
$tstamps_ts=array();
foreach ($tstamps as $stamp){
    if ($stamp[6]> strtotime('Last Sunday', time()) && $stamp[6]< strtotime('Next Sunday', time())) {
        array_push($tstamps2, $stamp);
        array_push($tstamps_ts, $stamp[6]);
    }
}
//var_dump($tstamps2);
//echo "<br><br>";
//var_dump($tstamps_ts);
//echo "<br><br>";
//var_dump($tstamps[1][6]);
//var_dump(mktime(10,30,0,6,9,2015));
//var_dump(strtotime('Last Sunday', time()));
//var_dump(strtotime('Next Sunday', time()));
//var_dump(mktime(10,30,0,6,11,2015));
//var_dump(mktime(12,30,0,6,12,2015));
//var_dump(mktime(9,30,0,6,11,2015));
//var_dump(mktime(9,30,0,6,12,2015));
//var_dump(mktime(11,30,0,6,11,2015));
?>

<html>
<head>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script>
        $(document).ready(function(){
            $(".clickable").click(function(){
                alert("Car: "+$(this).attr('data-car')+
                    "\nMechanic: "+$(this).attr('data-mech')+
                    "\nTask description: "+$(this).attr('data-jobdesc')+
                    "\nPrice: "+$(this).attr('data-price')+
                    "\nStatus: "+$(this).attr('data-status')
                );
            })
        })
    </script>
</head>
<body>
<h1>Jobs scheduled for this week</h1>
<div>
    <div style="position:relative; left:0px;">
    <table border="0" class="schedule" width="1130">
        <tr>
            <th width="50"></th>
            <th colspan="2" style="width: 60px;">9:00</th>
            <th colspan="2" style="width: 60px;">9:30</th>
            <th colspan="2" style="width: 60px;">10:00</th>
            <th colspan="2" style="width: 60px;">10:30</th>
            <th colspan="2" style="width: 60px;">11:00</th>
            <th colspan="2" style="width: 60px;">11:30</th>
            <th colspan="2" style="width: 60px;">12:00</th>
            <th colspan="2" style="width: 60px;">12:30</th>
            <th colspan="2" style="width: 60px;">13:00</th>
            <th colspan="2" style="width: 60px;">13:30</th>
            <th colspan="2" style="width: 60px;">14:00</th>
            <th colspan="2" style="width: 60px;">14:30</th>
            <th colspan="2" style="width: 60px;">15:00</th>
            <th colspan="2" style="width: 60px;">15:30</th>
            <th colspan="2" style="width: 60px;">16:00</th>
            <th colspan="2" style="width: 60px;">16:30</th>
            <th colspan="2" style="width: 60px;">17:00</th>
            <th colspan="2" style="width: 60px;">17:30</th>
            <th colspan="2" style="width: 60px;">18:00</th>
            <th></th>
        </tr>
        <?php
            echo "<tr><td colspan='2'>".date('D M, jS Y', strtotime('last sunday',strtotime('tomorrow')))."</td><td colspan='38' align='center' bgcolor='#abc'>Weekend</td></tr>";
            for ($d=0;$d<5;$d++){
                echo "<tr><td colspan='2'>".date('D M, jS Y', strtotime('last sunday',strtotime('tomorrow'))+($d+1)*24*3600)."</td>";
                for ($h = 0; $h<18; $h++){
                        if (in_array(strtotime('last sunday',strtotime('tomorrow'))+($d+1)*24*3600+9*3600+1800*$h , $tstamps_ts)) {
                            echo "<td colspan='" . 2 . "'";
                            if (isset($_SESSION['uname'])) {
                                $rand_col = dechex(rand(0, 155000) % 256) . dechex(rand(0, 155000) % 256) . dechex(rand(0, 155000) % 256);
                                echo "class='clickable' ";
                                $res = mysqli_fetch_assoc(mysqli_query($connection, "SELECT * FROM cars WHERE id =".$tstamps2[array_search(strtotime('last sunday',strtotime('tomorrow'))+($d+1)*24*3600+9*3600+1800*$h , $tstamps_ts)][1]));
                                echo "data-car='(". $res['year'] .") ". $res['made']. " " . $res['model']. "'";
                                $res = mysqli_fetch_assoc(mysqli_query($connection, "SELECT * FROM users WHERE id =".$tstamps2[array_search(strtotime('last sunday',strtotime('tomorrow'))+($d+1)*24*3600+9*3600+1800*$h , $tstamps_ts)][2]));
                                echo "data-mech='(". $res['phone'] .") ". $res['fname']. " " . $res['lname']. " @ " . $res['address'] . "'";
                                echo "data-jobdesc='". $tstamps2[array_search(strtotime('last sunday',strtotime('tomorrow'))+($d+1)*24*3600+9*3600+1800*$h , $tstamps_ts)][3] ."'";
                                echo "data-price='". $tstamps2[array_search(strtotime('last sunday',strtotime('tomorrow'))+($d+1)*24*3600+9*3600+1800*$h , $tstamps_ts)][4] ." lv.'";
                                if ($tstamps2[array_search(strtotime('last sunday',strtotime('tomorrow'))+($d+1)*24*3600+9*3600+1800*$h , $tstamps_ts)][5] == 1)
                                    echo "data-status='Complete!'";
                                else echo "data-status='In progress...'";
                                echo "bgcolor='#" . $rand_col . "'>";
                            } else echo "bgcolor='#666'>";
                            echo "</td>";
                        }
                    else echo "<td colspan='2'></td>";
                }
                echo "<td colspan='2'></td></tr>";
            }
            echo "<tr><td colspan='2'>".date('D M, jS Y', strtotime('last sunday',strtotime('tomorrow'))+7*24*3600)."</td><td colspan='38' align='center' bgcolor='#abc'>Weekend</td></tr>";
        ?>
    </table>
</div>
</div>
</body>
</html>
