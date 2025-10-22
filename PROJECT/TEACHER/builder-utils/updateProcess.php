<?php
include_once '../../project_conn.php';

// Debugging Logs (optional)
// file_put_contents('debug_log.txt', print_r($_POST, true));

$facultyId = $_POST['facultyId'];
$surveyId = $_POST['surveyId'];
$title = $_POST['title'];
$description = $_POST['description'];
$section_codes = $_POST['section_code'] ?? [];
$due_date = $_POST['due_date'];
$questions = $_POST['questions'] ?? [];

// Update survey info
$stmt = $conn->prepare("UPDATE survey SET survey_title = ?, `description` = ?, date_modified = NOW(), due_date = ? WHERE survey_id = ? AND faculty_id = ?");
$stmt->bind_param("sssii", $title, $description, $due_date, $surveyId, $facultyId);
$stmt->execute();
$stmt->close();

// Update section assignments
$isPublished = isset($_POST['is_published']) && $_POST['is_published'] == '1';

if ($isPublished) {
    // If published, update section assignments
    $conn->query("DELETE FROM survey_section WHERE survey_id = $surveyId");
    $stmt = $conn->prepare("INSERT INTO survey_section (survey_id, section_code) VALUES (?, ?)");
    foreach ($section_codes as $sec) {
        $stmt->bind_param("is", $surveyId, $sec);
        $stmt->execute();
    }
    $stmt->close();
} else {
    // If unpublished, delete all section assignments
    $conn->query("DELETE FROM survey_section WHERE survey_id = $surveyId");
}


// Fetch current question IDs for this survey
$currentQuestionIds = [];
$res = $conn->query("SELECT question_id FROM question WHERE survey_id = $surveyId");
while ($row = $res->fetch_assoc()) {
    $currentQuestionIds[] = $row['question_id'];
}

// Get question_ids from POST
$postQuestionIds = [];
foreach ($questions as $q) {
    if (!empty($q['question_id'])) {
        $postQuestionIds[] = (int)$q['question_id'];
    }
}

// Delete removed questions (and their choices & answers)
$toDelete = array_diff($currentQuestionIds, $postQuestionIds);
if (count($toDelete) > 0) {
    $idsToDelete = implode(',', $toDelete);
    $conn->query("DELETE FROM answer WHERE question_id IN ($idsToDelete)");
    $conn->query("DELETE FROM choice WHERE question_id IN ($idsToDelete)");
    $conn->query("DELETE FROM question WHERE question_id IN ($idsToDelete)");
}

// Process questions
foreach ($questions as $q) {
    $text = $q['text'];
    $type = $q['type'];
    $choices = $q['choices'] ?? [];

    if (!empty($q['question_id'])) {
        // Existing question: update question text and type
        $question_id = (int)$q['question_id'];
        $required = isset($q['required']) ? 'yes' : 'no';
        $stmt = $conn->prepare("UPDATE question SET question_text = ?, question_type = ?, REQUIRED = ? WHERE question_id = ?");
        $stmt->bind_param("sssi", $text, $type, $required, $question_id);
        $stmt->execute();
        $stmt->close();

        // Handle choices
        if ($type === 'MC' || $type === 'LS') {
            // Fetch existing choices for this question
            $existingChoices = [];
            $res = $conn->query("SELECT choice_id, choice_text FROM choice WHERE question_id = $question_id");
            while ($row = $res->fetch_assoc()) {
                $existingChoices[$row['choice_id']] = $row['choice_text'];
            }

            // Track choice IDs to keep
            $keepChoiceIds = [];

            foreach ($choices as $c) {
                $c = trim($c);
                if ($c === '') continue;

                // Check if choice matches existing
                $found = false;
                foreach ($existingChoices as $cid => $ctext) {
                    if ($ctext === $c) {
                        $keepChoiceIds[] = $cid;
                        unset($existingChoices[$cid]);
                        $found = true;
                        break;
                    }
                }

                if (!$found) {
                    // New choice: insert
                    $stmt = $conn->prepare("INSERT INTO choice (choice_text, question_id) VALUES (?, ?)");
                    $stmt->bind_param("si", $c, $question_id);
                    $stmt->execute();
                    $stmt->close();
                }
            }

            // Delete choices not in form
            if (!empty($existingChoices)) {
                $idsToDelete = implode(',', array_keys($existingChoices));
                $conn->query("DELETE FROM answer WHERE choice_id IN ($idsToDelete)");
                $conn->query("DELETE FROM choice WHERE choice_id IN ($idsToDelete)");
            }
        } else {
            // Non-choice questions: delete any existing choices
            $stmt = $conn->prepare("DELETE FROM choice WHERE question_id = ?");
            $stmt->bind_param("i", $question_id);
            $stmt->execute();
            $stmt->close();
        }

    } else {
        // New question
        $required = isset($q['required']) ? 'yes' : 'no';
        $stmt = $conn->prepare("INSERT INTO question (question_text, question_type, survey_id, REQUIRED) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssis", $text, $type, $surveyId, $required);
        $stmt->execute();
        $question_id = $stmt->insert_id;
        $stmt->close();

        // Insert choices if applicable
        if (($type === 'MC' || $type === 'LS') && count($choices) > 0) {
            $stmt = $conn->prepare("INSERT INTO choice (choice_text, question_id) VALUES (?, ?)");
            foreach ($choices as $choice) {
                $choice = trim($choice);
                if ($choice !== '') {
                    $stmt->bind_param("si", $choice, $question_id);
                    $stmt->execute();
                }
            }
            $stmt->close();
        }
    }
}

echo json_encode(['success' => true, 'message' => 'Survey updated successfully.']);
?>