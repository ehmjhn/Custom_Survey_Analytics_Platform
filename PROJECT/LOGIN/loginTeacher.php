<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Evaluate | Admin Login</title>
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
</head>
<body>
    <div class="container" id="container">
    <div class="sign-in">
        <form id="logForm">
            <h1>Sign In</h1>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required> 
            <div class="validation"></div>
            <a href="#" id='forgotLink'>Forgot your password?</a>
            <button type="submit">Sign In</button>
        </form>
    </div>

    <div class="toggle-container single">
        <div class="toggle">
            <div class="toggle-left">
                <h1>Welcome, Admin!</h1>
                <p>Log in with your admin credentials to access the system.</p>
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

    <!-- dsadsadsadsadsadasdsadas -->
     <div id="changePassModal">
        <div class="modal-content">
            <form action="submit" id="changePassForm">
                <span class="close">&times;</span>
                <h2>Change Password</h2>
                <p>Enter your Faculty ID:</p>
                <input type="text" name="forgotFacultyID" id="forgotFacultyID" placeholder="Enter your Faculty ID" required>
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

    <!-- dsadsadsadsadsadasdsadas -->
     <div id="passwordChanged">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Account Status</h2>
            <p>Password has been changed!</p>
        </div>
    </div>

    <style>
    .toggle-container.single {
        position: absolute;
        top: 0;
        left: 50%;
        width: 50%;
        height: 100%;
        overflow: hidden;
        border-radius: 150px 0 0 100px;
        z-index: 10;
        transform: none ;
    }

    .toggle-container.single .toggle {
        left: 0 ;
        transform: none ;
        width: 100%;
    }

    .toggle-container.single .toggle-left {
        transform: none ;
        width: 100%;
        padding: 0 30px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        text-align: center;
    }
    </style>


    <script>
    $(document).ready(function () {
        //hide forgot pass modal
        $("#forgotModal").hide();

        //hide default modal
        $(".validation").hide();

        // hide new pass modal
        $("#changePassModal").hide();

        // hide pass changed modal
        $("#passwordChanged").hide();

        var counter = 0;

        //form ajax
        $("#logForm").on("submit", function (e) {
            e.preventDefault();

            var formData = new FormData(this);

            $.ajax({
                type: 'POST',
                url: 'logTeacherProcess.php',
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
                }
            });
        });

        //form ajax for change pass
        $("#forgotForm").on("submit", function (e) {
            e.preventDefault();
            var formData = new FormData(this);

            $.ajax({
                type: 'POST',
                url: 'TchrForgotPassProcess.php',
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
            var facultyID = $("#forgotFacultyID").val();
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
                    url: 'TchrChangePassProcess.php?email='+email+'&confPassword='+confPassword+'&facultyID='+facultyID,
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
                            const forgotFacultyID = document.getElementById('forgotFacultyID');
                            forgotFacultyID.disabled = true;
                            const newPassword = document.getElementById('newPassword');
                            newPassword.disabled = true;
                            const confPassword = document.getElementById('confPassword');
                            confPassword.disabled = true;
                            $(".timeoutValidationChange").show();
                            
                            setTimeout(() => {
                                $(".timeoutValidationChange").fadeOut();
                                forgotFacultyID.disabled = false;
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
    </script>
</body>
</html>