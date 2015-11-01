<?php
/**
 * Created by PhpStorm.
 * User: Vlex
 * Date: 3/6/2015
 * Time: 1:23 AM
 */

require_once 'db_connection.php';

//if (isset($_SESSION['login']))

session_start();
//$_SESSION['uname']='username';
?>

<html>
<head>
    <title>..:: Car Shop - the best car shop in the world ::..</title>
    <link rel="stylesheet" type="text/css" href="style.css" />
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script src="//code.jquery.com/jquery-1.10.2.js"></script>
    <script src="//code.jquery.com/ui/1.11.3/jquery-ui.js"></script>


    <script>
        $(document).ready(function(){
            $(".id").click(function(){
                $(".login").slideToggle("up");
                $(".register").hide();
            });
            $(".reg").click(function(){
                $(".register").slideToggle("up");
                $(".login").hide();
            });
            $(".reg_hide").click(function(){
                $(".register").slideToggle("up");
            });
            $(".edit").click(function(){
                $(".edit_profile").slideToggle("up");
            });

        });

        <?php
         // fetching all registered usernames in order to prevent registering a matching one again
            $array = mysqli_fetch_all(mysqli_query($connection, "SELECT uname FROM users ORDER BY id"));
            echo "var users=[";
            foreach ($array as $str){
                echo "\"".$str[0]."\", ";
            };
            echo "];";
            if (isset($_SESSION['uname'])) $user_info = mysqli_fetch_assoc(mysqli_query($connection, "SELECT * FROM users WHERE uname = '".$_SESSION['uname']."'"));
        ?>

        function validate(){
            var err_counter = 0;
            var uname = document.getElementById("uname").value;
            var pass  = document.getElementById("pass").value;
            var pass2 = document.getElementById("pass2").value;
            var email = document.getElementById("email").value;
            var fname = document.getElementById("fname").value;
            var mname = document.getElementById("mname").value;
            var lname = document.getElementById("lname").value;
            if (fname == "" || fname == null) {
                document.getElementById('fname').style.backgroundColor="yellow";
                err_counter++}
            else {
                document.getElementById('fname').style.backgroundColor="white";
            };
            if (mname == "" || mname == null) {
                document.getElementById('mname').style.backgroundColor="yellow";
                err_counter++}
            else {
                document.getElementById('mname').style.backgroundColor="white";
            };
            if (lname == "" || lname == null) {
                document.getElementById('lname').style.backgroundColor="yellow";
                err_counter++}
            else {
                document.getElementById('lname').style.backgroundColor="white";
            };
            if (uname == "" || uname == null || users.indexOf(uname)!=-1) {
                document.getElementById('uname').style.backgroundColor="red";
                err_counter++}
            else {
                document.getElementById('uname').style.backgroundColor="white";
            };
            if (pass != pass2 || pass == "" || pass == null) {
                document.getElementById('pass').style.backgroundColor="red";
                err_counter++}
            else {
                document.getElementById('pass').style.backgroundColor="green";
            };
            if (pass != pass2 || pass2 == "" || pass2 == null) {
                document.getElementById('pass2').style.backgroundColor="red";
                err_counter++}
            else {
                document.getElementById('pass2').style.backgroundColor="green";
                };
            if (email.indexOf('@') == -1 || email.indexOf('.', email.indexOf('@')) == -1) {
                err_counter++;
                document.getElementById('email').style.backgroundColor = 'red';
            }
            if (users.indexOf(uname) != -1) {
                err_counter++;
                document.getElementById('uname').style.backgroundColor = 'red';
            }
            if (err_counter == 0) document.forms["register"].submit();

        };

        function logincheck(){
            var uname = document.getElementById('logname').value;
            if (users.indexOf(uname) == -1){
                document.getElementById('logname').style.backgroundColor = 'red';
            }
            else document.forms["login"].submit();
        }
    </script>
</head>
<body>

