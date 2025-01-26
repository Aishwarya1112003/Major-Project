
<?php
ob_start();
// session_start(); // Make sure the session is started
include("connect.php"); 
if($_SESSION['name']==''){
    header("location:signin.php");
    exit();
}

// session_start();

// Fetch admin details from session
$admin_email = $_SESSION['email'];  // Email is stored in session
$admin_name = $_SESSION['name'];  // Admin name is also stored in session

// Database connection
$connection = mysqli_connect("localhost", "root", "Ram1234*");
$db = mysqli_select_db($connection, 'fooddonation');

// Query to fetch the delivery address using the admin's email
$delivery_address = "";
$query = "SELECT address FROM admin WHERE email = '$admin_email'"; // Replace 'delivery_table' with your table name
$result = mysqli_query($connection, $query);
if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $delivery_address = $row['address'];
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
                <li><a href="#">
                    <i class="uil uil-estate"></i>
                    <span class="link-name">Dashboard</span>
                </a></li>
                <!-- <li><a href="#">
                    <i class="uil uil-files-landscapes"></i>
                    <span class="link-name">Content</span>
                </a></li> -->
                <!-- <li><a href="analytics.php">
                    <i class="uil uil-chart"></i>
                    <span class="link-name">Analytics</span> -->

                </a></li>
                <li><a href="donate.php">
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

        <div class="dash-content">
           <!-- <div class="overview">
                <div class="title">
                    <i class="uil uil-tachometer-fast-alt"></i>
                    <span class="text">Dashboard</span>
                </div>

                <div class="boxes">
                    <div class="box box1">
                        <i class="uil uil-user"></i>
                         <i class="fa-solid fa-user"></i>
                        <span class="text">Total users</span>
                        <?php
                           $query="SELECT count(*) as count FROM  login";
                           $result=mysqli_query($connection, $query);
                           $row=mysqli_fetch_assoc($result);
                         echo "<span class=\"number\">".$row['count']."</span>";
                        ?>
                        <span class="number">50,120</span>
                    </div>
                    <div class="box box2">
                        <i class="uil uil-comments"></i>
                        <span class="text">Feedbacks</span>
                        <?php
                           $query="SELECT count(*) as count FROM  user_feedback";
                           $result=mysqli_query($connection, $query);
                           $row=mysqli_fetch_assoc($result);
                         echo "<span class=\"number\">".$row['count']."</span>";
                        ?>
                        <span class="number">20,120</span>
                    </div>
                    <div class="box box3">
                        <i class="uil uil-heart"></i>
                        <span class="text">Total donates</span>
                        <?php
                           $query="SELECT count(*) as count FROM food_donations";
                           $result=mysqli_query($connection, $query);
                           $row=mysqli_fetch_assoc($result);
                         echo "<span class=\"number\">".$row['count']."</span>";
                        ?>
                        <span class="number">10,120</span> 
                    </div>
                </div>
            </div>-->

            <div class="activity">
                <div class="title">
                    <i class="uil uil-clock-three"></i>
                    <span class="text">Recent Donations</span>
                </div>
            <div class="get">
            <?php

$loc= $_SESSION['location'];

// Define the SQL query to fetch unassigned orders
$id=$_SESSION['Aid'];
$_SESSION['admin_id'] = $id;
$sql = "SELECT * ,
        DATE_FORMAT(created_at, '%Y-%m-%d %H:%i:%s') AS date,
        (expiry_hours - TIMESTAMPDIFF(HOUR, created_at, NOW())) AS remaining_time
        FROM food_donations 
        WHERE (status = 'active' AND assigned_to is null) OR (status = 'active' AND assigned_to = $id) OR (status = 'canceled' AND assigned_to != $id)  and is_expired = FALSE ORDER BY remaining_time Desc";


// Execute the query
$result=mysqli_query($connection, $sql);
if (!$result) {
    die("SQL Error: " . $connection->error);
}


// Check for errors
if (!$result) {
    die("Error executing query: " . mysqli_error($conn));
}

// Fetch the data as an associative array
$data = array();
while ($row = mysqli_fetch_assoc($result)) {
    $row['remaining_time'] = max($row['remaining_time'], 0); // Ensure no negative remaining time
    $data[] = $row;
}

