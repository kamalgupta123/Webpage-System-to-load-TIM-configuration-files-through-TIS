<?php

header('Content-Type: application/json');

$servername = "localhost";
$username = "root";
$password = "itspe";
$dbname = "htms";
$junction=$_POST['junction'];

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT cumulative_threshold_peak,cumulative_threshold_offpeak,threshold_peak,threshold_offpeak FROM tis_signal_configuration WHERE SignalSCN = '$junction'";


$result = $conn->query($sql);

$cumulative_threshold_peak = null;
$cumulative_threshold_offpeak = null;
$threshold_peak = null;
$threshold_offpeak = null;

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $cumulative_threshold_peak = $row['cumulative_threshold_peak'];
        $cumulative_threshold_offpeak = $row['cumulative_threshold_offpeak'];
        $threshold_peak = $row['threshold_peak'];
        $threshold_offpeak = $row['threshold_offpeak'];
    }    
} 

$data = array();

array_push($data,$cumulative_threshold_peak,$cumulative_threshold_offpeak,$threshold_peak,$threshold_offpeak);

echo json_encode($data);

$conn->close();

?>