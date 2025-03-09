<?php
include("config.php");

$error = "";
$msg = "";

if (isset($_REQUEST['reg'])) {
    $name = trim($_REQUEST['name']);
    $email = trim($_REQUEST['email']);
    $phone = trim($_REQUEST['phone']);
    $pass = trim($_REQUEST['pass']);
    $utype = $_REQUEST['utype'];

    if (!empty($name) && !empty($email) && !empty($phone) && !empty($pass) && strlen($pass) > 6) {
        $sql = "SELECT * FROM user WHERE uemail = ?";
        $stmt = mysqli_prepare($con, $sql);
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($result) > 0) {
            $error = "<p class='alert-warning'>Email already exists.</p>";
        } else {
            $sql = "INSERT INTO user (uname, uemail, uphone, upass, utype) VALUES (?, ?, ?, ?, ?)";
            $stmt = mysqli_prepare($con, $sql);
            mysqli_stmt_bind_param($stmt, "sssss", $name, $email, $phone, $pass, $utype);
            if (mysqli_stmt_execute($stmt)) {
                $msg = "<p class='alert-success'>Registered successfully.</p>";
            } else {
                $error = "<p class='alert-warning'>Registration failed. Please try again.</p>";
            }
        }
        mysqli_stmt_close($stmt);
    } else {
        $error = "<p class='alert-warning'>Please fill in all fields correctly. Password must be more than 6 chars.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="shortcut icon" href="images/logo/logo-house.svg">
        <link rel="stylesheet" href="style/register.css">
        <title>Real Estate Portal</title>
    </head>
    <body>
        <?php include("include/header.php"); ?>         
        <div class="login-body">
            <div class="loginbox">

                <h1>Register</h1>
                <?php echo $error; ?><?php echo $msg; ?>

                <form method="post">
                    <input type="text" name="name" placeholder="Your Name" required>
                    <input type="email" name="email" placeholder="Your Email" required>
                    <input type="text" name="phone" placeholder="Your Phone" maxlength="10" required>
                    <input type="password" name="pass" placeholder="Your Password" required>
                    <div class="form-group">
                        <label>Your User Type:</label>
                        <label>
                            <input type="radio" name="utype" value="user" checked>User
                        </label>
                        <label>
                            <input type="radio" name="utype" value="agent">Agent
                        </label>
                    </div>
                    <button name="reg" type="submit">Register</button>
                </form><br>

                <div class="dont-have">Already have an account? <a href="login.php">Login</a></div>
            </div>
        </div>
        <?php include("include/footer.php"); ?>
    </body>
</html>
