<?php
include_once "../project_conn.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $type = $_POST['type'];

    if ($type === "program" && isset($_POST['college'])) {
        $college = $_POST['college'];
        $sql = "SELECT program_code, program_name FROM program 
                WHERE college_code = '$college'";
        $result = $conn->query($sql);
        echo "<option value=''>Select Program</option>";
        while ($row = $result->fetch_assoc()) {
            echo "<option value='{$row['program_code']}'>{$row['program_name']}</option>";
        }
    }

    if ($type === "section" && isset($_POST['program'])) {
        $program = $_POST['program'];
        $sql = "SELECT section_code FROM section 
                WHERE program_code = '$program'";
        $result = $conn->query($sql);
        echo "<option value=''>Select Section</option>";
        while ($row = $result->fetch_assoc()) {
            echo "<option value='{$row['section_code']}'>{$row['section_code']}</option>";
        }
    }
}
?>
