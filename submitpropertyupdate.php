<?php
ini_set('session.cache_limiter', 'public');
session_cache_limiter(false);
session_start();
include("config.php");
if (!isset($_SESSION['uemail'])) {
    header("location:login.php");
}

if (isset($_POST['add'])) {
    $pid = $_REQUEST['id'];

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

    $aimage = !empty($_FILES['aimage']['name']) ? $_FILES['aimage']['name'] : $_POST['existing_aimage'];
    $aimage1 = !empty($_FILES['aimage1']['name']) ? $_FILES['aimage1']['name'] : $_POST['existing_aimage1'];
    $aimage2 = !empty($_FILES['aimage2']['name']) ? $_FILES['aimage2']['name'] : $_POST['existing_aimage2'];
    $aimage3 = !empty($_FILES['aimage3']['name']) ? $_FILES['aimage3']['name'] : $_POST['existing_aimage3'];
    $aimage4 = !empty($_FILES['aimage4']['name']) ? $_FILES['aimage4']['name'] : $_POST['existing_aimage4'];

    if (!empty($_FILES['aimage']['name'])) {
        move_uploaded_file($_FILES['aimage']['tmp_name'], "images/property/$aimage");
    }
    if (!empty($_FILES['aimage1']['name'])) {
        move_uploaded_file($_FILES['aimage1']['tmp_name'], "images/property/$aimage1");
    }
    if (!empty($_FILES['aimage2']['name'])) {
        move_uploaded_file($_FILES['aimage2']['tmp_name'], "images/property/$aimage2");
    }
    if (!empty($_FILES['aimage3']['name'])) {
        move_uploaded_file($_FILES['aimage3']['tmp_name'], "images/property/$aimage3");
    }
    if (!empty($_FILES['aimage4']['name'])) {
        move_uploaded_file($_FILES['aimage4']['tmp_name'], "images/property/$aimage4");
    }

    $sql = "UPDATE property SET title= '{$title}', pcontent= '{$content}', type='{$ptype}', number_of_rooms='{$number_of_rooms}', stype='{$stype}',
	bathroom='{$bath}', floor='{$floor}', 
	size='{$asize}', price='{$price}', location='{$loc}', city='{$city}',
	pimage='{$aimage}', pimage1='{$aimage1}', pimage2='{$aimage2}', pimage3='{$aimage3}', pimage4='{$aimage4}',
	uid='{$uid}', totalfloor='{$totalfloor}' WHERE pid = {$pid}";

    $result = mysqli_query($con, $sql);
    if ($result == true) {
        $msg = "<p class='alert alert-success'>Property Updated</p>";
        header("Location:feature.php?msg=$msg");
    } else {
        $error = "<p class='alert alert-warning'>Property Not Updated</p>";
        header("Location:feature.php?msg=$error");
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
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
        <title>Real Estate Portal</title>
    </head>

    <style>
        .text-center button {
            background-color: #f39c12;
            border-color: #f39c12;
            color: white;
            margin: 20px;
            font-size: 16px;
            margin-top: 20px;
            transition: background-color 0.3s ease;
        }

        .text-center button:hover {
            background-color: darkorange;
            border-color: darkorange;
        }
    </style>

    <body>
        <?php include("include/header.php"); ?>

        <div class="container mt-5">
            <h2 class="text-center mb-4">Update Property</h2>

            <form method="post" enctype="multipart/form-data" class="needs-validation" novalidate>
                <?php
                $pid = $_REQUEST['id'];
                $query = mysqli_query($con, "select * from property where pid='$pid'");
                while ($row = mysqli_fetch_row($query)) {
                    ?>
                    <div class="form-group">
                        <label for="title">Title</label>
                        <input type="text" class="form-control" id="title" name="title" required value="<?php echo $row['1']; ?>">
                    </div>

                    <div class="form-group">
                        <label for="content">Content</label>
                        <textarea class="form-control" id="content" name="content" rows="5" required><?php echo $row['2']; ?></textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="ptype">Property Type</label>
                                <select class="form-control" id="ptype" name="ptype" required>
                                    <option value="">Select Type</option>
                                    <option value="appartment" <?php echo ($row['3'] == 'appartment') ? 'selected' : ''; ?>>Appartment</option>
                                    <option value="house" <?php echo ($row['3'] == 'house') ? 'selected' : ''; ?>>House</option>
                                    <option value="commercial property" <?php echo ($row['3'] == 'commercial property') ? 'selected' : ''; ?>>Commercial property</option>
                                    <option value="office" <?php echo ($row['3'] == 'office') ? 'selected' : ''; ?>>Office</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="stype">Selling Type</label>
                                <select class="form-control" id="stype" name="stype" required>
                                    <option value="">Select Status</option>
                                    <option value="rent" <?php echo ($row['5'] == 'rent') ? 'selected' : ''; ?>>Rent</option>
                                    <option value="sale" <?php echo ($row['5'] == 'sale') ? 'selected' : ''; ?>>Sale</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="number_of_rooms">Number of rooms</label>
                                <input type="number" class="form-control" id="number_of_rooms" name="number_of_rooms" required value="<?php echo $row['4']; ?>">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="bath">Bathroom</label>
                                <input type="number" class="form-control" id="bath" name="bath" required value="<?php echo $row['6']; ?>">
                            </div>
                        </div>
                    </div>

                    <h5 class="mt-4">Price & Location</h5>
                    <hr>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="floor">Floor</label>
                                <input type="number" class="form-control" id="floor" name="floor" required value="<?php echo $row['7']; ?>">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="totalfl">Total Floor</label>
                                <input type="number" class="form-control" id="totalfl" name="totalfl" required value="<?php echo $row['18']; ?>">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="price">Price</label>
                                <input type="number" class="form-control" id="price" name="price" required value="<?php echo $row['9']; ?>">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="asize">Area Size</label>
                                <input type="number" class="form-control" id="asize" name="asize" required value="<?php echo $row['8']; ?>">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="city">City</label>
                                <input type="text" class="form-control" id="city" name="city" required value="<?php echo $row['11']; ?>">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="loc">Address</label>
                                <input type="text" class="form-control" id="loc" name="loc" required value="<?php echo $row['10']; ?>">
                            </div>
                        </div>
                    </div>

                    <h5 class="mt-4">Images</h5>
                    <hr>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="aimage">Image</label>
                                <input type="file" class="form-control-file" id="aimage" name="aimage">
                                <input type="hidden" name="existing_aimage" value="<?php echo $row['12']; ?>">
                                <img src="images/property/<?php echo $row['12']; ?>" alt="pimage" class="img-thumbnail mt-2" style="width: 150px; height: auto;">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="aimage1">Image 1</label>
                                <input type="file" class="form-control-file" id="aimage1" name="aimage1">
                                <input type="hidden" name="existing_aimage1" value="<?php echo $row['13']; ?>">
                                <img src="images/property/<?php echo $row['13']; ?>" alt="pimage" class="img-thumbnail mt-2" style="width: 150px; height: auto;">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="aimage2">Image 2</label>
                                <input type="file" class="form-control-file" id="aimage2" name="aimage2">
                                <input type="hidden" name="existing_aimage2" value="<?php echo $row['14']; ?>">
                                <img src="images/property/<?php echo $row['14']; ?>" alt="pimage" class="img-thumbnail mt-2" style="width: 150px; height: auto;">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="aimage3">Image 3</label>
                                <input type="file" class="form-control-file" id="aimage3" name="aimage3">
                                <input type="hidden" name="existing_aimage3" value="<?php echo $row['15']; ?>">
                                <img src="images/property/<?php echo $row['15']; ?>" alt="pimage" class="img-thumbnail mt-2" style="width: 150px; height: auto;">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="aimage4">Image 4</label>
                                <input type="file" class="form-control-file" id="aimage4" name="aimage4">
                                <input type="hidden" name="existing_aimage4" value="<?php echo $row['16']; ?>">
                                <img src="images/property/<?php echo $row['16']; ?>" alt="pimage" class="img-thumbnail mt-2" style="width: 150px; height: auto;">
                            </div>
                        </div>
                    </div>

                    <div class="text-center mt-4">
                        <button type="submit" class="btn btn-primary btn-lg" name="add">Submit</button>
                    </div>
                <?php } ?>
            </form>
        </div>

        <?php include("include/footer.php"); ?>

        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <script>
            document.querySelector("form").addEventListener("submit", function (e) {
                const title = document.querySelector('input[name="title"]').value.trim();
                const numberOfRooms = document.querySelector('input[name="number_of_rooms"]').value;
                const bath = document.querySelector('input[name="bath"]').value;
                const floor = document.querySelector('input[name="floor"]').value;
                const totalfl = document.querySelector('input[name="totalfl"]').value;
                const price = document.querySelector('input[name="price"]').value;
                const asize = document.querySelector('input[name="asize"]').value;
                const city = document.querySelector('input[name="city"]').value;
                const loc = document.querySelector('input[name="loc"]').value;

                let errors = [];

                if (title.length < 5)
                    errors.push("Title must be at least 5 characters long.");
                if (isNaN(numberOfRooms) || numberOfRooms < 1 || numberOfRooms > 10)
                    errors.push("Number of rooms must be between 1 and 10.");
                if (isNaN(bath) || bath < 1 || bath > 10)
                    errors.push("Number of bathrooms must be between 1 and 10.");
                if (isNaN(price) || price <= 0)
                    errors.push("Price must be a positive number.");
                if (isNaN(asize) || asize <= 0)
                    errors.push("Area size must be a positive number.");
                if (!city)
                    errors.push("City is required.");
                if (!loc)
                    errors.push("Address is required.");
                if (!floor || !totalfl)
                    errors.push("Floor and total floors are required.");

                if (errors.length > 0) {
                    e.preventDefault();
                    alert(errors.join("\n"));
                }
            });
        </script>
    </body>

</html>