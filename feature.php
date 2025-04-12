<?php
ini_set('session.cache_limiter', 'public');
session_cache_limiter(false);
session_start();
include("config.php");

if (!isset($_SESSION['uemail'])) {
    header("location:login.php");
}
?>
<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="shortcut icon" href="images/logo/logo-house.svg">
        <link rel="stylesheet" href="style/feature.css">
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
        <title>Real Estate Portal</title>
    </head>

    <body>
        <?php include("include/header.php"); ?>
        <div class="container mt-5">
            <div class="title text-center mb-4">
                <h2>User Listed Property</h2>
                <?php
                if (isset($_GET['msg'])) {
                    echo '<div class="alert alert-success">' . $_GET['msg'] . '</div>';
                } else if (isset($_GET['error'])) {
                    echo '<div class="alert alert-danger">' . $_GET['error'] . '</div>';
                }
                ?>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="thead-dark">
                        <tr>
                            <th>Properties</th>
                            <th>Type</th>
                            <th>Added Date</th>
                            <th>Rent/Sale</th>
                            <th>Update</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $uid = $_SESSION['uid'];
                        $query = mysqli_query($con, "SELECT * FROM `property` WHERE uid='$uid'");

                        while ($row = mysqli_fetch_array($query)) {
                            ?>
                            <tr>
                                <td class="d-block d-md-table-cell">
                                    <img src="images/property/<?php echo htmlspecialchars($row['12']); ?>" alt="Property Image" class="img-fluid" style="max-width: 380px; height: auto;">
                                    <div class="property-info mt-2">
                                        <h5 class="text-secondary">
                                            <a href="propertydetail.php?pid=<?php echo $row['0']; ?>"><?php echo htmlspecialchars($row['1']); ?></a>
                                        </h5>
                                        <span>
                                            <?php echo htmlspecialchars($row['11']); ?>
                                        </span>
                                        <div class="price">
                                            <span>$<?php echo htmlspecialchars($row['9']); ?> EUR</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="d-block d-md-table-cell"><?php echo htmlspecialchars($row['3']); ?></td>
                                <td class="d-block d-md-table-cell"><?php echo htmlspecialchars($row['19']); ?></td>
                                <td class="d-block d-md-table-cell">For <?php echo htmlspecialchars($row['5']); ?></td>
                                <td class="d-block d-md-table-cell">
                                    <a class="btn btn-primary btn-sm" href="submitpropertyupdate.php?id=<?php echo $row['0']; ?>">Update</a>
                                </td>
                                <td class="d-block d-md-table-cell">
                                    <a class="btn btn-danger btn-sm" href="submitpropertydelete.php?id=<?php echo $row['0']; ?>" onclick="return confirm('Are you sure you want to delete this ad?');">Delete</a>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>

        <?php include("include/footer.php"); ?>

        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    </body>

</html>