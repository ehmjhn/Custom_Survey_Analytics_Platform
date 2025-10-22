<?php
include_once "../../project_conn.php";

$facultyId = $_GET['facultyId'];

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

    <!-- Custom CSS -->
    <link rel="stylesheet" href="../teacherstyle.css">

    <!-- Font Awesome (optional) -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet" />

    <title>Evaluate | Survey Builder</title>

    <!-- jQuery (must be first) -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <!-- jQuery UI (sortable, draggable, etc.) -->
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>

    <!-- Chart.js (optional) -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

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
                <a id="mysurvey"><li><b>📝 WELCOME TO SURVEY BUILDER!</b></li></a>
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
            loadSurvey(<?php echo $facultyId; ?>); 

            $('#mysurvey').click(() => {
                loadSurvey(<?php echo $facultyId;?>);
            });
        });

        function loadSurvey(facultyId) {
            $.ajax({
                url: '../builder-utils/createSurvey.php',
                method: 'POST',
                data: { facultyId: facultyId },
            }).done(function(response){
                $(".main-content").html(response);
                $('.main-content').css({
                    'margin-left': '0',
                    'margin-right': '25px'
                });
            });
        }

    </script>
</body>
</html>