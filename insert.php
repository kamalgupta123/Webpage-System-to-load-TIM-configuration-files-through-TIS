<?php

$servername = "localhost";
$username = "root";
$password = "itspe";
$dbname = "htms";
$junction = $_POST['junction'];
$combinedPeakStart = $_POST['concatStartPeakStart'];
$combinedPeakEnd = $_POST['concatStartPeakEnd'];
$combinedPeakStartWeekend = $_POST['concatEndPeakStart'];
$combinedPeakEndWeekend = $_POST['concatEndPeakEnd'];

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql1 = "UPDATE tis_signal_configuration SET weekday_peak_start='$combinedPeakStart' WHERE SignalSCN = '$junction'";

if ($conn->query($sql1) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql1 . "<br>" . $conn->error;
}


$sql3 = "UPDATE tis_signal_configuration SET weekday_peak_end='$combinedPeakEnd' WHERE SignalSCN = '$junction'";

if ($conn->query($sql3) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql3 . "<br>" . $conn->error;
}


$sql5 = "UPDATE tis_signal_configuration SET weekend_peak_start='$combinedPeakStartWeekend' WHERE SignalSCN = '$junction'";

if ($conn->query($sql5) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql5 . "<br>" . $conn->error;
}


$sql7 = "UPDATE tis_signal_configuration SET weekend_peak_end='$combinedPeakEndWeekend' WHERE SignalSCN = '$junction'";

if ($conn->query($sql7) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql7 . "<br>" . $conn->error;
}

$conn->close();

?>