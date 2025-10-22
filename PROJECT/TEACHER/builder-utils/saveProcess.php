<?php
include_once '../../project_conn.php';

$facultyId = $_POST['facultyId'];
$title = $_POST['title'];
$description = $_POST['description'];
$section_codes = $_POST['section_code']; 
$due_date = $_POST['due_date'];
$publish = $_POST['publish'] ?? '0'; 

// Insert into survey table
$stmt = $conn->prepare("INSERT INTO survey (survey_title, `description`, date_created, due_date, faculty_id) VALUES (?, ?, NOW(), ?, ?)");
$stmt->bind_param("sssi", $title, $description, $due_date, $facultyId);
$stmt->execute();
$survey_id = $stmt->insert_id;
$stmt->close();

// Insert into survey_section for each selected section
if ($publish === '1' && !empty($section_codes)) {
    $stmt = $conn->prepare("INSERT INTO survey_section (survey_id, section_code) VALUES (?, ?)");
    foreach ($section_codes as $sec) {
        $stmt->bind_param("is", $survey_id, $sec);
        $stmt->execute();
    }
    $stmt->close();
}

// Insert questions and choices (same as your original code)
$questions = $_POST['questions'];
foreach ($questions as $q) {
    $text = $conn->real_escape_string($q['text']);
    $type = $conn->real_escape_string($q['type']);

    $required = isset($q['required']) ? 'yes' : 'no';

    $stmt = $conn->prepare("INSERT INTO question (question_text, question_type, survey_id, REQUIRED) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssis", $text, $type, $survey_id, $required);
    $stmt->execute();
    $question_id = $stmt->insert_id;
    $stmt->close();

    if (($type === 'MC' || $type === 'LS') && !empty($q['choices'])) {
        $stmt = $conn->prepare("INSERT INTO choice (choice_text, question_id) VALUES (?, ?)");
        foreach ($q['choices'] as $choice) {
            $choiceText = $conn->real_escape_string($choice);
            $stmt->bind_param("si", $choiceText, $question_id);
            $stmt->execute();
        }
        $stmt->close();
    }
}

echo json_encode(['status' => 'success', 'message' => 'Survey saved successfully.']);
?>
