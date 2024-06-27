<?php
session_start();

$server = "localhost";
$username = "root";
$password = "";
$dbname = "qrcodedb";

// Establishing connection
$conn = new mysqli($server, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['text'])) {
    $text = $_POST['text'];
    $date = date('Y-m-d');

      // Set timezone to Indian Standard Time (IST)
      date_default_timezone_set('Asia/Kolkata');
      $time = date('H:i:s');


    $voice = new com("SAPI.SpVoice");
    
                                                 
    // Check if the student has already timed in for the current date
    $check_query = "SELECT * FROM table_attendance WHERE STUDENTID='$text' AND LOGDATE='$date' AND STATUS='0'";
    $check_result = $conn->query($check_query);

    if ($check_result->num_rows > 0) {
        // If the student has already timed in, update the record with time out
        $update_query = "UPDATE table_attendance SET TIMEOUT=NOW(), STATUS='1' WHERE STUDENTID='$text' AND LOGDATE='$date' AND STATUS='0'";
        if ($conn->query($update_query) === TRUE) {

            $message = "Checked";
            $voice->speak($message);

            $_SESSION['success'] = 'Successfully Timed In';
        } else {
            $_SESSION['error'] = 'Error updating record: ' . $conn->error;
        }
    } else {
        // If the student has not timed in for the current date, insert new record
        $insert_query = "INSERT INTO table_attendance(STUDENTID, TIMEIN, LOGDATE, STATUS) VALUES ('$text', '$time', '$date', '0')";
        if ($conn->query($insert_query) === TRUE) {
            $message = "Go";
            $voice->speak($message);
            $_SESSION['success'] = 'Successfully Timed Out';
        } else {
            $_SESSION['error'] = 'Error inserting record: ' . $conn->error;
        }
    }
} else {
    $_SESSION['error'] = 'Please scan your QR Code Number';
}

$conn->close();
header("location: index.php");
?>
