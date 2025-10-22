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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Evalue | Dashboard</title>
    <link rel="stylesheet" href="../teacherstyle.css">
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
</head>
<body>
    <header>
        <div class="head-cont-title">
            <img src="../../logo.png" alt="logo" class="main-logo">
            <h1>Evaluate</h1>
        </div>
        <div class="head-cont-user-wrapper">
            <div class="head-cont-user">
                <img src="../../user.png" alt="user" class="user-img">
                <h3><?php echo $fullName; ?></h3>
            </div>
            <div class="user-dropdown">
                <a href="../../LOGIN/login.php">🔓 Sign Out</a>
            </div>
        </div>
    </header>

    <main class="hp-cont">
        <!-- Analytics Cards Section -->
        <div class="cards">
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
        </div>
        
        <!-- Create New Form Button Section -->
        <div class="makeSurvey">
            <div class="makeSurvey-inner">
            <a href="createSurveyPage.php?facultyId=<?php echo $facultyId; ?>" class="new-form-btn">+ Create New Survey</a>
            </div>
            <div class="filter-status">
                <label for="surveyStatus">Filter Survey: </label>
                <select id="surveyStatus" name="surveyStatus">
                    <option value="all" selected>All</option>
                    <option value="active">Active</option>
                    <option value="closed">Closed</option>
                </select>
            </div>
        </div>

        <!-- Created Surveys Section -->
        <div class="myForms">
            <div class="forms-wrapper">
            </div>
        </div>

        <!-- Deletion Modal -->
        <div id="deletionModal">
        </div>
    </main>
    
    <script>
    $(document).ready(function() {

        $('#deletionModal').hide();
        loadSurveyList(<?php echo $facultyId;?>);

        //Edit survey
        $(document).on("click", "#surv-edit", function () {  
            const surveyId = $(this).data("surveyid");
            const facultyId = $(this).data("facultyid");

            window.location.href = "updateSurveyPage.php?surveyId=" + surveyId + "&facultyId=" + facultyId;
        });

        //Delete survey
        $(document).on("click", "#surv-del", function () {
            const surveyId = $(this).data("surveyid");
            const surveyTitle = $(this).data("surveytitle");

            $.ajax({
                url: "../builder-utils/deleteConfirm.php",
                method: "GET",
                data: {
                    surveyId: surveyId,
                    surveyTitle: surveyTitle
                }
            }).done(function (response) {
                $('#deletionModal').html(response).fadeIn(200);
            });
        });

        $(document).on("click", "#dM-del", function (e) {
            e.preventDefault();
            $('#deletionModal').fadeOut(200);

            const surveyid = $(this).data("surveyid");

            $.ajax({
                url: "../builder-utils/deleteSurvey.php",
                method: "GET",
                data: { surveyid: surveyid }
            }).done(function (response) {
                $('#deletionModal').html(response).fadeIn(200);
                loadSurveyList(<?php echo $facultyId;?>);

                // Refresh data cards
                $.ajax({
                    url: "../analytics-utils/refreshDataCards.php",
                    method: "GET",
                    data: { facultyId: <?php echo $facultyId; ?> }
                }).done(function(cardsHtml) {
                    $('.analytics-container').replaceWith(cardsHtml);
                });
            });
        });

        $(document).on('click', '#dM-cancel',function () {
            $('#deletionModal').fadeOut(200);
        });

        $(window).click(function (e) {
            if ($(e.target).is('#deletionModal')) {
                $('#deletionModal').fadeOut(200);
            }
        });

        // Filter Survey
         $(document).on('change', '#surveyStatus', function(){
        var status = $(this).val();
            $('.form-card').each(function(){
                var text = $(this).find('p').first().text().toLowerCase();
                if(status === 'all' || text.includes(status)){
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        });

        //Sign out
        $(".head-cont-user").click(function(e) {
            e.stopPropagation();
            $(".user-dropdown").fadeToggle(150);
        });

        $(document).click(function(e) {
            if (!$(e.target).closest(".head-cont-user-wrapper").length) {
                $(".user-dropdown").fadeOut(150);
            }
        });
    });

    function loadSurveyList(facultyid){
        const facultyId = facultyid; 

        $.ajax({
            url: "../builder-utils/loadSurveyList.php",
            method: "GET",
            data: {facultyId: facultyId}
        }).done(function (response){
            $('.forms-wrapper').html(response);
        });
    }
    </script>

</body>
</html>