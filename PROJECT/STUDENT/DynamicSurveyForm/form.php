<?php
include_once "../../project_conn.php";

// Sanitize inputs
$survey_id = isset($_GET['survey_id']) ? (int)$_GET['survey_id'] : 0;
$student_id = isset($_GET['student_id']) ? $conn->real_escape_string($_GET['student_id']) : '';
$sectionCode = isset($_GET['sectionCode']) ? $conn->real_escape_string($_GET['sectionCode']) : '';

// Fetch survey info
$survey_query = "SELECT * FROM survey WHERE survey_id = $survey_id";
$survey_result = $conn->query($survey_query);
if (!$survey_result || $survey_result->num_rows === 0) {
    die("Survey not found.");
}
$survey = $survey_result->fetch_assoc();

// Fetch questions
$question_query = "SELECT * FROM question WHERE survey_id = $survey_id";
$question_result = $conn->query($question_query);
if (!$question_result) {
    die("Failed to fetch questions.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title><?php echo htmlspecialchars($survey['survey_title']); ?></title>
    <link rel="stylesheet" href="form.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
</head>
<body>
    <div class="survey-container">
        <a href="../AssignedSurveyList/studentHomePage.php?student_id=<?php echo urlencode($student_id); ?>&sectionCode=<?php echo urlencode($sectionCode); ?>" class="leave-survey-link">Leave Survey Form</a>
        <h2><?php echo htmlspecialchars($survey['survey_title']); ?></h2>
        <p class="description"><?php echo htmlspecialchars($survey['description']); ?></p>

        <div id="progress-container">
            <label for="progress">Progress:</label>
            <div>
                <div id="progress-bar" style="background:#2d4ea8; height:20px; width:0%; border-radius:5px;"></div>
            </div>
            <p id="progress-text">0% completed</p>
        </div>

        <form id="surveyForm" action="submit.php" method="POST">
            <input type="hidden" name="survey_id" value="<?php echo $survey_id; ?>">
            <input type="hidden" name="student_id" value="<?php echo htmlspecialchars($student_id); ?>">

            <?php while ($question = $question_result->fetch_assoc()) { 
                $qid = (int)$question['question_id'];
                $required_attr = ($question['REQUIRED'] === 'yes') ? 'required' : '';
                $asterisk = ($question['REQUIRED'] === 'yes') ? ' <span style="color:red">*</span>' : '';
            ?>
                <div class="question">
                    <p><?php echo htmlspecialchars($question['question_text']) . $asterisk; ?></p>

                    <?php if ($question['question_type'] === 'SA') { ?>
                        <input id="saInput_<?php echo $qid; ?>" 
                               type="text" 
                               name="answer[<?php echo $qid; ?>]" 
                               maxlength="1000"
                               <?php echo $required_attr; ?> >
                        <p><span id="charCount_<?php echo $qid; ?>">0</span>/1000 characters</p>

                    <?php } elseif ($question['question_type'] === 'LS' || $question['question_type'] === 'MC') { 
                        $choice_sql = "SELECT choice_id, choice_text FROM choice WHERE question_id = $qid";
                        $choice_result = $conn->query($choice_sql);
                        if (!$choice_result) {
                            echo "<p>Error loading choices.</p>";
                            continue;
                        }
                        while ($option = $choice_result->fetch_assoc()) { ?>
                            <label>
                                <input type="radio"
                                    name="answer[<?php echo $qid; ?>]"
                                    value="<?php echo (int)$option['choice_id']; ?>"
                                    class="radio-q<?php echo $qid; ?>"
                                    <?php echo $required_attr; ?>>
                                <?php echo htmlspecialchars($option['choice_text']); ?>
                            </label><br>
                        <?php } ?>
                        <button type="button" class="clear-btn" data-question-id="<?php echo $qid; ?>">Clear Answer</button>
                    <?php } ?>
                </div>
            <?php } ?>

            <div id="forms-btn">
                <button type="submit">Submit</button>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const inputs = document.querySelectorAll("input[type='radio'], input[type='text']");
            const progressBar = document.getElementById("progress-bar");
            const progressText = document.getElementById("progress-text");

            // Char count for all SA inputs
            document.querySelectorAll("input[type='text']").forEach(input => {
                const questionId = input.id.split('_')[1];
                const counter = document.getElementById(`charCount_${questionId}`);
                if (counter) {
                    input.addEventListener('input', () => {
                        counter.textContent = input.value.length;
                        updateProgress();
                    });
                }
            });

            const getAnsweredCount = () => {
                const answered = new Set();
                inputs.forEach(input => {
                    if ((input.type === 'radio' && input.checked) ||
                        (input.type === 'text' && input.value.trim() !== '')) {
                        answered.add(input.name);
                    }
                });
                return answered.size;
            };

            const updateProgress = () => {
                const questionInputs = new Set();
                inputs.forEach(input => questionInputs.add(input.name));
                const totalQuestions = questionInputs.size;
                const answered = getAnsweredCount();
                const percent = totalQuestions ? Math.round((answered / totalQuestions) * 100) : 0;

                progressBar.style.width = percent + "%";
                progressText.textContent = `${percent}% completed`;
            };

            inputs.forEach(input => {
                input.addEventListener("change", updateProgress);
                input.addEventListener("input", updateProgress);
            });

            // Clear button logic
            document.querySelectorAll('.clear-btn').forEach(button => {
                button.addEventListener('click', () => {
                    const questionId = button.dataset.questionId;
                    const radios = document.querySelectorAll(`input[name="answer[${questionId}]"]`);
                    radios.forEach(radio => radio.checked = false);
                    const textInput = document.getElementById(`saInput_${questionId}`);
                    if (textInput) {
                        textInput.value = '';
                        const counter = document.getElementById(`charCount_${questionId}`);
                        if (counter) counter.textContent = '0';
                    }
                    updateProgress();
                });
            });

            updateProgress();
        });

        $(document).ready(function() {
            $('#surveyForm').on('submit', function(e) {
                e.preventDefault();

                let formData = $(this).serialize();

                $.ajax({
                    url: 'submit.php',
                    type: 'POST',
                    data: formData,
                    dataType: 'json',
                    success: function(response) {
                        if (response.status === 'success') {
                            alert(response.message);
                            window.location.href = `../AssignedSurveyList/studentHomePage.php?student_id=<?php echo urlencode($student_id); ?>&sectionCode=<?php echo urlencode($sectionCode); ?>`;
                        } else {
                            alert('Error: ' + response.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        alert('Error submitting form: ' + xhr.responseText);
                    }
                });
            });
        });
    </script>
</body>
</html>
