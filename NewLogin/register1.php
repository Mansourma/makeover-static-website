<?php
    //Import PHPMailer classes into the global namespace
    //These must be at the top of your script, not inside a function
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    session_start();
    if (isset($_SESSION['SESSION_EMAIL'])) {
        header("Location: welcome.php");
        die();
    }

    //Load Composer's autoloader
    require 'vendor/autoload.php';

    include 'config.php';
    $msg = "";

    if (isset($_POST['submit'])) {
        $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $age = mysqli_real_escape_string($conn, $_POST['age']);
        $password = mysqli_real_escape_string($conn, md5($_POST['password']));
        $confirm_password = mysqli_real_escape_string($conn, md5($_POST['confirm-password']));
        $code = mysqli_real_escape_string($conn, md5(rand()));

        if (mysqli_num_rows(mysqli_query($conn, "SELECT * FROM users WHERE email='{$email}'")) > 0) {
            $msg = "<div class='alert alert-danger'>{$email} - This email address has been already exists.</div>";
        } else {
            if ($password === $confirm_password) {
                $sql = "INSERT INTO users (username, full_name, email, password, code) VALUES ('{$full_name}', '{$full_name}', '{$email}', '{$password}', '{$code}')";
                $result = mysqli_query($conn, $sql);

                if ($result) {
                    echo "<div style='display: none;'>";
                    //Create an instance; passing `true` enables exceptions
                    $mail = new PHPMailer(true);

                    try {
                        //Server settings
                        $mail->SMTPDebug = SMTP::DEBUG_SERVER;                     
                        $mail->isSMTP();                                           
                        $mail->Host       = 'smtp.gmail.com';                    
                        $mail->SMTPAuth   = true;                                   
                        $mail->Username   = 'mansourmohamedofficiel6@gmail.com';                   
                        $mail->Password   = 'password';                           
                        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            
                        $mail->Port       = 465;                                    

                        //Recipients
                        $mail->setFrom('mansourmohamedofficiel6@gmail.com');
                        $mail->addAddress($email);

                        //Content
                        $mail->isHTML(true);                                
                        $mail->Subject = 'MakeOver Verification';
                        $mail->Body    = 'Dear '.$name.', <br><br>

                        I am writing to inform you that your account has been successfully created on our website, MakeOver. To complete the registration process,
                         we require you to verify your email address. <br> <br>
                        
                        To verify your email, please follow the link provided below: <b><a href="http://localhost/login/?verification='.$code.'">http://localhost/login/?verification='.$code.'</a></b> <br>
                        Please note that this verification link is valid for 24 hours. If you do not verify your email within this time frame, 
                        you will need to request a new verification link. <br>


                         Thank you for choosing MakeOver. <br> <br>

                        Best regards,<br>
                        MakeOver Team';

                        $mail->send();
                        echo 'Message has been sent';
                    } catch (Exception $e) {
                        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                    }
                    echo "</div>";
                    $msg = "<div class='alert alert-info'>We've send a verification link on your email address.</div>";
                } else {
                    $msg = "<div class='alert alert-danger'>Something wrong went.</div>";
                }
            } else {
                $msg = "<div class='alert alert-danger'>Password and Confirm Password do not match</div>";
            }
        }
    }
?>
