<?php
    session_start();
    if (isset($_SESSION['SESSION_EMAIL'])) {
        header("Location: welcome.php");
        die();
    }

    include 'config.php';
    $msg = "";

    if (isset($_GET['verification'])) {
        if (mysqli_num_rows(mysqli_query($conn, "SELECT * FROM users WHERE code='{$_GET['verification']}'")) > 0) {
            $query = mysqli_query($conn, "UPDATE users SET code='' WHERE code='{$_GET['verification']}'");
            
            if ($query) {
                $msg = "<div class='alert alert-success'>Account verification has been successfully completed.</div>";
            }
        } else {
            header("Location: index.php");
        }
    }

    if (isset($_POST['submit'])) {
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $password = mysqli_real_escape_string($conn, md5($_POST['password']));

        $sql = "SELECT * FROM users WHERE email='{$email}' AND password='{$password}'";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) === 1) {
            $row = mysqli_fetch_assoc($result);

            if (empty($row['code'])) {
                $_SESSION['SESSION_EMAIL'] = $email;
                header("Location: welcome.php");
            } else {
                $msg = "<div class='alert alert-info'>First verify your account and try again.</div>";
            }
        } else {
            $msg = "<div class='alert alert-danger'>Email or password do not match.</div>";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>

    <!-- link awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">

    <!-- Link file CSS -->
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="contanier">
        <div class="box-login">
            <div class="login">
                <div class="header">
                    <img src="image/logo.png" alt="" class="logo">
                    <h2>Hello ! Welcome Back</h2>
                </div>

                <form action="">

                    <label for="email">Email</label>
                    <div class="inp">
                        <i class="fa-solid fa-envelope"></i>
                        <input type="email" placeholder="Enter Your Email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" id="email" name="email">
                    </div>

                    <label for="password">Password</label>
<div class="inp">

  <input id="password" type="password" placeholder="Enter Your Password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"
  title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" autocomplete="off">
  <i id="togglePassword" class="fa-solid fa-eye"></i>
</div>

                    <div class="check-box">
                        <div class="check">
                            <label for="checkbox">Remember Me</label>
                            <input type="checkbox">
                        </div>
                        <div class="check" >
                            <a href="#" class="forg">Forgot Password?</a>

                        </div>
                    </div>

                    <button>Login</button>
                </form>

                <span class="line-sign">or</span>

                <div class="sign-soc">
                    <div class="box">
                        <a href="#"><img src="image/google.png" alt=""></a>
                    </div>

                    <div class="box">
                        <a href="#"><img src="image/instg.png" alt=""></a>
                    </div>

                    <div class="box">
                        <a href="#"><img src="image/facebook.png" alt=""></a>
                    </div>
                </div>

                <p class="creat-ac">Don't Have an account? <a href="register.html">Create Account</a></p>
            </div>
        </div>
    </div>
<script>
        // JavaScript
const togglePassword = document.getElementById('togglePassword');
const password = document.getElementById('password');

togglePassword.addEventListener('click', function (e) {
    // toggle the type attribute
    const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
    password.setAttribute('type', type);
    // toggle the eye slash icon
    this.classList.toggle('fa-eye-slash');
});
    </script>
</body>
</html>