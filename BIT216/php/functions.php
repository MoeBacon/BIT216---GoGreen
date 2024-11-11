<?php
include 'dbConnect.php';
if ($dbConnection->connect_error) {
    die("Connection failed: " . $dbConnection->connect_error);
}
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';


if($_GET['op'] == 'userSignUp'){
    $fname = $_POST['name'];
    $lname = $_POST['surname'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $comID = $_POST['community_name'];
    $address = $_POST['address'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $role = "user";
    $sql = "SELECT userEmail FROM user";
    $user = mysqli_query($dbConnection, $sql);
    $found=false;
    while($row = mysqli_fetch_assoc($user)){
        if($row['userEmail'] == $email){
            $found = true;
        }
    }
    if($found){
        echo "<script> alert('This email address is already registered. Please choose another email.');
        location = '../signup.php';
        </script>";
    }

    $tempPwd = generateRandomPassword();


    if (!$found){
        $sql = "INSERT INTO user(userFname,userLname,userPwd,userPhone,userEmail,userAddress,userCity,userState,userRole,pwdStatus,comID)
        VALUES ('$fname','$lname','$tempPwd','$phone','$email','$address','$city','$state','$role','temp','$comID')";
        mysqli_query($dbConnection,$sql);
        
        echo "<script> alert('Registration successful. You can now login to your account with the temporary password sent to your email.');
        location = '../login.php';
        </script>";


        $mail = new PHPMailer(true);
    
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'localxplorerphp@gmail.com';
        $mail->Password = 'qnaw oijn gmcd hcka';
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;
    
        $mail->setFrom('localxplorerphp@gmail.com');
        $mail->addAddress($email);
    
        $mail->isHTML(true);
        
        $mail->Subject = 'Default Password for GoGreen';
        $mail->Body = "You can now use the password below to login to your account:<br>
        $tempPwd";
    
        $mail->send();
    }
}

if($_GET['op'] == 'adminSignup'){
    
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $pass = $_POST['password'];
    $community = $_POST['community_name'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $role = "admin";


    // $sql = "INSERT INTO request(Phone,Email,Description,Filename,File,Status,Date) VALUES('$phone','$email','$description','$filename','','$status','$date')";
    $sql = "SELECT userEmail FROM user";
    $user = mysqli_query($dbConnection, $sql);
    $found=false;
    while($row = mysqli_fetch_assoc($user)){
        if($row['userEmail'] == $email){
            $found = true;
        }
    }

    if($found){
        echo "<script> alert('This email address is already registered. Please choose another email.');
        location = '../signup.php';
        </script>";
    }


    $sql2 = "SELECT comArea FROM community";
    $communityQ = mysqli_query($dbConnection,$sql2);
    $communityFound = false;

    while($row = mysqli_fetch_assoc($communityQ)){
        if(strtolower($row['comArea']) == strtolower($community)){
            $communityFound = true;
        }
    }

    if($communityFound){
        echo "<script> alert('This community is already registered.');
        location = '../signup.php';
        </script>";
    }

    
    if (!$found && !$communityFound){
        $sql3 = "INSERT INTO community(comArea,comCity,comState)
        VALUES('$community','$city','$state')";
        mysqli_query($dbConnection,$sql3);
        $comID = mysqli_insert_id($dbConnection);

        $sql4 = "INSERT INTO user(userFname,userLname,userPwd,userPhone,userEmail,userCity,userState,userRole,comID) 
        VALUES('$fname','$lname','$pass','$phone','$email','$city','$state','$role','$comID')";
        mysqli_query($dbConnection, $sql4);
        echo "<script> alert('Your registration is success. You can now login to your account.');
        location = '../login.php';
        </script>";
    }

}


if($_GET['op'] == 'login'){
    $email = $_POST['name'];
    $pass = $_POST['password'];
    $role;
    $sql = "SELECT * FROM user";
    $userQ = mysqli_query($dbConnection, $sql);
    $emailFound = false;
    $passFound = false;
    
    while($user = mysqli_fetch_assoc($userQ)){
        if($email == $user['userEmail']){
            $emailFound = true;
            $sql2 = "SELECT pwdStatus FROM user WHERE userEmail = '$email'";
            $result = mysqli_query($dbConnection,$sql2);
            $row = mysqli_fetch_assoc($result);

            if($row['pwdStatus'] == "temp" && $pass == $user['userPwd']){
                session_start();
                $_SESSION['username'] = $user['userEmail'];
                header("Location: ../first_login.php");
            }
            elseif($pass == $user['userPwd']){
                $passFound = true;
                $role = $user['userRole'];
                session_start();
                $_SESSION['username'] = $user['userEmail'];
                if(isset($_POST['remember'])){ 
                    setcookie('email',$email,time()+60 * 60 * 24 * 7, '/');
                    setcookie('pass',$pass,time()+60 * 60 * 24 * 7, '/');
                }
                else{
                    setcookie('email', '', time() - 3600, '/');
                    setcookie('pass', '', time() - 3600, '/');
                }
                if($role == "user"){
                    header("Location: ../dashboard.php");
                }
                elseif($role == "admin"){
                    header("Location: ../admin_dashboard.php");
                }
            }
        }
    }


    if(!$emailFound){
        echo "<script> alert('Invalid email.');
        location = '../login.php';
        </script>";
    }
    else{
        if(!$passFound){
        echo "<script> alert('Invalid password.');
        location = '../login.php';
        </script>";
        }
    }

}

if($_GET['op']=="firstLogin"){
    session_start();
    $email = $_SESSION['username'];
    $pass = $_POST['password'];
    $sql = "UPDATE user SET userPwd = '$pass' WHERE userEmail = '$email'";
    mysqli_query($dbConnection,$sql);
    $sql2 = "UPDATE user SET pwdStatus = 'changed' WHERE userEmail = '$email'";
    mysqli_query($dbConnection,$sql2);
    echo "<script>alert('Your password has been reset.');
        location = '../dashboard.php';</script>";
}


    if($_GET['op'] == "signOut"){
        $currentDate = date('Y-m-d');
        $sql = "SELECT * FROM pickup WHERE pickupDate < '$currentDate' AND pickupStatus = 'Pending'";
        $result = mysqli_query($dbConnection,$sql);
        if(mysqli_num_rows($result) > 0){
            while($row = mysqli_fetch_assoc($result)){
                $id = $row['pickupID'];
                $sql2  = "UPDATE pickup SET pickupStatus = 'Completed' WHERE pickupID = $id";
                mysqli_query($dbConnection,$sql2);
            }
        }
        session_start();
        session_destroy();
        header("Location: ../login.php");
    }


if($_GET['op'] == 'forgetPass'){
    $email = $_POST['email'];

    $sql = "SELECT userEmail FROM user";
    $userQ = mysqli_query($dbConnection, $sql);
    $emailFound = false;
    while($user = mysqli_fetch_assoc($userQ)){
        if($email == $user['userEmail']){
            $emailFound = true;
        }
    }

    if($emailFound){
    
        $mail = new PHPMailer(true);
    
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'localxplorerphp@gmail.com';
        $mail->Password = 'qnaw oijn gmcd hcka';
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;
    
        $mail->setFrom('localxplorerphp@gmail.com');
        $mail->addAddress($email);
    
        $mail->isHTML(true);
        
        $mail->Subject = 'Reset Password';
        $mail->Body = "Click the link below to reset your password<br>
       http://localhost/BIT216/reset_password.php?token=$email";
    
        $mail->send();
    
        echo "<script>alert('Please check your email to reset your password.');
        location = '../forget_password.php';    </script>";
        
    }
    else{
        echo "<script>alert('Invalid email please try again.');
        location = '../login.php';</script>";
    }


}

if($_GET['op'] == 'resetPass'){
    $email = $_POST['token'];
    $pass = $_POST['password'];
    $sql = "UPDATE user SET userPwd = '$pass' WHERE userEmail = '$email'";
    mysqli_query($dbConnection,$sql);
    echo "<script>alert('Your password has been reset.');
        location = '../login.php';</script>";
}

if($_GET['op'] == 'addTimeSlot'){
    $day = $_POST['day'];
    $time = $_POST['time'];

    // Convert to 12-hour format with AM/PM
    $timeObj = DateTime::createFromFormat('H:i', $time);
    $formattedTime = $timeObj->format('g:i A'); // Output as xx:xx AM/PM

    session_start();
    $email = $_SESSION['username'];

    $sql = "SELECT comID FROM user WHERE userEmail = '$email'";
    $result = mysqli_query($dbConnection,$sql);
    $row = mysqli_fetch_assoc($result);
    $comID = $row['comID'];
    
    $sql2 = "INSERT INTO schedule (scheDay,scheTime,comID)
            VALUES('$day','$formattedTime','$comID')";
    mysqli_query($dbConnection,$sql2);
    echo "<script>alert('New time slot added.');
    location = '../admin_schedule.php';</script>";
}

if($_GET['op'] == 'deleteTimeSlot'){
    $scheduleID = $_POST['scheduleID'];
    $sql = "DELETE FROM schedule WHERE scheduleID = '$scheduleID'";
    mysqli_query($dbConnection,$sql);
    echo "<script>alert('Time slot deleted.');
    location = '../admin_schedule.php';</script>";
}

if($_GET['op'] == 'addPickup'){
    session_start();
    $email = $_SESSION['username'];
    $sql = "SELECT userID FROM user WHERE userEmail = '$email'";
    $result = mysqli_query($dbConnection,$sql);
    $row = mysqli_fetch_assoc($result);
    $userID = $row['userID'];

    $type = $_POST['selectedOption'];
    $date = $_POST['day'];
    $time = $_POST['time'];
    $status = "Pending";

    $UCType = ucfirst($type);
    $sql2 = "INSERT INTO pickup(pickupType,pickupDate,pickupTime,pickupStatus,userID)
    VALUES('$type','$date','$time','$status','$userID')";
    mysqli_query($dbConnection,$sql2);
    $pickupID = mysqli_insert_id($dbConnection);

    $mail = new PHPMailer(true);
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'localxplorerphp@gmail.com';
    $mail->Password = 'qnaw oijn gmcd hcka';
    $mail->SMTPSecure = 'ssl';
    $mail->Port = 465;

    $mail->setFrom('localxplorerphp@gmail.com');
    $mail->addAddress($email);

    $mail->isHTML(true);
    
    $mail->Subject = 'Waste Pickup Confirmation';
    $mail->Body = "Thank you for scheduling your waste pickup with GoGreen. Here are the details of your request:<br>
                    Pickup ID: $pickupID<br>
                    Pickup Date: $date<br>
                    Pickup Time: $time<br>
                    Waste Type: $UCType Waste<br><br>
                    Please ensure your waste is properly sorted and placed in the designated area before the scheduled time.<br><br>
                    Thank you for contributing to a cleaner, greener community!";

    $mail->send();

    echo "<script>alert('New pickup scheduled.');
    location = '../schedule.php';</script>";
}

if($_GET['op'] == 'issueReport'){
    session_start();
    $email = $_SESSION['username'];
    $sql = "SELECT userID FROM user WHERE userEmail = '$email'";
    $result = mysqli_query($dbConnection,$sql);
    $row = mysqli_fetch_assoc($result);
    $userID = $row['userID'];

    $issueType = $_POST['selectedOption'];
    $description = $_POST['description'];
    $location = $_POST['location'];
    $date = $_POST['date'];

    // Get the original file name and extension
    $fileName = basename($_FILES["photoUpload"]["name"]);
    $fileType = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

    // Create a unique file name by concatenating the current date or timestamp
    $uniqueFileName = pathinfo($fileName, PATHINFO_FILENAME) . "_" . date("YmdHis") . "." . $fileType;

    // Set the target directory and file path
    $targetDir = "../photoUpload/";
    $targetFilePath = $targetDir . $uniqueFileName;

    // Allow only specific file formats
    $allowedTypes = array("jpg", "jpeg", "png");

    if (empty($_FILES["photoUpload"]["name"])){
        $sql2 = "INSERT INTO issue(issueType, issueDate, issueLoc, issueDesc, issuePhoto, userID) 
              VALUES ('$issueType', '$date', '$location', '$description', NULL, '$userID')";
        if (mysqli_query($dbConnection, $sql2)) {
            $issueID = mysqli_insert_id($dbConnection);
            echo "<script>alert('Your issue has been reported to the admin of your community.'); 
            location = '../reportIssue.php';</script>";
            $mail = new PHPMailer(true);
    
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'localxplorerphp@gmail.com';
            $mail->Password = 'qnaw oijn gmcd hcka';
            $mail->SMTPSecure = 'ssl';
            $mail->Port = 465;
        
            $mail->setFrom('localxplorerphp@gmail.com');
            $mail->addAddress($email);
        
            $mail->isHTML(true);
            
            $mail->Subject = 'Reported Issue';
            $mail->Body = "Reported Issue Details:<br>
                            Report ID: $issueID<br>
                            Status: Pending<br>
                            Location: $location<br>
                            Description: $description<br><br>
                            Our admin team will review the issue and take necessary actions. You will be updated regarding the status of your report.<br>
                            Thank you for your cooperation!<br>
                            Best regards, Your Community Support Team";
        
            $mail->send();
            exit;
        } else {
            echo "Error: " . $sql2 . "<br>" . $dbConnection->error;
        }
    }

    if (in_array($fileType, $allowedTypes)) {   
        // Move file to target directory
        if (move_uploaded_file($_FILES["photoUpload"]["tmp_name"], $targetFilePath)) {

            // Insert the data into the database with the unique file name
            $sql2 = "INSERT INTO issue(issueType,issueDate,issueLoc,issueDesc,issuePhoto,userID) 
                    VALUES ('$issueType', '$date','$location','$description','$uniqueFileName','$userID')";
            if (mysqli_query($dbConnection, $sql2)) {
                $issueID = mysqli_insert_id($dbConnection);
                echo "<script>alert('Your issue has been reported to the admin of your community.');
                location = '../reportIssue.php';</script>";
                $mail = new PHPMailer(true);
    
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'localxplorerphp@gmail.com';
                $mail->Password = 'qnaw oijn gmcd hcka';
                $mail->SMTPSecure = 'ssl';
                $mail->Port = 465;
            
                $mail->setFrom('localxplorerphp@gmail.com');
                $mail->addAddress($email);
            
                $mail->isHTML(true);
                
                $mail->Subject = 'Reported Issue';
                $mail->Body = "Reported Issue Details:<br>
                                Report ID: $issueID<br>
                                Status: Pending<br>
                                Location: $location<br>
                                Description: $description<br><br>
                                Our admin team will review the issue and take necessary actions. You will be updated regarding the status of your report.<br>
                                Thank you for your cooperation!<br>
                                Best regards, Your Community Support Team";
            
                $mail->send();
            } else {
                echo "Error: " . $sql2 . "<br>" . $dbConnection->error;
            }
        } else {
            echo "<script>alert('Sorry, there was an error uploading your file.');
            location = '../reportIssue.php';</script>";
        }
    } else {
        echo "<script>alert('Sorry, only JPG, JPEG, PNG files are allowed.');
            location = '../reportIssue.php';</script>";
    }

}




if($_GET['op'] == 'userPickupStatistics'){
    session_start();
    $email = $_SESSION['username'];
    $sql = "SELECT userID FROM user WHERE userEmail = '$email'";
    $result = mysqli_query($dbConnection,$sql);
    $row = mysqli_fetch_assoc($result);
    $userID = $row['userID'];

   $date = $_GET['dateRange'];


   $data = [
    'yValues' => [0, 0, 0], // Initialize an array for the counts
    'result' => '' // Additional variable for total pickup count
    ];
    $startDate;
    $endDate;
    if (strpos($date, ' to ') !== false) {
        // It's a date range, split it into two variables
        list($startDate, $endDate) = explode(' to ', $date);
        
        // Use $startDate and $endDate for the SQL query
        $sql2 = "SELECT pickupType, COUNT(*) as count FROM pickup WHERE userID = '$userID' AND pickupDate BETWEEN ? AND ? GROUP BY pickupType";
        
        $stmt = mysqli_prepare($dbConnection, $sql2);
        if ($stmt) {
            // Bind parameters for the date range
            mysqli_stmt_bind_param($stmt, "ss", $startDate, $endDate);
        }
    } else {
        // It's a single date
        $sql2 = "SELECT pickupType, COUNT(*) as count FROM pickup WHERE userID = '$userID' AND pickupDate = ? GROUP BY pickupType";
        
        $stmt = mysqli_prepare($dbConnection, $sql2);
        if ($stmt) {
            // Bind the single date parameter
            mysqli_stmt_bind_param($stmt, "s", $date);
        }
    }


    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    // Initialize the values array
    $data['yValues'] = [0, 0, 0]; // Assuming 3 waste types: Paper, Plastic, etc.

    while ($row = mysqli_fetch_assoc($result)) {
        // Map the waste types to the respective index in the values array
        if ($row['pickupType'] == 'household') {
            $data['yValues'][0] = (int)$row['count'];
        } elseif ($row['pickupType'] == 'recyclable') {
            $data['yValues'][1] = (int)$row['count'];
        } elseif ($row['pickupType'] == 'hazardous') {
            $data['yValues'][2] = (int)$row['count'];
        }

    }

    if(mysqli_num_rows($result)>0){
        $data['result'] = 'pass';
    }
    else{
        $data['result'] = 'noData';
    }


    mysqli_stmt_close($stmt); // Close the prepared statement

    

    // Return the data as JSON
    header('Content-Type: application/json');
    echo json_encode($data);
}


if($_GET['op'] == 'userIssueReported'){
    session_start();
    $email = $_SESSION['username'];
    $sql = "SELECT userID FROM user WHERE userEmail = '$email'";
    $result = mysqli_query($dbConnection,$sql);
    $row = mysqli_fetch_assoc($result);
    $userID = $row['userID'];

   $date = $_GET['dateRange'];


   $data = [
    'yValues' => [0, 0, 0, 0], // Initialize an array for the counts
    'result' => '' // Additional variable for total pickup count
    ];
    $startDate;
    $endDate;
    if (strpos($date, ' to ') !== false) {
        // It's a date range, split it into two variables
        list($startDate, $endDate) = explode(' to ', $date);
        
        // Use $startDate and $endDate for the SQL query
        $sql2 = "SELECT issueType, COUNT(*) as count FROM issue WHERE userID = '$userID' AND issueDate BETWEEN ? AND ? GROUP BY issueType";
        
        $stmt = mysqli_prepare($dbConnection, $sql2);
        if ($stmt) {
            // Bind parameters for the date range
            mysqli_stmt_bind_param($stmt, "ss", $startDate, $endDate);
        }
    } else {
        // It's a single date
        $sql2 = "SELECT issueType, COUNT(*) as count FROM issue WHERE userID = '$userID' AND issueDate = ? GROUP BY issueType";
        
        $stmt = mysqli_prepare($dbConnection, $sql2);
        if ($stmt) {
            // Bind the single date parameter
            mysqli_stmt_bind_param($stmt, "s", $date);
        }
    }


    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    // Initialize the values array
    $data['yValues'] = [0, 0, 0, 0]; 

    while ($row = mysqli_fetch_assoc($result)) {
        // Map the waste types to the respective index in the values array
        if ($row['issueType'] == 'missed_pickup') {
            $data['yValues'][0] = (int)$row['count'];
        } elseif ($row['issueType'] == 'overflowing') {
            $data['yValues'][1] = (int)$row['count'];
        } elseif ($row['issueType'] == 'dumping') {
            $data['yValues'][2] = (int)$row['count'];
        } elseif ($row['issueType'] == 'others') {
            $data['yValues'][3] = (int)$row['count'];
        }

    }

    if(mysqli_num_rows($result)>0){
        $data['result'] = 'pass';
    }
    else{
        $data['result'] = 'noData';
    }


    mysqli_stmt_close($stmt); // Close the prepared statement

    

    // Return the data as JSON
    header('Content-Type: application/json');
    echo json_encode($data);
}




if($_GET['op'] == 'userRateOfRecycling'){
    session_start();
    $email = $_SESSION['username'];
    $sql = "SELECT userID FROM user WHERE userEmail = '$email'";
    $result = mysqli_query($dbConnection, $sql);
    $row = mysqli_fetch_assoc($result);
    $userID = $row['userID'];

    $date = $_GET['dateRange'];
    $data = [
        'recyclingData' => [],
        'result' => ''
    ];

    list($startDate, $endDate) = explode(' to ', $date);
    $start = new DateTime($startDate);
    $end = new DateTime($endDate);

    $interval = $start->diff($end);
    $days = $interval->days + 1; // Include both start and end date

    // Find the day of the week for the start and end dates (0=Sunday, 6=Saturday)
    $startDayOfWeek = $start->format('w'); // Day of the week for start date
    $endDayOfWeek = $end->format('w');     // Day of the week for end date

    // Calculate the number of weeks
    $weeks = 1; // The first day is considered its own week

    // If the start and end are not within the same week, calculate the number of extra weeks
    if ($days > (7 - $startDayOfWeek)) { // If more than the first partial week
        $remainingDays = $days - (7 - $startDayOfWeek); // Days left after the first partial week
        $weeks += ceil($remainingDays / 7); // Each group of 7 days forms a week
    }

    $sql2 = "SELECT 
                WEEK(pickupDate) AS week_number,      -- Get the week number of each date
                COUNT(*) AS total_pickup,             -- Count the total number of pickups in each week
                COUNT(CASE WHEN pickupType = 'recyclable' THEN 1 END) AS recyclable_pickups, -- Count pickups of type 'recyclable'
                ROUND((COUNT(CASE WHEN pickupType = 'recyclable' THEN 1 END) / COUNT(*) * 100), 2) AS recycling_rate -- Recycling rate rounded to 2 decimal places
            FROM 
                pickup
            WHERE 
                pickupDate BETWEEN '$startDate' AND '$endDate' 
                AND userID = '$userID'
            GROUP BY 
                week_number                  
            ORDER BY 
                week_number";

    $counter = 0;
    $result = mysqli_query($dbConnection, $sql2);
    
    while($row = mysqli_fetch_assoc($result)) {
        $data['recyclingData'][$counter] = [(int)$counter+1, (float)$row['recycling_rate']];
        $counter++;
    }
    if(mysqli_num_rows($result)>0){
        $data['result'] = 'pass';
    }
    else{
        $data['result'] = 'noData';
    }


    header('Content-Type: application/json');
    echo json_encode($data);
}




if($_GET['op'] == 'add_announcement'){
    session_start();
    $email = $_SESSION['username'];
    $sql = "SELECT comID FROM user WHERE userEmail = '$email'";
    $result = mysqli_query($dbConnection, $sql);
    $row = mysqli_fetch_assoc($result);
    $comID = $row['comID'];


    $title = $_POST['title'];
    $content = $_POST['content'];

    $fileName = basename($_FILES["image"]["name"]);

    $fileType = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

    // Create a unique file name by concatenating the current date or timestamp
    $uniqueFileName = pathinfo($fileName, PATHINFO_FILENAME) . "_" . date("YmdHis") . "." . $fileType;

    // Set the target directory and file path
    $targetDir = "../photoUpload/";
    $targetFilePath = $targetDir . $uniqueFileName;

    // Allow only specific file formats
    $allowedTypes = array("jpg", "jpeg", "png");

    if (empty($_FILES["image"]["name"])){
        $sql2 = "INSERT INTO announcement(annoTitle,annoDesc,annoImage,comID) 
              VALUES ('$title', '$content', NULL, '$comID')";
        if (mysqli_query($dbConnection, $sql2)) {

            echo "<script>alert('New announcement added.'); 
            location = '../admin_announcement.php';</script>";
            exit;
        } else {
            echo "Error: " . $sql2 . "<br>" . $dbConnection->error;
        }
    }

    if (in_array($fileType, $allowedTypes)) {   
        // Move file to target directory
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFilePath)) {

            // Insert the data into the database with the unique file name
            $sql2 = "INSERT INTO announcement(annoTitle,annoDesc,annoImage,comID) 
                    VALUES ('$title', '$content', '$uniqueFileName', '$comID')";
            if (mysqli_query($dbConnection, $sql2)) {
                echo "<script>alert('New announcement added.');
                location = '../admin_announcement.php';</script>";
            } else {
                echo "Error: " . $sql2 . "<br>" . $dbConnection->error;
            }
        } else {
            echo "<script>alert('Sorry, there was an error uploading your file.');
            location = '../reportIssue.php';</script>";
        }
    } else {
        echo "<script>alert('Sorry, only JPG, JPEG, PNG files are allowed.');
            location = '../reportIssue.php';</script>";
    }
}

if($_GET['op'] == 'admin_all_announcement'){
    session_start();
    $email = $_SESSION['username'];
    $sql = "SELECT comID FROM user WHERE userEmail = '$email'";
    $result = mysqli_query($dbConnection, $sql);
    $row = mysqli_fetch_assoc($result);
    $comID = $row['comID'];

    $sql = "SELECT annoTitle AS title, annoDesc AS content, DATE_FORMAT(annoDate, '%Y-%m-%d') AS date, annoImage AS image FROM announcement WHERE comID = '$comID' ORDER BY annoDate DESC";
    $result = $dbConnection->query($sql);

    $announcements = [];

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $announcements[] = [
                'title' => $row['title'],
                'content' => $row['content'],
                'date' => $row['date'],
                'image' => $row['image'] ? "photoUpload/" . $row['image'] : null // Set image path or null
            ];
        }
    }

    // Return the announcements as JSON
    header('Content-Type: application/json');
    echo json_encode($announcements);
}

