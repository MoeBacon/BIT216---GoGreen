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
  <title>Overview</title>
  <link rel="stylesheet" href="css/admin_overview.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Jua&display=swap">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
  <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>
<body>
    <div class="container">


        <?php
            include 'admin_nav.php';
        ?>
        <?php
            global $dbConnection;
            $email = $_SESSION['username'];
            $sql = "SELECT comID FROM user WHERE userEmail = '$email'";
            $result = mysqli_query($dbConnection,$sql);
            $row = mysqli_fetch_assoc($result);
            $comID = $row['comID'];

            $today = date("Y-m-d");
            $sql2 = "SELECT createdDate FROM community WHERE comID = '$comID'";
            $result2 = mysqli_query($dbConnection,$sql2);
            $row2 = mysqli_fetch_assoc($result2);
            $createdDate = $row2['createdDate']; 

        ?>
        
        <div class="content">
            <div class="content-container">
                <!-- Reported Issue -->
                <div class="report-card">
                    <h2>Reported Issue</h2>
                    <div class="report-content">
                        <label for="community-issue">Community :</label>

                        <select id="community-issue" class="dropdown">
                            <?php
                                $sql = "SELECT comArea,comID FROM community WHERE comID = '$comID'";
                                $result = mysqli_query($dbConnection,$sql);
                                $row = mysqli_fetch_assoc($result);
                                echo "<option selected value='" . $row['comID'] . "'>" . $row['comArea'] . "</option>";
                            ?>
                            <!-- <option selected value="">Select Community</option> -->
                            <?php
                            
                            $sql = "SELECT comArea,comID FROM community WHERE comID != '$comID'";
                            $result = mysqli_query($dbConnection,$sql);
                            if (mysqli_num_rows($result) > 0) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo "<option value='" . $row['comID'] . "'>" . $row['comArea'] . "</option>";
                                }
                            } 
                            ?>
                        </select>

                        <label for="date-issue">Date :</label>
                        <input type="text" id="date-range1" placeholder="Select Date Range ▾" required="required" class="filter" value="<?php echo $today . ' to ' . $createdDate; ?>">
                    </div>
                    <canvas id="myChart"></canvas>
                    <div class="message" id="message1" style="display:none;">
                        <p>No data avialable for the selected date range.</p>
                        <p>Please choose wider date range.</p>
                    </div>
                    <button class="generate-btn" id="btn1">Generate</button>
                </div>

                <!-- Pickup Statistics -->
                <div class="report-card">
                <h2>Pickup Statistics</h2>
                    <div class="report-content">
                        <label for="community-pickup">Community :</label>
                        <select id="community-pickup" class="dropdown">
                            <?php
                                    $sql = "SELECT comArea,comID FROM community WHERE comID = '$comID'";
                                    $result = mysqli_query($dbConnection,$sql);
                                    $row = mysqli_fetch_assoc($result);
                                    echo "<option selected value='" . $row['comID'] . "'>" . $row['comArea'] . "</option>";
                                ?>
                                <!-- <option selected value="">Select Community</option> -->
                                <?php
                                
                                $sql = "SELECT comArea,comID FROM community WHERE comID != '$comID'";
                                $result = mysqli_query($dbConnection,$sql);
                                if (mysqli_num_rows($result) > 0) {
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        echo "<option value='" . $row['comID'] . "'>" . $row['comArea'] . "</option>";
                                    }
                                } 
                                ?>
                        </select>

                        <label for="date-pickup">Date :</label>
                        <input type="text" id="date-range2" placeholder="Select Date Range ▾" required="required" class="filter" value="<?php echo $today . ' to ' . $createdDate; ?>">


                    </div>
                    <canvas id="myChart2"></canvas>
                    <div class="message" id="message2" style="display:none;">
                        <p>No data avialable for the selected date range.</p>
                        <p>Please choose wider date range.</p>
                    </div>
                    <button class="generate-btn" id="btn2">Generate</button>
                </div>

                <!-- Recycling Rate -->
                <div class="report-card full-width">
                <h2>Recycling Rate</h2>
                    <div class="report-content">
                        <label for="community-recycle">Community :</label>
                        <select id="community-recycle" class="dropdown">
                            <?php
                                $sql = "SELECT comArea,comID FROM community WHERE comID = '$comID'";
                                $result = mysqli_query($dbConnection,$sql);
                                $row = mysqli_fetch_assoc($result);
                                echo "<option selected value='" . $row['comID'] . "'>" . $row['comArea'] . "</option>";
                            ?>
                            <!-- <option selected value="">Select Community</option> -->
                            <?php
                            
                                $sql = "SELECT comArea,comID FROM community WHERE comID != '$comID'";
                                $result = mysqli_query($dbConnection,$sql);
                                if (mysqli_num_rows($result) > 0) {
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        echo "<option value='" . $row['comID'] . "'>" . $row['comArea'] . "</option>";
                                    }
                                } 
                            ?>
                        </select>

                        <label for="date-recycle">Date :</label>
                        <input type="text" id="date-range3" placeholder="Select Date Range ▾" required="required" class="filter" value="<?php echo $today . ' to ' . $createdDate; ?>">
                        

                    </div>
                    <div class="message" id="message3" style="display:none;">
                        <p>No data avialable for the selected date range.</p>
                        <p>Please choose wider date range.</p>
                    </div>
                    <div id="curve_chart" style="width: 800px;height: 350px;"></div>
                    <button class="generate-btn" id="btn3">Generate</button>
                </div>
            </div>

        </div>
    </div>
    <script>
        flatpickr("#date-range1", {
        mode: "range", 
        dateFormat: "Y-m-d", 
        minDate: "2000-01-01"  
        });
        flatpickr("#date-range2", {
        mode: "range", 
        dateFormat: "Y-m-d", 
        minDate: "2000-01-01"  
        });
        flatpickr("#date-range3", {
        mode: "range", 
        dateFormat: "Y-m-d", 
        minDate: "2000-01-01"  
        });
    </script>
    <script>
        let myChart;
        let myChart2;

            // var pickupStatisticsDate = document.getElementById("date-range2").value;
            // var communityPickup = document.getElementById("community-pickup").value;
            // var xValues = ["Hazardous", "Recycable", "Household"];
            // var yValues = [10, 10, 10];
            // var barColors = [
            // "#a2df9c",
            // "#00aba9",
            // "#3a3939e9"
            // ];

            // new Chart("myChart2", {
            //     type: "pie",
            //     data: {
            //         labels: xValues,
            //         datasets: [{
            //         backgroundColor: barColors,
            //         data: yValues
            //         }]
            //     },
            //     options: {
            //         title: {
            //         display: true
            //         },
            //         legend: {
            //         display: true,
            //         position: 'right'
            //         }
            //     }
            // });
            document.getElementById("btn2").addEventListener("click",function(event){
                var pickupDate = document.getElementById("date-range2").value;
                var communityPickup = document.getElementById("community-pickup").value;
                if(communityPickup == ""){
                    alert("Please select a community.");
                    return;
                }
                if(pickupDate == ""){
                    alert("Please select date range.");
                    return;
                }
                $(document).ready(function() {
                    

                    $.ajax({
                        url: 'php/functions.php?op=adminPickupStatistics', // Replace with your server-side script
                        type: 'GET', // or 'POST' based on your preference
                        data: {pickupDate:pickupDate,
                            communityPickup: communityPickup

                        },
                        dataType: 'json',
                        success: function(response) {
                            var xValues = ["Household", "Recycable", "Hazardous"];
                            var yValues = response.yValues; // Assume your server returns an object with a 'values' array
                            var result = response.result;
                            var barColors = ["#a2df9c", "#00aba9", "#3a3939e9"];
                            if (myChart2) {
                                myChart2.destroy(); // Destroy previous instance if it exists
                            }

                            myChart2 = new Chart("myChart2", {
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
                                        text: "Pickup Statistics"
                                    },
                                    legend: {
                                        display: true,
                                        position: 'right'
                                    }
                                }
                                
                            });
                            if(result == 'noData'){
                                document.getElementById("message2").style.display = "flex";
                                document.getElementById("myChart2").style.display = "none";
                            }
                            else if(result =='pass'){
                                document.getElementById("message2").style.display = "none";
                                document.getElementById("myChart2").style.display = "block";
                            }
                            // Optionally hide/show elements

                        },
                        error: function(xhr, status, error) {
                            console.error(error); // Handle any errors
                        }
                    });

                });
            });
    </script>

    <script>
        // var RORDate = document.getElementById("date-range3");
        // var communityRecycle = document.getElementById("community-recycle");
        // google.charts.load('current', {'packages':['corechart']});
        // google.charts.setOnLoadCallback(drawChart);

        // function drawChart() {
        //     var data = google.visualization.arrayToDataTable([
        //     ['Time', 'ROR'],
        //     [50,7],[60,8],[70,8],[80,9],[90,9],
        //     [100,9],[110,10],[120,11],
        //     [130,14],[140,14],[150,15]
        //     ]);

        //     // Set Options
        //     const options = {
        //     title: 'Recycling Rate',
        //     hAxis: {title: 'Time'},
        //     vAxis: {title: 'Rate of Recycling'},
        //     legend: 'none'
        //     };

        //     // Draw
        //     const chart = new google.visualization.LineChart(document.getElementById('curve_chart'));
        //     chart.draw(data, options);
        // }
        document.getElementById("btn3").addEventListener("click",function(event){
            var RORDate = document.getElementById("date-range3").value;
            var communityROR = document.getElementById("community-recycle").value;
            if(communityROR == ""){
                alert("Please select a community.");
                return;
            }
            if(RORDate == ""){
                alert("Please select date range.");
                return;
            }
            if(!RORDate.includes("to")){
                alert("Please select date range instead of a date.");
                return;
            }
            document.getElementById("message3").style.display = "none";
            document.getElementById("curve_chart").style.display = "block";
            $(document).ready(function() {
                $.ajax({
                    url: 'php/functions.php?op=adminRateOfRecycling', // Replace with your server-side script
                    type: 'GET', // or 'POST' based on your preference
                    data: {RORDate: RORDate,
                        communityROR: communityROR
                    }, // Optional: Pass any required data like time range
                    dataType: 'json',
                    success: function(response) {
                        var recyclingData = response.recyclingData; // Assume response contains array of data points
                        var result = response.result;
                        // Example response format: 
                        // { data: [ [50, 7], [60, 8], [70, 8], [80, 9], [90, 9], ... ] }
                        
                        // Call Google Charts after data is successfully retrieved
                        google.charts.load('current', {'packages': ['corechart']});
                        google.charts.setOnLoadCallback(function() {
                            drawChart(recyclingData);
                        });
                        if(result == 'noData'){
                            document.getElementById("message3").style.display = "flex";
                            document.getElementById("curve_chart").style.display = "none";
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error(error); // Handle any errors
                    }
                });
            });

            function drawChart(recyclingData) {
                var data = new google.visualization.DataTable();
                data.addColumn('number', 'Week');
                data.addColumn('number', 'ROR');

                data.addRows(recyclingData); // Add data fetched from the server

                // Set options
                const options = {
                    title: 'Recycling Rate',
                    hAxis: {title: 'Week'},
                    vAxis: {title: 'Rate of Recycling'},
                    legend: 'none'
                };

                // Draw chart
                const chart = new google.visualization.LineChart(document.getElementById('curve_chart'));
                chart.draw(data, options);
            }
        });
    </script>
    
    <script>

        document.getElementById("btn1").addEventListener("click",function(event){
            var issueReportedDate = document.getElementById("date-range1").value;
            var communityIssue = document.getElementById("community-issue").value;
            if(communityIssue == ""){
                alert("Please select a community.");
                return;
            }
            if(issueReportedDate == ""){
                alert("Please select date range.");
                return;
            }
            $(document).ready(function() {
                

                $.ajax({
                    url: 'php/functions.php?op=adminIssueReported', // Replace with your server-side script
                    type: 'GET', // or 'POST' based on your preference
                    data: {issueReportedDate:issueReportedDate,
                            communityIssue: communityIssue

                    },
                    dataType: 'json',
                    success: function(response) {
                        var xValues = ["Missed Pickup", "Overflowing Bin", "Illegal Dumping", "Others"];
                        var yValues = response.yValues; // Assume your server returns an object with a 'values' array
                        var result = response.result;
                        var barColors = ["#a2df9c", "#00aba9", "#3a3939e9", "#dd86f7"];
                        if (myChart) {
                            myChart.destroy(); // Destroy previous instance if it exists
                        }

                        myChart = new Chart("myChart", {
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
                                    text: "Issue Reported"
                                },
                                legend: {
                                    display: true,
                                    position: 'right'
                                }
                            }
                            
                        });
                        if(result == 'noData'){
                            document.getElementById("message1").style.display = "flex";
                            document.getElementById("myChart").style.display = "none";
                        }
                        else if(result =='pass'){
                            document.getElementById("message1").style.display = "none";
                            document.getElementById("myChart").style.display = "block";
                        }
                        // Optionally hide/show elements

                    },
                    error: function(xhr, status, error) {
                        console.error(error); // Handle any errors
                    }
                });

            });
        });
        // var xValues = ["Illegal Dumping", "Overflowing Bin", "Missed Pickup"];
        //     var yValues = [12, 16, 22];
        //     var barColors = [
        //     "#a2df9c",
        //     "#00aba9",
        //     "#3a3939e9"
        //     ];

        //     new Chart("myChart", {
        //         type: "pie",
        //         data: {
        //             labels: xValues,
        //             datasets: [{
        //             backgroundColor: barColors,
        //             data: yValues
        //             }]
        //         },
        //         options: {
        //             title: {
        //             display: true
        //             },
        //             legend: {
        //             display: true,
        //             position: 'right'
        //             }
        //         }
        //     });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var issueReportedDate = document.getElementById("date-range1").value;
            var communityIssue = document.getElementById("community-issue").value;
            if(communityIssue == ""){
                alert("Please select a community.");
                return;
            }
            if(issueReportedDate == ""){
                alert("Please select date range.");
                return;
            }
            $(document).ready(function() {
                

                $.ajax({
                    url: 'php/functions.php?op=adminIssueReported', // Replace with your server-side script
                    type: 'GET', // or 'POST' based on your preference
                    data: {issueReportedDate:issueReportedDate,
                            communityIssue: communityIssue

                    },
                    dataType: 'json',
                    success: function(response) {
                        var xValues = ["Missed Pickup", "Overflowing Bin", "Illegal Dumping", "Others"];
                        var yValues = response.yValues; // Assume your server returns an object with a 'values' array
                        var result = response.result;
                        var barColors = ["#a2df9c", "#00aba9", "#3a3939e9", "#dd86f7"];
                        if (myChart) {
                            myChart.destroy(); // Destroy previous instance if it exists
                        }

                        myChart = new Chart("myChart", {
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
                                    text: "Issue Reported"
                                },
                                legend: {
                                    display: true,
                                    position: 'right'
                                }
                            }
                            
                        });
                        if(result == 'noData'){
                            document.getElementById("message1").style.display = "flex";
                            document.getElementById("myChart").style.display = "none";
                        }
                        else if(result =='pass'){
                            document.getElementById("message1").style.display = "none";
                            document.getElementById("myChart").style.display = "block";
                        }
                        // Optionally hide/show elements

                    },
                    error: function(xhr, status, error) {
                        console.error(error); // Handle any errors
                    }
                });

            });


            //////////pickupStatistics here

            var pickupDate = document.getElementById("date-range2").value;
                var communityPickup = document.getElementById("community-pickup").value;
                if(communityPickup == ""){
                    alert("Please select a community.");
                    return;
                }
                if(pickupDate == ""){
                    alert("Please select date range.");
                    return;
                }
                $(document).ready(function() {
                    

                    $.ajax({
                        url: 'php/functions.php?op=adminPickupStatistics', // Replace with your server-side script
                        type: 'GET', // or 'POST' based on your preference
                        data: {pickupDate:pickupDate,
                            communityPickup: communityPickup

                        },
                        dataType: 'json',
                        success: function(response) {
                            var xValues = ["Household", "Recycable", "Hazardous"];
                            var yValues = response.yValues; // Assume your server returns an object with a 'values' array
                            var result = response.result;
                            var barColors = ["#a2df9c", "#00aba9", "#3a3939e9"];
                            if (myChart2) {
                                myChart2.destroy(); // Destroy previous instance if it exists
                            }

                            myChart2 = new Chart("myChart2", {
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
                                        text: "Pickup Statistics"
                                    },
                                    legend: {
                                        display: true,
                                        position: 'right'
                                    }
                                }
                                
                            });
                            if(result == 'noData'){
                                document.getElementById("message2").style.display = "flex";
                                document.getElementById("myChart2").style.display = "none";
                            }
                            else if(result =='pass'){
                                document.getElementById("message2").style.display = "none";
                                document.getElementById("myChart2").style.display = "block";
                            }
                            // Optionally hide/show elements

                        },
                        error: function(xhr, status, error) {
                            console.error(error); // Handle any errors
                        }
                    });

                });


                ////////curveChart
                var RORDate = document.getElementById("date-range3").value;
                var communityROR = document.getElementById("community-recycle").value;
                if(communityROR == ""){
                    alert("Please select a community.");
                    return;
                }
                if(RORDate == ""){
                    alert("Please select date range.");
                    return;
                }
                if(!RORDate.includes("to")){
                    alert("Please select date range instead of a date.");
                    return;
                }
                document.getElementById("message3").style.display = "none";
                document.getElementById("curve_chart").style.display = "block";
                $(document).ready(function() {
                    $.ajax({
                        url: 'php/functions.php?op=adminRateOfRecycling', // Replace with your server-side script
                        type: 'GET', // or 'POST' based on your preference
                        data: {RORDate: RORDate,
                            communityROR: communityROR
                        }, // Optional: Pass any required data like time range
                        dataType: 'json',
                        success: function(response) {
                            var recyclingData = response.recyclingData; // Assume response contains array of data points
                            var result = response.result;
                            // Example response format: 
                            // { data: [ [50, 7], [60, 8], [70, 8], [80, 9], [90, 9], ... ] }
                            
                            // Call Google Charts after data is successfully retrieved
                            google.charts.load('current', {'packages': ['corechart']});
                            google.charts.setOnLoadCallback(function() {
                                drawChart(recyclingData);
                            });
                            if(result == 'noData'){
                                document.getElementById("message3").style.display = "flex";
                                document.getElementById("curve_chart").style.display = "none";
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error(error); // Handle any errors
                        }
                    });
                });

                function drawChart(recyclingData) {
                    var data = new google.visualization.DataTable();
                    data.addColumn('number', 'Week');
                    data.addColumn('number', 'ROR');

                    data.addRows(recyclingData); // Add data fetched from the server

                    // Set options
                    const options = {
                        title: 'Recycling Rate',
                        hAxis: {title: 'Week'},
                        vAxis: {title: 'Rate of Recycling'},
                        legend: 'none'
                    };

                    // Draw chart
                    const chart = new google.visualization.LineChart(document.getElementById('curve_chart'));
                    chart.draw(data, options);
                }
            });

    </script>
  
</body>
</html>
