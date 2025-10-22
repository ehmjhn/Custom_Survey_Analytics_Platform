<?php
session_start();
include '../../project_conn.php';

$student_id = $_GET['student_id'];
$survey_id = (int)$_GET['survey_id']; 

$sql_response = "SELECT response_id FROM response WHERE student_id = $student_id AND survey_id = $survey_id LIMIT 1";
$response_result = $conn->query($sql_response);

if ($response_result->num_rows > 0) {
    $response_row = $response_result->fetch_assoc();
    $response_id = $response_row['response_id'];

    $sql_survey = "SELECT survey_title FROM survey WHERE survey_id = $survey_id LIMIT 1";
    $survey_result = $conn->query($sql_survey);
    $survey_title = "Survey Response";
    if ($survey_result && $survey_result->num_rows > 0) {
        $survey_data = $survey_result->fetch_assoc();
        $survey_title = $survey_data['survey_title'];
    }

    $sql_answers = "
    SELECT 
        q.question_text,
        CASE 
            WHEN c.choice_text IS NOT NULL THEN c.choice_text
            ELSE a.answer_text
        END AS student_answer
    FROM answer a
    JOIN question q ON a.question_id = q.question_id
    LEFT JOIN choice c ON a.choice_id = c.choice_id
    WHERE a.response_id = $response_id
    ORDER BY q.question_id ASC
";

    $answers_result = $conn->query($sql_answers);
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8" />
        <title><?php echo htmlspecialchars($survey_title); ?> - My Response</title>
        <link rel="stylesheet" href="viewAnswer.css">
    </head>
    <body>
        <h2><?php echo htmlspecialchars($survey_title); ?></h2>

        <a href="javascript:history.back()" class="back-btn">← Back</a>

        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Question</th>
                    <th>Your Answer</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($answers_result && $answers_result->num_rows > 0) {
                    $counter = 1;
                    while ($row = $answers_result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $counter++ . "</td>";
                        echo "<td>" . htmlspecialchars($row['question_text']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['student_answer']) . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo '<tr><td colspan="3">No answers found for this response.</td></tr>';
                }
                ?>
            </tbody>
        </table>
    </body>
    </html>
    <?php
} else {
    echo "No survey response found for this survey.";
}
?>
