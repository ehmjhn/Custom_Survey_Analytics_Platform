<?php
include_once "../../project_conn.php";

$survey_id = $_POST['surveyId']; 

$query = "SELECT s.survey_id, st.student_id, st.first_name, st.middle_name, st.last_name, st.email_add, 
st.section_code, r.submit_date 
FROM `student` as st 
JOIN response as r ON st.student_id = r.student_id 
JOIN survey as s ON s.survey_id = r.survey_id 
WHERE s.survey_id = $survey_id";

$result = $conn->query($query);
?>


<div class="table-container">
    <div class="date-filter-container" style="margin-bottom: 10px;">
        <label for="startDate"><p>Start Date:</p></label>
        <input type="date" id="startDate" name="startDate" />
        <label for="endDate" style="margin-left: 15px;"><p>End Date:</p></label>
        <input type="date" id="endDate" name="endDate" />
    </div>
    <table id="responseTable" class="display">
        <thead>
            <tr>
                <th>Student Name</th>
                <th>Email Address</th>
                <th>Section Code</th>
                <th>Date Submitted</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php
        while($row = $result->fetch_assoc()) {
            $student_id = $row['student_id'];
            $student_name = $row['first_name'] . ' ' . $row['middle_name'] . ' ' . $row['last_name'];
            $email_add = $row['email_add'];
            $section_code = $row['section_code'];
            $submit_date = $row['submit_date'];

            echo "
            <tr>
                <td>$student_name</td>
                <td>$email_add</td>
                <td>$section_code</td>
                <td>$submit_date</td>
                <td>
                    <button data-surveyid='$survey_id' data-studentid='$student_id' class='view-answers' id='answers'>View Answers</button>
                </td>
            </tr>
            ";
        }
        ?>
        </tbody>
    </table>
</div>

<script>
$(function() {
    $('#startDate, #endDate').on('change', function() {
        var startDate = $('#startDate').val();
        var endDate = $('#endDate').val();

        $('#responseTable tbody tr').each(function() {
            var submitDate = $(this).find('td:nth-child(4)').text().trim();

            if (!submitDate) {
                $(this).hide();
                return;
            }

            var submitDateObj = new Date(submitDate);
            var startDateObj = startDate ? new Date(startDate) : null;
            var endDateObj = endDate ? new Date(endDate) : null;

            var show = true;
            if (startDateObj && submitDateObj < startDateObj) show = false;
            if (endDateObj && submitDateObj > endDateObj) show = false;

            $(this).toggle(show);
        });
    });
});
</script>
