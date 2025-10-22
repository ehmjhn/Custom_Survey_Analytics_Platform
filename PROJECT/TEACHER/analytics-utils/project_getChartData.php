<?php
header('Content-Type: application/json');
include_once "../../project_conn.php";

if (!isset($_GET['surveyId']) || !is_numeric($_GET['surveyId'])) {
    echo json_encode(["error" => "Invalid survey ID"]);
    exit;
}

$survey_id = intval($_GET['surveyId']);
$chartData = [];

// MULTIPLE CHOICE / LIKERT SCALE
$query = "SELECT 
            q.question_id, 
            q.question_text, 
            q.question_type, 
            c.choice_text, 
            COUNT(a.answer_id) AS response_count
        FROM question q
        JOIN choice c ON q.question_id = c.question_id
        LEFT JOIN answer a ON a.choice_id = c.choice_id AND a.question_id = q.question_id
        WHERE q.survey_id = ? AND (q.question_type = 'MC' OR q.question_type = 'LS')
        GROUP BY q.question_id, c.choice_id
        ORDER BY q.question_id
";

$stmt = $conn->prepare($query);
$stmt->bind_param("i", $survey_id);
$stmt->execute();
$res = $stmt->get_result();

while ($row = $res->fetch_assoc()) {
    $qid = "q" . $row['question_id'];

    if (!isset($chartData[$qid])) {
        $chartData[$qid] = [
            'type' => $row['question_type'],
            'question' => $row['question_text'],
            'labels' => [],
            'data' => []
        ];
    }

    $chartData[$qid]['labels'][] = $row['choice_text'];
    $chartData[$qid]['data'][] = (int)$row['response_count'];
}

// SHORT ANSWER - SHOW ALL RESPONSES AS-IS
$shortQuery = "
    SELECT q.question_id, q.question_text, a.answer_text
    FROM question q
    JOIN answer a ON q.question_id = a.question_id
    WHERE q.survey_id = ? AND q.question_type = 'SA'
";

$stmt = $conn->prepare($shortQuery);
$stmt->bind_param("i", $survey_id);
$stmt->execute();
$res = $stmt->get_result();

while ($row = $res->fetch_assoc()) {
    $qid = "q" . $row['question_id'];

    if (!isset($chartData[$qid])) {
        $chartData[$qid] = [
            'type' => 'SA',
            'question' => $row['question_text'],
            'words' => []
        ];
    }

    $answer = trim($row['answer_text']);
    if (strlen($answer) > 0) {
        $chartData[$qid]['words'][] = [$answer, 1];
    }
}

echo json_encode($chartData);
