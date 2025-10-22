<?php
include_once "../../project_conn.php";

$student_id = $_POST['studentid'];
$survey_id = $_POST['surveyid'];

$query = "SELECT CONCAT(first_name, ' ', middle_name, ' ', last_name) AS student_name 
          FROM student 
          WHERE student_id = $student_id";

$student = $conn->query($query);

if ($student && $checkStud = $student->fetch_assoc()) {
    $studName = $checkStud['student_name'];
} else {
    $studName = "Not Found";
}
?>


<div class="table-container">
    Student Name: <h3 style="color: #23397c"><?php echo $studName; ?></h3>
    <table>
        <tbody>
        <tr>
            <th>#</th>
            <th>Question</th>
            <th>Answer</th>
        </tr>
        <?php
        $query = "SELECT DISTINCT s.survey_title, s.date_created, q.question_text, a.choice_id, a.answer_text, 
        st.student_id, r.submit_date from survey as s join response as r join student as st join question as q join 
        answer as a join choice as ch where s.survey_id=r.survey_id and r.student_id=st.student_id and 
        s.survey_id=q.survey_id and q.question_id=a.question_id and a.response_id=r.response_id and st.student_id=$student_id 
        and s.survey_id=$survey_id";

        $result = $conn->query($query);

        $number = 0;
        
        // to print the answers and choice id, this is to prevent null table cells
        while($row = $result->fetch_assoc()) {
            $question_text = $row['question_text'];
            $choice_id = $row['choice_id'];
            $answer_text = $row['answer_text'];

            if(isset($choice_id)){
                $query2 = "select choice_text from choice where choice_id=$choice_id;";
                $result2 = $conn->query($query2);
                while($row = $result2->fetch_assoc()) {
                    $choice_text = $row['choice_text'];
                }
                $combined = $choice_text . ' ' . $answer_text;
            }else{
                $combined = $answer_text;
            }

            $number++;

            echo "
            <tr>
                <td>$number. </td>
                <td>$question_text</td>
                <td>$combined</td>   
            </tr>
            ";
        }

        $number = 0;
        ?>
        </tbody>
    </table>
    <button id="back-button" data-surveyid="<?php echo $survey_id; ?>">Back</button>
</div>