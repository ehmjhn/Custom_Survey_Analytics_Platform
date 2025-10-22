<?php
include_once '../project_conn.php';

header('Content-Type: application/json');

$email = $_GET['email'];
$studentID = $_GET['studentID'];
$confPassword = $_GET['confPassword'];

// echo json_encode([
//         "status" => "success",
//         "message" => "❌ Email not found!"
//     ]);
//     exit();

$checkStud = $conn->query("SELECT * FROM student WHERE email_add = '$email'");
if ($checkStud->num_rows > 0) {
    
    $row = $checkStud->fetch_assoc();
    if ($row['student_id'] == $studentID) {
        //update query
        $sql = "UPDATE student SET `password`='$confPassword' WHERE email_add='$email'";

        if($conn->query($sql)){
            echo json_encode([
                "status" => "success"
            ]);
            exit();
        }else{
            echo json_encode([
                "status" => "error",
                "message" => "❌ Email not found!"
            ]);
            exit();
        }
    } else {
        echo json_encode([
            "status" => "error",
            "message" => "❌ Incorrect Student ID, try again!"
        ]);
        exit();
    }
}



// $update = $conn->query("SELECT * FROM student WHERE email_add = '$email'");
// if ($checkStud->num_rows > 0) {
//     $row = $checkStud->fetch_assoc();
//     if ($row['password'] == $password) {
//         echo json_encode([
//             "status" => "success",
//             "redirect" => "../STUDENT/studentHomePage.php?studentId=" . $row['student_id'] . "&sectionCode=" . urlencode($row['section_code'])
            
//         ]);
//         exit();
//     } else {
//         echo json_encode([
//             "status" => "error",
//             "message" => "❌ Incorrect password, try again!"
//         ]);
//         exit();
//     }
// }

// echo json_encode([
//     "status" => "error",
//     "message" => "❌ Email not found!"
// ]);
// exit();
?>
