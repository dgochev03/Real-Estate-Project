<?php
session_start();
include("config.php");

$query = "SELECT property.*, user.uname FROM property JOIN user ON property.uid = user.uid WHERE 1=1";

if (isset($_GET['search']) && !empty($_GET['search'])) {
    $search = mysqli_real_escape_string($con, $_GET['search']);
    $query .= " AND property.title LIKE '%$search%'";
}

if (isset($_GET['city']) && !empty($_GET['city'])) {
    $city = mysqli_real_escape_string($con, $_GET['city']);
    $query .= " AND property.city = '$city'";
}

if (isset($_GET['location']) && !empty($_GET['location'])) {
    $location = mysqli_real_escape_string($con, $_GET['location']);
    $query .= " AND property.location = '$location'";
}

if (isset($_GET['floor']) && !empty($_GET['floor'])) {
    $floor = mysqli_real_escape_string($con, $_GET['floor']);
    if ($floor == '4+') {
        $query .= " AND property.floor >= 4";
    } else {
        $query .= " AND property.floor = '$floor'";
    }
}

if (isset($_GET['min_price']) && !empty($_GET['min_price'])) {
    $min_price = mysqli_real_escape_string($con, $_GET['min_price']);
    $query .= " AND property.price >= $min_price";
}

if (isset($_GET['max_price']) && !empty($_GET['max_price'])) {
    $max_price = mysqli_real_escape_string($con, $_GET['max_price']);
    $query .= " AND property.price <= $max_price";
}

if (isset($_GET['property_type']) && !empty($_GET['property_type'])) {
    $property_type = mysqli_real_escape_string($con, $_GET['property_type']);
    $query .= " AND property.type = '$property_type'";
}

if (isset($_GET['type']) && !empty($_GET['type'])) {
    $type = mysqli_real_escape_string($con, $_GET['type']);
    $query .= " AND property.stype = '$type'";
}

if (isset($_GET['sort']) && !empty($_GET['sort'])) {
    switch ($_GET['sort']) {
        case 'price_asc':
            $query .= " ORDER BY property.price ASC";
            break;
        case 'price_desc':
            $query .= " ORDER BY property.price DESC";
            break;
        case 'date_new':
            $query .= " ORDER BY property.date_added DESC";
            break;
        case 'date_old':
            $query .= " ORDER BY property.date_added ASC";
            break;
        default:
            break;
    }
}