<div class="wrapper">
    <div class="menu">
        <div id="left">
            <a href="about.html" target="iframe">About us</a> |
            <a href="contacts.html" target="iframe">Contacts</a> |
            <a href="schedule.php" target="iframe">Schedule</a>
            <?php if(isset($_SESSION['uname'])) echo " | <a href=\"my_veh.php\" target=\"iframe\">My Vehicles</a> | <a href=\"queue.php\" target=\"iframe\">Jobs Queue</a>"; ?>
        </div>
        <div id="right"><?php if (!isset($_SESSION['uname'])) {
                echo "<a href=\"#\" class=\"reg\">Register</a> | <a href=\"#\" class=\"id\">Log in</a>";
            } else {
                echo "Hello, ".$_SESSION['uname']."! &nbsp;&nbsp;&nbsp; <a href=\"#\" class=\"edit\">Edit Profile</a> | <a href=\"logout.php\">Log out</a>";
            };
        ?>

        </div>
    </div>
    <div class="content">
        <iframe src="about.html" name="iframe"></iframe>
    </div>
    <div class="footer">All materials on this site are protected by the international copyright laws and copying any content
        without the written approval of the authors is prosecuted according to the laws in motion back in XVI century - by beheading you!<br>
        Design and funcitonalities: Vladislav Tachev @ NBU : F59631</div>
</div>
<div class="login">
    <form action="login.php" method="post" id="login">
        <?php if(isset($_SESSION['login_error'])) echo $_SESSION['login_error']; ?>
        <input type="text" name="uname" value="Username" id="logname"/> <br/>
        <input type="password" name="pass" value="Password"/> <br/>
        <input type="button" value="Log in" onclick="logincheck()">
    </form>
</div>
<div class="register">
    <form target="_self" action="register.php" method="POST" id="register">
        <input type="text" id="uname" name="uname" placeholder="Username" /> <br/>
        <input type="password" id="pass" name="pass" placeholder="Password" /> <br/>
        <input type="password" id="pass2" name="pass2" placeholder="Confirm password" /> <br/>
        <input type="text" id="fname" name="fname" placeholder="First name" /> <br/>
        <input type="text" id="mname" name="mname" placeholder="Middle name" /> <br/>
        <input type="text" id="lname" name="lname" placeholder="Last name" /> <br/>
        <input type="text" id="email" name="email" placeholder="e-mail" /> <br/>
        <input type="radio" name="role" value="cust" checked>Customer
        <input type="radio" name="role" value="mech"> Mechanic<br />
        <input type="text" name="phone" placeholder="Phone number" /> <br/>
        <input type="text" name="address" placeholder="Address" /> <br/>
        <input type="button" value="Register" onclick="validate()"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <input type="button" value="Close" class="reg_hide">
    </form>
</div>

<div class="edit_profile">
    <form target="_self" action="register.php" method="POST" id="register">
        <input type="text" disabled="true" value="<?php echo $user_info['uname']; ?>"/> <br/>
        <input type="password" id="pass" name="pass" value="Password" /> <br/>
        <input type="password" id="pass2" name="pass2" value="Password"/> <br/>
        <input type="text" name="fname" value="<?php echo $user_info['fname']; ?>" /><br/>
        <input type="text" name="mname" value="<?php echo $user_info['mname']; ?>" /> <br/>
        <input type="text" name="lname" value="<?php echo $user_info['lname']; ?>" /> <br/>
        <input type="text" id="email" name="email" value="<?php echo $user_info['email']; ?>" /> <br/>
        <input type="radio" name="role" value="cust" <?php if ($user_info['type'] == '1') echo "checked";?> >Customer &nbsp;&nbsp;
        <input type="radio" name="role" value="mech" <?php if ($user_info['type'] == '0') echo "checked";?> > Mechanic<br />
        <input type="text" name="phone" value="<?php echo $user_info['phone']; ?>"/> <br/>
        <input type="text" name="address" value='<?php echo $user_info['address']; ?>' /> <br/>
        <input type="button" value="Save Changes" onclick="edit_validate()"> &nbsp;&nbsp;&nbsp;
        <input type="button" value="Close" class="edit">
    </form>
</div>
</body>
</html>