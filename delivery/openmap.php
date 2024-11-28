<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Display Juhu Beach Location on Map</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css"
    integrity="sha256-kLaT2GOSpHechhsozzB+flnD+zUyjE2LlfWPgU04xyI=" crossorigin=""/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/leaflet.min.js"></script>
    <link rel="stylesheet" href="../home.css">
    <style>
      @import url('https://fonts.googleapis.com/css?family=Poppins:400,500,600,700&display=swap');
   
      /* Add some basic styling to the map container */
      #map-container {
        width: auto;
        height: 300px;
        margin:auto;
        margin:10px 20px 10px 20px;
        z-index: 2;
      }
      #contain{
        font-family: 'Poppins', sans-serif;
        margin: auto;
        align-items: center;
        text-align: center;
      }
      .nav-bar a{
        background:#06C167;
      }
      @media screen and (max-width: 600px) {
        #map-container {
          height: 200px;
        }
      }
    </style>
</head>
<body>
    <header>
        <div class="logo">Sustain <b style="color: #06C167;">Bite</b></div>
        <div class="hamburger">
            <div class="line"></div>
            <div class="line"></div>
            <div class="line"></div>
        </div>
        <nav class="nav-bar">
            <ul>
                <li><a href="delivery.php">Home</a></li>
                <li><a href="#" class="active">Map</a></li>
                <li><a href="deliverymyord.php">My Orders</a></li>
                <li><a href="logout.php">Log out</a></li>
            </ul>
        </nav>
    </header>
    <br>
    <script>
        hamburger=document.querySelector(".hamburger");
        hamburger.onclick = function(){
            navBar=document.querySelector(".nav-bar");
            navBar.classList.toggle("active");
        }
    </script>

    <div id="contain">
        <h3>Current Location</h3>
        <div id="map-container"></div>
        <div id="address"></div>
        <br>
    </div>

    <!-- LeafletJS map and JavaScript code -->
    <script>
        function initMap() {
            // Coordinates for Juhu Beach near SNDT University
            var userLocation = {
                lat: 19.0810,  // Juhu Beach latitude
                lng: 72.8347   // Juhu Beach longitude
            };

            // Initialize the map centered on Juhu Beach
            var map = L.map('map-container').setView(userLocation, 15);

            // Add OpenStreetMap tile layer to the map
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors',
                maxZoom: 18,
                tileSize: 512,
                zoomOffset: -1
            }).addTo(map);

            // Add a marker for Juhu Beach
            var marker = L.marker(userLocation).addTo(map);
            marker.bindPopup("<b>You are here!</b>").openPopup();

            // Display the address for Juhu Beach
            document.getElementById('address').innerText = `You are at SNDT University, Mumabi, near Juhu Beach`;
        }

        // Call initMap on page load
        initMap();
    </script>
</body>
</html>
