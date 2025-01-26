<?php
require_once('api_config.php'); // Include the API key configuration
include('connect.php'); // Database connection

require_once '../phpmailer/src/Exception.php';
require_once '../phpmailer/src/PHPMailer.php';
require_once '../phpmailer/src/SMTP.php';

if (isset($_POST['order_id'])) {
    $order_id = $_POST['order_id'];

    // Debugging: check if the order_id is being passed correctly
    echo "Received order_id: " . htmlspecialchars($order_id);
    
    // Check if order_id is valid and not empty
    if (!empty($order_id)) {
        // Update the donation status to 'canceled' in the database
        $query = "UPDATE food_donations SET donation_status='Pickup Today' WHERE fid = $order_id";
        // Execute the query
        $result = mysqli_query($connection, $query);
        

        // Check if the query was successful
        if ($result) {
            $emailQuery = "SELECT email, food, category, quantity, donation_status FROM food_donations WHERE fid = '$order_id'";
            $emailResult = mysqli_query($connection, $emailQuery);
        
            if ($emailResult && mysqli_num_rows($emailResult) > 0) {
                $row = mysqli_fetch_assoc($emailResult);
                $donorEmail = $row['email'];
                $food = $row['food'];
                $category = $row['category'];
                $quantity = $row['quantity'];
                $donationStatus = $row['donation_status'];
        
                echo "Donor email: " . $donorEmail . "<br>";
        
                // Send email notification to donor
                $mail = new PHPMailer\PHPMailer\PHPMailer();
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'sustainbite.donatefood@gmail.com'; 
                $mail->Password = 'yiqv kbbc ktyh niss'; 
                $mail->SMTPSecure = PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;
        
                $mail->setFrom('sustainbite.donatefood@gmail.com', 'Food Donation System');
                $mail->addAddress($donorEmail);
        
                // Email content
                $mail->isHTML(true);
                $mail->Subject = 'Pickup Today';
                $mail->Body    = "
                    <h3>Pickup Donation Details</h3>
                    <p>Pickup of your food donation will be done today. Here are the details:</p>
                    <p><strong>Food:</strong> $food</p>
                    <p><strong>Category:</strong> $category</p>
                    <p><strong>Quantity:</strong> $quantity</p>
                    <p><strong>Status:</strong> $donationStatus</p>
                    <p>The order will be picked up between 9am - 11pm.</p>
                ";
        
                if ($mail->send()) {
                    echo "Email notification sent successfully.<br>";
                    header("Location: admin.php"); // Redirect back to your page (change the URL as needed)
                    exit;
                } else {
                    echo "Error sending email: " . $mail->ErrorInfo;
                }
            } else {
                echo "Error fetching donor email or donation details.<br>";
            }
            
        } else {
            // Show an error message if the deletion fails
            echo "Error updating record: " . mysqli_error($connection);
        }
    }
    else {
        echo "Error: Pickup button was not clicked.";
    }
}
?>