if($_GET['op'] == 'adminIssueReported'){
    session_start();
    $email = $_SESSION['username'];
    $sql = "SELECT userID FROM user WHERE userEmail = '$email'";
    $result = mysqli_query($dbConnection,$sql);
    $row = mysqli_fetch_assoc($result);
    $userID = $row['userID'];

    $date = $_GET['issueReportedDate'];
    $comID = $_GET['communityIssue'];

   $data = [
    'yValues' => [0, 0, 0, 0], // Initialize an array for the counts
    'result' => '' // Additional variable for total pickup count
    ];
    $startDate;
    $endDate;
    if (strpos($date, ' to ') !== false) {
        // It's a date range, split it into two variables
        list($startDate, $endDate) = explode(' to ', $date);
        
        // Use $startDate and $endDate for the SQL query
        $sql2 = "SELECT i.issueType, COUNT(*) AS count
                    FROM issue i
                    JOIN user u ON i.userID = u.userID
                    WHERE u.comID = ?
                    AND i.issueDate BETWEEN ? AND ?
                    GROUP BY i.issueType";
        
        $stmt = mysqli_prepare($dbConnection, $sql2);
        if ($stmt) {
            // Bind parameters for the date range
            mysqli_stmt_bind_param($stmt, "sss", $comID, $startDate, $endDate);
        }
    } else {
        // It's a single date
        $sql2 = "SELECT i.issueType, COUNT(*) AS count
                    FROM issue i
                    JOIN user u ON i.userID = u.userID
                    WHERE u.comID = ?
                    AND i.issueDate = ?
                    GROUP BY i.issueType";
        
        $stmt = mysqli_prepare($dbConnection, $sql2);
        if ($stmt) {
            // Bind the single date parameter
            mysqli_stmt_bind_param($stmt, "ss", $comID, $date);
        }
    }


    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    // Initialize the values array
    $data['yValues'] = [0, 0, 0, 0]; 

    while ($row = mysqli_fetch_assoc($result)) {
        // Map the waste types to the respective index in the values array
        if ($row['issueType'] == 'missed_pickup') {
            $data['yValues'][0] = (int)$row['count'];
        } elseif ($row['issueType'] == 'overflowing') {
            $data['yValues'][1] = (int)$row['count'];
        } elseif ($row['issueType'] == 'dumping') {
            $data['yValues'][2] = (int)$row['count'];
        } elseif ($row['issueType'] == 'others') {
            $data['yValues'][3] = (int)$row['count'];
        }

    }

    if(mysqli_num_rows($result)>0){
        $data['result'] = 'pass';
    }
    else{
        $data['result'] = 'noData';
    }


    mysqli_stmt_close($stmt); // Close the prepared statement

    

    // Return the data as JSON
    header('Content-Type: application/json');
    echo json_encode($data);
}


