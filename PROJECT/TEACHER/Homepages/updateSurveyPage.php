<?php
include_once "../../project_conn.php";

$facultyId = $_GET['facultyId'];
$surveyId = $_GET['surveyId'];

$sqlUser = "SELECT `first_name`, `middle_name`, `last_name` FROM `faculty` WHERE `faculty_id` = $facultyId";
$resUser = $conn->query($sqlUser);
$user = $resUser->fetch_assoc();
$fullName = $user['first_name'] . ' ' . $user['middle_name'] . ' ' . $user['last_name'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- jQuery (must be first) -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <!-- jQuery UI (sortable, draggable, etc.) -->
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- WordCloud2 -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/wordcloud2.js/1.1.2/wordcloud2.min.js"></script>

    <!-- DataTables CSS (for response table) -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css" />

    <!-- Font Awesome (icons) -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet" />

    <!-- Custom Teacher Page CSS -->
    <link rel="stylesheet" href="../teacherstyle.css">

    <title>Evaluate | Survey Builder</title>


</head>
<body>
    <header>
        <div class="head-cont-title">
            <img src="../../logo.png" alt="logo" class="main-logo">
            <h1>Evaluate</h1>
        </div>
        <div class="head-cont-user">
            <img src="../../user.png" alt="user" class="user-img">
            <h3><?php echo $fullName; ?></h3>
        </div>
    </header>

    <aside>
        <div class="sidenav-cont">
            <ul class="main-links">
                <a id='mysurvey'><li>EDIT SURVEY</li></a>
                <a id='responses'><li>RESPONSES</li></a>
                <a id='analytics'><li>ANALYTICS</li></a>
            </ul>
            <ul class="logout-link">
                <a href='Homepage.php?facultyId=<?php echo $facultyId;?>' id='logout'><li>🔙 HOMEPAGE</li></a>
            </ul>
        </div>
    </aside>

    <main class="main-content"></main>

    <footer>
        <p><b>©2025 WST Copyright & Compliance Ltd.</b> All rights reserved.</p>
    </footer>

    <!-- JQUERY -->
    <script>
        $(document).ready(() => {
            // Initial load
            loadSurvey(<?php echo $facultyId;?>, <?php echo $surveyId;?>); 

            $('#mysurvey').click(() => {
                loadSurvey(<?php echo $facultyId;?>, <?php echo $surveyId;?>);
            });

            $('#responses').click(() => {
                loadResponse(<?php echo $facultyId;?>, <?php echo $surveyId;?>);
            });

            $('#analytics').click(() => {
                loadAnalytics(<?php echo $facultyId;?>, <?php echo $surveyId;?>);
            });

        });

        function loadSurvey(facultyId, surveyId) {
            $.ajax({
                url: '../builder-utils/editSurvey.php',
                method: 'POST',
                data: { 
                    facultyId: facultyId,
                    surveyId: surveyId
                },
            }).done(function(response){
                $(".main-content").html(response);
                $('.main-content').css({
                    'margin-left': '0',
                    'margin-right': '25px'
                });
            });
        }

        function loadResponse(facultyId, surveyId) {
            $.ajax({
                url: 'ResponsePage.php', 
                method: 'POST',
                data: { 
                    facultyId: facultyId,
                    surveyId: surveyId 
                },
            }).done(function(response){
                $(".main-content").html(response);
                $('.main-content').css({
                    'margin-right': '0',
                    'margin-left': '150px'
                });
            });
        }
        
        function loadAnalytics(facultyId, surveyId) {
            $.ajax({
                url: 'AnalyticsPage.php', 
                method: 'POST',
                data: { 
                    facultyId: facultyId,
                    surveyId: surveyId
                },
            }).done(function(response){
                $(".main-content").html(response);
                $('.main-content').css({
                    'margin-right': '0',
                    'margin-left': '150px'
                });
            });
        }
    </script>
</body>
</html>