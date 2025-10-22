<?php
include_once '../project_conn.php';

header('Content-Type: application/json');

$email = $_POST['forgotPasswordEmail'];

$checkStud = $conn->query("SELECT * FROM student WHERE email_add = '$email'");
if ($checkStud->num_rows > 0) {
    
    $row = $checkStud->fetch_assoc();
    if ($row['email_add'] == $email) {
        echo json_encode([
            "status" => "success",
            // "redirect" => "../LOGIN/changePasswordProcess.php?email=" . $email; 
            
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
