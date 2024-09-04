<?php
date_default_timezone_set('Asia/Ho_Chi_Minh');
// Database connection parameters
$hostname = 'localhost';
$username = 'root';
$password = '';
$database = 'ftp';
// Create a database connection
$conn = new mysqli($hostname, $username, $password, $database);
$currentDate = date("Y-m-d");
$deleteQuery = "DELETE FROM users WHERE guest< CURDATE() AND guest != ''";
$conn->query($deleteQuery);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
//get ip of client
function getClientIP()
{
    // Check if running on localhost
    if ($_SERVER['REMOTE_ADDR'] == '127.0.0.1' || $_SERVER['REMOTE_ADDR'] == '::1') {
        // If localhost, return the LAN IP address
        return getLanIP();
    }

    // For production or other environments, use your original logic to get the client's IP address
    if (array_key_exists('HTTP_CF_CONNECTING_IP', $_SERVER)) {
        return  $_SERVER["HTTP_CF_CONNECTING_IP"];
    } else if (array_key_exists('HTTP_X_FORWARDED_FOR', $_SERVER)) {
        return  $_SERVER["HTTP_X_FORWARDED_FOR"];
    } else if (array_key_exists('REMOTE_ADDR', $_SERVER)) {
        return $_SERVER['REMOTE_ADDR'];
    } else if (array_key_exists('HTTP_CLIENT_IP', $_SERVER)) {
        return $_SERVER['HTTP_CLIENT_IP'];
    }
    return '';
}

function getLanIP()
{
    // Get the LAN IP address of the server
    $lanIP = gethostbyname(gethostname());
    return filter_var($lanIP, FILTER_VALIDATE_IP) ? $lanIP : '';
}

$ip = getClientIP();

//func insert tracking
function insertTracking($action, $path, $file, $pic, $msg = "")
{
    global $conn; // Assuming $conn is your database connection

    // Sanitize the input to prevent SQL injection
    $action = mysqli_real_escape_string($conn, $action);
    $path = mysqli_real_escape_string($conn, $path);
    $file = mysqli_real_escape_string($conn, $file);
    $pic = mysqli_real_escape_string($conn, $pic);
    $client = mysqli_real_escape_string($conn, getClientIP());
    $remark = mysqli_real_escape_string($conn, $msg);
    // Create the SQL query to insert a new tracking record
    $query = "INSERT INTO tracking (action, path, file, pic, client,remark) VALUES ('$action', '$path', '$file', '$pic', '$client', '$remark')";

    // Execute the query
    if (mysqli_query($conn, $query)) {
        // The tracking record was successfully inserted
        return true;
    } else {
        // An error occurred while inserting the tracking record
        return false;
    }
}
//func insert tracking
function updateConfig($lang, $theme, $user)
{
    global $conn; // Assuming $conn is your database connection
    // Sanitize the input to prevent SQL injection
    $lang = mysqli_real_escape_string($conn, $lang);
    $theme = mysqli_real_escape_string($conn, $theme);
    $user = mysqli_real_escape_string($conn, $user);
    // Create the SQL query to insert a new tracking record
    $query = "UPDATE `users` SET `lang`='$lang',`theme`='$theme' WHERE username = '$user'";

    // Execute the query
    if (mysqli_query($conn, $query)) {
        // The tracking record was successfully inserted
        return true;
    } else {
        // An error occurred while inserting the tracking record
        return false;
    }
}


