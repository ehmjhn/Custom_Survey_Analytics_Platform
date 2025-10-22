<?php
include_once "../../project_conn.php";

$surveyId = $_GET['surveyId'];
$surveyTitle = $_GET['surveyTitle'];

echo <<<HTML
    <div class="modal-content">
        <p>Do you want to delete the survey</p>
        <h2 id="surv-title">$surveyTitle</h2>
        <div class="btn-grp">
            <button class="cancel" id="dM-cancel">Cancel</button>
            <button class="delete" id="dM-del" data-surveyid='$surveyId'>Delete</button>
        </div>
    </div>
    HTML;
?>