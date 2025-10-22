<?php
include_once "../../project_conn.php";

$facultyId = $_GET['facultyId']; 

$sql = "
    SELECT s.survey_id, s.survey_title, s.due_date, s.date_created, s.date_modified,
           (SELECT COUNT(*) FROM response r WHERE r.survey_id = s.survey_id) AS response_count
    FROM survey s
    WHERE s.faculty_id = ?
    ORDER BY s.date_created DESC
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $facultyId);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {

    $isActive = (strtotime($row['due_date']) >= strtotime(date('Y-m-d')));
    $status = $isActive ? "Active" : "Closed";

    $statusClass = $isActive ? "status-active" : "status-closed";
    $cardClass = $isActive ? "form-card" : "form-card closed-card";

    $dateCreated = date("F j, Y", strtotime($row['date_created']));
    $dateModified = $row['date_modified'] ? date("F j, Y", strtotime($row['date_modified'])) : null;

    $modifiedHtml = $dateModified 
        ? "<p style=\"font-size: 12px;\"><i>Modified on {$dateModified}</i></p>" 
        : "";

    $deleteButton = $isActive
        ? "<button class=\"del-btn\" id=\"surv-del\" data-surveyid=\"{$row['survey_id']}\" data-surveytitle=\"{$row['survey_title']}\">Delete</button>"
        : "";

    echo <<<HTML
    <div class="{$cardClass}">
        <h3>{$row['survey_title']}</h3>
        <p class="{$statusClass}">{$status} - {$row['response_count']} Responses</p>
        <p style="font-size: 12px;"><i>Created on {$dateCreated}</i></p>
        {$modifiedHtml}
        <div class="btn-grp">
            <button class="edit-btn" id="surv-edit" data-surveyid="{$row['survey_id']}" data-facultyid="{$facultyId}">Open</button>
            {$deleteButton}
        </div>
    </div>
    HTML;
}
?>
