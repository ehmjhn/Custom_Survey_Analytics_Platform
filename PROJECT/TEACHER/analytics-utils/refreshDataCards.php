<?php
include_once "../../project_conn.php";

$facultyId = $_GET['facultyId'];

$sqlUser = "SELECT `first_name`, `middle_name`, `last_name` FROM `faculty` WHERE `faculty_id` = $facultyId";
$resUser = $conn->query($sqlUser);
$user = $resUser->fetch_assoc();
$fullName = $user['first_name'] . ' ' . $user['middle_name'] . ' ' . $user['last_name'];

// Total Surveys Created (Active Only)
$sql = "SELECT COUNT(*) AS total_surveys FROM survey WHERE faculty_id = $facultyId AND due_date >= CURDATE()";
$totalSurveys = $conn->query($sql)->fetch_assoc()['total_surveys'] ?? 0;

// Shared Active Surveys 
$sql = "SELECT COUNT(DISTINCT s.survey_id) AS active_surveys
        FROM survey s
        JOIN survey_section ss ON s.survey_id = ss.survey_id
        WHERE s.faculty_id = $facultyId
        AND s.due_date >= CURDATE()";
$activeSurveys = $conn->query($sql)->fetch_assoc()['active_surveys'] ?? 0;

// Total Inactive Surveys
$sql = "SELECT COUNT(*) AS total_inactive_surveys 
        FROM survey 
        WHERE faculty_id = $facultyId 
        AND due_date < CURDATE()";

$totalInactiveSurveys = $conn->query($sql)->fetch_assoc()['total_inactive_surveys'] ?? 0;

// Total Student Responses Received (Active Surveys)
$sql = "SELECT COUNT(*) AS total_responses 
    FROM response 
    WHERE survey_id IN (
        SELECT survey_id 
        FROM survey 
        WHERE faculty_id = $facultyId 
        AND due_date >= CURDATE()
    )";
$totalResponses = $conn->query($sql)->fetch_assoc()['total_responses'] ?? 0;

// Survey Completion Rate (% for Active Surveys)
$sql = "SELECT ROUND(AVG(COALESCE(r.cnt, 0) * 1.0 / NULLIF(scnt.cnt, 0)) * 100, 0) AS avg_completion_rate
    FROM survey s
    LEFT JOIN (
        SELECT survey_id, COUNT(*) AS cnt FROM response GROUP BY survey_id
    ) r ON s.survey_id = r.survey_id
    LEFT JOIN (
        SELECT ss.survey_id, COUNT(*) AS cnt 
        FROM survey_section ss 
        JOIN student st ON ss.section_code = st.section_code 
        GROUP BY ss.survey_id
    ) scnt ON s.survey_id = scnt.survey_id
    WHERE s.faculty_id = $facultyId AND s.due_date >= CURDATE()";
$completionRate = $conn->query($sql)->fetch_assoc()['avg_completion_rate'] ?? 0;
?>

<div class="analytics-container">
    <div class="analytic-card card-blue">
        <p>Total Active Surveys</p>
        <span><?php echo $totalSurveys; ?></span>
    </div>
    <div class="analytic-card card-red">
        <p>Shared Active Surveys</p>
        <span><?php echo $activeSurveys; ?></span>
    </div>
    <div class="analytic-card card-violet">
        <p>Total Inactive Surveys</p>
        <span><?php echo $totalInactiveSurveys; ?></span>
    </div>
    <div class="analytic-card card-gold">
        <p>Total Student Responses Received on Active Surveys</p>
        <span><?php echo $totalResponses; ?></span>
    </div>
    <div class="analytic-card card-pink">
        <p>Survey Completion Rate (Active)</p>
        <span><?php echo $completionRate ?>%</span>
    </div>
</div>
