<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Evaluate | Login</title>
    <link rel="stylesheet" href="loginstyle.css">
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
</head>
<body>

    <header>
        <div class="head-cont-title">
            <img src="../logo.png" alt="logo" class="main-logo">
            <h1>Evaluate</h1>
        </div>
        <div class="logbtn"> 
            <div class="cont-student">
                <h3>Sign-in as Student</h3>
            </div>
            <div class="cont-teacher">
                <h3>Sign-in as Teacher</h3>
            </div>
        </div>
    </header>

    <main class='main-content'>
        <div class="overview-section">
        <h2 class="overview-title">Welcome to <span class="highlight">Evaluate</span> 🚀</h2>
        <p class="overview-description">
            Evaluate is a powerful platform that lets you build custom surveys and instantly gain insights through advanced analytics. Whether for education, business, or research, our tools help you collect and act on feedback effortlessly.
        </p>
        <ul class="overview-features">
            <li>🛠️ <strong>Drag-and-drop</strong> survey builder</li>
            <li>📊 <strong>Real-time analytics</strong> with visual insights</li>
            <li>👥 <strong>Assign surveys</strong> to specific roles or sections</li>
            <li>📁 <strong>View submission history</strong> of answered surveys</li>
            <li>🔒 <strong>Secure & compliant</strong> data handling</li>
        </ul>
        </div>
    </main>
</body>

<script>
    $(document).ready(function (){
        $(".cont-teacher").click(loadTeacher);
        $(".cont-student").click(loadStudent);
    });

    function loadTeacher() {
        $.ajax({
            url: 'loginTeacher.php', 
        }).done(function(response){
            $(".main-content").html(response);
        });
    }

    function loadStudent() {
        $.ajax({
            url: 'loginStudent.php', 
        }).done(function(response){
            $(".main-content").html(response);
        });
    }
</script>

</html>