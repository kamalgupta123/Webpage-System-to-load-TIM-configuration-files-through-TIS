<?php

$servername = "localhost";
$username = "root";
$password = "itspe";
$dbname = "htms";
$junction=$_POST['junction'];

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT InterStageTime,StageOrder,min_green_time,max_green_time,min_green_offpeak,max_green_offpeak FROM utmc_traffic_signal_stages WHERE SignalSCN = '$junction'";
  
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
       echo "<tr class='rows'><td style='padding-left: 105px;padding-right: 79px;'><p>".$row["StageOrder"]."</p></td><td style='padding-left: 60px;padding-right: 79px;'><input style='width:54px' type='text' name='min_green_time' value='".$row["InterStageTime"]."'></td><td style='padding-left: 60px;padding-right: 79px;'><input style='width:54px' type='text' name='min_green_time' value='".$row["min_green_time"]."'></td><td style='padding-left: 61px;padding-right: 79px;'><input style='width:54px' type='text' name='max_green_time' value='".$row["max_green_time"]."'></td><td style='padding-left: 16px;padding-right: 79px;'><input style='width:54px' type='text' name='min_green_offpeak' value='".$row["min_green_offpeak"]."'></td><td style='padding-right: 79px;'><input style='width:54px' type='text' name='max_green_offpeak' value='".$row["max_green_offpeak"]."'></td></tr>";                             
    }    
} 

$conn->close();

?>