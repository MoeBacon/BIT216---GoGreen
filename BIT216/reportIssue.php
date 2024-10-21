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
        <form class="report-form" id="form" method="post" action="php/functions.php?op=issueReport" enctype="multipart/form-data">
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
            <input type="hidden" id="selectedOption" name="selectedOption" value="">
            <div class="input-container">
                <label for="photoUpload">Upload a Photo (optional)</label>
                <span class="semi">:</span>
                <div class="file-upload-wrapper">
                    <input type="file" id="photoUpload" name="photoUpload" accept=".jpg, .jpeg, .png, image/*">
                    <span class="remove-file" id="removeFile">&times;</span>
                </div>

            </div>
            <div class="input-container">
                <label for="description">Description</label>
                <span class="semi">:</span>
                <textarea type="text" id="description" placeholder="Enter your details here" name="description" required></textarea>
            </div>

            <div class="input-container">
                <label for="location">Location</label>
                <span class="semi">:</span>
                <input type="text" id="location" placeholder="Enter your location here" name="location" required>
            </div>

            <div class="input-container">
                <label for="date">Date</label>
                <span class="semi">:</span>
                <input type="date" id="date" placeholder="Choose your date here" name="date" required>
            </div>

            <div class="submit-container">
                <button type="submit" class="submit-btn">Submit</button>
            </div>
        </form>
        <?php
            if(isset($_GET['op'])){
                $date = $_GET['op'];
                echo '<input type="hidden" id="hiddenDate" name="date" value="' . $date . '">';
            }
        ?>
            

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
                console.log(selectedOption.value);
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
const hiddenDateInput = document.getElementById('hiddenDate');
const dateInput = document.getElementById('date');
if (hiddenDateInput) {
    dateInput.value = hiddenDateInput.value;
}

</script>

<script>
    const photoUpload = document.getElementById('photoUpload');
    const removeFile = document.getElementById('removeFile');

    photoUpload.addEventListener('change', function() {
        if (photoUpload.files.length > 0) {
            removeFile.style.display = 'inline';
        }
    });

    removeFile.addEventListener('click', function() {
        photoUpload.value = '';
        removeFile.style.display = 'none';
    });
</script>

<script>
    const form = document.getElementById('form');
    form.addEventListener('submit', function(event) {
        if(selectedOption.value == ''){
            alert('Please select an issue type before submitting.');
            event.preventDefault(); 
        }
    });

</script>


</body>
</html>