//func change pwd
function change_password($oldPassword, $newPassword, $confirmNewPassword, $username, $conn)
{
    // Validate the old and new passwords
    if (empty($oldPassword) || empty($newPassword) || empty($confirmNewPassword)) {
        return 'error'; // Incomplete form data
    }

    // Check if the new password and confirm new password match
    if ($newPassword !== $confirmNewPassword) {
        return 'error'; // Passwords do not match
    }

    // Query the database to retrieve the user's hashed password
    $query = "SELECT password FROM users WHERE username = '$username'";
    $result = $conn->query($query);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $storedPasswordHash = $row['password'];

        // Verify the old password
        if (password_verify($oldPassword, $storedPasswordHash)) {
            // Old password is correct, update the password
            $newPasswordHash = password_hash($newPassword, PASSWORD_BCRYPT);

            // Update the password in the database
            $updateQuery = "UPDATE users SET password = '$newPasswordHash' WHERE username = '$username'";
            if ($conn->query($updateQuery) === TRUE) {
                return 'success'; // Password updated successfully
            } else {
                return 'error'; // Error updating the password
            }
        } else {
            return 'incorrect'; // Old password is incorrect
        }
    } else {
        return 'not_found'; // User not found in the database
    }
}
function GuiThongBao($email, $tieu_de, $noi_dung_thu)
{
    require "PHPMailer/src/PHPMailer.php";
    require "PHPMailer/src/SMTP.php";
    require 'PHPMailer/src/Exception.php';
    $mail = new PHPMailer\PHPMailer\PHPMailer(true); //true:enables exceptions
    try {
        $mail->SMTPDebug = 0; //0,1,2: chế độ debug. khi chạy ngon thì chỉnh lại 0 nhé
        $mail->isSMTP();
        $mail->CharSet  = "utf-8";
        $mail->Host = 'mail.tscovn.com';  //SMTP servers
        $mail->SMTPAuth = true; // Enable authentication
        $mail->Username = 'noreply@tscovn.com'; // SMTP username
        $mail->Password = 'Tsuchiya$2023';   // SMTP password
        $mail->SMTPSecure = '';  // encryption TLS/SSL 
        $mail->Port = 25;  // port to connect to                
        $mail->setFrom('noreply@tscovn.com', 'TSCOVN Auto Mail');
        $mail->addAddress($email); //mail và tên người nhận  
        $mail->isHTML(true);  // Set email format to HTML
        $mail->ContentType = "text/html";
        $mail->addBCC('hungvo@tscovn.com');
        $mail->addAttachment('./Notification Deploying Web Server Service.pdf');
        $mail->addAttachment('./help.pdf');
        $mail->AddStringEmbeddedImage(file_get_contents('./images/banner.png'), 'ftp_banner', 'ftp_banner.png');
        $mail->Subject = $tieu_de;
        $noidungthu = $noi_dung_thu;
        $mail->Body = $noidungthu;
        $mail->smtpConnect(array(
            "ssl" => array(
                "verify_peer" => false,
                "verify_peer_name" => false,
                "allow_self_signed" => true
            )
        ));
        $mail->send();
        //echo 'Đã gửi mail xong';
    } catch (Exception $e) {
        echo 'Mail không gửi được. Lỗi: ', $mail->ErrorInfo;
    }
}
//change path for guest user
function change_guest_path($pic, $newPath)
{
    global $conn;
    $query = "SELECT * FROM users WHERE create_pic = '$pic'";
    $result = $conn->query($query);
    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $oldPath = $row['path'];
        $createDate = 'update-' . date("Y-m-d H:i:s");
        $insertQuery = "UPDATE `users` SET `path`='$newPath',`create_date`='$createDate' WHERE create_pic='$pic'";
        if ($conn->query($insertQuery) === TRUE) {
            return ["Success", $oldPath, $newPath];
        } else {
            return 'error'; // Error updating the password
        }
    } else {
        return 'dont have user guest'; // User not found in the database
    }
}


//create user
function create_guest($user, $pwd, $username)
{
    global $conn;
    // Validate the old and new passwords
    if (empty($user)) {
        $user = bin2hex(random_bytes('3'));
    }

    if (empty($pwd)) {
        $pwd = bin2hex(random_bytes('12'));
    }

    // Query the database to retrieve the user's hashed password
    $query = "SELECT * FROM users WHERE username = '$username'";
    $result = $conn->query($query);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $dept = $row['dept'];
        $path = $row['path'];
        $user_guest = $user . "-guest";
        $pass = "TSCOVN-" . $pwd;
        $newPasswordHash = password_hash($pass, PASSWORD_BCRYPT);
        $date = date("Y-m-d");

        $truyvan = "SELECT * FROM users WHERE dept= '$dept'";
        $kqtv = $conn->query($truyvan);
        if ($result->num_rows) {
            $row = $kqtv->fetch_assoc();
            $deleteQuery = "DELETE FROM users WHERE create_pic = '$username' AND guest !='' ";
            if ($conn->query($deleteQuery) === TRUE) {
                // User deleted successfully
                echo "User deleted.";
            } else {
                // Error during user deletion
                echo "Error deleting the user.";
            }
            // Update the password in the database
            $insertQuery = "INSERT INTO `users`(`username`, `password`, `dept`, `path`, `guest`,`create_pic`) VALUES ('$user_guest','$newPasswordHash','$dept','$path','$date','$username')";
            if ($conn->query($insertQuery) === TRUE) {
                return ["Success", $user_guest, $pass];
            } else {
                return 'error'; // Error updating the password
            }
        }
    } else {
        return 'not_found'; // User not found in the database
    }
}
// $res = create_guest("", "", "huongle");
// var_dump($res);