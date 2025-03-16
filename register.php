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
            $error = "<div class='alert alert-warning'>Email already exists.</div>";
        } else {
            $sql = "INSERT INTO user (uname, uemail, uphone, upass, utype) VALUES (?, ?, ?, ?, ?)";
            $stmt = mysqli_prepare($con, $sql);
            mysqli_stmt_bind_param($stmt, "sssss", $name, $email, $phone, $pass, $utype);
            if (mysqli_stmt_execute($stmt)) {
                $msg = "<div class='alert alert-success'>Registered successfully.</div>";
            } else {
                $error = "<div class='alert alert-warning'>Registration failed. Please try again.</div>";
            }
        }
        mysqli_stmt_close($stmt);
    } else {
        $error = "<div class='alert alert-warning'>Please fill in all fields correctly. Password must be more than 6 chars.</div>";
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
        <title>Real Estate Portal</title>
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
        <link rel="stylesheet" href="style/register.css">
    </head>
    <body>
        <?php include("include/header.php"); ?>

        <div class="login-body">
            <div class="loginbox">
                <h1 class="text-center mb-4">Register</h1>
                <?php echo $error; ?><?php echo $msg; ?>

                <form method="post">
                    <div class="form-group">
                        <input type="text" name="name" class="form-control" placeholder="Your Name" required>
                    </div>
                    <div class="form-group">
                        <input type="email" name="email" class="form-control" placeholder="Your Email" required>
                    </div>
                    <div class="form-group">
                        <input type="text" name="phone" class="form-control" placeholder="Your Phone" maxlength="10" required>
                    </div>
                    <div class="form-group password-container">
                        <input type="password" name="pass" id="password" class="form-control" placeholder="Your Password" required>
                        <span class="password-toggle" onclick="togglePassword()">
                            <i class="fas fa-eye"></i>
                        </span>

                    </div>
                    <small class="password-requirements">Password must be at least 6 characters.</small>
                    <div class="form-group">
                        <label>Your User Type:</label>
                        <div>
                            <label class="mr-3">
                                <input type="radio" name="utype" value="user" checked> User
                            </label>
                            <label>
                                <input type="radio" name="utype" value="agent"> Agent
                            </label>
                        </div>
                    </div>
                    <button type="submit" name="reg" class="btn btn-custom btn-block">Register</button>
                </form>

                <div class="text-center mt-3">
                    Already have an account? <a href="login.php" class="register-link">Login</a>
                </div>
            </div>
        </div>

        <?php include("include/footer.php"); ?>

        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <script>
                            function togglePassword() {
                                const passwordField = document.getElementById("password");
                                const toggleIcon = document.querySelector(".password-toggle i");
                                if (passwordField.type === "password") {
                                    passwordField.type = "text";
                                    toggleIcon.classList.remove("fa-eye");
                                    toggleIcon.classList.add("fa-eye-slash");
                                } else {
                                    passwordField.type = "password";
                                    toggleIcon.classList.remove("fa-eye-slash");
                                    toggleIcon.classList.add("fa-eye");
                                }
                            }
        </script>
    </body>
</html>