<?php
ini_set('session.cache_limiter', 'public');
session_cache_limiter(false);
session_start();
include("config.php");

if (!isset($_SESSION['uemail'])) {
    header("location:login.php");
}

if (isset($_POST['submit_password'])) {
    $old_pass = $_POST['old_pass'];
    $new_pass1 = $_POST['new_pass1'];
    $new_pass2 = $_POST['new_pass2'];

    $uid = $_SESSION['uid'];

    if (!empty($old_pass) && !empty($new_pass1) && !empty($new_pass2) && $new_pass1 == $new_pass2) {
        $sql = "SELECT upass FROM user WHERE uid = '$uid'";
        $result = mysqli_query($con, $sql);
        $row = mysqli_fetch_assoc($result);

        if ($row) {
            $current_pass = $row['upass'];

            if ($current_pass == $old_pass) {
                $sql = "UPDATE user SET upass = '$new_pass1' WHERE uid = '$uid'";
                $result = mysqli_query($con, $sql);
                if ($result) {
                    $msg = "<p class='alert alert-success'>Password changed successfully</p>";
                } else {
                    $error = "<p class='alert alert-warning'>Password not updated successfully</p>";
                }
            } else {
                $error = "<p class='alert alert-warning'>Old password is incorrect</p>";
            }
        } else {
            $error = "<p class='alert alert-warning'>User not found</p>";
        }
    } else {
        $error = "<p class='alert alert-warning'>Please fill all the fields and ensure passwords match</p>";
    }
}

if (isset($_POST['submit_phone'])) {
    $new_phone = $_POST['new_phone'];
    $uid = $_SESSION['uid'];

    if (!empty($new_phone)) {
        $sql = "UPDATE user SET uphone = '$new_phone' WHERE uid = '$uid'";
        $result = mysqli_query($con, $sql);
        if ($result) {
            $msg = "<p class='alert alert-success'>Phone number changed successfully</p>";
        } else {
            $error = "<p class='alert alert-warning'>Phone number not updated successfully</p>";
        }
    } else {
        $error = "<p class='alert alert-warning'>Please enter a new phone number</p>";
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
        <link rel="stylesheet" href="style/profile.css">
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
        <title>Real Estate Property</title>
    </head>
    <body>
        <?php include("include/header.php"); ?>

        <div class="container mt-5">
            <?php
            if (isset($msg)) {
                echo '<div class="alert alert-success text-center">' . $msg . '</div>';
            }
            if (isset($error)) {
                echo '<div class="alert alert-warning text-center">' . $error . '</div>';
            }
            ?>
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6"> 
                    <h2 class="text-center mb-4">Profile</h2>

                    <?php
                    $uid = $_SESSION['uid'];
                    $query = mysqli_query($con, "SELECT * FROM `user` WHERE uid='$uid'");
                    while ($row = mysqli_fetch_array($query)) {
                        ?>

                        <div class="card mb-4">
                            <div class="card-body">
                                <h5 class="card-title">User Information</h5>
                                <p class="card-text"><b>Name:</b> <?php echo $row['1']; ?></p>
                                <p class="card-text"><b>Email:</b> <?php echo $row['2']; ?></p>
                                <p class="card-text"><b>Phone:</b> <?php echo $row['3']; ?></p>
                                <p class="card-text"><b>Role:</b> <?php echo $row['5']; ?></p>
                            </div>
                        </div>
                    <?php } ?>

                    <div class="card mb-4">
                        <div class="card-body">
                            <h5 class="card-title">Change Password</h5>
                            <form method="POST">
                                <div class="form-group">
                                    <label for="old-password">Old password:</label>
                                    <input type="password" class="form-control" name="old_pass" required>
                                </div>
                                <div class="form-group">
                                    <label for="new-password">New Password:</label>
                                    <input type="password" class="form-control" name="new_pass1" required>
                                </div>
                                <div class="form-group">
                                    <label for="confirm-password">Confirm the new password:</label>
                                    <input type="password" class="form-control" name="new_pass2" required>
                                </div>
                                <button type="submit" class="btn btn-orange btn-block" name="submit_password">Change Password</button>
                            </form>
                        </div>
                    </div>

                    <div class="card mb-4">
                        <div class="card-body">
                            <h5 class="card-title">Change Phone Number</h5>
                            <form method="POST">
                                <div class="form-group">
                                    <label for="new-phone">New Phone Number:</label>
                                    <input type="text" class="form-control" name="new_phone" required>
                                </div>
                                <button type="submit" class="btn btn-orange btn-block" name="submit_phone">Change Phone Number</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php include("include/footer.php"); ?>

        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    </body>
</html>