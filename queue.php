<?php
/**
 * Created by PhpStorm.
 * User: Vlex
 * Date: 3/10/2015
 * Time: 9:45 PM
 */


require_once 'db_connection.php';
session_start();
$job_list = @mysqli_fetch_all(mysqli_query($connection, "SELECT * FROM jobs WHERE car_id IN (SELECT id FROM cars WHERE owner_id = (SELECT id FROM users WHERE uname='".$_SESSION['uname']."'))"), MYSQLI_ASSOC);
$mech_job_list = @mysqli_fetch_all(mysqli_query($connection, "SELECT * FROM jobs WHERE mechanic_id IN (SELECT id FROM users WHERE uname='".$_SESSION['uname']."') AND status !=99"), MYSQLI_ASSOC);
$mech_job_unassigned = @mysqli_fetch_all(mysqli_query($connection, "SELECT * FROM jobs WHERE status = 99 AND mechanic_id = (SELECT id FROM users WHERE uname='".$_SESSION['uname']."')"), MYSQLI_ASSOC);
//var_dump($job_list);

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
            $(".add_btn").click(function(){
                $(".add_job").slideToggle("up");
                $(".add_btn").hide() ;
                $(".cls_btn").show() ;
            });
            $(".cls_btn").click(function(){
                $(".add_job").slideToggle("up");
                $(".cls_btn").hide();
                $(".add_btn").show();
            });
<?php
$customer = mysqli_fetch_assoc(mysqli_query($connection, "SELECT * FROM users WHERE uname = '".$_SESSION['uname']."'"))['type'];
if ($customer == "1"){
    foreach ($job_list as $job){
    echo "            $(\"#trigg".$job['id']."\").click(function(){\n";
    echo "                $(\"#comm".$job['id']."\").slideToggle(\"up\");\n";
    echo "            });\n";
    }
} else {
    foreach ($mech_job_list as $job){
    echo "            $(\"#mtrigg".$job['id']."\").click(function(){\n";
    echo "                $(\"#mcomm".$job['id']."\").slideToggle(\"up\");\n";
    echo "            });\n";
    }
    foreach ($mech_job_unassigned as $job){
    echo "            $(\"#mtrigg".$job['id']."\").click(function(){\n";
    echo "                $(\"#mcomm".$job['id']."\").slideToggle(\"up\");\n";
    echo "            });\n";
    }
}
 ?>
        });

        function add_job(){
            var car_id = document.getElementById('make').value;
            var description = document.getElementById('model').value;
            var type = document.getElementById('type').options[document.getElementById('type').selectedIndex].text;
            if (make !="" && model != "" && year != "") document.forms["add_car"].submit();
            else window.alert("Missing required information!");
        }

    </script>
</head>
<body >

    <?php
