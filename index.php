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
        </section>

        <?php include("include/footer.php"); ?>
    </body>
</html>

