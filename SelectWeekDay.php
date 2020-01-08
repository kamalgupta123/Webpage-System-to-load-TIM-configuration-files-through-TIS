<?php
header('Content-Type: application/json');
$servername = "localhost";
$username = "root";
$password = "itspe";
$dbname = "htms";
$junction=$_POST['junction'];
//echo $junction;

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
     
$sql = "SELECT weekday_peak_start,weekday_peak_end,weekend_peak_start,weekend_peak_end FROM tis_signal_configuration WHERE SignalSCN = '$junction'";

//echo $sql;
$wps;
$wpe;
$weps;
$wepe;

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $wps=explode(",",$row['weekday_peak_start']);
        $wpe=explode(",",$row['weekday_peak_end']);
        $weps=explode(",",$row['weekend_peak_start']);
        $wepe=explode(",",$row['weekend_peak_end']);
    }
} 


$arr = array("weekday_peak_start" => $wps,"weekday_peak_end" => $wpe,"weekend_peak_start" => $weps,"weekend_peak_end" => $wepe);
echo json_encode($arr);

$conn->close();

?>