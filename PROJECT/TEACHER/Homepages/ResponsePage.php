<?php
include_once "../../project_conn.php";

$survey_id = $_POST['surveyId']; 
$facultyId = $_POST['facultyId']; 
?>

<div class="resp-content">
    <div class="btn-grp">
        <button data-survey_id='<?php echo $survey_id;?>' class='view-responses'>View Students</button>
        <button data-survey_id='<?php echo $survey_id;?>' class='view-summary'>View Summary</button>
    </div>
    <div class="view-cont"></div>
</div>

<script>
    //Reset margin in page
    function resetSidebar() {
        $('#sidebar').removeClass('collapsed');
        $('.main-content').css('margin-right', '0');
        $('#toggleSidebarBtn').find('i').removeClass('fa-chevron-left').addClass('fa-chevron-right');
    }

    $(document).ready(() => {
        // Initial load: automatically load the first survey's responses
        const firstSurveyButton = $('.view-responses').first();
        if (firstSurveyButton.length > 0) {
            const surveyId = firstSurveyButton.data('survey_id');
            loadResponses(surveyId);
        }

        // Handle View Responses button click
        $(document).on('click', '.view-responses', function() {
            const surveyId = $(this).data('survey_id');
            loadResponses(surveyId);
        });

        // Handle View Summary button click
        $(document).on('click', '.view-summary', function() {
            const surveyId = $(this).data('survey_id');
            $.ajax({
                url: '../response-utils/response_summary.php',
                method: 'POST',
                data: { surveyId: surveyId },
                success: function(response) {
                    $('.view-cont').html(response);
                    resetSidebar();
                }
            });
        });

        // The response loading function
        function loadResponses(surveyId) {
            $.ajax({
                url: '../response-utils/view_responses.php',
                method: 'POST',
                data: { surveyId: surveyId },
                success: function(response) {
                    $(".view-cont").html(response);
                    resetSidebar();

                    // Check if DataTables is loaded
                    if (!$.fn.DataTable) {
                        $.getScript("https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js", function() {
                            $('#responseTable').DataTable();
                        });
                    } else {
                        $('#responseTable').DataTable();
                    }
                }
            });
        }

        // View Answers
        $(document).on('click','#answers', function() {
            const surveyid = $(this).data('surveyid');
            const studentid = $(this).data('studentid');

            $.ajax({
                url: "../response-utils/view_answers.php",
                method: "POST",
                data: {
                    surveyid: surveyid,
                    studentid: studentid
                }
            }).done( function(response){
                $('.view-cont').html(response);
            });
        });

        $(document).on('click', '#back-button', function(){
            let surveyid = $(this).data('surveyid'); // Or wherever it’s stored

            $.ajax({
                url: "../response-utils/view_responses.php",
                method: "POST",
                data: { surveyId: surveyid }
            }).done(function(response){
                $('.view-cont').html(response);

                $('#responseTable').DataTable();
            });
        });
    });
</script>