//    $customer = mysqli_fetch_assoc(mysqli_query($connection, "SELECT * FROM users WHERE uname = '".$_SESSION['uname']."'"))['type'];
    if ($customer == "1"){
        if (count($job_list)==0){
            echo "No jobs have been entered for this user yet. If you want to add one - click on the button bellow.<br><br>";}
        else {
            echo "<table class='my_jobs'><tr><th>Vehicle</th><th>Vehicle type</th><th>Mechanic</th><th>Address</th><th>Description</th><th>Scheduled for</th><th>Price</th><th>Completed?</th><th class=\"comments\">Comments</th></tr>";
            foreach ($job_list as $job){
                $car = mysqli_fetch_assoc(mysqli_query($connection, "SELECT * FROM cars WHERE id ='".$job['car_id']."'"));
                $mechanic = mysqli_fetch_assoc(mysqli_query($connection, "SELECT * FROM users WHERE id ='".$job['mechanic_id']."'"));
                if ($job['status'] == "1") $status = "Complete"; else if ($job['status']=="0") $status = "In progress"; else $status="Pending";
                $comments = @mysqli_fetch_all(mysqli_query($connection, "SELECT * FROM comments WHERE job_id = '".$job['id']."' ORDER BY id"), MYSQLI_ASSOC);
                echo "<tr><td>(".$car['year'].") ".$car['made']." ".$car['model']."</td><td>".$car['cat']."</td><td>".$mechanic['fname']." ".$mechanic['lname']."</td><td>".$mechanic['address']."</td><td>".$job['description']."</td><td>".date("D M jS @H:i", $job['timestamp'])."</td><td>".$job['price']."lv.</td>";
                if($status == "Complete") echo "<td class=\"job_compl\">".$status."</td>";
                if($status == "In progress") echo "<td class=\"job_prog\">".$status."</td>";
                if($status == "Pending") echo "<td class=\"job_pend\">".$status."</td>";
                echo "<td><button type=\"button\" ";
                if (!isset($comments)) echo "disabled=\"disabled\"";
                echo "id=\"trigg".$job['id']."\">Show comments</button><br><div id=\"comm".$job['id']."\" style=\"display:none;\">";

                echo "<table>";
                foreach ($comments as $comm){
                    $author = mysqli_fetch_assoc(mysqli_query($connection, "SELECT * FROM users WHERE id = '".$comm['author_id']."'"));
                    if ($author['type'] == "1") $role = "Cust"; else $role = "Mech";
                    echo "<tr><td style=\"width:25%; display:inline-block;\">By ".$author['fname']." ".$author['lname']." (".$role.") on ".date("D M jS @H:i", $comm['timestamp'])."</td><td width=\"65%\">".$comm['comment']."</td></tr>";
                }
                echo "<table></table><form target=\"_self\" action=\"add_com.php\" method=\"POST\"><input type=\"hidden\" name=\"job_id\" value=\"".$job['id']."\"><textarea name=\"text\"></textarea><br/><button type=\"submit\">Comment</button></form>";
                echo "</div></td></tr>";
            }
            echo "</table><br/>\n\n";
            echo "<button type='button' class='add_btn'>Add a new job</button>\n<button type='button' class='cls_btn' style='display: none;'>Close</button>\n";
            echo "<div class='add_job' style='display:none'";
            echo ">\n<form target=\"_self\" action=\"add_job.php\" id=\"add_job\" method=\"POST\">\n";
            echo "<label for=\"vehicle\">For Vehicle</label><select name=\"car_id\" id=\"car_id\">\n";
                $cars = mysqli_fetch_all(mysqli_query($connection, "SELECT * FROM cars WHERE owner_id = (SELECT id FROM users WHERE uname = '". $_SESSION['uname'] ."')" ));
                foreach ($cars as $vehicle){
                    echo "<option value='".$vehicle[0]."'>(".$vehicle[4].") ". $vehicle[2]. " " . $vehicle[3]."</option>\n";
                }
            echo "</select> <br/>\n";
            echo "<label for=\"for_mech\">Mechanic</label><select name=\"for_mech\" id=\"for_mech\">\n";
                $mechs = @mysqli_fetch_all(mysqli_query($connection, "SELECT * FROM users WHERE type = 0" ), MYSQLI_ASSOC);
                foreach ($mechs as $mech){
                    echo "<option value='".$mech['id']."'>".$mech['fname']." ". $mech['lname']. " - " . $mech['phone']." @".$mech['address']."</option>\n";
                }
            echo "</select><br>\n";
            echo "<label for=\"desc\">Description</label><textarea name=\"desc\" id=\"desc\"></textarea> <br/>\n";
            echo "<label for=\"time\">Time</label><input type=\"date\" name=\"date\" min=\"". date("Y-m-d",strtotime('Tomorrow'))."\" max=\"". date("Y-m-d",strtotime('+1 week next Friday'))."\" />\n";
            echo "<br/><button type=\"submit\">Add</button>\n</form>\n</div>";

    }
    } else{

        if (count($mech_job_unassigned)==0){
            echo "No pending to be accepted jobs for this mechanic at the moment!<br><br>";}
        else {
            echo "<table class='my_jobs'><tr><th>Vehicle</th><th>Vehicle type</th><th>Owner</th><th>Description</th><th>Scheduled for</th><th>Price</th><th>Completed?</th><th class=\"comments\">Comments</th></tr>";
            foreach ($mech_job_unassigned as $job){
                $car = mysqli_fetch_assoc(mysqli_query($connection, "SELECT * FROM cars WHERE id ='".$job['car_id']."'"));
                $owner = mysqli_fetch_assoc(mysqli_query($connection, "SELECT * FROM users WHERE id = (SELECT owner_id FROM cars WHERE id ='".$job['car_id']."')"));
                if ($job['status'] == "1") $status = "Complete"; else if ($job['status']=="0") $status = "In progress"; else $status="Pending";
                $comments = @mysqli_fetch_all(mysqli_query($connection, "SELECT * FROM comments WHERE job_id = '".$job['id']."' ORDER BY id"), MYSQLI_ASSOC);
                echo "<tr><td>(".$car['year'].") ".$car['made']." ".$car['model']."</td><td>".$car['cat']."</td><td>".$owner['fname']." ".$owner['lname']." (".$owner['phone'].")</td><td>".$job['description']."</td><form method=\"post\" target=\"_self\" action=\"set_inprog.php?id=".$job['id']."\"><td><input type=\"datetime-local\" name=\"new_time\" min=\"".date("Y-m-j", $job['timestamp'])."T09:00:00\" max=\"".date("Y-m-j", $job['timestamp'])."T17:30:00\" step=\"1800\" value=\"".date("Y-m-j", $job['timestamp'])."T".date("H:i:s", $job['timestamp'])."\"></td><td>".$job['price']."lv.<br><input type=\"text\" name=\"new_price\" size=\"4\"></td>";
                if($status == "Pending") echo "<td class=\"job_pend\">".$status."<br><button type=\"submit\">Begin Job</button></form></td>";
                echo "<td><button type=\"button\" ";
                echo "id=\"mtrigg".$job['id']."\">Show comments</button><br><div id=\"mcomm".$job['id']."\" style=\"display:none;\">";
                echo "<table>";
                foreach ($comments as $comm){
                    $author = mysqli_fetch_assoc(mysqli_query($connection, "SELECT * FROM users WHERE id = '".$comm['author_id']."'"));
                    if ($author['type'] == "1") $role = "Cust"; else $role = "Mech";
                    echo "<tr><td style=\"width:25%; display:inline-block;\">By ".$author['fname']." ".$author['lname']." (".$role.") on ".date("D M jS @H:i", $comm['timestamp'])."</td><td width=\"65%\">".$comm['comment']."</td></tr>";
                }
                echo "<table></table><form target=\"_self\" action=\"add_com.php\" method=\"POST\"><input type=\"hidden\" name=\"job_id\" value=\"".$job['id']."\"><textarea name=\"text\"></textarea><br/><button type=\"submit\">Comment</button></form>";
                echo "</div></td></tr>";
            }
            echo "</table><br><br>\n\n";
        }
        if (count($mech_job_list)==0){
            echo "No jobs have been entered for this mechanic yet. If you want to add one - click on the button bellow.<br><br>";}
        else {
            echo "<table class='my_jobs'><tr><th>Vehicle</th><th>Vehicle type</th><th>Owner</th><th>Description</th><th>Scheduled for</th><th>Price</th><th>Completed?</th><th class=\"comments\">Comments</th></tr>";
            foreach ($mech_job_list as $job){
                $car = mysqli_fetch_assoc(mysqli_query($connection, "SELECT * FROM cars WHERE id ='".$job['car_id']."'"));
                $owner = mysqli_fetch_assoc(mysqli_query($connection, "SELECT * FROM users WHERE id = (SELECT owner_id FROM cars WHERE id ='".$job['car_id']."')"));
                if ($job['status'] == "1") $status = "Complete"; else if ($job['status']=="0") $status = "In progress"; else $status="Pending";
                $comments = @mysqli_fetch_all(mysqli_query($connection, "SELECT * FROM comments WHERE job_id = '".$job['id']."' ORDER BY id"), MYSQLI_ASSOC);
                echo "<tr><td>(".$car['year'].") ".$car['made']." ".$car['model']."</td><td>".$car['cat']."</td><td>".$owner['fname']." ".$owner['lname']." (".$owner['phone'].")</td><td>".$job['description']."</td><td>".date("D M jS @H:i", $job['timestamp'])."</td><td>".$job['price']."lv.</td>";
                if($status == "Complete") echo "<td class=\"job_compl\">".$status."<br></td>";
                if($status == "In progress") echo "<td class=\"job_prog\">".$status."<br><form method=\"post\" target=\"_self\" action=\"set_compl.php?id=".$job['id']."\"><button type=\"submit\">Mark complete</button></form></td>";
                echo "<td><button type=\"button\" ";
                echo "id=\"mtrigg".$job['id']."\">Show comments</button><br><div id=\"mcomm".$job['id']."\" style=\"display:none;\">";
                echo "<table>";
                foreach ($comments as $comm){
                    $author = mysqli_fetch_assoc(mysqli_query($connection, "SELECT * FROM users WHERE id = '".$comm['author_id']."'"));
                    if ($author['type'] == "1") $role = "Cust"; else $role = "Mech";
                    echo "<tr><td style=\"width:25%; display:inline-block;\">By ".$author['fname']." ".$author['lname']." (".$role.") on ".date("D M jS @H:i", $comm['timestamp'])."</td><td width=\"65%\">".$comm['comment']."</td></tr>";
                }
                echo "<table></table><form target=\"_self\" action=\"add_com.php\" method=\"POST\"><input type=\"hidden\" name=\"job_id\" value=\"".$job['id']."\"><textarea name=\"text\"></textarea><br/><button type=\"submit\">Comment</button></form>";
                echo "</div></td></tr>";
            }
            echo "</table>";
        }
    }
    ?>
</body>
</html>