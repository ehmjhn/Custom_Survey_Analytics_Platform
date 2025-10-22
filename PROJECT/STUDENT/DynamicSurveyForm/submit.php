<?php
include_once '../../project_conn.php';

header('Content-Type: application/json'); // JSON response

// Use POST (not GET)
$survey_id = (int) $_POST['survey_id'];
$student_id = (int) $_POST['student_id'];
$answers = $_POST['answer'] ?? [];

$response = [];

if (empty($answers)) {
    echo json_encode(['status' => 'error', 'message' => 'No answers submitted.']);
    exit();
}

// Validate student
$check_student = $conn->query("SELECT student_id FROM student WHERE student_id = $student_id");
if ($check_student->num_rows == 0) {
    echo json_encode(['status' => 'error', 'message' => "Student ID $student_id does not exist."]);
    exit();
}

// Insert into response table
$today = date("Y-m-d");
$insert_response_sql = "INSERT INTO response (submit_date, survey_id, student_id) VALUES ('$today', $survey_id, $student_id)";
if ($conn->query($insert_response_sql)) {
    $response_id = $conn->insert_id;

    // foreach ($answers as $question_id => $answer_value) {
    //     $question_id = (int) $question_id;

    //     if ($answer_value === '' || $answer_value === null) {
    //         $choice_id = "NULL";
    //         echo $choice_id;
    //     } else {
    //         $choice_id = (int) $answer_value;
    //         echo $choice_id;
    //     }

    //     // $is_null = ($answer_value === '' || $answer_value === null);

    //     $question_type_result = $conn->query("SELECT question_type FROM question WHERE question_id = $question_id");
    //     if ($question_type_result->num_rows == 0)
    //         continue;
    //     $row = $question_type_result->fetch_assoc();
    //     $question_type = $row['question_type'];

    //     if ($question_type == 'SA') {
    //         $answer_text = $conn->real_escape_string($answer_value);
    //         $insert_answer_sql = "INSERT INTO answer (answer_text, response_id, question_id) VALUES ('$answer_text', $response_id, $question_id)";
    //         $conn->query($insert_answer_sql);

    //     } elseif ($question_type == 'LS' || $question_type == 'MC') {
    //         // $choice_id = (int) $answer_value;

    //         if ($choice_id === "NULL") {
    //             echo "tama";
    //             $insert_answer_sql = "INSERT INTO answer (answer_text, response_id, question_id, choice_id) VALUES ('', $response_id, $question_id, NULL)";
    //         } else {
    //             echo "mali";
    //             $insert_answer_sql = "INSERT INTO answer (answer_text, response_id, question_id, choice_id) VALUES ('', $response_id, $question_id, $choice_id)";
    //         }

    //         // if ($is_null) {
    //         //     $insert_answer_sql = "INSERT INTO answer (answer_text, response_id, question_id, choice_id)
    //         //                   VALUES ('', $response_id, $question_id, NULL)";
    //         // } else {
    //         //     $choice_id = (int) $answer_value;
    //         //     $insert_answer_sql = "INSERT INTO answer (answer_text, response_id, question_id, choice_id)
    //         //                   VALUES ('', $response_id, $question_id, $choice_id)";
    //         // }

    //         $conn->query($insert_answer_sql);
    //     }
    // }


    $questions_result = $conn->query("SELECT question_id, question_type FROM question WHERE survey_id = $survey_id");

    while ($question = $questions_result->fetch_assoc()) {
        $question_id = (int) $question['question_id'];
        $question_type = $question['question_type'];
        $answer_value = $answers[$question_id] ?? null;
        $is_null = ($answer_value === '' || $answer_value === null);

        if ($question_type == 'SA') {
            $answer_text = $conn->real_escape_string($answer_value);
            $insert_answer_sql = "INSERT INTO answer (answer_text, response_id, question_id) 
                              VALUES ('$answer_text', $response_id, $question_id)";
        } elseif ($question_type == 'LS' || $question_type == 'MC') {
            if ($is_null) {
                $insert_answer_sql = "INSERT INTO answer (answer_text, response_id, question_id, choice_id) 
                                  VALUES ('', $response_id, $question_id, NULL)";
            } else {
                $choice_id = (int) $answer_value;
                $insert_answer_sql = "INSERT INTO answer (answer_text, response_id, question_id, choice_id) 
                                  VALUES ('', $response_id, $question_id, $choice_id)";
            }
        }

        $conn->query($insert_answer_sql);
    }


    echo json_encode(['status' => 'success', 'message' => 'Your responses have been submitted!']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Error saving response: ' . $conn->error]);
}

$conn->close();
?>