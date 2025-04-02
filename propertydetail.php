<?php
session_start();
include("config.php");
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="Real Estate Portal">
        <link rel="shortcut icon" href="images/logo/logo-house.svg">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
        <link rel="stylesheet" href="style/propertydetail.css">
        <title>Real Estate Portal</title>
    </head>
    <body>

        <div id="page-wrapper">
            <?php include("include/header.php"); ?>

            <div class="container mt-4">
                <?php
                $id = $_REQUEST['pid'];
                $query = mysqli_query($con, "SELECT property.*, user.* FROM property JOIN user ON property.uid = user.uid WHERE pid='$id'");
                $row = mysqli_fetch_array($query);
                ?>

                <div class="property-details">
                    <div class="status">For <?php echo $row['5']; ?></div>
                    <h3 class="mt-3"><?php echo $row['1']; ?></h3>

                    <div class="property-images">
                        <div class="slide"><img src="images/property/<?php echo $row['12']; ?>" alt="Property Image" /></div>
                        <div class="slide"><img src="images/property/<?php echo $row['13']; ?>" alt="Property Image" /></div>
                        <div class="slide"><img src="images/property/<?php echo $row['14']; ?>" alt="Property Image" /></div>
                        <div class="slide"><img src="images/property/<?php echo $row['15']; ?>" alt="Property Image" /></div>
                        <div class="slide"><img src="images/property/<?php echo $row['16']; ?>" alt="Property Image" /></div>

                    </div>

                    <ul class="list-unstyled">
                        <h5>
                            <li class="property-info"><i class="fas fa-map-marker-alt"></i> <?php echo $row['11'] . ", " . $row['10']; ?></li>
                        </h5><h5>
                            <li class="property-info"><i class="fas fa-euro-sign"></i> Number of rooms: <?php echo $row['9']; ?> EUR</li>
                        </h5>
                    </ul>
                    <h4>Description</h4>
                    <p><?php echo $row['2']; ?></p>

                    <h4>Summary</h4>
                    <ul class="list-unstyled">
                        <li class="property-info"><i class="fas fa-ruler-combined"></i> Size: <?php echo $row['8']; ?> sq.m.</li>
                        <li class="property-info"><i class="fas fa-bed"></i> Number of rooms: <?php echo $row['4']; ?></li>
                        <li class="property-info"><i class="fas fa-bath"></i> Number of bathrooms: <?php echo $row['6']; ?></li>
                        <li class="property-info"><i class="fas fa-building"></i> Property Type: <?php echo $row['3']; ?></li>
                        <li class="property-info"><i class="fas fa-layer-group"></i> Floor: <?php echo $row['7']; ?></li>
                        <li class="property-info"><i class="fas fa-layer-group"></i> Total Floor: <?php echo $row['18']; ?></li>
                        <li class="property-info"><i class="fas fa-city"></i> City: <?php echo $row['11']; ?></li>
                        <li class="property-info"><i class="fas fa-calendar-alt"></i> Published: <?php echo $row['19']; ?></li>
                    </ul>

                    <h4>Contact <?php
                        if ($row['utype'] == "user")
                            echo "private seller";
                        else
                            echo "agent";
                        ?></h4>
                    <div class="agent">
                        <h6 class="card-title"><?php echo $row['uname']; ?></h6>
                        <p class="card-text">tel: <?php echo $row['uphone']; ?><br>email: <?php echo $row['uemail']; ?></p>
                    </div>
                </div>
            </div>
            <?php include("include/footer.php"); ?>
        </div>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    </body>
</html>