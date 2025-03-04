<?php
ini_set('session.cache_limiter', 'public');
session_cache_limiter(false);
session_start();
include("config.php");
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <link rel="stylesheet" href="style/index.css">
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="shortcut icon" href="images/logo/logo-house.svg">
        <title>Real Estate Portal</title>
    </head>
    <body>
        <?php include("include/header.php"); ?>

        <section class="banner" style="background-image: url('images/banner/04.jpg');">
            <div class="container">
                <h1><span class="highlight">Find</span><br>your new home</h1>
                <form method="post" action="propertygrid.php">
                    <label for="type">Select Type</label>
                    <select name="type" required>
                        <option value="">Select Type</option>
                        <option value="appartment">Appartment</option>
                        <option value="house">House</option>
                        <option value="commercial property">Commercial property</option>
                        <option value="office">Office</option>
                    </select>
                    <label for="stype">Sale/Rent</label>
                    <select name="stype" required>
                        <option value="rent">Rent</option>
                        <option value="sale">Sale</option>
                    </select>
                    <input type="text" name="city" placeholder="Enter city" required>
                    <button type="submit" name="filter"><b>Search Property</b></button>
                </form>
            </div>
        </section>

        <section class="recent-properties">
            <div class="container">
                <h2>Recent Property</h2>
                <div class="property-list">
                    <?php
                    $query = mysqli_query($con, "SELECT property.*, user.uname, user.utype FROM property, user WHERE property.uid = user.uid ORDER BY date DESC LIMIT 9");
                    while ($row = mysqli_fetch_array($query)) {
                        ?>

                        <article class="property-item">
                            <img src="images/property/<?php echo $row['12']; ?>" alt="property image">
                            <div class="property-info">
                                <h3><a id="linkstoads" href="propertydetail.php?pid=<?php echo $row['0']; ?>"><?php echo $row['1']; ?></a></h3>
                                <p><?php echo $row['11']; ?></p>
                                <ul>
                                    <li> For <?php echo $row['5']; ?></li>
                                    <li><?php echo $row['8']; ?> Sq.m.</li>
                                    <li><?php echo $row['7']; ?> Floor</li>
                                </ul>
                                <div class="meta">
                                    <span>By: <?php echo $row['uname']; ?></span>
                                    <span><?php echo $row['9']; ?>  EUR</span>
                                </div>
                            </div>
                        </article>
                    <?php } ?>
                </div>
            </div>
        </section>

        <?php include("include/footer.php"); ?>
    </body>
</html>

