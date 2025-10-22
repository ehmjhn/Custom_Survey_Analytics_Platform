<?php
session_start();
include '../../project_conn.php';

// Sanitize GET parameters to prevent SQL injection
$studentId = isset($_GET['student_id']) ? $conn->real_escape_string($_GET['student_id']) : null;
$sectionCode = isset($_GET['sectionCode']) ? $conn->real_escape_string($_GET['sectionCode']) : null;

// Get student name
$sqlStudent = "SELECT first_name, last_name FROM student WHERE student_id = '$studentId'";
$resultStudent = $conn->query($sqlStudent);
$studentName = "Student";

if (!$resultStudent) {
    die("Query failed: " . $conn->error);
}

if ($resultStudent->num_rows > 0) {
    $rowStudent = $resultStudent->fetch_assoc();
    $studentName = htmlspecialchars($rowStudent['first_name'] . " " . $rowStudent['last_name']);
} else {
    $studentName = "Student not found";
}

if (isset($_GET['tab'])) {
    $tab = $_GET['tab'];

    if ($tab === 'forms') {
        $sql = "SELECT 
            s.survey_id, 
            s.survey_title, 
            s.description, 
            s.due_date,
            CONCAT(f.first_name, ' ', f.last_name) AS faculty_name
        FROM 
            student stu
        JOIN 
            survey_section ss ON stu.section_code = ss.section_code
        JOIN 
            survey s ON ss.survey_id = s.survey_id
        LEFT JOIN 
            faculty f ON s.faculty_id = f.faculty_id
        LEFT JOIN 
            response r ON r.student_id = stu.student_id AND r.survey_id = s.survey_id
        WHERE 
            stu.student_id = '$studentId'
            AND r.response_id IS NULL  
            AND s.due_date >= CURDATE()  
        ORDER BY 
            s.survey_id ASC";

        $result = $conn->query($sql);

        echo "<h2>Survey List</h2>";

        if ($result->num_rows > 0) {
            echo '<div class="cards-container">';
            while ($row = $result->fetch_assoc()) {
                $surveyTitle = htmlspecialchars($row['survey_title']);
                $facultyName = htmlspecialchars($row['faculty_name']);
                $dueDate = date("F j, Y", strtotime($row['due_date']));
                $surveyId = urlencode($row['survey_id']);
                $studentIdUrl = urlencode($studentId);
                $sectionCodeUrl = urlencode($sectionCode);

                echo "
                <div class='card'>
                    <h3>{$surveyTitle}</h3>
                    <p><strong>Status:</strong> Active - {$facultyName}</p>
                    <p><strong>Due Date:</strong> {$dueDate}</p>
                    <a href='../DynamicSurveyForm/form.php?survey_id={$surveyId}&student_id={$studentIdUrl}&sectionCode={$sectionCodeUrl}' class='btn'>Answer</a>
                </div>";
            }
            echo '</div>';
        } else {
            echo "<p>No surveys found for your section.</p>";
        }
        exit();
    }

    if ($tab === 'history') {
        $sqlHistory = "
            SELECT s.survey_id, s.survey_title, s.description,
                   CONCAT(f.first_name, ' ', f.last_name) AS faculty_name,
                   r.submit_date
            FROM response r
            JOIN survey s ON r.survey_id = s.survey_id
            LEFT JOIN faculty f ON s.faculty_id = f.faculty_id
            WHERE r.student_id = '$studentId'
            ORDER BY r.submit_date DESC";

        $resultHistory = $conn->query($sqlHistory);

        echo "<h2>Survey Submission History</h2>";

        if ($resultHistory->num_rows > 0) {
            echo '<div class="cards-container">';
            while ($row = $resultHistory->fetch_assoc()) {
                $surveyTitle = htmlspecialchars($row['survey_title']);
                $facultyName = htmlspecialchars($row['faculty_name']);
                $submitDate = date("F j, Y", strtotime($row['submit_date']));
                $surveyId = urlencode($row['survey_id']);
                $studentIdUrl = urlencode($studentId);

                echo "<div class='card'>
                        <h3>{$surveyTitle}</h3>
                        <p><strong>Status:</strong> Submitted - {$facultyName}</p>
                        <p><strong>Submission Date:</strong> {$submitDate}</p>
                        <a href='../Submission&History/viewAnswer.php?survey_id={$surveyId}&student_id={$studentIdUrl}' class='btn'>View Answer</a>
                      </div>";
            }
            echo '</div>';
        } else {
            echo "<p>You have not submitted any surveys yet.</p>";
        }
        exit();
    }

    if ($tab === 'overdue') {
        $sql = "SELECT s.survey_id, s.survey_title, s.description, s.due_date,
        CONCAT(f.first_name, ' ', f.last_name) AS faculty_name
        FROM survey s
        JOIN survey_section ss ON s.survey_id = ss.survey_id
        JOIN student stu ON ss.section_code = stu.section_code
        LEFT JOIN faculty f ON s.faculty_id = f.faculty_id
        WHERE stu.student_id = '$studentId'
        AND s.due_date < CURDATE()
        AND NOT EXISTS (
            SELECT 1
            FROM response r
            WHERE r.survey_id = s.survey_id
                AND r.student_id = stu.student_id
        )
        ORDER BY s.due_date ASC;
        ";

        $result = $conn->query($sql);

        echo "<h2>Overdue Surveys</h2>";

        if ($result->num_rows > 0) {
            echo '<div class="cards-container">';
            while ($row = $result->fetch_assoc()) {
                $surveyTitle = htmlspecialchars($row['survey_title']);
                $facultyName = htmlspecialchars($row['faculty_name']);
                $dueDate = date("F j, Y", strtotime($row['due_date']));
                echo "<div class='card'>
                        <h3>{$surveyTitle}</h3>
                        <p><strong>Status:</strong> Overdue - {$facultyName}</p>
                        <p><strong>Due Date:</strong> {$dueDate}</p>
                    </div>";
            }
            echo '</div>';
        } else {
            echo "<p>No overdue surveys found for your section.</p>";
        }
        exit();
    }
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Survey Dashboard</title>
    <link rel="stylesheet" href="studentHomePage.css" />
    <style>                  
.card {
    background-color:rgb(208, 232, 255);
    border-radius: 12px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    padding: 20px;
    transition: transform 0.2s, box-shadow 0.2s;
}

.card h3 {
    margin-top: 0;
    color: #1e2e6e;
}

.card p {
    color: #2d4ea8;
    margin: 8px 0;
}

.card .btn {
    display: inline-block;
    margin-top: 10px;
    padding: 10px 16px;
    background-color: #2d4ea8;
    color: white;
    border-radius: 6px;
    text-decoration: none;
    transition: background-color 0.3s ease;
}

.card .btn:hover {
    background-color: #1e3686; 
}

.card:hover {
    transform: translateY(-5px);
    box-shadow: 0 6px 16px rgba(29, 46, 110, 0.25);
}
.cards-container {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 40px;
    margin-top: 20px;
}

    </style>
</head>
<body>

<div class="header">
    <div class="head-cont-title">
        <img src="../../logo.png" alt="logo" class="main-logo">
        <div>Evaluate</div>
    </div>
    <div style="display: flex; align-items: center; gap: 20px;">
        <img src="../../user.png" alt="user" class="user-img">
        <div><?php echo $studentName; ?></div>
        <div><?php echo $sectionCode; ?></div>
        <a href="../../LOGIN/login.php" id="logoutBtn" class="logout-btn" style="display:flex; align-items:center; gap:6px;">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="14" height="14" viewBox="0 0 24 24">
            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
            <polyline points="16 17 21 12 16 7"/>
            <line x1="21" y1="12" x2="9" y2="12"/>
        </svg>
        Logout
        </a>
    </div>
</div>

<div class="container">
    <div class="tab-container">
        <div class="tab active" onclick="loadTab('forms')">Active Surveys</div>
        <div class="tab" onclick="loadTab('history')">History</div>
        <div class="tab" onclick="loadTab('overdue')">Overdue Surveys</div>
    </div>

    <div id="tab-content"></div>
</div>

<div id="logoutModal" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.4); justify-content:center; align-items:center;">
  <div style="background:#fff; padding:20px; border-radius:8px; text-align:center;">
    <p>Are you sure you want to logout?</p>
    <button id="confirmLogout">Yes</button>
    <button id="cancelLogout">Cancel</button>
  </div>
