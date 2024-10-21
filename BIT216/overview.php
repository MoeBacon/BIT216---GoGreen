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
    <link rel="stylesheet" href="css/overview.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Jua&display=swap">

    <script src="https://kit.fontawesome.com/bbf63d7a1f.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

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
            <header class="header">
                <div class="welcome-message">
                    <h1>Overview</h1>
                    <p>Welcome to GoGreen</p>
                </div>
                <div class="user-profile">
                    <button class="noti">
                        <i class="fa-solid fa-bell"></i>
                        <div class="noti-num">3</div>
                    </button>
                    <img src="image/handsome.jpeg" alt="Profile Picture">
                    <p>Hello wei chen</p>
                </div>
            </header>

            <section class="content">
                <div class="profile-card">
                    <form>
                        <h2 id="statisticsH2">Statistics</h2>  
                        <div class="filters">
                    
                            <input type="text" id="date-range" placeholder="Select Date Range ▾" required="required" class="filter">
                            <select id="type" class="filter">
                                <option selected>Report ▾</option>
                                <option>Pickup Statistics</option>
                                <option>Issue Reported</option>
                                <option>Rate of Recycling</option>
                            </select>
                        
                    
                        </div>
                        <div class="statistics" id="statistics" style="display:none;">
                            <canvas id="myChart"></canvas>
                        </div>
                        <div class="statistics" id="statistics2" style="display:none;">
                            <canvas id="myChart2"></canvas>
                        </div>
                        <div id="message">
                            <p>-- Select date and report type to generate --</p>
                        </div>
                        <div id="message2" style="display:none;">
                            <p>-- There is no data for this date range. Please choose a wider date range. --</p>
                        </div>
                        <div class="curve_chart">
                            <div id="curve_chart" style="width: 800px;height: 350px; display: none;"></div>
                        </div>
                        <button class="generateBtn">Generate</button>
                    </form>
                </div>
                
            </section>
        </main>
    </div>
    <script>
        flatpickr("#date-range", {
            mode: "range", 
            dateFormat: "Y-m-d", 
            minDate: "2000-01-01"  
        });
    </script>
    <script>
        // var xValues = ["Paper", "Aluminium", "Plastic"];
        // var yValues = [10, 10, 10];
        // var barColors = [
        // "#a2df9c",
        // "#00aba9",
        // "#3a3939e9"
        // ];

        // new Chart("myChart", {
        // type: "pie",
        // data: {
        //     labels: xValues,
        //     datasets: [{
        //     backgroundColor: barColors,
        //     data: yValues
        //     }]
        // },
        // options: {
        //     legend: {
        //     display: true,
        //     position: 'right'
        //     }
        // }
        // });
    </script>
<script>
    let myChart;
    let myChart2;
    
