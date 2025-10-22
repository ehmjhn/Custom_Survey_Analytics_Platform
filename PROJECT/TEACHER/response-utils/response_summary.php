<?php
include_once "../../project_conn.php";

$survey_id = $_POST['surveyId'];

echo '<div class="table-container">
        <table id="responseSummary">';

$query2 = "SELECT DISTINCT r.submit_date, st.email_add 
FROM response AS r 
JOIN student AS st ON r.student_id = st.student_id
JOIN answer AS a ON r.response_id = a.response_id
JOIN survey AS s ON r.survey_id = s.survey_id
JOIN question AS q ON a.question_id = q.question_id
WHERE s.survey_id = $survey_id";

$result2 = $conn->query($query2);

// Table headers
$query = "SELECT question_text FROM question WHERE survey_id=$survey_id;";
$result = $conn->query($query);

echo "<thead>
        <tr>
            <th>Submit Date</th>
            <th>Email Address</th>";

while ($row = $result->fetch_assoc()) {
    echo "<th>{$row['question_text']}</th>";
}

echo "</tr></thead><tbody>";

while ($row2 = $result2->fetch_assoc()) {
    $submit_date = $row2['submit_date'];
    $email_add = $row2['email_add'];

    $query3 = "SELECT a.choice_id, a.answer_text 
    FROM response AS r 
    JOIN student AS st ON r.student_id = st.student_id
    JOIN answer AS a ON r.response_id = a.response_id
    JOIN survey AS s ON r.survey_id = s.survey_id
    JOIN question AS q ON a.question_id = q.question_id
    WHERE s.survey_id = $survey_id AND st.email_add='$email_add'";

    $result3 = $conn->query($query3);
    $data = [];

    while ($row3 = $result3->fetch_assoc()) {
        $combined = '';
        if (isset($row3['choice_id'])) {
            $choice_id = $row3['choice_id'];
            $choice_res = $conn->query("SELECT choice_text FROM choice WHERE choice_id=$choice_id");
            $choice_text = $choice_res->fetch_assoc()['choice_text'];
            $combined = $choice_text . ' ' . $row3['answer_text'];
        } else {
            $combined = $row3['answer_text'];
        }
        $data[] = $combined;
    }

    echo "<tr>
            <td>$submit_date</td>
            <td>$email_add</td>";
    foreach ($data as $d) {
        echo "<td>$d</td>";
    }
    echo "</tr>";
}

echo "</tbody></table>
      <div id='message'></div>
    </div>";
?>

<script>
    var table = document.getElementById('responseSummary');
    if (table && table.rows.length == 1) {
        document.getElementById('message').innerHTML = 'No data available in table';
    }
</script>