// If the delivery person has taken an order, update the assigned_to field in the database
if (isset($_POST['food'])) {
    $order_id = $_POST['order_id']; // ID of the donation
    $admin_id = $_POST['delivery_person_id']; // Admin ID from session
    
    // Update query to assign the donation and set status to 'active'
    $update_query = "UPDATE food_donations 
                     SET status = 'active', assigned_to = $admin_id, donation_status = 'Accepted by NGO'
                     WHERE Fid = $order_id";
    
    $update_result = mysqli_query($connection, $update_query);
    
    if ($update_result) {
        echo "<script>alert('Food donation assigned successfully!');</script>";
        // Reload the page to show updated data
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit();
    } else {
        echo "<script>alert('Error assigning the donation.');</script>";
    }

    // Reload the page to prevent duplicate assignments
    header('Location: ' . $_SERVER['REQUEST_URI']);
    // exit;
    ob_end_flush();
}
// mysqli_close($conn);


?>

<!-- Display the orders in an HTML table -->
<div class="table-container">
         <!-- <p id="heading">donated</p> -->
         <div class="table-wrapper">
        <table class="table">
        <thead>
        <tr>
            <th >Name</th>
            <th>food</th>
            <th>Category</th>
            <th>phoneno</th>
            <th>date/time</th>
            <th>address</th>
            <th>Quantity</th>
            <th>Donation Status </th>
            <th>Expiring In</th>
            <th>Donation Status</th>
            <!-- <th>Action</th> -->
         
          
           
        </tr>
        </thead>
       <tbody>

        <?php 
foreach ($data as $row) { 
    $remaining_seconds = max(0, $row['remaining_time'] * 3600); // Convert hours to seconds
?>
        <tr>
    <td data-label="Name"><?= htmlspecialchars($row['name']); ?></td>
    <td data-label="Food"><?= htmlspecialchars($row['food']); ?></td>
    <td data-label="Category"><?= htmlspecialchars($row['category']); ?></td>
    <td data-label="Phone No"><?= htmlspecialchars($row['phoneno']); ?></td>
    <td data-label="Date/Time"><?= htmlspecialchars($row['date']); ?></td>
    <td data-label="Address"><?= htmlspecialchars($row['address']); ?></td>
    <td data-label="Quantity"><?= htmlspecialchars($row['quantity']); ?></td>
    <td data-label="Donation Status"><?= htmlspecialchars($row['donation_status']); ?></td>
    <td data-label="Expiring In">
        <!--<span class="timer" data-remaining-time="<?= $remaining_seconds ?>"></span>-->
        <!--<div class="timer" data-item-id=Fid data-remaining-time="<?= $remaining_seconds ?>"></div>-->
        <div class="timer" data-item-id="<?= $row['Fid'] ?>" data-remaining-time="<?= $remaining_seconds ?>"></div>


    </td>
        
            <!-- <td><?= $row['Fid'] ?></td>
            <td><?= $row['name'] ?></td>
            <td><?= $row['address'] ?></td> -->
            <td data-label="Action" style="margin:auto">
                <?php if (($row['status'] == 'active' && $row['assigned_to'] == null) || ($row['status'] == 'canceled' && $row['assigned_to'] != $id)) { ?>
                    <form method="post" action="admin.php" style="display:inline;">
                    <input type="hidden" name="id" value="<?= $row['Fid'] ?>"> <!-- Hidden input to pass row ID -->
                    <input type="hidden" name="order_id" value="<?= $row['Fid'] ?>">
                    <input type="hidden" name="delivery_person_id" value="<?= $id ?>">
                    <input type="hidden" name="donation_address" value="<?= $row['address'] ?>"> <!-- Donation Address -->
                    <button type="submit" name="food">Get Food</button>
                    </form>
                    <form method="post" action="delete.php" style="display:inline;">
                        <input type="hidden" name="order_id" value="<?= $row['Fid'] ?>"> <!-- Hidden input to pass row ID -->
                        <button type="submit" name="cancel" style="background-color: red; color: white;">Cancel Food</button>
                    </form>
                <?php } else if ($row['assigned_to'] == $id && $row['status'] == 'active') { ?>
                    Order assigned to you
                    <!-- <form method="POST" action="update_status.php">
                        <input type="hidden" name="fid" value="<?php echo $row['fid']; ?>">
                        <select name="donation_status">
                            <option value="Pending" <?php if($row['donation_status'] == 'Pending') echo 'selected'; ?>>Pending</option>
                            <option value="Assigned to NGO" <?php if($row['donation_status'] == 'Assigned to NGO') echo 'selected'; ?>>Assigned to NGO</option>
                            <option value="Pickup Scheduled" <?php if($row['donation_status'] == 'Pickup Scheduled') echo 'selected'; ?>>Pickup Scheduled</option>
                            <option value="Picked Up" <?php if($row['donation_status'] == 'Picked Up') echo 'selected'; ?>>Picked Up</option>
                            <option value="Delivered to Needy" <?php if($row['donation_status'] == 'Delivered to Needy') echo 'selected'; ?>>Delivered to Needy</option>
                        </select>
                        <button type="submit">Update</button>
                    </form> -->
                    <form method="get" action="map_view.php" style="display:inline;">
                    <input type="hidden" name="donation_address" value="<?= urlencode($row['address']) ?>">
                    <input type="hidden" name="delivery_address" value="<?= urlencode($delivery_address) ?>"> <!-- Replace $delivery_address with correct session/variable -->
                    <input type="hidden" name="order_id" value="<?= $row['Fid'] ?>">
                    <button type="submit" id="mapButton_<?php echo $row['Fid']; ?>">Map</button>
</form>
        </form>
                <?php } else { ?>
                    Order assigned to another delivery person
                <?php } ?>
            </td>
        </tr>
        <?php } ?>
    </tbody>
