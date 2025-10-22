<?php
include_once "../../project_conn.php";

$surveyId = $_POST['surveyId'];
$facultyId = $_POST['facultyId'];

$surveyResult = $conn->query("SELECT survey_id, survey_title FROM survey WHERE survey_id = $surveyId");
$surveys = [];
while ($row = $surveyResult->fetch_assoc()) {
    // Get respondent count for this survey
    $respCount = 0;
    $respResult = $conn->query("
        SELECT COUNT(DISTINCT response_id) AS respondent_count
        FROM answer a
        JOIN question q ON a.question_id = q.question_id
        WHERE q.survey_id = {$row['survey_id']}
    ");
    if ($respRow = $respResult->fetch_assoc()) {
        $respCount = $respRow['respondent_count'];
    }

    $surveys[$row['survey_id']] = [
        'title' => $row['survey_title'],
        'respondent_count' => $respCount,
        'questions' => []
    ];
}

$questionResult = $conn->query("SELECT q.question_id, q.question_text, q.survey_id, q.question_type FROM question q WHERE q.survey_id = $surveyId");
while ($row = $questionResult->fetch_assoc()) {
    $row['respondent_count'] = $surveys[$row['survey_id']]['respondent_count'];
    $surveys[$row['survey_id']]['questions'][] = $row;
}
?>

<div class="surveyresult">
    <?php foreach ($surveys as $survey): ?>
        <div class="survey-block">
            <h2>
                <?php echo htmlspecialchars($survey['title']); ?>
                (Respondents: <?php echo $survey['respondent_count']; ?>)
            </h2>
            <?php foreach ($survey['questions'] as $index => $question): ?>
                <div class="question-card">
                    <div class="question-header">
                        <span class="question-text" data-respondent-count="<?php echo $question['respondent_count']; ?>">
                            <?php echo ($index + 1) . '. ' . htmlspecialchars($question['question_text']); ?>
                        </span>
                    </div>
                    <div class="question-content">
                        <canvas 
                            class="chart-canvas" 
                            id="q<?php echo $question['question_id']; ?>" 
                            data-type="<?php echo $question['question_type']; ?>">
                        </canvas>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endforeach; ?>
</div>

<style>
    .no-data {
        font-style: italic;
        color: #999;
        text-align: center;
        margin: 20px 0;
    }
</style>

<script>
$(document).ready(function () {
    const surveyId = <?php echo $surveyId; ?>;

    $.ajax({
        url: '../analytics-utils/project_getChartData.php',
        method: 'GET',
        data: { surveyId: surveyId },
        dataType: 'json',
        success: function (chartData) {
            console.log("Chart JSON data:", chartData);

            $('.chart-canvas').each(function () {
                const canvas = this;
                const canvasId = canvas.id;
                const type = $(canvas).data('type').toUpperCase();
                const data = chartData[canvasId];

                // Check respondent count
                const respondentCount = parseInt($(canvas).closest('.question-card').find('.question-text').data('respondent-count')) || 0;

                if (respondentCount === 0 || !data || (data.data && data.data.length === 0) || (data.words && data.words.length === 0)) {
                    $(canvas).replaceWith('<p class="no-data">No data available.</p>');
                    return;
                }

                const ctx = canvas.getContext('2d');

                if (type === 'MC') {
                    new Chart(ctx, {
                        type: 'pie',
                        data: {
                            labels: data.labels,
                            datasets: [{
                                label: 'Responses',
                                data: data.data,
                                backgroundColor: [
                                    '#36a2eb', '#ff6384', '#ffcd56', '#4bc0c0', '#9966ff'
                                ]
                            }]
                        },
                        options: { responsive: true }
                    });
                }

                if (type === 'LS') {
                    new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: data.labels,
                            datasets: [{
                                label: 'Responses',
                                data: data.data,
                                backgroundColor: '#36a2eb'
                            }]
                        },
                        options: {
                            responsive: true,
                            scales: { y: { beginAtZero: true } }
                        }
                    });
                }

                if (type === 'SA') {
                    WordCloud(canvas, {
                        list: data.words,
                        gridSize: 10,
                        weightFactor: 5,
                        fontFamily: 'Arial',
                        color: 'random-dark',
                        backgroundColor: '#ffffff'
                    });
                }
            });
        },
        error: function (xhr, status, error) {
            console.error('Chart load error:', error);
        }
    });
});
</script>
