<?php
include_once "../../project_conn.php";

$surveyId = $_GET['surveyid'];

$sql = $conn->query("SELECT * FROM `survey` WHERE `survey_id` = $surveyId");
if ($sql->num_rows > 0) {
    // Delete related choices 
    $conn->query("DELETE FROM `survey_section` WHERE `survey_id` = $surveyId");
    $conn->query("DELETE FROM `choice` WHERE `question_id` IN (SELECT question_id FROM question WHERE survey_id = $surveyId)");
    $conn->query("DELETE FROM `question` WHERE `survey_id` = $surveyId");
    $conn->query("DELETE FROM `survey` WHERE `survey_id` = $surveyId");

    echo "<div class='modal-content'>
        <h2 id='surv-title'>Survey deleted successfully.</h2>
        <div class='btn-frp'>
            <button class='cancel' id='dM-cancel'>Go Back</button>
        </div>
    </div>";
} else {
    echo "<div class='modal-content'>
        <h2 id='surv-title'>Survey not found.</h2>
        <div class='btn-frp'>
            <button class='cancel' id='dM-cancel'>Go Back</button>
        </div>
    </div>";
}
?>
