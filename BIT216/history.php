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
    <!-- container -->
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
                <select class="filter">
                    <option selected>All ▾</option>
                    <option>Household Waste</option>
                    <option>Recycable Waste</option>
                    <option>Hazardous Waste</option>
                </select>
            </div>

            <div class="history-container">
                <div class="history-entry">
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
                </div>

                <div class="history-entry">
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
                </div>
                <div class="history-entry">
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
                </div>
                <div class="history-entry">
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
                </div>
                <div class="history-entry">
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
                </div>

                

                
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
