<?php
    include 'php/dbConnect.php';
    session_start();
    if(!isset($_SESSION['username'])){
        header ("Location: login.php");
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Announcement</title>
  <link rel="stylesheet" href="css/admin_dashboard.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Jua&display=swap">

</head>
<body>
  <div class="container">


    <?php
        include 'admin_nav.php';
    ?>
    
    <div class="content">
        <div class="welcome-container">
            <p>Welcome to GoGreen</p>
            <div class="image-placeholder">
                <img src="image/waste collection.jpg" alt="Community Image" id="community-image">
            </div>
            <div class="community-details">
                <?php
                    global $dbConnection;
                    $email = $_SESSION['username'];
                    $sql = "SELECT comID FROM user WHERE userEmail = '$email'";
                    $result = mysqli_query($dbConnection,$sql);
                    $row = mysqli_fetch_assoc($result);
                    $comID = $row['comID'];

                    $sql2 = "SELECT * FROM community WHERE comID = $comID";
                    $result2 = mysqli_query($dbConnection,$sql2);
                    $community = mysqli_fetch_assoc($result2);
                    echo "
                    <p><strong>Community :</strong> {$community['comArea']}</p>
                    <p><strong>State :</strong> {$community['comState']}</p>
                    <p><strong>Created Date :</strong> {$community['createdDate']}</p>";
                ?>
                
            </div>
        </div>
    </div>

</body>
</html>
