<?php
include("config.php");

if (isset($_GET['city'])) {
    $city = $_GET['city'];
    $query = "SELECT DISTINCT location FROM property WHERE city = '$city' ORDER BY location ASC";
    $result = mysqli_query($con, $query);

    $options = '<option value="">All Locations</option>';
    while ($row = mysqli_fetch_array($result)) {
        $location = $row['location'];
        $options .= "<option value='$location'>$location</option>";
    }
    echo $options;
}
?>

