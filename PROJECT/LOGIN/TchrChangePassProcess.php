<?php
include_once '../project_conn.php';

header('Content-Type: application/json');

$email = $_GET['email'];
$facultyID = $_GET['facultyID'];
$confPassword = $_GET['confPassword'];

// echo json_encode([
//         "status" => "success",
//         "message" => "❌ Email not found!"
//     ]);
//     exit();

$checkStud = $conn->query("SELECT * FROM faculty WHERE email_add = '$email'");
if ($checkStud->num_rows > 0) {
    
    $row = $checkStud->fetch_assoc();
    if ($row['faculty_id'] == $facultyID) {
        //update query
        $sql = "UPDATE faculty SET `password`='$confPassword' WHERE email_add='$email'";

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
        exit();
    } else {
        echo json_encode([
            "status" => "error",
            "message" => "❌ Incorrect Student ID, try again!"
        ]);
        exit();
    }
}