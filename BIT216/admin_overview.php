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
</head>
<body>
    <div class="container">


        <?php
            include 'admin_nav.php';
        ?>
        
        <div class="content">
            <div class="content-container">
                <!-- Reported Issue -->
                <div class="report-card">
                    <h2>Reported Issue</h2>
                    <div class="report-content">
                        <label for="community-issue">Community :</label>
                        <select id="community-issue" class="dropdown">
                        <option value="community1">Community 1</option>
                        <option value="community2">Community 2</option>
                        </select>

                        <label for="date-issue">Date :</label>
                        <input type="text" id="date-range1" placeholder="Select Date Range ▾" required="required" class="filter">
                    </div>
                    <canvas id="myChart"></canvas>
                    <button class="generate-btn">Generate</button>
                </div>

                <!-- Pickup Statistics -->
                <div class="report-card">
                <h2>Pickup Statistics</h2>
                    <div class="report-content">
                        <label for="community-pickup">Community :</label>
                        <select id="community-pickup" class="dropdown">
                        <option value="community1">Community 1</option>
                        <option value="community2">Community 2</option>
                        </select>

                        <label for="date-pickup">Date :</label>
                        <input type="text" id="date-range2" placeholder="Select Date Range ▾" required="required" class="filter">


                    </div>
                    <canvas id="myChart2"></canvas>

                    <button class="generate-btn">Generate</button>
                </div>

                <!-- Recycling Rate -->
                <div class="report-card full-width">
                <h2>Recycling Rate</h2>
                    <div class="report-content">
                        <label for="community-recycle">Community :</label>
                        <select id="community-recycle" class="dropdown">
                        <option value="community1">Community 1</option>
                        <option value="community2">Community 2</option>
                        </select>

                        <label for="date-recycle">Date :</label>
                        <input type="text" id="date-range3" placeholder="Select Date Range ▾" required="required" class="filter">
                        

                    </div>
                    <div id="curve_chart" style="width: 800px;height: 350px;"></div>
                    <button class="generate-btn">Generate</button>
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
            var xValues = ["Hazardous", "Recycable", "Household"];
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
                    display: true
                    },
                    legend: {
                    display: true,
                    position: 'right'
                    }
                }
            });
    </script>

    <script>
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            var data = google.visualization.arrayToDataTable([
            ['Time', 'ROR'],
            [50,7],[60,8],[70,8],[80,9],[90,9],
            [100,9],[110,10],[120,11],
            [130,14],[140,14],[150,15]
            ]);

            // Set Options
            const options = {
            title: 'Recycling Rate',
            hAxis: {title: 'Time'},
            vAxis: {title: 'Rate of Recycling'},
            legend: 'none'
            };

            // Draw
            const chart = new google.visualization.LineChart(document.getElementById('curve_chart'));
            chart.draw(data, options);
        }
    </script>
    
    <script>
        var xValues = ["Illegal Dumping", "Overflowing Bin", "Missed Pickup"];
            var yValues = [12, 16, 22];
            var barColors = [
            "#a2df9c",
            "#00aba9",
            "#3a3939e9"
            ];

            new Chart("myChart2", {
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
                    display: true
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