document.querySelector(".generateBtn").addEventListener("click", function(event) {
    event.preventDefault(); 
    var dateRange = document.getElementById("date-range").value;
    var reportType = document.getElementById("type").value;

    if (dateRange === "") {
        alert("Please select a date range."); 
        return;
    } 
    if (reportType === "Report ▾") {
        alert("Please select a report type."); 
        return;
    } else {
        console.log(dateRange); 
        console.log(reportType);
    }

    if (reportType === "Pickup Statistics") {
        document.getElementById("message").style.display = "none";
        document.getElementById("message2").style.display = "none";
        document.getElementById("curve_chart").style.display = "none";
        document.getElementById("statistics2").style.display = "none";
        document.getElementById("statistics").style.display = "flex";
        $(document).ready(function() {


            $.ajax({
                url: 'php/functions.php?op=userPickupStatistics', // Replace with your server-side script
                type: 'GET', // or 'POST' based on your preference
                data: {dateRange:dateRange},
                dataType: 'json',
                success: function(response) {
                    var xValues = ["Household", "Recyclable", "Hazardous"];
                    var yValues = response.yValues; // Assume your server returns an object with a 'values' array
                    var result = response.result;
                    var barColors = ["#a2df9c", "#00aba9", "#3a3939e9"];
                    
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
                                text: "Pickup Statistics"
                            },
                            legend: {
                                display: true,
                                position: 'right'
                            }
                        }
                        
                    });
                    if(result == 'noData'){
                        document.getElementById("message").style.display = "none";
                        document.getElementById("message2").style.display = "flex";
                        document.getElementById("curve_chart").style.display = "none";
                        document.getElementById("statistics2").style.display = "none";
                        document.getElementById("statistics").style.display = "none";
                    }
                    // Optionally hide/show elements

                },
                error: function(xhr, status, error) {
                    console.error(error); // Handle any errors
                }
            });

        });
    } else if (reportType === "Rate of Recycling") {
        if(!dateRange.includes('to')){
            alert ("Select date range instead of date.");
            return;
        }
        document.getElementById("message").style.display = "none";
        document.getElementById("message2").style.display = "none";
        document.getElementById("statistics").style.display = "none";
        document.getElementById("statistics2").style.display = "none";
        document.getElementById("curve_chart").style.display = "flex";
        
//         google.charts.load('current', {'packages': ['corechart']});
//         google.charts.setOnLoadCallback(function() {
//     drawChart(recyclingData); // Pass your data to the drawChart function here
// });
//         var recyclingData = [[50, 0]];
//         function drawChart(recyclingData) {
//             var data = new google.visualization.DataTable();
//             data.addColumn('number', 'Time');
//             data.addColumn('number', 'ROR');

//             data.addRows(recyclingData); // Add data fetched from the server

//             // Set options
//             const options = {
//                 title: 'Recycling Rate',
//                 hAxis: {title: 'Time'},
//                 vAxis: {title: 'Rate of Recycling'},
//                 legend: 'none'
//             };

//             // Draw
//             const chart = new google.visualization.LineChart(document.getElementById('curve_chart'));
//             chart.draw(data, options);
//         }




            $(document).ready(function() {
            $.ajax({
                url: 'php/functions.php?op=userRateOfRecycling', // Replace with your server-side script
                type: 'GET', // or 'POST' based on your preference
                data: {dateRange: dateRange}, // Optional: Pass any required data like time range
                dataType: 'json',
                success: function(response) {
                    console.log(response);
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
                        document.getElementById("message").style.display = "none";
                        document.getElementById("message2").style.display = "flex";
                        document.getElementById("curve_chart").style.display = "none";
                        document.getElementById("statistics2").style.display = "none";
                        document.getElementById("statistics").style.display = "none";
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
    } else if (reportType === "Issue Reported") {
        
        document.getElementById("message").style.display = "none";
        document.getElementById("message2").style.display = "none";
        document.getElementById("curve_chart").style.display = "none";
        document.getElementById("statistics2").style.display = "flex";
        document.getElementById("statistics").style.display = "none";
        $(document).ready(function() {


            $.ajax({
                url: 'php/functions.php?op=userIssueReported', // Replace with your server-side script
                type: 'GET', // or 'POST' based on your preference
                data: {dateRange:dateRange},
                dataType: 'json',
                success: function(response) {
                    var xValues = ["Missed Pickup", "Overflowing Bin", "Illegal Dumping", "Others"];
                    var yValues = response.yValues; // Assume your server returns an object with a 'values' array
                    var result = response.result;
                    var barColors = ["#a2df9c", "#00aba9", "#3a3939e9", "#dd86f7"];
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
                                text: "Issue Reported"
                            },
                            legend: {
                                display: true,
                                position: 'right'
                            }
                        }
                        
                    });
                    if(result == 'noData'){
                        document.getElementById("message").style.display = "none";
                        document.getElementById("message2").style.display = "flex";
                        document.getElementById("curve_chart").style.display = "none";
                        document.getElementById("statistics2").style.display = "none";
                        document.getElementById("statistics").style.display = "none";
                    }
                    // Optionally hide/show elements

                },
                error: function(xhr, status, error) {
                    console.error(error); // Handle any errors
                }
            });

        });
    }
});

        // function drawChart() {
        //     var data = google.visualization.arrayToDataTable([
        //         ['Time', 'ROR'],
        //         ['', 7], ['', 8], [70, 8], [80, 9], [90, 9],
        //         [100, 9], [110, 10], [120, 11],
        //         [130, 14], [140, 14], [150, 15],
        //         [130, 14], [140, 14], [150, 15],
        //         [130, 14], [140, 14], [150, 15],
        //         [130, 14], [140, 14], [150, 15],
        //         [130, 14], [140, 14], [150, 15],
        //         [130, 14], [140, 14], [150, 15],
        //         [130, 14], [140, 14], [150, 15],
        //         [100, 9], [110, 10], [120, 11],
        //         [130, 14], [140, 14], [150, 15],
        //         [130, 14], [140, 14], [150, 15],
        //         [130, 14], [140, 14], [150, 15],
        //         [130, 14], [140, 14], [150, 15],
        //         [130, 14], [140, 14], [150, 15],
        //         [130, 14], [140, 14], [150, 15],
        //         [130, 14], [140, 14], [150, 15],
        //         [130, 14], [140, 14], [150, 15]
        //     ]);

        //     // Set Options
        //     const options = {
        //         title: 'Recycling Rate',
        //         hAxis: {title: 'Time'},
        //         vAxis: {title: 'Rate of Recycling'},
        //         legend: 'none'
        //     };
</script>

</body>
</html>
