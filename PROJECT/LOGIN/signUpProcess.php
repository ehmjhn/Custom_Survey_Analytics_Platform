<?php
include_once '../project_conn.php'; 

$section = isset($_POST['section']) ? $_POST['section'] : null;

header('Content-Type: application/json');

$first_name = $_POST['hiddenFirstName'];
$middle_name = $_POST['hiddenMiddleName'];
$last_name = $_POST['hiddenLastName'];
$email = $_POST['hiddenEmail'];
$password = $_POST['hiddenPassword'];
$section = $_POST['section'];

$sql = "INSERT INTO student (email_add, first_name, middle_name, last_name, password, section_code) 
        VALUES ('$email', '$first_name', '$middle_name', '$last_name', '$password', '$section')";

if ($conn->query($sql) === TRUE) {
    echo json_encode(['status' => 'success']);
} else {
    echo json_encode(['status' => 'error', 'message' => $conn->error]);
}

$conn->close();
?>