$result = mysqli_query($con, $query);
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="shortcut icon" href="images/logo/logo-house.svg">

        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
        <link rel="stylesheet" href="style/property.css">
        <title>Real Estate Portal</title>
    </head>
    <body>
        <?php include("include/header.php"); ?>

        <div class="container-fluid mt-4">
            <div class="row">
                <div class="d-block d-md-none text-center mb-3">
                    <button id="toggle-filter-btn" class="btn btn-primary">
                        <i class="fas fa-filter"></i> Show Filters
                    </button>
                </div>

                <div class="col-md-3" id="filter-section">
                    <div class="card mb-4">
                        <div class="card-body">
                            <h5 class="card-title"><i class="fas fa-filter"></i> Search & Filter</h5>
                            <form method="GET">
                                <div class="form-group">
                                    <label for="search"><i class="fas fa-search"></i> Search by Title</label>
                                    <input type="text" class="form-control" name="search" placeholder="Enter title..." value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
                                </div>
                                <div class="form-group">
                                    <label for="city"><i class="fas fa-city"></i> Filter by City</label>
                                    <select class="form-control" name="city" id="city">
                                        <option value="">All Cities</option>
                                        <?php
                                        $city_query = "SELECT DISTINCT city FROM property ORDER BY city ASC";
                                        $city_result = mysqli_query($con, $city_query);
                                        while ($city_row = mysqli_fetch_array($city_result)) {
                                            $city = $city_row['city'];
                                            $selected = (isset($_GET['city']) && $_GET['city'] == $city) ? 'selected' : '';
                                            echo "<option value='$city' $selected>$city</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="location"><i class="fas fa-map-marker-alt"></i> Filter by Location</label>
                                    <select class="form-control" name="location" id="location">
                                        <option value="">All Locations</option>
                                        <?php
                                        if (isset($_GET['city']) && !empty($_GET['city'])) {
                                            $city = $_GET['city'];
                                            $location_query = "SELECT DISTINCT location FROM property WHERE city = '$city' ORDER BY location ASC";
                                            $location_result = mysqli_query($con, $location_query);
                                            while ($location_row = mysqli_fetch_array($location_result)) {
                                                $location = $location_row['location'];
                                                $selected = (isset($_GET['location']) && $_GET['location'] == $location) ? 'selected' : '';
                                                echo "<option value='$location' $selected>$location</option>";
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="min_price"><i class="fas fa-euro-sign"></i> Minimum Price</label>
                                    <input type="number" class="form-control" name="min_price" placeholder="Enter minimum price" value="<?php echo isset($_GET['min_price']) ? $_GET['min_price'] : ''; ?>">
                                </div>
                                <div class="form-group">
                                    <label for="max_price"><i class="fas fa-euro-sign"></i> Maximum Price</label>
                                    <input type="number" class="form-control" name="max_price" placeholder="Enter maximum price" value="<?php echo isset($_GET['max_price']) ? $_GET['max_price'] : ''; ?>">
                                </div>
                                <div class="form-group">
                                    <label for="floor"><i class="fas fa-building"></i> Filter by Floor</label>
                                    <select class="form-control" name="floor" id="floor">
                                        <option value="">All Floors</option>
                                        <option value="1" <?php if (isset($_GET['floor']) && $_GET['floor'] == '1') echo 'selected'; ?>>1st Floor</option>
                                        <option value="2" <?php if (isset($_GET['floor']) && $_GET['floor'] == '2') echo 'selected'; ?>>2nd Floor</option>
                                        <option value="3" <?php if (isset($_GET['floor']) && $_GET['floor'] == '3') echo 'selected'; ?>>3rd Floor</option>
                                        <option value="4+" <?php if (isset($_GET['floor']) && $_GET['floor'] == '4+') echo 'selected'; ?>>4th Floor and Above</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="property_type"><i class="fas fa-building"></i> Filter by Property Type</label>
                                    <select class="form-control" name="property_type" id="property_type">
                                        <option value="">All Types</option>
                                        <option value="appartment" <?php if (isset($_GET['property_type']) && $_GET['property_type'] == 'apartment') echo 'selected'; ?>>Apartment</option>
                                        <option value="house" <?php if (isset($_GET['property_type']) && $_GET['property_type'] == 'house') echo 'selected'; ?>>House</option>
                                        <option value="commercial" <?php if (isset($_GET['property_type']) && $_GET['property_type'] == 'commercial') echo 'selected'; ?>>Commercial Property</option>
                                        <option value="office" <?php if (isset($_GET['property_type']) && $_GET['property_type'] == 'office') echo 'selected'; ?>>Office</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="type"><i class="fas fa-tag"></i> Filter by Sale or Rent</label>
                                    <select class="form-control" name="type">
                                        <option value="">Filter by sale or rent</option>
                                        <option value="sale" <?php if (isset($_GET['type']) && $_GET['type'] == 'sale') echo 'selected'; ?>>Sale</option>
                                        <option value="rent" <?php if (isset($_GET['type']) && $_GET['type'] == 'rent') echo 'selected'; ?>>Rent</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="sort"><i class="fas fa-sort"></i> Sort By</label>
                                    <select class="form-control" name="sort">
                                        <option value="">Sort By</option>
                                        <option value="price_asc" <?php if (isset($_GET['sort']) && $_GET['sort'] == 'price_asc') echo 'selected'; ?>>Price (Low to High)</option>
                                        <option value="price_desc" <?php if (isset($_GET['sort']) && $_GET['sort'] == 'price_desc') echo 'selected'; ?>>Price (High to Low)</option>
                                        <option value="date_new" <?php if (isset($_GET['sort']) && $_GET['sort'] == 'date_new') echo 'selected'; ?>>Date (Newest)</option>
                                        <option value="date_old" <?php if (isset($_GET['sort']) && $_GET['sort'] == 'date_old') echo 'selected'; ?>>Date (Oldest)</option>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-primary btn-block" id="filterbutton"><i class="fas fa-check"></i> Apply Filters</button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-md-9">
                    <h2 class="mb-4"><i class="fas fa-home"></i> Property Listings</h2>
                    <table class="table table-hover table-bordered">
                        <thead class="thead-light">
                            <tr>
                                <th>Image</th>
                                <th>Title</th>
                                <th>City</th>
                                <th>Location</th>
                                <th>Price</th>
                                <th>Rent/Sale</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            while ($row = mysqli_fetch_array($result)) {
                                $propertyUrl = "propertydetail.php?pid=" . $row['0'];
                                ?>
                                <tr class="clickable-row" data-href="<?php echo $propertyUrl; ?>">
                                    <td>
                                        <img src="images/property/<?php echo $row['12']; ?>" alt="Property Image" class="img-fluid d-block mx-auto">
                                    </td>
                                    <td>
                                        <a href="<?php echo $propertyUrl; ?>" class="property-link"> <?php echo $row['1']; ?> </a>
                                    </td>
                                    <td><?php echo $row['city']; ?></td>
                                    <td><?php echo $row['location']; ?></td>
                                    <td><?php echo $row['9']; ?> EUR</td>
                                    <td><?php echo $row['5']; ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <?php include("include/footer.php"); ?>

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <script>
            $(document).ready(function () {
                $('#city').change(function () {
                    var city = $(this).val();

                    $('#location').html('<option value="">Loading...</option>');

                    if (city) {
                        $.ajax({
                            url: 'fetch_locations.php',
                            type: 'GET',
                            data: {city: city},
                            success: function (response) {
                                $('#location').html(response);
                            },
                            error: function () {
                                $('#location').html('<option value="">Error loading locations</option>');
                            }
                        });
                    } else {
                        $('#location').html('<option value="">All Locations</option>');
                    }
                });
            });
        </script>
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                document.querySelectorAll(".clickable-row").forEach(row => {
                    row.addEventListener("click", function () {
                        window.location = this.dataset.href;
                    });
                });

                const toggleFilterBtn = document.getElementById('toggle-filter-btn');
                const filterSection = document.getElementById('filter-section');

                if (toggleFilterBtn && filterSection) {
                    toggleFilterBtn.addEventListener('click', function () {
                        filterSection.classList.toggle('active');
                        if (filterSection.classList.contains('active')) {
                            toggleFilterBtn.innerHTML = '<i class="fas fa-filter"></i> Hide Filters';
                        } else {
                            toggleFilterBtn.innerHTML = '<i class="fas fa-filter"></i> Show Filters';
                        }
                    });
                }
            });
        </script>
        <script>
            window.onload = function () {
                if (sessionStorage.getItem('autoClickFilter') === 'true') {
                    sessionStorage.removeItem('autoClickFilter');
                    document.getElementById('filterbutton').click();
                }
            };
        </script>
    </body>
</html>