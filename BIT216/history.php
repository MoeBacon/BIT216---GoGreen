<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pickup History</title>
    <link rel="stylesheet" href="css/history.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Jua&display=swap">

    <script src="https://kit.fontawesome.com/bbf63d7a1f.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

</head>
<body>
   
<div class="container">
        <aside class="sidebar">
            <div class="logo">
                <img src="image/GOGREEN1.png" alt="Logo">
            </div>
            <?php
                include 'nav.php';
            ?>
        </aside>
        <main class="main-content">
        <form class="report-form">
            <div class="banner">
                <h2>Pickup History</h2>
            </div>
            
            <div class="filters">
                <input type="text" id="date-range" placeholder="Select Date Range ▾" class="filter">
                <select class="filter" id = "type">
                    <option selected value="all">All ▾</option>
                    <option value="household">Household Waste</option>
                    <option value="recyclable">Recycable Waste</option>
                    <option value="hazardous">Hazardous Waste</option>
                </select>
            </div>

            <div class="history-container">
                <?php
                    global $dbConnection;
                    $email = $_SESSION['username'];
                    $sql = "SELECT userID FROM user WHERE userEmail = '$email'";
                    $result = mysqli_query($dbConnection,$sql);
                    $row = mysqli_fetch_assoc($result);
                    $userID = $row['userID'];

                    $sql2 = "SELECT * FROM pickup WHERE userID = '$userID'";
                    $result2 = mysqli_query($dbConnection,$sql2);
                    
                    if(mysqli_num_rows($result2)==0){
                        echo '<div class="no-his-container">';
                        echo '<p>----- No pickup history -----</p>';
                        echo '</div>';
                    }
                    else{
                        while($row2 = mysqli_fetch_assoc($result2)){
                            $src = "";
                            if($row2['pickupType'] == "household"){
                                $src = "image/household.png";
                            }
                            else if($row2['pickupType'] == "recyclable"){
                                $src = "image/recyclable.png";
                            }
                            else if ($row2['pickupType'] == "hazardous"){   
                                $src = "image/hazardous.png";
                            }
                            echo '<div class="history-entry ' . $row2['pickupType'] . ' ' . $row2['pickupDate'] . '">';
                            echo '    <div class="history-details">';
                            echo '        <img src="' . $src . '" alt="' . $row2['pickupType'] . ' waste">';
                            echo '        <div class="details-text">';
                            echo '            <p class="waste-type">' . ucfirst($row2['pickupType']) . ' Waste</p>';
                            echo '            <p class="pickup-info">' . $row2['pickupDate'] . ' • ' . $row2['pickupTime'] . '</p>';
                            echo '            <span class="' . $row2['pickupStatus'] . '">' . $row2['pickupStatus'] . '</span>';
                            echo '        </div>';
                            echo '    </div>';
                            echo '    <button type="button" class="report-section" onclick="window.location.href=\'reportIssue.php?op=' . $row2['pickupDate'] . '\'">';
                            echo '        <div class="warning-icon">⚠</div>';
                            echo '        <p>Report this pickup</p>';
                            echo '        <div class="expand-arrow">›</div>';
                            echo '    </button>';
                            echo '</div>';
                        }
                    }
                ?>
                
                <!-- <div class="history-entry">
                    <div class="history-details">
                        <img src="image/household.png" alt="Household Waste">
                        <div class="details-text">
                            <p class="waste-type">Household Waste</p>
                            <p class="pickup-info">8 September 2024 • 4:41pm</p>
                            <span class="completed">Completed</span>
                        </div>
                    </div>
                    <button type="button" class="report-section">
                        <div class="warning-icon">⚠</div>
                        <p>Report this pickup</p>
                        <div class="expand-arrow">›</div>
                    </button>
                </div> -->



                
            </div>
        </form>
           
        </main>
    </div>
    <script>
    flatpickr("#date-range", {
        mode: "range", 
        dateFormat: "Y-m-d", 
        minDate: "2000-01-01"  
        });
    </script>
    


</body>
</html>
