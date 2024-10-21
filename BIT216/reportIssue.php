<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report an Issue</title>
    <link rel="stylesheet" href="css/reportIssue.css">
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
            <?php
                include 'nav.php';
            ?>
        </aside>
        <main class="main-content">
        <form class="report-form">
            <div class="banner">
                <h2>Every report matters. How can we help you?</h2>
            </div>

            <div class="icon-container">
                <div class="icon-box" data-value="missed_pickup">
                    <img src="image/missed_pickup.png" alt="Missed Pickup">
                    <p>Missed PickUp</p>
                </div>
                <div class="icon-box" data-value="overflowing">
                    <img src="image/overflow.png" alt="Overflowing Bin">
                    <p>Overflowing Bin</p>
                </div>
                <div class="icon-box" data-value="dumping">
                    <img src="image/dumping.png" alt="Illegal Dumping">
                    <p>Illegal Dumping</p>
                </div>
                <div class="icon-box" data-value="others">
                    <img src="image/feedback.png" alt="Others">
                    <p>Others</p>
                </div>
            </div>
            <input type="hidden" id="selectedOption" name="selectedOption">
            <div class="input-container">
                <label for="photoUpload">Upload a Photo (optional)</label>
                <span class="semi">:</span>
                <input type="file" id="photoUpload" name="photoUpload" accept="image/*">
            </div>
            <div class="input-container">
                <label for="description">Description</label>
                <span class="semi">:</span>
                <textarea type="text" id="description" placeholder="Enter your details here" oninput="autoExpand(this)"></textarea>
            </div>

            <div class="input-container">
                <label for="location">Location</label>
                <span class="semi">:</span>
                <input type="text" id="location" placeholder="Choose your location here">
            </div>

            <div class="input-container">
                <label for="date">Date</label>
                <span class="semi">:</span>
                <input type="date" id="date" placeholder="Choose your date here">
            </div>

            <div class="submit-container">
                <button type="submit" class="submit-btn">Submit</button>
            </div>
        </form>
            <!-- <header class="header">
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

                    <h2>Embayu Damansara West</h2>  

                    <div class="details">
                        <div class="timetable">
                            <p class="timetable-font">Timetable</p>
                            <div class = "timetable-container">
                                <span class="day">Monday</span>
                                <span class="time">8:30 am</span>
                            </div>
                            <hr class="timetableHR">
                            <div class = "timetable-container">
                                <span class="day">Tuesday</span>
                                <span class="time">8:30 am</span>
                            </div>
                            <hr class="timetableHR">
                            <div class = "timetable-container">
                                <span class="day">Wednesday</span>
                                <span class="time">-</span>
                            </div>
                            <hr class="timetableHR">
                            <div class = "timetable-container">
                                <span class="day">Thursday</span>
                                <span class="time">8:30 am</span>
                            </div>
                            <hr class="timetableHR">
                            <div class = "timetable-container">
                                <span class="day">Friday</span>
                                <span class="time">8:30 am</span>
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
                        <button class="schedule-btn">
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
                        
                    </div>
                    <div class="statistics">
                        <h2 class="statistics-h2">Statistics</h2>
                        <canvas id="myChart"></canvas>
                    </div>
                </div>
            </section> -->
        </main>
    </div>

    <script>
        const iconBoxes = document.querySelectorAll('.icon-box');
        const selectedOption = document.getElementById('selectedOption');


        iconBoxes.forEach(box => {
            box.addEventListener('click', function() {
                // Remove 'active' class from all icon boxes
                if(this.classList.contains('active')){
                    iconBoxes.forEach(b => b.classList.remove('active'));
                    selectedOption.value = '';
                }
                else{
                    iconBoxes.forEach(b => b.classList.remove('active'));
                    this.classList.add('active');
                    selectedOption.value = this.dataset.value;
                }
                //console.log(selectedOption.value);
            });
        });
    </script>

    <script>

    const datePicker = document.getElementById('date');


    // const today = new Date();


    // const tomorrow = new Date(today);
    // tomorrow.setDate(today.getDate() + 1); 

    // // Format the date as yyyy-mm-dd
    // const year = tomorrow.getFullYear();
    // const month = String(tomorrow.getMonth() + 1).padStart(2, '0'); 
    // const day = String(tomorrow.getDate()).padStart(2, '0');
    
    // const minDate = `${year}-${month}-${day}`;

    
    // datePicker.setAttribute('min', minDate);
    datePicker.addEventListener('click', () => {
            datePicker.showPicker(); 
    }); 
</script>

<script> 
    function autoExpand(textarea) {
        textarea.style.height = "auto"; // Reset the height to auto to recalculate
        textarea.style.height = textarea.scrollHeight + "px"; // Set it to the new height
}
</script>


</body>
</html>
