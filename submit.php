<?php

$servername = "localhost";
$username = "root";
$password = "itspe";
$dbname = "htms";
$interStageTime = $_POST['interStageTime'];
$StageOrder = $_POST['stageOrder'];
$minGreenPeak = $_POST['minGreenPeak'];
$maxGreenPeak = $_POST['maxGreenPeak'];
$minGreenOffpeak = $_POST['minGreenOffpeak'];
$maxGreenOffpeak = $_POST['maxGreenOffpeak'];

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "UPDATE utmc_traffic_signal_stages SET InterStageTime=$interStageTime,StageOrder=$StageOrder,min_green_time=$minGreenPeak,max_green_time=$maxGreenPeak,min_green_offpeak=$minGreenOffpeak,max_green_offpeak=$maxGreenOffpeak WHERE StageOrder=$StageOrder";

if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
    echo "Error: " . $sql . "<br>" . $conn->error;
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();

?> 