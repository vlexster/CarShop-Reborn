<?php
/**
 * Created by PhpStorm.
 * User: Vlex
 * Date: 3/10/2015
 * Time: 9:45 PM
 */


require_once 'db_connection.php';
session_start();
if(isset($_GET['type'])){
    mysqli_query($connection, "INSERT INTO parts(`type`, `make`, `model`, `vendor`, `origin`, `price`, `avail`) VALUES('".$_GET['type']."', '".$_GET['make']."', '".$_GET['model']."', '".$_GET['vendor']."', '".$_GET['origin']."', ".$_GET['price'].", ".$_GET['avail'].")");
}
$parts = @mysqli_fetch_all(mysqli_query($connection, "SELECT * FROM parts WHERE 1"), MYSQLI_ASSOC);
//var_dump($job_list);

echo "<br><br>";
echo "<br><br>";
?>

<html>
<head>
    <link rel="stylesheet" type="text/css" href="style.css" />
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script src="//code.jquery.com/jquery-1.10.2.js"></script>
    <script src="//code.jquery.com/ui/1.11.3/jquery-ui.js"></script>
    <script type="text/javascript" src="http://tablesorter.com/jquery-latest.js"></script>
    <script type="text/javascript" src="http://tablesorter.com/__jquery.tablesorter.min.js"></script>
    <script>
        $(document).ready(function()
            {
                $("#myTable").tablesorter({sortList:[[0,0]], widgets: ['zebra']});
            }
        );
    </script>
    <style>
        table.tablesorter {
            font-family:arial;
            background-color: #CDCDCD;
            margin:10px 0pt 15px;
            font-size: 8pt;
            width: 100%;
            text-align: left;
        }
        table.tablesorter thead tr th, table.tablesorter tfoot tr th {
            background-color: #e6EEEE;
            border: 1px solid #FFF;
            font-size: 8pt;
            padding: 4px;
        }
        table.tablesorter thead tr .header {
            background-image: url(images/bg.gif);
            background-repeat: no-repeat;
            background-position: center right;
            cursor: pointer;
        }
        table.tablesorter tbody td {
            color: #3D3D3D;
            padding: 4px;
            background-color: #FFF;
            vertical-align: top;
        }
        table.tablesorter tbody tr.odd td {
            background-color:#F0F0F6;
        }
        table.tablesorter thead tr .headerSortUp {
            background-image: url(images/asc.gif);
        }
        table.tablesorter thead tr .headerSortDown {
            background-image: url(images/desc.gif);
        }
        table.tablesorter thead tr .headerSortDown, table.tablesorter thead tr .headerSortUp {
            background-color: #8dbdd8;
        }
    </style>
</head>
<body >
<?php
echo "<table border=\"0\" id=\"myTable\" class=\"tablesorter\">
    <thead><tr>
        <th>Part type</th>
        <th>For make</th>
        <th>For model</th>
        <th>Vendor</th>
        <th>Made in</th>
        <th>Price</th>
        <th>In stock</th>
    </tr></thead>
    <tbody>";
//    <tr><td>shock</td>
//        <td>opel</td>
//        <td>vectra</td>
//        <td>sdsada</td>
//        <td>china</td>
//        <td>123</td>
//        <td>2</td></tr>
//        <tr><td>windshield</td>
//        <td>honda</td>
//        <td>cr-v</td>
//        <td>honda</td>
//        <td>japan</td>
//        <td>1234</td>
//        <td>123</td></tr>
//    ";
foreach($parts as $part){
    echo "<td>".$part['type']."</td>
        <td>".$part['make']."</td>
        <td>".$part['model']."</td>
        <td>".$part['vendor']."</td>
        <td>".$part['origin']."</td>
        <td>".$part['price']."</td>
        <td>".$part['avail']."</td></tr>";
}
echo "</tbody></table>";
?>
<!--<form action="inventory.php" target="_self" method="get">
    <input type="text" name="type" placeholder="Type"><br>
    <input type="text" name="make" placeholder="For make"><br>
    <input type="text" name="model" placeholder="For model"><br>
    <input type="text" name="vendor" placeholder="Vendor"><br>
    <input type="text" name="origin" placeholder="Country of origin"><br>
    <input type="text" name="price" placeholder="Price"><br>
    <input type="text" name="avail" placeholder="Available qty"><br>
    <input type="submit" value="Add to inventory">
</form>-->
</body>
</html>