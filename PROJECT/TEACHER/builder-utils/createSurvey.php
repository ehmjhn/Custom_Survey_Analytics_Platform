<?php
include_once "../../project_conn.php";

$section = [];
$sqlSec = "SELECT section_code FROM section";
$result = $conn->query($sqlSec);
while ($row = $result->fetch_assoc()) {
    $section[] = $row['section_code'];
}

$facultyId = $_POST['facultyId'];
?>

<div class="survey-body">
    <div class="builder">
        <h3>📝 Create Survey</h3>
        <form id="surveyForm" method="POST">
            <input type="hidden" name="facultyId" value="<?php echo $facultyId; ?>">
            <input type="hidden" name="publish" id="publishInput" value="0">
            <div class="form-row">
                <div class="form-settings">
                    <div class="form-group">
                        <input type="text" name="title" placeholder="Survey Title" required/>
                    </div>
                    <div class="form-group">
                        <input type="text" name="description" placeholder="Description" required/>
                    </div>

                    <?php
                        $isPublished = !empty($existingSurvey['section_codes']); // Adjust this logic based on your DB schema
                    ?>
                    <div class="form-group d-flex align-items-start gap-4 flex-wrap">
                        <!-- Switch -->
                        <div class="d-flex align-items-center gap-2">
                            <label for="publishToggle" class="form-label mb-0">Publish Survey:</label>
                            <label class="switch">
                                <input type="checkbox" id="publishToggle" <?= $isPublished ? 'checked' : '' ?>>
                                <span class="slider round"></span>
                            </label>
                        </div>
                        <!-- Section -->
                        <div class="section-group" id="sectionAssignment" style="display: <?= $isPublished ? 'block' : 'none' ?>;">
                            <label class="form-label d-block">Assign to Section(s):</label>
                            <button type="button" id="add-section" class="btn btn-secondary btn-sm mb-2">+ Add Section</button>
                            <div id="section-container">
                                <?php foreach ($existingSurvey['section_codes'] ?? [''] as $secCode): ?>
                                    <div class="section-select d-flex align-items-center gap-2 mb-2">
                                        <select name="section_code[]" class="form-select">
                                            <option value="">Select Section</option>
                                            <?php foreach ($section as $sec): ?>
                                                <option value="<?= $sec ?>" <?= $sec === $secCode ? 'selected' : '' ?>><?= $sec ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        <button type="button" class="remove-section btn btn-sm btn-danger">Remove</button>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        Due Date:<input type="date" name="due_date" required/>
                    </div>
                </div>
            </div>

            <div id="questionContainer">
                <p class="text-muted">Drag questions here to build your survey</p>
            </div>
            
            <div style="text-align: right;">
                <button type="submit" class="btn btn-success save"><i class="fas fa-save me-1"></i> Save Survey</button>
            </div>
        </form>
    </div>

    <div class="sidebar collapsed" id="sidebar">
        <button id="toggleSidebarBtn"><i class="fas fa-chevron-right"></i>Form Elements</button>
        <h5><i class="fas fa-toolbox"></i> Form Elements</h5>
        <div class="draggable" draggable="true" data-type="LS"><i class="fas fa-sliders-h me-2"></i>Likert Scale</div>
        <div class="draggable" draggable="true" data-type="MC"><i class="fas fa-list-ul me-2"></i>Multiple Choice</div>
        <div class="draggable" draggable="true" data-type="SA"><i class="fas fa-pen me-2"></i>Short Answer</div>
    </div>
</div>