if($_GET['op'] == 'adminPickupStatistics'){
    session_start();
    $email = $_SESSION['username'];
    $sql = "SELECT userID FROM user WHERE userEmail = '$email'";
    $result = mysqli_query($dbConnection,$sql);
    $row = mysqli_fetch_assoc($result);
    $userID = $row['userID'];

   $date = $_GET['pickupDate'];
   $comID = $_GET['communityPickup'];


   $data = [
    'yValues' => [0, 0, 0], // Initialize an array for the counts
    'result' => '' // Additional variable for total pickup count
    ];
    $startDate;
    $endDate;
    if (strpos($date, ' to ') !== false) {
        // It's a date range, split it into two variables
        list($startDate, $endDate) = explode(' to ', $date);
        
        // Use $startDate and $endDate for the SQL query
        $sql2 = "SELECT p.pickupType, COUNT(*) AS count
                FROM pickup p
                JOIN user u ON p.userID = u.userID
                WHERE u.comID = ?  -- Check for a specific comID
                AND p.pickupDate BETWEEN ? AND ?
                GROUP BY p.pickupType";
        
        $stmt = mysqli_prepare($dbConnection, $sql2);
        if ($stmt) {
            // Bind parameters for the date range
            mysqli_stmt_bind_param($stmt, "sss", $comID, $startDate, $endDate);
        }
    } else {
        // It's a single date
        $sql2 = "SELECT p.pickupType, COUNT(*) AS count
                FROM pickup p
                JOIN user u ON p.userID = u.userID
                WHERE u.comID = ?  -- Check for a specific comID
                AND p.pickupDate = ?
                GROUP BY p.pickupType";
        
        $stmt = mysqli_prepare($dbConnection, $sql2);
        if ($stmt) {
            // Bind the single date parameter
            mysqli_stmt_bind_param($stmt, "ss", $comID, $date);
        }
    }


    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    // Initialize the values array
    $data['yValues'] = [0, 0, 0]; // Assuming 3 waste types: Paper, Plastic, etc.

    while ($row = mysqli_fetch_assoc($result)) {
        // Map the waste types to the respective index in the values array
        if ($row['pickupType'] == 'household') {
            $data['yValues'][0] = (int)$row['count'];
        } elseif ($row['pickupType'] == 'recyclable') {
            $data['yValues'][1] = (int)$row['count'];
        } elseif ($row['pickupType'] == 'hazardous') {
            $data['yValues'][2] = (int)$row['count'];
        }

    }

    if(mysqli_num_rows($result)>0){
        $data['result'] = 'pass';
    }
    else{
        $data['result'] = 'noData';
    }


    mysqli_stmt_close($stmt); // Close the prepared statement

    

    // Return the data as JSON
    header('Content-Type: application/json');
    echo json_encode($data);
}

