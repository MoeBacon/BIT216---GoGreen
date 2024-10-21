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
    <title>My Dashboard</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Jua&display=swap">

    <script src="https://kit.fontawesome.com/bbf63d7a1f.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
</head>
<body>
    <div class="container">
        <aside class="sidebar">
            <div class="logo">
                <img src="image/GOGREEN1.png" alt="Logo">
            </div>
            <!-- <nav class="menu">
                <ul>
                    <li><a href="dashboard.php" class="active"><i class="fa-solid fa-table-columns"></i><span>My dashboard</span></a></li>
                    <li><a href="account.php"><i class="fa-solid fa-user"></i><span>Accounts</span></a></li>
                    <li><a href="reportIssue.php"><i class="fa-solid fa-comment-dots"></i><span>Report</span></a></li>
                    <li><a href="schedule.php"><i class="fa-solid fa-calendar-days"></i><span>Schedule PickUp</span></a></li>
                    <li><a href="history.php"><i class="fa-solid fa-clock-rotate-left"></i><span>History</span></a></li>
                    <li><a href="overview.php"><i class="fa-solid fa-chart-simple"></i><span>Overview</span></a></li>
                    <li><a href="overview.php"><i class="fa-solid fa-arrow-right-from-bracket logout"></i><span>Logout</span></a></li>
                </ul>
            </nav> -->
            <?php
                include 'nav.php';
            ?>
        </aside>
        <main class="main-content">
            <header class="header">
                <div class="welcome-message">
                    <h1>My Dashboard</h1>
                    <p>Welcome to GoGreen</p>
                </div>
                <div class="user-profile">
                    <button class="noti" onClick="toggleNotiDropdown()">
                        <i class="fa-solid fa-bell" id="noti-icon"></i>
                    </button>
                    <div class="noti-dropdown" id="notiDropdown">
                        <?php
                            global $dbConnection;
                            $email = $_SESSION['username'];
                            $sql = "SELECT comID FROM user WHERE userEmail = '$email'";
                            $result = mysqli_query($dbConnection,$sql);
                            $row = mysqli_fetch_assoc($result);
                            $comID = $row['comID'];

                            $sql2 = "SELECT annoTitle, annoDesc, annoDate, annoImage FROM announcement WHERE comID = '$comID'";
                            $result = mysqli_query($dbConnection,$sql2);
                            while($row = mysqli_fetch_assoc($result)){
                                echo "<div class='noti-item' onclick=\"showNotificationDetails('" . addslashes($row['annoTitle']) . "', '" . $row['annoDate'] . "', 'photoUpload/" . $row['annoImage'] . "', '" . addslashes($row['annoDesc']) . "')\">
                                    <h3>" . htmlspecialchars($row['annoTitle']) . "</h3>
                                    <p>" . htmlspecialchars(substr($row['annoDesc'], 0, 50)) . "...</p>
                                </div>";
                            
                            }

                        ?>
                    </div>
                    <img src="image/handsome.jpeg" alt="Profile Picture">
                    <?php
                        $sql = "SELECT userFname, userLname FROM user WHERE comID = '$comID'";
                        $result = mysqli_query($dbConnection,$sql);
                        $row = mysqli_fetch_assoc($result);
                        $fname = $row['userFname'];
                        $lname = $row['userLname'];
                    ?>
                    <p>Hello <?php echo $fname ?></p>
                </div>
            </header>

            <section class="content">
                <div class="profile-card">
                    <?php
                        $sql2 = "SELECT comArea FROM community WHERE comID = '$comID'";
                        $result2 = mysqli_query($dbConnection,$sql2);
                        $row2 = mysqli_fetch_assoc($result2);

                        echo "<h2>".$row2['comArea']."</h2>";
                    ?>
                      

                    <div class="details">
                        <div class="timetable">
                            <p class="timetable-font">Timetable</p>
                            <div class = "timetable-container">
                                <span class="day">Monday</span>
                                <?php
                                
                                    $sql = "SELECT scheTime FROM schedule WHERE comID = '$comID' AND scheDay = 'Monday' ORDER BY STR_TO_DATE(scheTime, '%h:%i %p') ASC";
                                    $result = mysqli_query($dbConnection, $sql);

                                   
                                    $timeSlots = [];
                                    
                                   
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        $timeSlots[] = $row['scheTime'];
                                    }
                                    
                                    
                                    if (count($timeSlots) == 2) {
                                        echo '<span class="time">' . $timeSlots[0] . ', ' . $timeSlots[1] . '</span>';
                                    } elseif (count($timeSlots) == 1) {
                                        echo '<span class="time">' . $timeSlots[0] . '</span>';
                                    } else {
                                        
                                        echo '<span class="time">-</span>';
                                    }
                                ?>
                                
                            
                            </div>
                            <hr class="timetableHR">
                            <div class = "timetable-container">
                                <span class="day">Tuesday</span>
                                <?php
                                
                                    $sql = "SELECT scheTime FROM schedule WHERE comID = '$comID' AND scheDay = 'Tuesday' ORDER BY STR_TO_DATE(scheTime, '%h:%i %p') ASC";
                                    $result = mysqli_query($dbConnection, $sql);

                                   
                                    $timeSlots = [];
                                    
                                   
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        $timeSlots[] = $row['scheTime'];
                                    }
                                    
                                    
                                    if (count($timeSlots) == 2) {
                                        echo '<span class="time">' . $timeSlots[0] . ', ' . $timeSlots[1] . '</span>';
                                    } elseif (count($timeSlots) == 1) {
                                        echo '<span class="time">' . $timeSlots[0] . '</span>';
                                    } else {
                                        
                                        echo '<span class="time">-</span>';
                                    }
                                ?>
                            </div>
                            <hr class="timetableHR">
                            <div class = "timetable-container">
                                <span class="day">Wednesday</span>
                                <?php
                                
                                    $sql = "SELECT scheTime FROM schedule WHERE comID = '$comID' AND scheDay = 'Wednesday' ORDER BY STR_TO_DATE(scheTime, '%h:%i %p') ASC";
                                    $result = mysqli_query($dbConnection, $sql);

                                   
                                    $timeSlots = [];
                                    
                                   
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        $timeSlots[] = $row['scheTime'];
                                    }
                                    
                                    
                                    if (count($timeSlots) == 2) {
                                        echo '<span class="time">' . $timeSlots[0] . ', ' . $timeSlots[1] . '</span>';
                                    } elseif (count($timeSlots) == 1) {
                                        echo '<span class="time">' . $timeSlots[0] . '</span>';
                                    } else {
                                        
                                        echo '<span class="time">-</span>';
                                    }
                                ?>
                            </div>
                            <hr class="timetableHR">
                            <div class = "timetable-container">
                                <span class="day">Thursday</span>
                                <?php
                                
                                    $sql = "SELECT scheTime FROM schedule WHERE comID = '$comID' AND scheDay = 'Thursday' ORDER BY STR_TO_DATE(scheTime, '%h:%i %p') ASC";
                                    $result = mysqli_query($dbConnection, $sql);

                                   
                                    $timeSlots = [];
                                    
                                   
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        $timeSlots[] = $row['scheTime'];
                                    }
                                    
                                    
                                    if (count($timeSlots) == 2) {
                                        echo '<span class="time">' . $timeSlots[0] . ', ' . $timeSlots[1] . '</span>';
                                    } elseif (count($timeSlots) == 1) {
                                        echo '<span class="time">' . $timeSlots[0] . '</span>';
                                    } else {
                                        
                                        echo '<span class="time">-</span>';
                                    }
                                ?>
                            </div>
                            <hr class="timetableHR">
                            <div class = "timetable-container">
                                <span class="day">Friday</span>
                                <?php
                                
                                    $sql = "SELECT scheTime FROM schedule WHERE comID = '$comID' AND scheDay = 'Friday' ORDER BY STR_TO_DATE(scheTime, '%h:%i %p') ASC";
                                    $result = mysqli_query($dbConnection, $sql);

                                   
                                    $timeSlots = [];
                                    
                                   
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        $timeSlots[] = $row['scheTime'];
                                    }
                                    
                                    
                                    if (count($timeSlots) == 2) {
                                        echo '<span class="time">' . $timeSlots[0] . ', ' . $timeSlots[1] . '</span>';
                                    } elseif (count($timeSlots) == 1) {
                                        echo '<span class="time">' . $timeSlots[0] . '</span>';
                                    } else {
                                        
                                        echo '<span class="time">-</span>';
                                    }
                                ?>
                            </div>
                            
                        </div>
                        <div class="type">
                            <div class="type-circle">
                                <div class="hover-window window1">
                                    <strong>Paper Recycling</strong><br><br>
                                    We accept newspapers, magazines, cardboard, and office paper. Please ensure they are clean and dry.<br>
                                    <em>Tip:</em> Flatten cardboard boxes to save space.<br>
                                    <em>Impact:</em> Recycling paper helps save trees and reduces landfill waste.
                                </div>
                            </div>
                            <div class="type-circle">
                                <div class="hover-window window2">
                                    <strong>Aluminium Recycling</strong><br><br>
                                    We accept aluminum cans and foil. Please rinse them before recycling.<br>
                                    <em>Tip:</em> Crush cans to save space.<br>
                                    <em>Impact:</em> Recycling aluminum saves 95% of the energy required to produce new aluminum.
                                </div>
                            </div>
                            <div class="type-circle">
                                <div class="hover-window window3">
                                    <strong>Plastic Recycling</strong><br><br>
                                    We accept plastic bottles, containers, and bags. Ensure they are rinsed and free of food residue.<br>
                                    <em>Tip:</em> Remove caps from bottles for easier recycling.<br>
                                    <em>Impact:</em> Recycling plastic reduces the amount of waste in our oceans.
                                </div>
                            </div>
                        </div>
                        
                    </div>
                    <div class="schedule">
                        <button class="schedule-btn" onclick="window.location.href='schedule.php';">
                            <span id="schedule-text">Schedule&nbsp;</span>
                            <span id="your-text">Your</span>
                            <span id="pickup-text">&nbsp;Pickup</span>
                        </button>
                    </div>

                </div>
                <div class="account-bill-container">
                    <div class="accounts">
                        <h2 class="history-h2">Recent PickUp History</h2>
                        <div class="history">
                            <?php
                                $sql = "SELECT userID FROM user WHERE userEmail = '$email'";
                                $result = mysqli_query($dbConnection,$sql);
                                $row = mysqli_fetch_assoc($result);
                                $userID = $row['userID'];

                                $sql2 = "SELECT * FROM pickup WHERE userID = '$userID' ORDER BY pickupDate DESC LIMIT 3";
                                $result2 = mysqli_query($dbConnection,$sql2);
                                $empty = 3 - mysqli_num_rows($result2);
                                while($row2 = mysqli_fetch_assoc($result2)){
                                    $day = date('l', strtotime($row2['pickupDate']));
                                    echo '<div class="history-content">';
                                    echo '    <p>' . $day . ' ' . $row2['pickupDate'] . '</p>';  
                                    echo '    <p>Type: ' . ucfirst($row2['pickupType']) . ' Waste</p>';  
                                    echo '</div>';
                                    echo '<hr class="history-line"></hr>';
                                }

                                for($i=0; $i<$empty; $i++){
                                    echo '<div class="history-content">';
                                    echo '    <p>No</p>';  
                                    echo '    <p>History</p>';  
                                    echo '</div>';
                                    echo '<hr class="history-line"></hr>';
                                }


                            ?>

                        </div>

                    </div>
                    <div class="statistics">
                        <h2 class="statistics-h2">Statistics</h2>
                        <canvas id="myChart"></canvas>

                    </div>
                    <div id="notification-modal" class="modal">
                        <div class="modal-content">
                            <span class="close" onclick="closeModal()">&times;</span>
                            <h3 id="modal-title"></h3>
                            <p id="modal-date"></p>
                            <img id="modal-image" src="" alt="Notification Image" />
                            <p id="modal-content"></p>
                        </div>
                    </div>
                </div>
            </section>

        </main>
    </div>

    <?php
        // Query 1
        $result1 = mysqli_query($dbConnection, "SELECT COUNT(pickupID) FROM pickup WHERE pickupType = 'household' AND userID = '$userID'");
        $row1 = mysqli_fetch_assoc($result1);
        $value1 = $row1['COUNT(pickupID)'];


        // Query 2
        $result2 = mysqli_query($dbConnection, "SELECT COUNT(pickupID) FROM pickup WHERE pickupType = 'recyclable' AND userID = '$userID'");
        $row2 = mysqli_fetch_assoc($result2);
        $value2 = $row2['COUNT(pickupID)'];


        // Query 3
        $result3 = mysqli_query($dbConnection, "SELECT COUNT(pickupID) FROM pickup WHERE pickupType = 'hazardous' AND userID = '$userID'");
        $row3 = mysqli_fetch_assoc($result3);
        $value3 = $row3['COUNT(pickupID)'];

    ?>

    <script>
        var xValues = ["Household", "Recyclable", "Hazardous"];
        var yValues = [<?php echo $value1; ?>, <?php echo $value2; ?>, <?php echo $value3; ?>];

        var barColors = [
        "#a2df9c",
        "#00aba9",
        "#3a3939e9"
        ];

        new Chart("myChart", {
        type: "pie",
        data: {
            labels: xValues,
            datasets: [{
            backgroundColor: barColors,
            data: yValues
            }]
        },
        options: {
            title: {
            display: true,
            text: "Type of Waste"
            },
            legend: {
            display: true,
            position: 'right'
            }
        }
        });
    </script>

    <script>
        function toggleNotiDropdown() {
            var dropdown = document.getElementById("notiDropdown");
            if (dropdown.style.display === "block") {
                dropdown.style.display = "none";
            } else {
                dropdown.style.display = "block";
            }
        }

        // Optionally, close the dropdown if clicked outside of it
        window.onclick = function(event) {

            if (!event.target.matches('.noti') && !event.target.closest('.noti-dropdown')) {
                var dropdown = document.getElementById("notiDropdown");
                if (dropdown.style.display === "block") {
                    dropdown.style.display = "none";
                }
            }
        }
    </script>

    <script>
        // document.addEventListener('DOMContentLoaded', function () {
        //     // This will close the notification modal when clicking outside of it
        //     window.addEventListener('click', function(event) {
        //         const modal = document.getElementById('notification-modal');
        // const notificationList = document.getElementById('notification-list');
        
        // // Check if modal and notificationList are not null
        // if (modal && notificationList) {
        //     // Close the modal if the click is outside of it
        //     if (event.target === modal) {
        //         closeModal();
        //     }
            
        //     // Close the notification list if clicking outside of it
        //     if (!notificationList.contains(event.target) && !modal.contains(event.target)) {
        //         // Hide the notification list or perform your close logic
        //         // closeNotificationList(); // Implement this function if necessary
        //     }
        // } else {
        //     console.error("Modal or notification list element not found.");
        // }
        //     });
        // });

        function showNotificationDetails(title, date, image, content) {
            // Set the content of the modal
            document.getElementById('modal-title').innerText = title;
            document.getElementById('modal-date').innerText = date;
            document.getElementById('modal-content').innerText = content;
            const modalImage = document.getElementById('modal-image');

            if (image == 'photoUpload/') {
                modalImage.style.display = 'none'; // Hide image if not present
            } else {
                
                modalImage.src = image;
                modalImage.style.display = 'block'; // Show image if present
            }

            // Display the modal
            document.getElementById('notification-modal').style.display = 'block';
        }

        function closeModal() {
            // Hide the modal
            document.getElementById('notification-modal').style.display = 'none';
        }

    </script>

</body>
</html>