</div>

<script>
function loadTab(tab) {
    document.querySelectorAll('.tab').forEach(t => t.classList.remove('active'));
    document.querySelector(`.tab[onclick="loadTab('${tab}')"]`).classList.add('active');

    fetch(`<?php echo basename(__FILE__); ?>?tab=${tab}&student_id=<?php echo urlencode($studentId); ?>&sectionCode=<?php echo urlencode($sectionCode); ?>`)
        .then(response => {
            if (!response.ok) throw new Error('Network error');
            return response.text();
        })
        .then(html => {
            document.getElementById('tab-content').innerHTML = html;
        })
        .catch(e => {
            document.getElementById('tab-content').innerHTML = '<p>Error loading content.</p>';
        });
}

loadTab('forms');

const logoutBtn = document.getElementById('logoutBtn');
const logoutModal = document.getElementById('logoutModal');
const confirmLogout = document.getElementById('confirmLogout');
const cancelLogout = document.getElementById('cancelLogout');

logoutBtn.addEventListener('click', (e) => {
    e.preventDefault();
    logoutModal.style.display = 'flex';
});

cancelLogout.addEventListener('click', () => {
    logoutModal.style.display = 'none';
});

confirmLogout.addEventListener('click', () => {
    window.location.href = '../../LOGIN/login.php';
});
</script>
</body>
</html>