<script>
    $(document).ready(function () {
        let questionIndex = 0; // For sorting & naming

        // Make questionContainer sortable with handle
        $("#questionContainer").sortable({
            handle: ".question-handle",
            update: function () {
                updateQuestionIndexes();
            }
        });

        $('#toggleSidebarBtn').on('click', function () {
            const $sidebar = $('.sidebar');
            const $mainContent = $('.main-content');
            const $icon = $(this).find('i');

            $sidebar.toggleClass('collapsed');

            if ($sidebar.hasClass('collapsed')) {
                // Sidebar is collapsed: main content margin-left = 0
                $icon.removeClass('fa-chevron-left').addClass('fa-chevron-right');
                $mainContent.css({'margin-left': '0'});
            } else {
                // Sidebar is expanded: main content margin-left = sidebar width
                $icon.removeClass('fa-chevron-right').addClass('fa-chevron-left');
                $mainContent.css({'margin-left': '170px'});
            }
        });

        // Toggle Publish Survey
        $('#publishToggle').on('change', function () {
            if ($(this).is(':checked')) {
                $('#sectionAssignment').slideDown();
                $('#section-container select').attr('required', true);
                $('#publishInput').val('1');  // Set hidden input to 1 when toggled ON
            } else {
                $('#sectionAssignment').slideUp();
                $('#section-container select').removeAttr('required');
                $('#publishInput').val('0');  // Set hidden input to 0 when toggled OFF
            }
        });

        //Add Sections
        $('#add-section').click(function () {
            const sectionDropdown = `
                <div class="section-select mt-2">
                    <select name="section_code[]" required>
                        <option value="">Select Section</option>
                        <?php foreach ($section as $sec): ?>
                            <option value="<?= $sec ?>"><?= $sec ?></option>
                        <?php endforeach; ?>
                    </select>
                    <button type="button" class="remove-section btn btn-sm btn-danger ms-2">Remove</button>
                </div>
            `;
            $('#section-container').append(sectionDropdown);
        });
        // Handle removal
        $(document).on('click', '.remove-section', function () {
            $(this).closest('.section-select').remove();
        });

        // Drag and Drop from sidebar
        $(".draggable").on("dragstart", function (e) {
            e.originalEvent.dataTransfer.setData("type", $(this).data("type"));
        });

        $("#questionContainer").on("dragover", function (e) {
            e.preventDefault();
        }).on("drop", function (e) {
            e.preventDefault();
            const type = e.originalEvent.dataTransfer.getData("type");
            addQuestion(type);
        });

        // Function to add question card HTML
        function addQuestion(type) {
            // Remove placeholder text on first question add
            if ($("#questionContainer p.text-muted").length) {
                $("#questionContainer p.text-muted").remove();
            }

            let labelType = (type === 'LS') ? 'Likert Scale' : (type === 'MC') ? 'Multiple Choice' : 'Short Answer';

            let html = `<div class="question-card" data-type="${type}">
                <input type="hidden" name="questions[${questionIndex}][type]" value="${type}">
                <div class="question-header">
                    <div><i class="fas fa-grip-vertical question-handle me-2"></i> <strong>${labelType}</strong></div>
                    <button type="button" class="btn btn-danger remove-question"><i class="fas fa-trash"></i></button>
                </div>
                <div>
                    <input type="text" name="questions[${questionIndex}][text]" placeholder="Enter your question" required />
                </div>`;

            if (type === 'MC' || type === 'LS') {
                html += `<hr class="mt-3" style="border-top: 2px solid #182758; margin-bottom: 10px" />
                <div class="choices mt-2">
                    <div class="input-group">
                        <button type="button" class="btn add-choice"><i class="fas fa-plus"></i></button>
                        <input type="text" name="questions[${questionIndex}][choices][]" placeholder="Choice text" required />
                    </div>
                </div>`;
            }

            html += `<div class="required">
                    <label class="form-label mb-0">Required</label>
                    <label class="required-switch mb-0">
                        <input type="checkbox" name="questions[${questionIndex}][required]" class="required-toggle" checked>
                        <span class="slider blue-slider"></span>
                    </label>
                </div>`;

            html += `</div>`;
            $("#questionContainer").append(html);
            questionIndex++;
        }

        // Add choice button (for MC and LS)
        $(document).on("click", ".add-choice", function () {
            const container = $(this).closest(".choices");
            const questionCard = container.closest(".question-card");
            const idx = $("#questionContainer .question-card").index(questionCard);

            container.append(`
                <div class="input-group">
                    <button type="button" class="btn-danger remove-choice"><i class="fas fa-minus"></i></button>
                    <input type="text" name="questions[${idx}][choices][]" placeholder="Choice text" required />
                </div>
            `);
        });

        // Remove choice button
        $(document).on("click", ".remove-choice", function () {
            $(this).closest(".input-group").remove();
        });

        // Remove question button
        $(document).on("click", ".remove-question", function () {
            $(this).closest(".question-card").remove();
            if ($("#questionContainer .question-card").length === 0) {
                $("#questionContainer").append('<p class="text-muted">Drag questions here to build your survey</p>');
            }
            updateQuestionIndexes();
        });

        // Update input names/indexes after reorder or delete
        function updateQuestionIndexes() {
            $("#questionContainer .question-card").each(function (i, card) {
                $(card).find("input, select, textarea").each(function () {
                    const name = $(this).attr("name");
                    if (name) {
                        const newName = name.replace(/\[\d+\]/, `[${i}]`);
                        $(this).attr("name", newName);
                    }
                });
            });
            questionIndex = $("#questionContainer .question-card").length;
        }

        $("#surveyForm").on("submit", function (e) {
            e.preventDefault();

            if ($("#questionContainer .question-card").length === 0) {
                alert("Please add at least one question before saving the survey.");
                return;
            }

            var formData = new FormData(this);

            $.ajax({
                type: 'POST',
                url: '../builder-utils/saveProcess.php',
                data: formData,
                contentType: false,
                processData: false,
                success: function (response) {
                    let res = JSON.parse(response);
                    if (res.status === 'success') {
                        alert(res.message);
                    } else {
                        alert(res.message);
                    }
                    console.log(response);
                },
                error: function (xhr, status, error) {
                    alert("Something went wrong: " + error);
                    console.log(xhr.responseText);
                }
            });
        });
    });
</script>
