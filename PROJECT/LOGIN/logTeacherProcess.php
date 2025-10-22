<?php
include_once '../project_conn.php'; 

header('Content-Type: application/json');

$email = $_POST['email'];
$password = $_POST['password'];

$checkFac = $conn->query("SELECT * FROM faculty WHERE email_add = '$email'");
if ($checkFac->num_rows > 0) {
    $row = $checkFac->fetch_assoc();
    if ($row['password'] == $password) {
        echo json_encode([
        "status" => "success",
        "redirect" => "../TEACHER/Homepages/Homepage.php?facultyId=" . $row['faculty_id']
        ]);
        exit();
    } else {
        echo json_encode([
            "status" => "error",
            "message" => "❌ Incorrect password, try again!"
        ]);
        exit();
    }
}

echo json_encode([
    "status" => "error",
    "message" => "❌ Email not found!"
]);
exit();
?>
