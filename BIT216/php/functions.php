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
    
        echo "<script>alert('Please check your email to reset your password.');</script>";
        
    }
    else{
        echo "<script>alert('Invalid email please try again.');
        location = '../forget_password.php';</script>";
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