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
                    <button class="noti">
                        <i class="fa-solid fa-bell"></i>
                        <div class="noti-num">3</div>
                    </button>
                    <img src="image/handsome.jpeg" alt="Profile Picture">
                    <p>Hello Nigg4</p>
                </div>
            </header>

            <section class="content">
                <div class="profile-card">
                    <?php
                        global $dbConnection;
                        $email = $_SESSION['username'];
                        $sql = "SELECT comID FROM user WHERE userEmail = '$email'";
                        $result = mysqli_query($dbConnection,$sql);
                        $row = mysqli_fetch_assoc($result);
                        $comID = $row['comID'];

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
                        <h2 class="history-h2">PickUp History</h2>
                        <div class="history">
                            <div class="history-content">
                                <p>Monday 2/9/2024</p>
                                <p>Type: Paper</p>
                            </div>
                            <hr class="history-line"></hr>
                            <div class="history-content">
                                <p>Monday 2/9/2024</p>
                                <p>Type: Paper</p>
                            </div>
                            <hr class="history-line"></hr>
                            <div class="history-content">
                                <p>Monday 2/9/2024</p>
                                <p>Type: Paper</p>
                            </div>
                        </div>
                        <!-- <div class="account">
                            <p>Active account</p>
                            <p>8040 5060 8098 4525</p>
                            <button class="block-btn">Block Account</button>
                        </div>
                        <div class="account">
                            <p>Blocked account</p>
                            <p>7162 5088 3134 3148</p>
                            <button class="unblock-btn">Unblock account</button>
                        </div> -->
                    </div>
                    <div class="statistics">
                        <h2 class="statistics-h2">Statistics</h2>
                        <canvas id="myChart"></canvas>
                        <!-- <div class="bill">
                            <p>Phone bill</p>
                            <span class="status paid">Bill paid</span>
                        </div>
                        <div class="bill">
                            <p>Internet bill</p>
                            <span class="status unpaid">Not paid</span>
                        </div>
                        <div class="bill">
                            <p>House rent</p>
                            <span class="status paid">Bill paid</span>
                        </div>
                        <div class="bill">
                            <p>Income tax</p>
                            <span class="status paid">Bill paid</span>
                        </div> -->
                    </div>
                </div>
            </section>
        </main>
    </div>

    <script>
        var xValues = ["Paper", "Aluminium", "Plastic"];
        var yValues = [10, 10, 10];
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
</body>
</html>