</table>

            </div>

        

 
<!-- 
                <div class="table-container">
         <p id="heading">donated</p>
         <div class="table-wrapper">
        <table class="table">
        <thead>
        <tr>
            <th >Name</th>
            <th>food</th>
            <th>Category</th>
            <th>phoneno</th>
            <th>date/time</th>
            <th>address</th>
            <th>Quantity</th>
            <th>Status</th>
          
           
        </tr>
        </thead>
       <tbody>
   
         <?php
        $loc=$_SESSION['location'];
        $query="select * from food_donations where location='$loc' ";
        $result=mysqli_query($connection, $query);
        if($result==true){
            while($row=mysqli_fetch_assoc($result)){
                echo "<tr><td data-label=\"name\">".$row['name']."</td><td data-label=\"food\">".$row['food']."</td><td data-label=\"category\">".$row['category']."</td><td data-label=\"phoneno\">".$row['phoneno']."</td><td data-label=\"date\">".$row['date']."</td><td data-label=\"Address\">".$row['address']."</td><td data-label=\"quantity\">".$row['quantity']."</td><td  data-label=\"Status\" >".$row['quantity']."</td></tr>";

             }
            
          }
          else{
            echo "<p>No results found.</p>";
         }
    
       ?> 
    
        </tbody>
    </table>
         </div>
                </div>
                
          -->
            
        </div>
    </section>

    <script src="admin.js"></script>
    <script>
    document.addEventListener("DOMContentLoaded", function () {
        // Select all timers
        const timers = document.querySelectorAll(".timer");

        timers.forEach((timer, index) => {
            const itemId = timer.getAttribute("data-item-id");//new
            const timerKey = `expirationTimer_${index}`; // Unique key for each timer
            const initialRemainingTime = parseInt(timer.getAttribute("data-remaining-time"), 10);

            // Calculate expiration time and save it in localStorage if not already set
            let expirationTime = localStorage.getItem(timerKey);
            if (!expirationTime) {
                expirationTime = Date.now() + initialRemainingTime * 1000;
                localStorage.setItem(timerKey, expirationTime);
            }
 
            const interval = setInterval(() => {
                const remainingTime = Math.floor((expirationTime - Date.now()) / 1000);

                if (remainingTime <= 0) {
                    clearInterval(interval);
                    timer.innerHTML = "<span style='color: red;'>Expired</span>";
                    console.log("hello");
                    updateExpirationStatus(itemId);
                    localStorage.removeItem(timerKey); // Clean up expired timer
                } else {
                    // Calculate hours, minutes, and seconds
                    const hours = Math.floor(remainingTime / 3600);
                    const minutes = Math.floor((remainingTime % 3600) / 60);
                    const seconds = remainingTime % 60;

                    // Display the formatted time
                    timer.textContent = `${hours}h ${minutes}m ${seconds}s`;
                }
            }, 1000);
        });
    });
    function updateExpirationStatus(itemId) {
    console.log(itemId)
        console.log("working");
        const xhr = new XMLHttpRequest();
        xhr.open("POST", "/major-project/admin/updateExpirationStatus.php", true); // Your backend endpoint to handle the update
        xhr.setRequestHeader("Content-Type", "application/json");
        xhr.onload = function () {
            if (xhr.status === 200) {
                console.log("Expiration status updated successfully.");
            } else {
                console.error("Failed to update expiration status.");
            }
        };
        xhr.send(JSON.stringify({ itemId: itemId, isExpired: true }));
    }
</script>   

</body>
</html>
