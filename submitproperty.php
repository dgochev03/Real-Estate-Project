<?php
ini_set('session.cache_limiter', 'public');
session_cache_limiter(false);
session_start();
include("config.php");
if (!isset($_SESSION['uemail'])) {
    $_SESSION['login_message'] = "Please, login first!";
    header("location: login.php");
    exit();
}

if (isset($_POST['add'])) {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $ptype = $_POST['ptype'];
    $number_of_rooms = $_POST['number_of_rooms'];
    $stype = $_POST['stype'];
    $bath = $_POST['bath'];
    $floor = $_POST['floor'];
    $price = $_POST['price'];
    $city = $_POST['city'];
    $asize = $_POST['asize'];
    $loc = $_POST['loc'];
    $uid = $_SESSION['uid'];
    $totalfloor = $_POST['totalfl'];

    $aimage = $_FILES['aimage']['name'];
    $aimage1 = $_FILES['aimage1']['name'];
    $aimage2 = $_FILES['aimage2']['name'];
    $aimage3 = $_FILES['aimage3']['name'];
    $aimage4 = $_FILES['aimage4']['name'];

    $temp_name = $_FILES['aimage']['tmp_name'];
    $temp_name1 = $_FILES['aimage1']['tmp_name'];
    $temp_name2 = $_FILES['aimage2']['tmp_name'];
    $temp_name3 = $_FILES['aimage3']['tmp_name'];
    $temp_name4 = $_FILES['aimage4']['tmp_name'];

    move_uploaded_file($temp_name, "images/property/$aimage");
    move_uploaded_file($temp_name1, "images/property/$aimage1");
    move_uploaded_file($temp_name2, "images/property/$aimage2");
    move_uploaded_file($temp_name3, "images/property/$aimage3");
    move_uploaded_file($temp_name4, "images/property/$aimage4");


    $sql = "insert into property (title,pcontent,type,number_of_rooms,stype,bathroom,floor,size,price,location,city,pimage,pimage1,pimage2,pimage3,pimage4,uid,totalfloor)
	values('$title','$content','$ptype','$number_of_rooms','$stype','$bath','$floor','$asize','$price',
	'$loc','$city','$aimage','$aimage1','$aimage2','$aimage3','$aimage4','$uid','$totalfloor')";
    $result = mysqli_query($con, $sql);
    if ($result) {
        $msg = "<p class='alert-success'>Property Inserted Successfully</p>";
    } else {
        $error = "<p class='alert-warning'>Property Not Inserted Some Error</p>";
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="style/submitproperty.css">
    <title>Real Estate Portal</title>
</head>

<body>
    <?php include("include/header.php"); ?>
    <div class="container my-5">
        <h2 class="text-center text-orange">Submit Property</h2>
        <?php if (isset($msg)) echo $msg; else if (isset($error)) echo $error; ?>
        
        <form method="post" enctype="multipart/form-data" class="mt-4">
            <div class="mb-3">
                <label class="form-label">Title</label>
                <input type="text" name="title" class="form-control" required placeholder="Enter Title">
            </div>
            <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea name="content" class="form-control" rows="4"></textarea>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Property Type</label>
                    <select required name="ptype" class="form-select">
                        <option value="">Select Type</option>
                        <option value="appartment">Appartment</option>
                        <option value="house">House</option>
                        <option value="commercial property">Commercial property</option>
                        <option value="office">Office</option>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Selling Type</label>
                    <select required name="stype" class="form-select">
                        <option value="">Select Status</option>
                        <option value="rent">Rent</option>
                        <option value="sale">Sale</option>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Number of rooms</label>
                    <input type="number" name="number_of_rooms" class="form-control" required placeholder="1-10">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Bathroom</label>
                    <input type="number" name="bath" class="form-control" required placeholder="1-10">
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Floor</label>
                    <input type="text" name="floor" class="form-control" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Total Floors</label>
                    <input type="text" name="totalfl" class="form-control" required>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Price (EUR)</label>
                    <input type="text" name="price" class="form-control" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Area Size (sq.m.)</label>
                    <input type="text" name="asize" class="form-control" required>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">City</label>
                    <input type="text" name="city" class="form-control" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Address</label>
                    <input type="text" name="loc" class="form-control" required>
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Upload Images</label>
                <input name="aimage" type="file" class="form-control" required>
                <input name="aimage1" type="file" class="form-control mt-2" required>
                <input name="aimage2" type="file" class="form-control mt-2" required>
                <input name="aimage3" type="file" class="form-control mt-2" required>
                <input name="aimage4" type="file" class="form-control mt-2" required>
            </div>
            <div class="text-center">
                <input type="submit" value="Submit" name="add" class="btn btn-orange">
            </div>
        </form>
    </div>
    
    <?php include("include/footer.php"); ?>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>