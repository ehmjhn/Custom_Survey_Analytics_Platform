<?php
include_once '../project_conn.php'; 

header('Content-Type: application/json');

$email = $_POST['email'];
$password = $_POST['password'];

$checkStud = $conn->query("SELECT * FROM student WHERE email_add = '$email'");
if ($checkStud->num_rows > 0) {
    $row = $checkStud->fetch_assoc();
    if ($row['password'] == $password) {
        echo json_encode([
            "status" => "success",
            "redirect" => "../STUDENT/AssignedSurveyList/studentHomePage.php?student_id=" . $row['student_id'] . "&sectionCode=" . $row['section_code']
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
