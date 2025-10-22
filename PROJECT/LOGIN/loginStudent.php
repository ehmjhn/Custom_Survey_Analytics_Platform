<?php
include_once '../project_conn.php'; 

$colleges = $conn->query("SELECT college_code, college_name FROM college");
$programs = $conn->query("SELECT program_code, program_name FROM program");
$sections = $conn->query("SELECT section_code FROM section");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="loginstyle.css">
    <title>Evaluate | Student Login</title>
</head>

<body>

    <div class="container" id="container">
        <div class="sign-up">
            <form>
                <h1>Create Account</h1>
                <input type="text" id="firstName" name="firstName" placeholder="First Name" required>
                <input type="text" id="middleName" name="middleName" type="text" placeholder="Middle Initial" required>
                <input type="text" id="lastName" name="lastName" placeholder="Last Name" required>
                <input type="email" id="email" name="email" placeholder="Email" required>
                <input type="password" id="password" name="password" placeholder="Password" required>
                <button id="signupBtn" type="submit">Sign Up</button>
            </form>
        </div>
        <div class="sign-in">
            <form id='logFormStud'>
                <h1>Sign In</h1>
                <input type="email" name="email" placeholder="Email" required>
                <input type="password" name="password" placeholder="Password" required>
                <div class="validation"></div>
                <a href="#" id='forgotLink'>Forgot your password?</a>
                <button type="submit">Sign In</button>
            </form>
        </div>
        <div class="toggle-container">
            <div class="toggle">
                <div class="toggle-left">
                    <h1>Welcome Learners!</h1>
                    <p>Log in with your personal details to continue.</p>
                    <button class="hidden" id="login">Sign In</button>
                </div>
                <div class="toggle-right">
                    <h1>Hello, Learners!</h1>
                    <p>Enter your credentials to register and access this page.</p>
                    <button class="hidden" id="register">Sign Up</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Forgot Password Modal -->
    <div id="forgotModal">
        <div class="modal-content">
            <form action="submit" id="forgotForm">
                <span class="close">&times;</span>
                <h2>Forgot Password</h2>
                <p>Enter your email to reset your password:</p>
                <input id="forgotPasswordEmail" name="forgotPasswordEmail" type="email" placeholder="Enter your email" required>
                <div class="validationForgot" style="display:none"></div>
                <div class="timeoutValidationForgot" style="display:none">You have been timed out! Please try again after 30 seconds.</div>
                <button id="submitForgot" type="submit">Submit</button>
            </form>
        </div>
    </div>

    <!-- Sign up Modal -->
    <div id="signupModal">
        <div id="signUpModalContent">

            <form method="post" id="finalSignupForm">
                <span class="close">&times;</span>
                <h2>Choose your section</h2>
                <p class="note">All fields are required</p>
                <input type="hidden" id="hiddenFirstName" name="hiddenFirstName">
                <input type="hidden" id="hiddenMiddleName" name="hiddenMiddleName">
                <input type="hidden" id="hiddenLastName" name="hiddenLastName">
                <input type="hidden" id="hiddenEmail" name="hiddenEmail">
                <input type="hidden" id="hiddenPassword" name="hiddenPassword">
                <label for="college">College:</label>
                <select id="college" name="college" required>
                    <option value="">Select College</option>
                    <?php while ($row = $colleges->fetch_assoc()): ?>
                        <option value="<?= $row['college_code'] ?>"><?= $row['college_name'] ?></option>
                    <?php endwhile; ?>
                </select>


                <label for="program">Program:</label>
                <select id="program" name="program" required>
                    <option value="">Select Program</option>
                </select>

                <label for="section">Section:</label>
                <select id="section" name="section" required>
                    <option value="">Select Section</option>
                </select>
                <button id="signUpBtnFinal" type="submit">Sign up</button>
            </form>

        </div>
    </div>

    <!-- Change Pass -->
     <div id="changePassModal">
        <div class="modal-content">
            <form action="submit" id="changePassForm">
                <span class="close">&times;</span>
                <h2>Change Password</h2>
                <p>Enter your Student ID:</p>
                <input type="text" name="forgotStudentID" id="forgotStudentID" placeholder="Enter your Student ID" required>
                <p>Enter your new password:</p>
                <input type="password" name="newPassword" id="newPassword" placeholder="Enter your new password" required>
                <p>Confirm your new password:</p>
                <input type="password" name="confPassword" id="confPassword" placeholder="Confirm your new password" required>
                <div class="validationChange" style="display:none"></div>
                <div class="timeoutValidationChange" style="display:none">You have been timed out! Please try again after 30 seconds.</div>
                <button id="submitNewPass" type="submit">Submit</button>
            </form>
        </div>
    </div>

    <!-- Pass Change -->
     <div id="passwordChanged">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Account Status</h2>
            <p>Password has been changed!</p>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            //hide forgot pass modal
            $("#forgotModal").hide();
            $("#signupModal").hide();

            // hide new pass modal
            $("#changePassModal").hide();

            // hide pass changed modal
            $("#passwordChanged").hide();

            //hide default modal
            $(".validation").hide();

            //Sign-up 
            $('#register').on('click', function () {
                $('#container').addClass('active');
            });

            //Sign-in
            $('#login').on('click', function () {
                $('#container').removeClass('active');
            });

            var counter = 0;
        //form ajax
        $("#logFormStud").on("submit", function (e) {
            e.preventDefault();

            var formData = new FormData(this);
            

            $.ajax({
                type: 'POST',
                url: 'logStudProcess.php',
                data: formData,
                dataType: 'json',
                contentType: false,
                processData: false,
            }).done(function(response) {
                if (response.status === "success") {
                    window.location.href = response.redirect;
                } else if (response.status === "error") {
                    $(".validation").html(response.message).show();
                    setTimeout(function() {
                        $(".validation").fadeOut();
                    }, 3000);
                    counter++;
                    console.log(counter);
                    if(counter == 5){
                        const email = document.getElementById('email');
                        email.disabled = true;
                        const password = document.getElementById('password');
                        password.disabled = true;
                        $(".timeoutValidation").show();
                        
                        setTimeout(() => {
                            $(".timeoutValidation").fadeOut();
                            email.disabled = false;
                            password.disabled = false;
                            counter=0;
                            console.log(counter);
                        }, 30000);
                    }
                }
            });
            
        });

        //form ajax for change pass
        $("#forgotForm").on("submit", function (e) {
            e.preventDefault();
            var formData = new FormData(this);

            $.ajax({
                type: 'POST',
                url: 'StudForgotPassProcess.php',
                data: formData,
                dataType: 'json',
                contentType: false,
                processData: false,
            }).done(function(response) {
                if (response.status === "success") {
                    // window.location.href = response.redirect;
                    // New Password Modal
                    e.preventDefault();
                    //hide forgot pass modal
                    $("#forgotModal").hide();
                    $('#changePassModal').fadeIn(200);

                    $('.close').click(function () {
                        $('#changePassModal').fadeOut(200);
                    });

                    $(window).click(function (e) {
                        if ($(e.target).is('#changePassModal')) {
                            $('#changePassModal').fadeOut(200);
                        }
                    });
                } else if (response.status === "error") {
                    $(".validationForgot").html(response.message).show();
                    setTimeout(function() {
                        $(".validationForgot").fadeOut();
                    }, 3000);
                    counter++;
                    console.log(counter);
                    if(counter == 5){
                        const forgotPasswordEmail = document.getElementById('forgotPasswordEmail');
                        forgotPasswordEmail.disabled = true;
                        $(".timeoutValidationForgot").show();
                        
                        setTimeout(() => {
                            $(".timeoutValidationForgot").fadeOut();
                            forgotPasswordEmail.disabled = false;
                            counter=0;
                            console.log(counter);
                        }, 30000);
                    }
                }
            });
        });

        //form ajax for new password
        $("#changePassForm").on("submit", function (e) {
            e.preventDefault();

            var formData = new FormData(this);
            var email = $("#forgotPasswordEmail").val();
            var studentID = $("#forgotStudentID").val();
            var newPassword = $("#newPassword").val();
            var confPassword = $("#confPassword").val();

            if(newPassword != confPassword){
                $(".validationChange").html("Password does not match!").show();
                setTimeout(function() {
                    $(".validationChange").fadeOut();
                }, 3000);
            }else{
                $.ajax({
                    type: 'POST',
                    url: 'StudChangePassProcess.php?email='+email+'&confPassword='+confPassword+'&studentID='+studentID,
                    data: formData,
                    dataType: 'json',
                    contentType: false,
                    processData: false,
                }).done(function(response) {
                    if (response.status === "success") {
                        // window.location.href = response.redirect;
                        // New Password Modal
                        e.preventDefault();
                        //hide forgot pass modal
                        $("#changePassModal").hide();
                        $('#passwordChanged').fadeIn(200);

                        $('.close').click(function () {
                            $('#passwordChanged').fadeOut(200);
                        });

                        $(window).click(function (e) {
                            if ($(e.target).is('#passwordChanged')) {
                                $('#passwordChanged').fadeOut(200);
                            }
                        });

                    } else if (response.status === "error") {
                        $(".validationChange").html(response.message).show();
                        setTimeout(function() {
                            $(".validationChange").fadeOut();
                        }, 3000);
                        counter++;
                        console.log(counter);
                        if(counter == 5){
                            const forgotStudentID = document.getElementById('forgotStudentID');
                            forgotStudentID.disabled = true;
                            const newPassword = document.getElementById('newPassword');
                            newPassword.disabled = true;
                            const confPassword = document.getElementById('confPassword');
                            confPassword.disabled = true;
                            $(".timeoutValidationChange").show();
                            
                            setTimeout(() => {
                                $(".timeoutValidationChange").fadeOut();
                                forgotStudentID.disabled = false;
                                newPassword.disabled = false;
                                confPassword.disabled = false;
                                counter=0;
                                console.log(counter);
                            }, 30000);
                        }

                    }
                });
            }  
        });

        // Forgot Password Modal
        $('#forgotLink').click(function (e) {
                e.preventDefault();
                $('#forgotModal').fadeIn(200);
                document.getElementById('forgotForm').reset();
                document.getElementById('changePassForm').reset();
            });

            $('.close').click(function () {
                $('#forgotModal').fadeOut(200);
                $('#signupModal').fadeOut(200);
            });

            $(window).click(function (e) {
                if ($(e.target).is('#forgotModal')) {
                    $('#forgotModal').fadeOut(200);
                    document.getElementById('forgotForm').reset();
                    document.getElementById('changePassForm').reset();
                }
            });
        });

        // Sign up modal script
        $("#finalSignupForm").on("submit", function (e) {
            e.preventDefault();

            var formData = new FormData(this);

            $.ajax({
                type: 'POST',
                url: 'signupProcess.php',  
                data: formData,
                dataType: 'json', 
                contentType: false,
                processData: false,
                success: function (response) {
                    if (response.status === "success") {
                        alert("Sign up successful! You can now log in.");
                        $('#signupModal').fadeOut(200);
                        $('#finalSignupForm')[0].reset();
                    } else {
                        alert("Error: " + response.message);
                    }
                },
                error: function (xhr, status, error) {
                    alert("An error occurred: " + error);
                }
            });
        });

        $('#signupBtn').on('click', function (e) {
            e.preventDefault();

            const form = $(this).closest('form')[0]; // Get the form element

            if (!form.checkValidity()) {
                form.reportValidity(); // Show validation errors
                return; // Stop if invalid
            }

            // If valid, proceed to copy values and show modal
            const fname = $('#firstName').val().trim();
            const mname = $('#middleName').val().trim();
            const lname = $('#lastName').val().trim();
            const email = $('#email').val().trim();
            const pass = $('#password').val().trim();

            $('#hiddenFirstName').val(fname);
            $('#hiddenMiddleName').val(mname);
            $('#hiddenLastName').val(lname);
            $('#hiddenEmail').val(email);
            $('#hiddenPassword').val(pass);

            $('#signupModal').fadeIn(200);
        });

        // Dynamic dropdowns
        $('#college').on('change', function () {
            var college = $(this).val();
            $('#program').html('<option value="">Loading...</option>');
            $('#section').html('<option value="">Select Section</option>');
            if (college) {
                $.post('loadOptions.php', { type: 'program', college: college }, function (data) {
                    $('#program').html(data);
                });
            } else {
                $('#program').html('<option value="">Select Program</option>');
            }
        });

        $('#program').on('change', function () {
            var program = $(this).val();
            $('#section').html('<option value="">Loading...</option>');
            if (program) {
                $.post('loadOptions.php', { type: 'section', program: program }, function (data) {
                    $('#section').html(data);
                });
            } else {
                $('#section').html('<option value="">Select Section</option>');
            }
        });
    </script>
</body>

</html>