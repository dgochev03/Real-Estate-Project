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
            $error = "<div class='alert alert-warning'>Login Not Successfully</div>";
        }
    } else {
        $error = "<div class='alert alert-warning'>Please fill all the fields</div>";
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
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="style/login.css">
    </head>

    <body>

        <?php include("include/header.php"); ?>

        <div class="container mb-5">
            <?php
            if (isset($_SESSION['login_message'])) {
                echo "<p class='alert alert-warning'>" . $_SESSION['login_message'] . "</p>";
                unset($_SESSION['login_message']);
            }
            ?>
            <div class="row justify-content-center">
                <div class="col-md-6 col-lg-4">
                    <div class="login-box p-4 mt-5 bg-white rounded shadow">
                        <h1 class="text-center mb-4">Login</h1>
                        <?php echo $error; ?><?php echo $msg; ?>

                        <form method="post">
                            <div class="form-group">
                                <input type="email" name="email" class="form-control" placeholder="Your Email" required>
                            </div>
                            <div class="form-group">
                                <input type="password" name="pass" class="form-control" placeholder="Your Password" required>
                            </div>
                            <button type="submit" name="login" class="btn btn-custom btn-block">Login</button>
                        </form>

                        <div class="alternative text-center my-3">
                            <span>or</span>
                        </div>
                        <div class="register-link text-center">
                            Don't have an account? <a href="register.php">Register</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

<?php include("include/footer.php"); ?>

        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    </body>
</html>
