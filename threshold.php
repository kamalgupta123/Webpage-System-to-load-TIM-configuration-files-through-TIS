<?php

$servername = "localhost";
$username = "root";
$password = "itspe";
$dbname = "htms";
$cumPeak = $_POST['cumPeak'];
$cumOffPeak = $_POST['cumOffPeak'];
$nonCumPeak = $_POST['nonCumPeak'];
$nonCumOffPeak = $_POST['nonCumOffPeak'];
$junction = $_POST['junction'];

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "UPDATE tis_signal_configuration SET cumulative_threshold_peak=$cumPeak,cumulative_threshold_offpeak=$cumOffPeak,threshold_peak=$nonCumPeak,threshold_offpeak=$nonCumOffPeak WHERE SignalSCN='$junction'";

if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
    echo "Error: " . $sql . "<br>" . $conn->error;
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();


?>