if($_GET['op'] == 'adminRateOfRecycling'){
    session_start();
    $email = $_SESSION['username'];
    $sql = "SELECT userID FROM user WHERE userEmail = '$email'";
    $result = mysqli_query($dbConnection, $sql);
    $row = mysqli_fetch_assoc($result);
    $userID = $row['userID'];

    $date = $_GET['RORDate'];
    $comID = $_GET['communityROR'];
    $data = [
        'recyclingData' => [],
        'result' => ''
    ];

    list($startDate, $endDate) = explode(' to ', $date);
    $start = new DateTime($startDate);
    $end = new DateTime($endDate);

    $interval = $start->diff($end);
    $days = $interval->days + 1; // Include both start and end date

    // Find the day of the week for the start and end dates (0=Sunday, 6=Saturday)
    $startDayOfWeek = $start->format('w'); // Day of the week for start date
    $endDayOfWeek = $end->format('w');     // Day of the week for end date

    // Calculate the number of weeks
    $weeks = 1; // The first day is considered its own week

    // If the start and end are not within the same week, calculate the number of extra weeks
    if ($days > (7 - $startDayOfWeek)) { // If more than the first partial week
        $remainingDays = $days - (7 - $startDayOfWeek); // Days left after the first partial week
        $weeks += ceil($remainingDays / 7); // Each group of 7 days forms a week
    }

    $sql2 = "SELECT 
                WEEK(p.pickupDate) AS week_number,      -- Get the week number of each date
                COUNT(*) AS total_pickup,               -- Count the total number of pickups in each week
                COUNT(CASE WHEN p.pickupType = 'recyclable' THEN 1 END) AS recyclable_pickups, -- Count pickups of type 'recyclable'
                ROUND((COUNT(CASE WHEN p.pickupType = 'recyclable' THEN 1 END) / COUNT(*) * 100), 2) AS recycling_rate -- Recycling rate rounded to 2 decimal places
            FROM 
                pickup p
            JOIN 
                user u ON p.userID = u.userID           -- Join the 'user' table to access comID
            WHERE 
                u.comID = '$comID'                       -- Set the condition for comID
                AND p.pickupDate BETWEEN '$startDate' AND '$endDate'        -- Use placeholders for the date range
            GROUP BY 
                week_number                   
            ORDER BY 
                week_number";

    $counter = 0;
    $result = mysqli_query($dbConnection, $sql2);
    
    while($row = mysqli_fetch_assoc($result)) {
        $data['recyclingData'][$counter] = [(int)$counter+1, (float)$row['recycling_rate']];
        $counter++;
    }
    if(mysqli_num_rows($result)>0){
        $data['result'] = 'pass';
    }
    else{
        $data['result'] = 'noData';
    }


    header('Content-Type: application/json');
    echo json_encode($data);
}
?>











<?php
//functions here
function generateRandomPassword($length = 8) {
    // Define possible characters for the password
    $upperCaseLetters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $lowerCaseLetters = 'abcdefghijklmnopqrstuvwxyz';
    $numbers = '0123456789';
    $specialCharacters = '!@#$%^&*()-_=+<>?';


    $allCharacters = $upperCaseLetters . $lowerCaseLetters . $numbers . $specialCharacters;


    $password = '';
    $charactersLength = strlen($allCharacters);

    for ($i = 0; $i < $length; $i++) {
        $password .= $allCharacters[rand(0, $charactersLength - 1)];
    }

    return $password;
}




?>