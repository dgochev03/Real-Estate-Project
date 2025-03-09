<?php 
session_start();
include("config.php");
$error = "";
$msg = "";

if (isset($_REQUEST['login'])) {
    $email = $_REQUEST['email'];
    $pass = $_REQUEST['pass'];

    if (!empty($email) && !empty($pass)) {
        $sql = "SELECT * FROM user WHERE uemail='$email' AND upass='$pass'";
        $result = mysqli_query($con, $sql);
        $row = mysqli_fetch_array($result);

        if ($row) {
            $_SESSION['uid'] = $row['uid'];
            $_SESSION['uemail'] = $email;
            header("location:index.php");
        } else {
            $error = "<p class='alert-warning'>Login Not Successfully</p>";
        }
    } else {
        $error = "<p class='alert-warning'>Please fill all the fields</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="images/logo/logo-house.svg">
    <title>Real Estate Portal</title>
    <link rel="stylesheet" href="style/login.css">
</head>

<body>

    <?php include("include/header.php"); ?>

    <div class="login-container">
        <div class="login-box">
            <h1>Login</h1>
            <?php echo $error; ?><?php echo $msg; ?>

            <form method="post">
                <input type="email" name="email" placeholder="Your Email" required>
                <input type="password" name="pass" placeholder="Your Password" required>
                <button type="submit" name="login">Login</button>
            </form>

            <div class="alternative">
                <span>or</span>
            </div>
            <div class="register-link">Don't have an account? <a href="register.php">Register</a></div>
        </div>
    </div>

    <?php include("include/footer.php"); ?>
</body>
</html>
