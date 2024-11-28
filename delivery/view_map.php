<?php
ob_start();
include("connect.php");
include '../connection.php';

if ($_SESSION['name'] == '') {
    header("location:deliverylogin.php");
}
$name = $_SESSION['name'];
$city = $_SESSION['city'];
$id = $_SESSION['Did'];

// if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['view_map'])) {
//     $pickup_address = $_GET['pickup_address'] ?? 'Pickup address not found';
//     $delivery_address = $_GET['delivery_address'] ?? 'Delivery address not found';

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['view_map'])) {
    $pickup_address = $_GET['pickup_address'] ?? 'Pickup address not found';
    $delivery_address = $_GET['delivery_address'] ?? 'Delivery address not found';
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['view_map'])) {
    $pickup_address = $_GET['pickup_address'] ?? 'Pickup address not found';
    $delivery_address = $_GET['delivery_address'] ?? 'Delivery address not found';
    $order_id = $_GET['order_id'] ?? null; // Retrieve order ID from the request

    // Update the delivery_by field in the database
    if ($order_id) {
        $sql_update = "UPDATE food_donations SET delivery_by = '$id' WHERE Fid = '$order_id'";
        if (!mysqli_query($connection, $sql_update)) {
            echo "<p style='color: red; text-align: center;'>Failed to update the order status. Please try again.</p>";
        }
    }


    function getCoordinates($address)
    {
        if (!$address) return null;
        $url = "https://nominatim.openstreetmap.org/search?q=" . urlencode($address) . "&format=json&limit=1";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "User-Agent: MyFoodDonationApp/1.0 (email@example.com)"
        ]);

        $response = curl_exec($ch);
        if ($response === false) {
            curl_close($ch);
            return null;
        }

        $data = json_decode($response, true);
        curl_close($ch);

        if (isset($data[0])) {
            return ['lat' => $data[0]['lat'], 'lon' => $data[0]['lon']];
        } else {
            return null;
        }
    }

    $pickup_coords = getCoordinates($pickup_address);
    $delivery_coords = getCoordinates($delivery_address);
}
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Food Delivery Dashboard</title>
    <link rel="stylesheet" href="../home.css">
    <link rel="stylesheet" href="delivery.css">
    <script src="https://cdn.jsdelivr.net/npm/leaflet@1.9.4/dist/leaflet.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet-routing-machine/3.2.12/leaflet-routing-machine.min.js"></script>
</head>

<body>
    <header>
        <div class="logo">Sustain <b style="color: #06C167;">Bite</b></div>
        <nav class="nav-bar">
            <ul>
                <li><a href="#home" class="active">Home</a></li>
                <li><a href="openmap.php">Map</a></li>
                <li><a href="deliverymyord.php">My Orders</a></li>
                <li><a href="logout.php">Log out</a></li>
            </ul>
        </nav>
    </header>
    <h2 style="margin-top: 20px; text-align: center;">Hold tight! The food hero is rolling in.</h2>


    <?php if (isset($pickup_coords) && isset($delivery_coords)): ?>
        <div id="map" style="height: 500px; width: 80%; margin: 20px auto;"></div>
        
		<style>
    /* Move directions panel to the bottom-right corner and make it transparent */
    .leaflet-routing-container {
        position: absolute !important;
        bottom: 10px !important;
        right: 10px !important;
        background: rgba(255, 255, 255, 0.7) !important; /* Transparent white background */
        border-radius: 8px; /* Rounded corners */
        padding: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3); /* Subtle shadow */
        max-height: 300px; /* Limit the height */
        overflow-y: auto; /* Enable scroll for overflow */
        z-index: 1000; /* Ensure it stays above map */
        width: 300px; /* Set the width of the directions panel */
    }

    /* Optional: Style the table and text inside directions panel */
    .leaflet-routing-container table {
        font-size: 14px; /* Adjust font size for readability */
    }
</style>
		<script>
            var map = L.map('map').setView([<?= $pickup_coords['lat'] ?>, <?= $pickup_coords['lon'] ?>], 14);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
            }).addTo(map);

            L.marker([<?= $pickup_coords['lat'] ?>, <?= $pickup_coords['lon'] ?>]).addTo(map)
                .bindPopup("Pickup Address: <?= htmlspecialchars($pickup_address) ?>").openPopup();

            L.marker([<?= $delivery_coords['lat'] ?>, <?= $delivery_coords['lon'] ?>]).addTo(map)
                .bindPopup("Delivery Address: <?= htmlspecialchars($delivery_address) ?>").openPopup();

            L.Routing.control({
                waypoints: [
                    L.latLng(<?= $pickup_coords['lat'] ?>, <?= $pickup_coords['lon'] ?>),
                    L.latLng(<?= $delivery_coords['lat'] ?>, <?= $delivery_coords['lon'] ?>)
                ],
                routeWhileDragging: true,
                createMarker: function() { return null; },
                lineOptions: {
                    styles: [{ color: 'blue', weight: 4, opacity: 0.7 }]
                }
            }).addTo(map);
        </script>
    <?php endif; ?>

    <div class="table-container">
	<table class="table">
            <!-- <thead>
                <tr>
                    <th>Name</th>
                    <th>Phone</th>
                    <th>Date</th>
                    <th>Pickup Address</th>
                    <th>Delivery Address</th>
                    <th>Action</th>
                </tr>
            </thead> -->
            <tbody>
                <?php
                $sql = "SELECT 
                            fd.Fid AS Fid, fd.location AS cure, fd.name, fd.phoneno, fd.date, fd.delivery_by, fd.address AS From_address, 
                            ad.name AS delivery_person_name, ad.address AS To_address
                        FROM food_donations fd
                        LEFT JOIN admin ad ON fd.assigned_to = ad.Aid
                        WHERE assigned_to IS NOT NULL AND delivery_by IS NULL";
                $result = mysqli_query($connection, $sql);

                while ($row = mysqli_fetch_assoc($result)): ?>
                    <!-- <tr> -->
                        <!-- <td><?= htmlspecialchars($row['name']) ?></td>
                        <td><?= htmlspecialchars($row['phoneno']) ?></td>
                        <td><?= htmlspecialchars($row['date']) ?></td>
                        <td><?= htmlspecialchars($row['From_address']) ?></td>
                        <td><?= htmlspecialchars($row['To_address']) ?></td>
                        <td>
						<form method="get" action=" ">
                       <input type="hidden" name="order_id" value="<?= $row['Fid'] ?>">
			           <input type="hidden" name="delivery_person_id" value="<?= $id ?>">
			           <input type="hidden" name="pickup_address" value="<?= htmlspecialchars($row['From_address']) ?>">
                       <input type="hidden" name="delivery_address" value="<?= htmlspecialchars($row['To_address']) ?>">           
                       <button type="submit" name="view_map">Take Order</button>  -->
                    <!-- </form> -->
                        <!-- </td> -->
                    <!-- </tr> -->
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>

</html>
