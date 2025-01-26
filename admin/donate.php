
<?php
// $connection = mysqli_connect("localhost:3307", "root", "");
// $db = mysqli_select_db($connection, 'demo');
include "../connection.php";
include("connect.php"); 
if($_SESSION['name']==''){
	header("location:signin.php");
}
?>

<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    
    <!----======== CSS ======== -->
    <link rel="stylesheet" href="admin.css">
     
    <!----===== Iconscout CSS ===== -->
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">

    <title>Admin Dashboard Panel</title> 
    
<?php
 $connection=mysqli_connect("localhost","root","Ram1234*");
 $db=mysqli_select_db($connection,'fooddonation');
 


?>
</head>
<body>
    <nav>
        <div class="logo-name">
            <div class="logo-image">
                <!--<img src="images/logo.png" alt="">-->
            </div>

            <span class="logo_name"></span>
        </div>

        <div class="menu-items">
            <ul class="nav-links">
                <li><a href="admin.php">
                    <i class="uil uil-estate"></i>
                    <span class="link-name">Dahsboard</span>
                </a></li>
                <!-- <li><a href="#">
                    <i class="uil uil-files-landscapes"></i>
                    <span class="link-name">Content</span>
                </a></li> -->
                <!--<li><a href="analytics.php"> -->
                    <!-- <i class="uil uil-chart"></i> -->
                    <!-- <span class="link-name">Analytics</span> -->
                </a></li>
                <li><a href="#">
                    <i class="uil uil-heart"></i>
                    <span class="link-name">Donates</span>
                </a></li>
                <!--<li><a href="feedback.php">
                    <i class="uil uil-comments"></i>
                    <span class="link-name">Feedbacks</span>
                </a></li>
                <li><a href="adminprofile.php">
                    <i class="uil uil-user"></i>
                    <span class="link-name">History</span>
                </a></li>
                    <li><a href="#">
                    <i class="uil uil-share"></i>
                    <span class="link-name">Share</span>
                </a></li> -->
            </ul>
            
            <ul class="logout-mode">
                <li><a href="../logout.php">
                    <i class="uil uil-signout"></i>
                    <span class="link-name">Logout</span>
                </a></li>

                <li class="mode">
                    <a href="#">
                        <i class="uil uil-moon"></i>
                    <span class="link-name">Dark Mode</span>
                </a>

                <div class="mode-toggle">
                  <span class="switch"></span>
                </div>
            </li>
            </ul>
        </div>
    </nav>

    <section class="dashboard">
        
        <div class="top">
            <i class="uil uil-bars sidebar-toggle"></i>
            <!-- <p>Food Donate</p> -->
            <p  class ="logo" ><b style="color: #06C167; ">SustainBite</b></p>
             <p class="user"></p>
            <!-- <div class="search-box">
                <i class="uil uil-search"></i>
                <input type="text" placeholder="Search here...">
            </div> -->
            
            <!--<img src="images/profile.jpg" alt="">-->
        </div>
        <br>
        <br>
        <br>
    
  

            <div class="activity">
               
            <div class="location">
                <!-- <p class="logo">Filter by Location</p> -->
          <form method="post">
             <label for="location" class="logo">Select a donor:</label>
             <!-- <br> -->
             <input type="email" id="location" name="email" placeholder="Enter an email" required />

            

        
            </select>
                <input type="submit" value="Get Details">
         </form>
         <br>

         <?php
    // Get the selected email from the form
    if(isset($_POST['email'])) {
      $email = $_POST['email'];
      // Query the database for people in the selected email

       $sql = "SELECT * FROM food_donations WHERE email='$email'";
    $result = mysqli_query($connection, $sql);

    // Check if the query was successful
    if ($result) {
        // Check if there are any rows
        if (mysqli_num_rows($result) > 0) {
            // Start the table HTML structure
            echo "<div class=\"table-container\">";
            echo "    <div class=\"table-wrapper\">";
            echo "        <table class=\"table\">";
            echo "            <thead>";
            echo "                <tr>
                                    <th>Name</th>
                                    <th>Food</th>
                                    <th>Category</th>
                                    <th>Phone No</th>
                                    <th>Date/Time</th>
                                    <th>Address</th>
                                    <th>Quantity</th>
                                    <th>Status</th>
                                </tr>";
            echo "            </thead>";
            echo "            <tbody>";

            // Fetch and display rows
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>
                        <td data-label=\"Name\">" . htmlspecialchars($row['name']) . "</td>
                        <td data-label=\"Food\">" . htmlspecialchars($row['food']) . "</td>
                        <td data-label=\"Category\">" . htmlspecialchars($row['category']) . "</td>
                        <td data-label=\"Phone No\">" . htmlspecialchars($row['phoneno']) . "</td>
                        <td data-label=\"Date/Time\">" . htmlspecialchars($row['date']) . "</td>
                        <td data-label=\"Address\">" . htmlspecialchars($row['address']) . "</td>
                        <td data-label=\"Quantity\">" . htmlspecialchars($row['quantity']) . "</td>
                        <td data-label=\"Status\">" . htmlspecialchars($row['donation_status']) . "</td>
                      </tr>";
            }

            // End the table
            echo "            </tbody>";
            echo "        </table>";
            echo "    </div>";
            echo "</div>";
        } else {
            // No rows found
            echo "<p>No results found.</p>";
        }
    } else {
        // Query error
        echo "<p>Error executing query: " . mysqli_error($connection) . "</p>";
    }
}

  ?>
 </div>

 

            
            </div>
    </section>

    <script src="admin.js"></script>
</body>
</html>
