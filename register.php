
<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

session_start();
if (isset($_SESSION['SESSION_EMAIL'])) {
    header("Location: dashboard.php");
    die();
}

//Load Composer's autoloader
require 'vendor/autoload.php';

include 'config.php';
$msg = "";

if (isset($_POST['submit'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, md5($_POST['password']));
    $confirm_password = mysqli_real_escape_string($conn, md5($_POST['confirm-password']));
    $code = mysqli_real_escape_string($conn, md5(rand()));

    if (mysqli_num_rows(mysqli_query($conn, "SELECT * FROM sample_form WHERE email='{$email}'")) > 0) {
        $msg = "<div class='alert alert-danger'>{$email} - This email address has been already exists.</div>";
    } else {
        if ($password === $confirm_password) {
            $sql = "INSERT INTO sample_form (name, email, password, code) VALUES ('{$name}', '{$email}', '{$password}', '{$code}')";
            $result = mysqli_query($conn, $sql);

            if ($result) {
                echo "<div style='display: none;'>";
                //Create an instance; passing `true` enables exceptions
                $mail = new PHPMailer(true);

                try {
                    //Server settings
                    $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
                    $mail->isSMTP();                                            //Send using SMTP
                    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
                    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                    $mail->Username   = '8202642@ntc.edu.ph';                     //SMTP username
                    $mail->Password   = 'ftsdwdeqdvjlufxk';                               //SMTP password
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
                    $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

                    //Recipients
                    $mail->setFrom('8202642@ntc.edu.ph');
                    $mail->addAddress($email);

                    //Content
                    $mail->isHTML(true);                                  //Set email format to HTML
                    $mail->Subject = 'CodeIT Account Verification';
                    $mail->Body = 'Here is the verification link: <a href="http://localhost/website1/login.php?verification='.$code.'">http://localhost/website1/login.php?verification='.$code.'</a>';


                    $mail->send();
                    echo 'Message has been sent';
                } catch (Exception $e) {
                    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                }
                echo "</div>";
                $msg = "<div class='alert alert-info'>We've send a verification link on your email address.</div>";
            } else {
                $msg = "<div class='alert alert-danger'>Something went wrong.</div>";
            }
        } else {
            $msg = "<div class='alert alert-danger'>Password and Confirm Password do not match</div>";
        }
    }
}
?>





<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="css/form.css">
</head>
<body>
<section class="w3l-mockup-form">
        <div class="container">
            <!-- /form -->
            <div class="workinghny-form-grid">
                <div class="main-mockup">
                    <div class="w3l_form align-self">
                        <div class="left_grid_info">
                        <img src="assets/pic3.png" alt="logo">
                    </div>
                </div>
                <div class="content-wthree">
                    <h2>Register Now</h2>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. </p>
                    <?php echo $msg; ?>
                    <form action="" method="post">
                        <input type="text" class="name" name="name" placeholder="Enter Your Name" value="<?php if (isset($_POST['submit'])) {
                                                                                                                echo $name;
                                                                                                            } ?>" required>
                        <input type="email" class="email" name="email" placeholder="Enter Your Email" value="<?php if (isset($_POST['submit'])) {
                                                                                                                    echo $email;
                                                                                                                } ?>" required>
                        <input type="password" class="password" name="password" placeholder="Enter Your Password" required>
                        <input type="password" class="confirm-password" name="confirm-password" placeholder="Enter Your Confirm Password" required>
                        <button name="submit" class="btn" type="submit">Register</button>
                    </form>
                    <div class="social-icons">
                        <p>Have an account! <a href="login.php">Login</a>.</p>
                    </div>
                </div>
            </div>
        </div>
        <!-- //form -->
        </div>
    </section>
</body>
</html>