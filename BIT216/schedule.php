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
    <title>Schedule Pickup</title>
    <link rel="stylesheet" href="css/schedule.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Jua&display=swap">

    <script src="https://kit.fontawesome.com/bbf63d7a1f.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
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
        <form class="report-form" method="post" id="form" action="php/functions.php?op=addPickup">
            <div class="banner">
                <h2>Schedule Pickup</h2>
            </div>

            <div class="icon-container">
                <div class="icon-box-container" data-value="household">
                    <div class="icon-box" data-value="household">
                        <img src="image/household.png" alt="Household Waste">
                    </div>
                    <p>Household Waste</p>
                </div>
                <div class="icon-box-container" data-value="recyclable">
                    <div class="icon-box" data-value="recyclable">
                        <img src="image/recyclable.png" alt="Recyclable Waste">
                    </div>
                    <p>Recyclable Waste</p>
                </div>
                <div class="icon-box-container" data-value="hazardous">
                    <div class="icon-box" data-value="hazardous">
                        <img src="image/hazardous.png" alt="Hazardous Wate">
                    </div>
                    <p>Hazardous Waste</p>
                </div>
            </div>
            <input type="hidden" id="selectedOption" name="selectedOption">

            <div class="input-field-container">
                <div class="input-container">
                    <span class="icon-calendar">📅</span>
                    <select name="day" id="daySelector" required>
                        <option selected value="">Select day</option>
                        <?php
                            global $dbConnection;
                            $email = $_SESSION['username'];
                            $sql = "SELECT comID FROM user WHERE userEmail = '$email'";
                            $result = mysqli_query($dbConnection,$sql);
                            $row = mysqli_fetch_assoc($result);

                            $comID = $row['comID'];
                            $days = [];
                            $sql2 = "SELECT DISTINCT scheDay FROM schedule WHERE comID = '$comID' ORDER BY FIELD(scheDay, 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday')";
                            $result2 = mysqli_query($dbConnection,$sql2);



                            function getNextAvailableDate($day) {
                                // Array mapping day names to day numbers (Monday = 1, ..., Sunday = 7)
                                $dayMap = [
                                    "Monday" => 1,
                                    "Tuesday" => 2,
                                    "Wednesday" => 3,
                                    "Thursday" => 4,
                                    "Friday" => 5,
                                    "Saturday" => 6,
                                    "Sunday" => 7
                                ];
                            
                                // Get the current day number (Monday = 1, ..., Sunday = 7)
                                $currentDayNumber = date('N');
                            
                                // Get the target day number
                                $targetDayNumber = $dayMap[$day];
                            
                                // Calculate the number of days to add to get the next target day
                                $daysToAdd = ($targetDayNumber - $currentDayNumber + 7) % 7;
                                if ($daysToAdd == 0) {
                                    $daysToAdd = 7; // If today is the target day, set it for the next week
                                }
                            
                                // Calculate the next available date
                                $nextDate = date('Y-m-d', strtotime("+$daysToAdd days"));
                            
                                return $nextDate;
                            }

                            function getSecondAvailableDate($day) {
                                    // Array mapping day names to day numbers (Monday = 1, ..., Sunday = 7)
                                $dayMap = [
                                    "Monday" => 1,
                                    "Tuesday" => 2,
                                    "Wednesday" => 3,
                                    "Thursday" => 4,
                                    "Friday" => 5,
                                    "Saturday" => 6,
                                    "Sunday" => 7
                                ];

                                // Get the current day number (Monday = 1, ..., Sunday = 7)
                                $currentDayNumber = date('N');

                                // Get the target day number
                                $targetDayNumber = $dayMap[$day];

                                // Calculate the number of days to add to get the next target day
                                $daysToAdd = ($targetDayNumber - $currentDayNumber + 7) % 7;
                                
                                // If today is the target day, set it for the next week
                                if ($daysToAdd == 0) {
                                    $daysToAdd = 7; 
                                }

                                // Calculate the next available date (first occurrence)
                                $nextDate = strtotime("+$daysToAdd days");

                                // Add 7 more days to get the next-next available date (second occurrence)
                                $nextNextDate = strtotime("+7 days", $nextDate);

                                // Format the date as yyyy-mm-dd
                                return date('Y-m-d', $nextNextDate);
                            }



                            while ($row2 = mysqli_fetch_assoc($result2)) {
                                $scheDay = $row2['scheDay'];
                                $nextAvailableDate = getNextAvailableDate($scheDay); // Get the next available date for this day
                                $secondAvailableDate = getSecondAvailableDate($scheDay);
                                echo "<option value='$nextAvailableDate'>$scheDay ( $nextAvailableDate )</option>";
                                echo "<option value='$secondAvailableDate'>$scheDay ( $secondAvailableDate )</option>";
                            }
                            
                            
                            
                        ?>
                    </select>


                    <!-- <input type="date"  id="date" placeholder="Choose your date here"> -->
                </div>
                <hr>
                <div class="input-container">
                    <span class="icon-time">🕑</span>
                    <select name="time" id="timeSelector" required>
                        <option selected value="">Select a day first</option>
                        <?php
                            $sql = "SELECT scheTime FROM schedule WHERE comID='$comID' AND scheDay = 'Monday' ORDER BY STR_TO_DATE(scheTime, '%h:%i %p') ASC";
                            $result = mysqli_query($dbConnection,$sql);
                            while($row = mysqli_fetch_assoc($result)){
                                echo "<option class='Monday' value='" . $row['scheTime'] . "'>" . $row['scheTime'] . "</option>";
                            }
                            $sql = "SELECT scheTime FROM schedule WHERE comID='$comID' AND scheDay = 'Tuesday' ORDER BY STR_TO_DATE(scheTime, '%h:%i %p') ASC";
                            $result = mysqli_query($dbConnection,$sql);
                            while($row = mysqli_fetch_assoc($result)){
                                echo "<option class='Tuesday' value='" . $row['scheTime'] . "'>" . $row['scheTime'] . "</option>";
                            }
                            $sql = "SELECT scheTime FROM schedule WHERE comID='$comID' AND scheDay = 'Wednesday' ORDER BY STR_TO_DATE(scheTime, '%h:%i %p') ASC";
                            $result = mysqli_query($dbConnection,$sql);
                            while($row = mysqli_fetch_assoc($result)){
                                echo "<option class='Wednesday' value='" . $row['scheTime'] . "'>" . $row['scheTime'] . "</option>";
                            }
                            $sql = "SELECT scheTime FROM schedule WHERE comID='$comID' AND scheDay = 'Thursday' ORDER BY STR_TO_DATE(scheTime, '%h:%i %p') ASC";
                            $result = mysqli_query($dbConnection,$sql);
                            while($row = mysqli_fetch_assoc($result)){
                                echo "<option class='Thursday' value='" . $row['scheTime'] . "'>" . $row['scheTime'] . "</option>";
                            }
                            $sql = "SELECT scheTime FROM schedule WHERE comID='$comID' AND scheDay = 'Friday' ORDER BY STR_TO_DATE(scheTime, '%h:%i %p') ASC";
                            $result = mysqli_query($dbConnection,$sql);
                            while($row = mysqli_fetch_assoc($result)){
                                echo "<option class='Friday' value='" . $row['scheTime'] . "'>" . $row['scheTime'] . "</option>";
                            }

                        ?>

                    </select>
                    <!-- <input type="text" id="time" placeholder="Choose your time here"> -->
                </div>
                <div class="submit-container">
                    <button type="submit" class="submit-btn">Submit</button>
                </div>
            </div>

        </form>

        </main>
    </div>

    <script>
        const iconBoxes = document.querySelectorAll('.icon-box-container');
        const selectedOption = document.getElementById('selectedOption');

        iconBoxes.forEach(box => {
            box.addEventListener('click', function() {
                
                const iconBox = this.querySelector('.icon-box');
                if(iconBox.classList.contains('active')){
                    iconBoxes.forEach(b => b.querySelector('.icon-box').classList.remove('active'));
                    
                    
                    selectedOption.value = '';
                }
                else{
                    iconBoxes.forEach(b => b.querySelector('.icon-box').classList.remove('active'));
                    
                    
                    iconBox.classList.add('active');
                    selectedOption.value = iconBox.dataset.value;
                }
                console.log(selectedOption.value);
            });
        });
    </script>

    <script>








    
        // const allowedDaysString = document.getElementById('hiddenDay').value;
        // const dayMap = {
        //     "Sunday": 0,
        //     "Monday": 1,
        //     "Tuesday": 2,
        //     "Wednesday": 3,
        //     "Thursday": 4,
        //     "Friday": 5,
        //     "Saturday": 6
        // };
        // const allowedDays = allowedDaysString.split(', ').map(day => dayMap[day]);

        // // Set up the date picker
        // const datePicker = document.getElementById('date');
        // const today = new Date();
        // const tomorrow = new Date(today);
        // tomorrow.setDate(today.getDate() + 1);

        // // Format the date as yyyy-mm-dd for the min date
        // const year = tomorrow.getFullYear();
        // const month = String(tomorrow.getMonth() + 1).padStart(2, '0');
        // const day = String(tomorrow.getDate()).padStart(2, '0');
        // const minDate = `${year}-${month}-${day}`;
        // datePicker.setAttribute('min', minDate);

        // // Function to check if a date matches an allowed day
        // function isAllowedDay(date) {
        //     const dayOfWeek = date.getDay(); // 0 for Sunday, 1 for Monday, etc.
        //     return allowedDays.includes(dayOfWeek);
        // }

        // // Add an event listener to prevent user from selecting invalid dates
        // datePicker.addEventListener('input', function() {
        //     const selectedDate = new Date(this.value);
        //     if (!isAllowedDay(selectedDate)) {
        //         alert('Please select a date corresponding to the allowed days.');
        //         this.value = ''; // Clear invalid selection
        //     }
        // });

        // // Automatically show the date picker when clicking the input field
        // datePicker.addEventListener('click', () => {
        //     datePicker.showPicker();
        // });


    const daySelector = document.getElementById('daySelector');
    const timeSelector = document.getElementById('timeSelector');

    // Function to display options based on selected day
    function updateTimeOptions() {
        const selectedText = daySelector.options[daySelector.selectedIndex].text;
        const options = timeSelector.options;  // Get all options in timeSelector

        const selectedDay = selectedText.split(' (')[0];


        // Loop through all the options in timeSelector
        for (let i = 0; i < options.length; i++) {
            if (options[i].classList.contains(selectedDay)) {
                options[i].style.display = 'block';  // Show options of the selected day
            } else {
                options[i].style.display = 'none';  // Hide options that don't match the selected day
            }
        }
    }

    // Call updateTimeOptions on day change
    daySelector.addEventListener('change', updateTimeOptions);

    // Call updateTimeOptions on page load
    updateTimeOptions();  // Call this function to set initial state




</script>


<script>
    const form = document.getElementById('form');
    function formSubmitValidation(){
        const selectedOption = document.getElementById('selectedOption');
        const day = document.getElementById('daySelector');
        const time = document.getElementById('timeSelector');
        if(selectedOption.value == ''){
            alert('Please select a waste type');
            event.preventDefault();
        }
        else if(day.value == ''){
            alert('Please select a day');
            event.preventDefault();
        }
        else if(time.value == ''){
            alert('Please select a time');
            event.preventDefault();
        }
    }
    form.addEventListener('submit',formSubmitValidation);
</script>


</body>
</html>
