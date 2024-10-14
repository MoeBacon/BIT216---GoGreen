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
  <title>Waste Schedule</title>
  <link rel="stylesheet" href="css/admin_schedule.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Jua&display=swap">

</head>
<body>
  <div class="container">


    <?php
        include 'admin_nav.php';
    ?>
    
    <div class="content">
        <header>
            <h1>Waste Collection Schedule</h1>
        </header>
        <section class="days-selector">
            <button class="day-btn" onclick="showSchedule('monday', this)">Monday</button>
            <button class="day-btn" onclick="showSchedule('tuesday', this)">Tuesday</button>
            <button class="day-btn" onclick="showSchedule('wednesday', this)">Wednesday</button>
            <button class="day-btn" onclick="showSchedule('thursday', this)">Thursday</button>
            <button class="day-btn" onclick="showSchedule('friday', this)">Friday</button>
            <button class="day-btn" onclick="showSchedule('saturday', this)">Saturday</button>
            <button class="day-btn" onclick="showSchedule('sunday', this)">Sunday</button>
            <button class="day-btn" onclick="showSchedule('all', this)">All</button>
        </section>

        <section class="schedule-display">
        <div id="monday" class="schedule-day">
            <h3>Monday</h3>
            <?php
                global $dbConnection;
                $email = $_SESSION['username'];
                $sql = "SELECT comID FROM user WHERE userEmail = '$email'";
                $result = mysqli_query($dbConnection,$sql);
                $row = mysqli_fetch_assoc($result);
                $comID = $row['comID'];

                $sql2 = "SELECT * FROM schedule WHERE comID = '$comID' AND scheDay = 'Monday'";
                $result2 = mysqli_query($dbConnection,$sql2);
                if(mysqli_num_rows($result2)>0){
                    while ($row = mysqli_fetch_assoc($result2)) {
                        echo '<div class="time-slot" data-value="'. $row['scheduleID'] .'"onclick="selectTimeSlot(this)">' . $row['scheTime'] . '</div>';
                    }
                }
                else{
                    echo '<div class="no-time">----   No time slot on Monday   ----</div>';
                }

            ?>
        </div>

        <div id="tuesday" class="schedule-day">
            <h3>Tuesday</h3>
            <?php
                $sql2 = "SELECT * FROM schedule WHERE comID = '$comID' AND scheDay = 'Tuesday'";
                $result2 = mysqli_query($dbConnection,$sql2);
                if(mysqli_num_rows($result2)>0){
                    while ($row = mysqli_fetch_assoc($result2)) {
                        echo '<div class="time-slot" data-value="'. $row['scheduleID'] .'" onclick="selectTimeSlot(this)">' . $row['scheTime'] . '</div>';
                    }
                }
                else{
                    echo '<div class="no-time">----   No time slot on Tuesday   ----</div>';
                }
            ?>
            
        </div>

        <div id="wednesday" class="schedule-day">
            <h3>Wednesday</h3>
            <?php
                $sql2 = "SELECT * FROM schedule WHERE comID = '$comID' AND scheDay = 'Wednesday'";
                $result2 = mysqli_query($dbConnection,$sql2);
                if(mysqli_num_rows($result2)>0){
                    while ($row = mysqli_fetch_assoc($result2)) {
                        echo '<div class="time-slot" data-value="'. $row['scheduleID'] .'" onclick="selectTimeSlot(this)">' . $row['scheTime'] . '</div>';
                    }
                }
                else{
                    echo '<div class="no-time">----   No time slot on Wednesday   ----</div>';
                }
            ?>
        </div>

        <div id="thursday" class="schedule-day">
            <h3>Thursday</h3>
            <?php
                $sql2 = "SELECT * FROM schedule WHERE comID = '$comID' AND scheDay = 'Thursday'";
                $result2 = mysqli_query($dbConnection,$sql2);
                if(mysqli_num_rows($result2)>0){
                    while ($row = mysqli_fetch_assoc($result2)) {
                        echo '<div class="time-slot" data-value="'. $row['scheduleID'] .'" onclick="selectTimeSlot(this)">' . $row['scheTime'] . '</div>';
                    }
                }
                else{
                    echo '<div class="no-time">----   No time slot on Thursday   ----</div>';
                }
            ?>
        </div>

        <div id="friday" class="schedule-day">
            <h3>Friday</h3>
            <?php
                $sql2 = "SELECT * FROM schedule WHERE comID = '$comID' AND scheDay = 'Friday'";
                $result2 = mysqli_query($dbConnection,$sql2);
                if(mysqli_num_rows($result2)>0){
                    while ($row = mysqli_fetch_assoc($result2)) {
                        echo '<div class="time-slot" data-value="'. $row['scheduleID'] .'" onclick="selectTimeSlot(this)">' . $row['scheTime'] . '</div>';
                    }
                }
                else{
                    echo '<div class="no-time">----   No time slot on Friday   ----</div>';
                }
            ?>
        </div>

        <div id="saturday" class="schedule-day">
            <h3>Saturday</h3>
            <?php
                $sql2 = "SELECT * FROM schedule WHERE comID = '$comID' AND scheDay = 'Saturday'";
                $result2 = mysqli_query($dbConnection,$sql2);
                if(mysqli_num_rows($result2)>0){
                    while ($row = mysqli_fetch_assoc($result2)) {
                        echo '<div class="time-slot" data-value="'. $row['scheduleID'] .'" onclick="selectTimeSlot(this)">' . $row['scheTime'] . '</div>';
                    }
                }
                else{
                    echo '<div class="no-time">----   No time slot on Saturday   ----</div>';
                }
            ?>
        </div>

        <div id="sunday" class="schedule-day">
            <h3>Sunday</h3>
            <?php
                $sql2 = "SELECT * FROM schedule WHERE comID = '$comID' AND scheDay = 'Sunday'";
                $result2 = mysqli_query($dbConnection,$sql2);
                if(mysqli_num_rows($result2)>0){
                    while ($row = mysqli_fetch_assoc($result2)) {
                        echo '<div class="time-slot" data-value="'. $row['scheduleID'] .'" onclick="selectTimeSlot(this)">' . $row['scheTime'] . '</div>';
                    }
                }
                else{
                    echo '<div class="no-time">----   No time slot on Sunday   ----</div>';
                }
            ?>
        </div>

        <!-- Add similar blocks for other days -->

        </section>

        <div id="addTimeSlotModal" class="modal">
            <div class="modal-content">
                <h2>Add New Time Slot</h2>
                <form method="post" action="php/functions.php?op=addTimeSlot" onsubmit="return addTimeSlot();">
                    <label for="daySelect">Day:</label>
                    <select id="daySelect" name="day">
                        <option value="Monday">Monday</option>
                        <option value="Tuesday">Tuesday</option>
                        <option value="Wednesday">Wednesday</option>
                        <option value="Thursday">Thursday</option>
                        <option value="Friday">Friday</option>
                        <option value="Saturday">Saturday</option>
                        <option value="Sunday">Sunday</option>
                    </select>

                    <label for="timeInput">Time:</label>
                    <input type="time" name="time" id="timeInput">

                    <div class="modal-buttons">
                        <button type="submit" ">Add</button>
                        <button type="button" onclick="closeModal()">Back</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="actions">
            <button onclick="openModal()">Add</button>
            <form method="post" action="php/functions.php?op=deleteTimeSlot" onsubmit="return deleteTimeSlot();">
                <input type="hidden" id="hiddenID" name="scheduleID" value="">
                <button type="submit">Delete</button>
            </form>
        </div>
    </div>
  </div>


  <script>
    function showSchedule(day, element) {
        // Hide all schedule-day divs
        const scheduleDays = document.querySelectorAll('.schedule-day');
        scheduleDays.forEach(function (dayDiv) {
            dayDiv.style.display = 'none';
        });

        // Show the selected day or all days
        if (day === 'all') {
            scheduleDays.forEach(function (dayDiv) {
                dayDiv.style.display = 'block';
            });
        } else {
            document.getElementById(day).style.display = 'block';
        }

        // Remove selected-day class from all buttons
        const allDayButtons = document.querySelectorAll('.day-btn');
        allDayButtons.forEach(function (btn) {
            btn.classList.remove('selected-day');
        });

        // Add selected-day class to the clicked button
        element.classList.add('selected-day');
    }

    
    document.addEventListener('DOMContentLoaded', function () {
    const allButton = document.querySelector('button[onclick*="all"]');

    showSchedule('all',allButton);
    });


    function selectTimeSlot(element) {
        if(element.classList.contains('selected')){
            element.classList.remove('selected');
            document.getElementById("hiddenID").value = "";

        }
        else{
            const allTimeSlots = document.querySelectorAll('.time-slot');
            allTimeSlots.forEach(slot => {
                slot.classList.remove('selected');
            });
            element.classList.add('selected');
            document.getElementById("hiddenID").value = element.getAttribute('data-value');
            console.log('Selected time:', element.innerText);
        }
    }


    function openModal() {
    document.getElementById("addTimeSlotModal").style.display = "flex";
    }

    // Function to close the modal
    function closeModal() {
    document.getElementById("addTimeSlotModal").style.display = "none";
    }

    // Function to handle adding a time slot (this can be customized based on your needs)
    function addTimeSlot() {
        const selectedDay = document.getElementById("daySelect").value; // Get selected day
        const selectedTime = document.getElementById("timeInput").value; // Get selected time

        // Check if time is selected
        if (!selectedTime) {
            alert('Please select a time.');
            return false; // Prevent form submission
        }

        // Get the selected day's time slots container
        const dayContainer = document.getElementById(selectedDay.toLowerCase()); // Use selectedDay to get the container
        const existingTimeSlots = dayContainer ? dayContainer.querySelectorAll('.time-slot') : [];

        // Check if there are already 2 time slots for the selected day
        if (existingTimeSlots.length >= 2) {
            alert('You cannot add more than 2 time slots for ' + selectedDay.charAt(0).toUpperCase() + selectedDay.slice(1));
            return false; // Prevent form submission
        }

        return true; // Allow form submission
    }

    function deleteTimeSlot(){
        const input = document.getElementById("hiddenID");
        if(input.value == ""){
            alert('Please select a time.');
            return false;
        }
        const userConfirmed = confirm("Are you sure you want to delete this time slot?");
        if(userConfirmed){
            return true;
        }
        else{
            return false;
        }
        
    }


    window.onclick = function(event) {
    const modal = document.getElementById("addTimeSlotModal");
    if (event.target === modal) {
        closeModal();
    }
    };

  </script>
</body>
</html>
