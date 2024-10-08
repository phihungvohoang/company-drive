<?php
//Default Configuration
$CONFIG = '{"lang":"en","error_reporting":false,"show_hidden":false,"hide_Cols":false,"theme":"light"}';
/*
 * TSCOVN | FTP File Manager V1.23.3010
 * @author Hung IT
 */
// if User has the external config file, try to use it to override the default config above [config.php]
$config_file = __DIR__ . '\config.php';
if (is_readable($config_file)) {
     @include($config_file);
}
//TFM version
define('VERSION', '1.23.3010');

//Application Title
define('APP_TITLE', 'TSCOVN FTP File Manager');

// --- EDIT BELOW CONFIGURATION CAREFULLY ---

// Auth with login/password
// set true/false to enable/disable it
// Is independent from IP white- and blacklisting
$use_auth = true;

// Login user name and password
// Users: array('Username' => 'Password', 'Username2' => 'Password2', ...)
// thêm user vào đây
// $auth_users = array(
//      'admin' => '$2y$10$ZKyqTn0pdnzkjD.22pK5U.PevSexuMXpZrr6kyLjgFpt1CJHZsF62', //tscovn@@
//      'trieunguyen' => '$2y$10$a2pUwTx7MSro7PBEoFWRDO6f2Iec6OiLNkfYSa6SWbxwWtYpicUx2', //123456
//      'lien' => '$2y$10$a2pUwTx7MSro7PBEoFWRDO6f2Iec6OiLNkfYSa6SWbxwWtYpicUx2' //123456
// );

$auth_users = array();
$readonly_users = array();
$isAdmin = array();
$directories_users = array();
$query = "SELECT * FROM users";
$result = $conn->query($query);

if ($result->num_rows > 0) {
     while ($row = $result->fetch_assoc()) {
          $auth_users[$row['username']] = $row['password'];
          if ($row['path'] !== "") {
               $directories_users[$row['username']] = $row['path'];
               if (!file_exists($row['path'])) {
                    //today do this
                    mkdir($row['path'], 0777, true);
               }
          }
          if ($row['readonly'] == 1) {
               $readonly_users[] = $row['username'];
          }
          if ($row['isAdmin'] == 1) {
               $isAdmin[] = $row['username'];
          }
     }
}

// Readonly users
// e.g. array('users', 'guest', ...)
//phân quyền
//$readonly_users = array('lien');

// Global readonly, including when auth is not being used
$global_readonly = false;

// Global isAdmin, including when auth is not being used
$global_isAdmin = false;

// user specific directories
// array('Username' => 'Directory path', 'Username2' => 'Directory path', ...)
//phân quyền folder cấu hình sẵn



// Enable highlight.js (https://highlightjs.org/) on view's page
$use_highlightjs = true;

// highlight.js style
// for dark theme use 'ir-black'
$highlightjs_style = 'vs';

// Enable ace.js (https://ace.c9.io/) on view's page
$edit_files = true;

// Default timezone for date() and time()
// Doc - http://php.net/manual/en/timezones.php
$default_timezone = 'Asia/Ho_Chi_Minh'; // UTC

// Root path for file manager
// use absolute path of directory i.e: '/var/www/folder' or $_SERVER['DOCUMENT_ROOT'].'/folder'
$root_path = $_SERVER['DOCUMENT_ROOT'];

// Root url for links in file manager.Relative to $http_host. Variants: '', 'path/to/subfolder'
// Will not working if $root_path will be outside of server document root
$root_url = '';

// Server hostname. Can set manually if wrong
// $_SERVER['HTTP_HOST'].'/folder'
$http_host = $_SERVER['HTTP_HOST'];

// input encoding for iconv
$iconv_input_encoding = 'UTF-8';

// date() format for file modification date
// Doc - https://www.php.net/manual/en/function.date.php
$datetime_format = 'd/m/Y g:i A';

// Path display mode when viewing file information
// 'full' => show full path
// 'relative' => show path relative to root_path
// 'host' => show path on the host
$path_display_mode = 'full';

// Allowed file extensions for create and rename files
// e.g. 'txt,html,css,js'
$allowed_file_extensions = '';

// Allowed file extensions for upload files
// e.g. 'gif,png,jpg,html,txt'
$allowed_upload_extensions = '';

// Favicon path. This can be either a full url to an .PNG image, or a path based on the document root.
// full path, e.g http://example.com/favicon.png
// local path, e.g images/icons/favicon.png
$favicon_path = './favicon.ico';

// Files and folders to excluded from listing
// e.g. array('myfile.html', 'personal-folder', '*.php', ...)
$exclude_items = array();

// Online office Docs Viewer
// Availabe rules are 'google', 'microsoft' or false
// Google => View documents using Google Docs Viewer
// Microsoft => View documents using Microsoft Web Apps Viewer
// false => disable online doc viewer
$online_viewer = 'google';

// Sticky Nav bar
// true => enable sticky header
// false => disable sticky header
$sticky_navbar = true;

// Maximum file upload size
// Increase the following values in php.ini to work properly
// memory_limit, upload_max_filesize, post_max_size
$max_upload_size_bytes = 2000000000; // size 5,000,000,000 bytes (~5GB)

// chunk size used for upload
// eg. decrease to 1MB if nginx reports problem 413 entity too large
$upload_chunk_size_bytes = 5000000; // chunk size 2,000,000 bytes (~2MB) tui thay the thanh 5mb

// Possible rules are 'OFF', 'AND' or 'OR'
// OFF => Don't check connection IP, defaults to OFF
// AND => Connection must be on the whitelist, and not on the blacklist
// OR => Connection must be on the whitelist, or not on the blacklist
$ip_ruleset = 'OFF';

// Should users be notified of their block?
$ip_silent = true;

// IP-addresses, both ipv4 and ipv6
$ip_whitelist = array(
     '127.0.0.1',    // local ipv4
     '::1'           // local ipv6
);

// IP-addresses, both ipv4 and ipv6
$ip_blacklist = array(
     '0.0.0.0',      // non-routable meta ipv4
     '::'            // non-routable meta ipv6
);

function copyToClipboard($string)
{
     return str_replace(' ', '%20', $string);
}

// External CDN resources that can be used in the HTML (replace for GDPR compliance)
$external = array(
     'css-bootstrap' => '<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">',
     'css-dropzone' => '<link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/min/dropzone.min.css" rel="stylesheet">',
     'css-font-awesome' => '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" crossorigin="anonymous">',
     'css-highlightjs' => '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.6.0/styles/' . $highlightjs_style . '.min.css">',
     'js-ace' => '<script src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.13.1/ace.js"></script>',
     'js-bootstrap' => '<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>',
     'js-dropzone' => '<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/min/dropzone.min.js"></script>',
     'js-jquery' => '<script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>',
     'js-jquery-datatables' => '<script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js" crossorigin="anonymous" defer></script>',
     'js-highlightjs' => '<script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.6.0/highlight.min.js"></',
     'pre-jsdelivr' => '<link rel="preconnect" href="https://cdn.jsdelivr.net" crossorigin/><link rel="dns-prefetch" href="https://cdn.jsdelivr.net"/>',
     'pre-cloudflare' => '<link rel="preconnect" href="https://cdnjs.cloudflare.com" crossorigin/><link rel="dns-prefetch" href="https://cdnjs.cloudflare.com"/>'
);

// --- EDIT BELOW CAREFULLY OR DO NOT EDIT AT ALL ---

// max upload file size
define('MAX_UPLOAD_SIZE', $max_upload_size_bytes);

// upload chunk size
define('UPLOAD_CHUNK_SIZE', $upload_chunk_size_bytes);

// private key and session name to store to the session
if (!defined('FM_SESSION_ID')) {
     define('FM_SESSION_ID', 'filemanager');
}

// Configuration
$cfg = new FM_Config();

// Default language
$lang = isset($cfg->data['lang']) ? $cfg->data['lang'] : 'en';

// Show or hide files and folders that starts with a dot
$show_hidden_files = isset($cfg->data['show_hidden']) ? $cfg->data['show_hidden'] : true;

// PHP error reporting - false = Turns off Errors, true = Turns on Errors
$report_errors = isset($cfg->data['error_reporting']) ? $cfg->data['error_reporting'] : true;

// Hide Permissions and Owner cols in file-listing
$hide_Cols = isset($cfg->data['hide_Cols']) ? $cfg->data['hide_Cols'] : true;

// Theme
$theme = isset($cfg->data['theme']) ? $cfg->data['theme'] : 'light';

define('FM_THEME', $theme);

//available languages
$lang_list = array('en' => 'English');

if ($report_errors == true) {
     @ini_set('error_reporting', E_ALL);
     @ini_set('display_errors', 1);
} else {
     @ini_set('error_reporting', E_ALL);
     @ini_set('display_errors', 0);
}

// if fm included
if (defined('FM_EMBED')) {
     $use_auth = false;
     $sticky_navbar = false;
} else {
     @set_time_limit(600);

     date_default_timezone_set($default_timezone);

     ini_set('default_charset', 'UTF-8');
     if (version_compare(PHP_VERSION, '5.6.0', '<') && function_exists('mb_internal_encoding')) {
          mb_internal_encoding('UTF-8');
     }
     if (function_exists('mb_regex_encoding')) {
          mb_regex_encoding('UTF-8');
     }

     session_cache_limiter('nocache'); // Prevent logout issue after page was cached
     session_name(FM_SESSION_ID);
     function session_error_handling_function($code, $msg, $file, $line)
     {
          // Permission denied for default session, try to create a new one
          if ($code == 2) {
               session_abort();
               session_id(session_create_id());
               @session_start();
          }
     }
     set_error_handler('session_error_handling_function');
     session_start();
     restore_error_handler();
}

//Generating CSRF Token
if (empty($_SESSION['token'])) {
     if (function_exists('random_bytes')) {
          $_SESSION['token'] = bin2hex(random_bytes(32));
     } else {
          $_SESSION['token'] = bin2hex(openssl_random_pseudo_bytes(32));
     }
}

if (empty($auth_users)) {
     $use_auth = false;
}

$is_https = isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS'] == 'on' || $_SERVER['HTTPS'] == 1)
     || isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https';

// update $root_url based on user specific directories
if (isset($_SESSION[FM_SESSION_ID]['logged']) && !empty($directories_users[$_SESSION[FM_SESSION_ID]['logged']])) {
     $wd = fm_clean_path(dirname($_SERVER['PHP_SELF']));
     $root_url =  $root_url . $wd . DIRECTORY_SEPARATOR . $directories_users[$_SESSION[FM_SESSION_ID]['logged']];
}
// clean $root_url
$root_url = fm_clean_path($root_url);

// abs path for site
defined('FM_ROOT_URL') || define('FM_ROOT_URL', ($is_https ? 'https' : 'http') . '://' . $http_host . (!empty($root_url) ? '/' . $root_url : ''));
defined('FM_SELF_URL') || define('FM_SELF_URL', ($is_https ? 'https' : 'http') . '://' . $http_host . $_SERVER['PHP_SELF']);


// logout
if (isset($_GET['logout'])) {
     //reset config
     $saveConfig = array(
          'lang' => 'en',
          'error_reporting' => false,
          'show_hidden' => false,
          'hide_Cols' => false,
          'theme' => 'light'
     );
     //save config
     $fm_file = __FILE__;
     $var_name = '$CONFIG';
     $var_value = var_export(json_encode($saveConfig), true);
     $config_string = "<?php" . chr(13) . chr(10) . "//Default Configuration" . chr(13) . chr(10) . "$var_name = $var_value;" . chr(13) . chr(10);
     if (is_writable($fm_file)) {
          $lines = file($fm_file);
          if ($fh = @fopen($fm_file, "w")) {
               @fputs($fh, $config_string, strlen($config_string));
               for ($x = 3; $x < count($lines); $x++) {
                    @fputs($fh, $lines[$x], strlen($lines[$x]));
               }
               @fclose($fh);
          }
     }

     insertTracking('Logout', '', '', $_SESSION[FM_SESSION_ID]['logged']);
     unset($_SESSION[FM_SESSION_ID]['logged']);
     unset($_SESSION['token']);
     fm_redirect(FM_SELF_URL);
}

// Validate connection IP
if ($ip_ruleset != 'OFF') {
     //get ip of client
     function getClientIP()
     {
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
     //gán cho biến $clientIP
     $clientIp = getClientIP();
     $proceed = false;
     $whitelisted = in_array($clientIp, $ip_whitelist);
     $blacklisted = in_array($clientIp, $ip_blacklist);

     if ($ip_ruleset == 'AND') {
          if ($whitelisted == true && $blacklisted == false) {
               $proceed = true;
          }
     } else
    if ($ip_ruleset == 'OR') {
          if ($whitelisted == true || $blacklisted == false) {
               $proceed = true;
          }
     }

     if ($proceed == false) {
          trigger_error('User connection denied from: ' . $clientIp, E_USER_WARNING);

          if ($ip_silent == false) {
               fm_set_msg(lng('Access denied. IP restriction applicable'), 'error');
               fm_show_header_login();
               fm_show_message();
          }
          exit();
     }
}

// Checking if the user is logged in or not. If not, it will show the login form.
if ($use_auth) {
     if (isset($_SESSION[FM_SESSION_ID]['logged'], $auth_users[$_SESSION[FM_SESSION_ID]['logged']])) {
          //Default Configuration
          $user = $_SESSION[FM_SESSION_ID]['logged'];
          $checkQuery = "SELECT * FROM users WHERE `username` = '$user'";
          $result = mysqli_query($conn, $checkQuery);

          if ($result) {
               $userData = mysqli_fetch_assoc($result);

               if ($userData) {
                    $saveConfig = array(
                         'lang' => $userData['lang'],
                         'error_reporting' => $userData['errorReport'],
                         'show_hidden' => $userData['hiddenFile'],
                         'hide_Cols' => $userData['hidePerm'],
                         'theme' => $userData['theme']
                    );
                    //save config
                    $fm_file = __FILE__;
                    $var_name = '$CONFIG';
                    $var_value = var_export(json_encode($saveConfig), true);
                    $config_string = "<?php" . chr(13) . chr(10) . "//Default Configuration" . chr(13) . chr(10) . "$var_name = $var_value;" . chr(13) . chr(10);
                    if (is_writable($fm_file)) {
                         $lines = file($fm_file);
                         if ($fh = @fopen($fm_file, "w")) {
                              @fputs($fh, $config_string, strlen($config_string));
                              for ($x = 3; $x < count($lines); $x++) {
                                   @fputs($fh, $lines[$x], strlen($lines[$x]));
                              }
                              @fclose($fh);
                         }
                    }
                    //end save config
                    // User-specific configuration found, use it

               }
          }
          // xử lý đổi đường dẫn
          if (isset($_POST['type']) && $_POST['type'] === 'changePath') {
               $changeResult = change_guest_path($_SESSION[FM_SESSION_ID]['logged'], $_POST['newPath']);

               if ($changeResult) {
                    // Password changed successfully, display a success message
                    fm_set_msg('Change success from: ' . $changeResult[1] . " To: " . $changeResult[2], 'ok');
               } else {
                    fm_set_msg('Đổi đường dẫn ko được', 'error');
               }
          }
          //xử lý tạo user guest
          elseif (isset($_POST['type']) && $_POST['type'] === 'create_guest_user') {
               $changeResult = create_guest("", "", $_SESSION[FM_SESSION_ID]['logged']);

               if ($changeResult) {
                    // Password changed successfully, display a success message
                    fm_set_msg('Username: ' . $changeResult[1] . "    Password: " . $changeResult[2], 'ok');
               } else {
                    fm_set_msg('Ko tạo được user guest', 'error');
               }
          }
          //xử lý đổi mật khẩu
          elseif (isset($_POST['type']) && $_POST['type'] === 'changepwd') {
               // Call the change_password function to handle the password change
               $changeResult = change_password($_POST['oldPassword'], $_POST['newPassword'], $_POST['confirmNewPassword'], $_SESSION[FM_SESSION_ID]['logged'], $conn);

               if ($changeResult === 'success') {
                    // Password changed successfully, display a success message
                    fm_set_msg('Password changed successfully', 'ok');
               } elseif ($changeResult === 'incorrect') {
                    // Incorrect old password, display an error message
                    fm_set_msg('Incorrect old password', 'error');
               } elseif ($changeResult === 'not_found') {
                    // User not found, display an error message
                    fm_set_msg('User not found', 'error');
               } else {
                    // Error during the password change, display an error message
                    fm_set_msg('Error changing the password', 'error');
               }
          } elseif (isset($_GET['taoTaiKhoan'])) {
               // Check if the logged-in user is an admin
               if ($_SESSION[FM_SESSION_ID]['logged'] == 'admin') {
                    // Create a new user
                    $user = $_GET['taoTaiKhoan'];
                    $email = isset($_GET['email']) ? $_GET['email'] : $user . "@tscovn.com";
                    $full = isset($_GET['full']) ? $_GET['full'] : '';
                    $dept = isset($_GET['dept']) ? $_GET['dept'] : '';
                    if (empty($pwd)) {
                         $pwd = bin2hex(random_bytes('12'));
                    }
                    $path = "Data/" . $dept . "/" . $user;
                    // Check if a password is provided, or use a default password if not
                    $temppwd = "TSCOVN-" . $pwd;

                    // Hash the password securely
                    $password = password_hash($temppwd, PASSWORD_BCRYPT);

                    // Check if the username already exists in the database
                    $checkQuery = "SELECT COUNT(*) FROM `users` WHERE `username` = '$user'";
                    $result = mysqli_query($conn, $checkQuery);

                    if ($result && mysqli_fetch_row($result)[0] == 0) {
                         // The username is not a duplicate, so proceed with user creation
                         $query = "INSERT INTO `users` (`username`, `password`,`email`, `dept`, `path`, `readonly`) VALUES ('$user', '$password','$email', '$dept', '$path', '$full');";
                         $tieuDe = "Create User Successfully For FTP Server";
                         $noiDung = "
                         <!DOCTYPE html>
                         <html
                           lang='en'
                           xmlns='http://www.w3.org/1999/xhtml'
                           xmlns:o='urn:schemas-microsoft-com:office:office'
                         >
                           <head>
                             <meta charset='UTF-8' />
                             <meta name='viewport' content='width=device-width,initial-scale=1' />
                             <meta name='x-apple-disable-message-reformatting' />
                             <title></title>
                             <!--[if mso]>
                               <noscript>
                                 <xml>
                                   <o:OfficeDocumentSettings>
                                     <o:PixelsPerInch>96</o:PixelsPerInch>
                                   </o:OfficeDocumentSettings>
                                 </xml>
                               </noscript>
                             <![endif]-->
                             <style>
                               table,
                               td,
                               div,
                               h1,
                               p {
                                 font-family: Arial, sans-serif;
                               }
                             </style>
                           </head>
                           <body style='margin: 0; padding: 0'>
                             <table
                               role='presentation'
                               style='
                                 width: 100%;
                                 border-collapse: collapse;
                                 border: 0;
                                 border-spacing: 0;
                                 background: #ffffff;
                               '
                             >
                               <tr>
                                 <td align='center' style='padding: 0'>
                                   <table
                                     role='presentation'
                                     style='
                                       width: 602px;
                                       border-collapse: collapse;
                                       border: 1px solid #cccccc;
                                       border-spacing: 0;
                                       text-align: left;
                                     '
                                   >
                                     <tr>
                                       <td
                                         align='center'
                                         style='background: #70bbd9'
                                       >
                                       <img src='cid:ftp_banner' width='250' style='height: auto; display: block'>
                                       </td>
                                     </tr>
                                     <tr>
                                       <td style='padding: 36px 30px 5px 30px'>
                                         <table
                                           role='presentation'
                                           style='
                                             width: 100%;
                                             border-collapse: collapse;
                                             border: 0;
                                             border-spacing: 0;
                                           '
                                         >
                                           <tr>
                                           <tr>
                                             <td style='color: #ffaa00'>
                                               <h1
                                                 style='
                                                   margin: 0 0 20px 0;
                                                   font-family: Arial, sans-serif;
                                                 '
                                               >
                                               Hello " . strtoupper($user) . "
                                               </h1>
                                           </tr><tr>
                                             <td style='color: #153643'>
                                               <h1
                                                 style='
                                                   font-size: 24px;
                                                   margin: 0 0 20px 0;
                                                   font-family: Arial, sans-serif;
                                                 '
                                               >
                                                 Welcome to TSCOVN FTP File Manager
                                               </h1>
                                               <p
                                                 style='
                                                   margin: 0 0 12px 0;
                                                   font-size: 16px;
                                                   line-height: 24px;
                                                   font-family: Arial, sans-serif;
                                                 '
                                               >
                                                 
                                               System provide you an Username and password to login, Don't share to anyone to protect your data. 
                                               </p>
                                               <p
                                               style='
                                                 margin: 0 0 12px 15px;
                                                 font-size: 16px;
                                                 line-height: 24px;
                                                 font-family: Arial, sans-serif;
                                               '
                                             >
                                               Username: " . $user . " <br>
                                                 Password: " . $temppwd . " 
                                             </p></td></tr>
                                             <tr><td style='padding:10px 0px;color: #ee4c50'>
                                               <p
                                                 style='
                                                   font-size: 11px;
                                                   font-family: Arial, sans-serif;
                                                 '
                                               ><i>Make sure you read all add attachment. <br />This email message was auto-generated. Please do not respond. If you need additional help, 
                                                 <a
                                                   href='http://www.example.com'
                                                   style='color: #ee4c50; text-decoration: underline'
                                                   >Contact here.</a
                                                 >
                                               </p>
                                             </td>
                                           </tr>
                                         </table>
                                       </td>
                                     </tr>
                                     <tr>
                                       <td style='padding: 20px; background: #ee4c50'>
                                         <table
                                           role='presentation'
                                           style='
                                             width: 100%;
                                             border-collapse: collapse;
                                             border: 0;
                                             border-spacing: 0;
                                             font-size: 9px;
                                             font-family: Arial, sans-serif;
                                           '
                                         >
                                           <tr>
                                             <td style='padding: 0; width: 50%' align='left'>
                                               <p
                                                 style='
                                                   margin: 0;
                                                   font-size: 14px;
                                                   line-height: 16px;
                                                   font-family: Arial, sans-serif;
                                                   color: #ffffff;
                                                 '
                                               >
                                               IT Department &copy; 2023 TSCOVN All rights reserved.<br />
                                               </p>
                                             </td>
                                             <td style='padding: 0; width: 50%' align='right'></td>
                                           </tr>
                                         </table>
                                       </td>
                                     </tr>
                                   </table>
                                 </td>
                               </tr>
                             </table>
                           </body>
                         </html>
                         ";

                         if (mysqli_query($conn, $query)) {
                              fm_set_msg("User '$user' Passwod '$temppwd' has been created.", 'ok');
                              GuiThongBao($email, $tieuDe, $noiDung);
                         } else {
                              fm_set_msg("Failed to create the user.", 'error');
                         }
                    } else {
                         fm_set_msg("Username '$user' already exists. Choose a different username.", 'error');
                    }
               } else {
                    fm_set_msg("You do not have permission to create a new user.", 'error');
               }
          }
     } elseif (isset($_POST['fm_usr'], $_POST['fm_pwd'], $_POST['token'])) {
          // Logging In
          sleep(1);
          if (function_exists('password_verify')) {
               if (isset($auth_users[$_POST['fm_usr']]) && isset($_POST['fm_pwd']) && password_verify($_POST['fm_pwd'], $auth_users[$_POST['fm_usr']]) && verifyToken($_POST['token'])) {
                    $_SESSION[FM_SESSION_ID]['logged'] = $_POST['fm_usr'];
                    $_SESSION['user'] = $_POST['fm_usr'];
                    insertTracking('Login', '', '', $_SESSION[FM_SESSION_ID]['logged']);
                    fm_set_msg(lng('You are logged in'));
                    fm_redirect(FM_SELF_URL);
               } else {
                    unset($_SESSION[FM_SESSION_ID]['logged']);
                    fm_set_msg(lng('Login failed. Invalid username or password'), 'error');
                    fm_redirect(FM_SELF_URL);
               }
          } else {
               fm_set_msg(lng('password_hash not supported, Upgrade PHP version'), 'error');;
          }
     } else {
          // Form
          unset($_SESSION[FM_SESSION_ID]['logged']);
          fm_show_header_login();
?>
          <section class="h-100">
               <div class="container h-100">
                    <div class="row justify-content-md-center h-100">
                         <div class="card-wrapper">
                              <div class="card fat <?php echo fm_get_theme(); ?>">
                                   <div class="card-body">
                                        <form class="form-signin" action="" method="post" autocomplete="off">
                                             <div class="mb-3">
                                                  <div class="brand">
                                                       <img src="http://filemanager.tscovn.com:9001/logo.png" alt="tscovn-logo">
                                                       </svg>
                                                  </div>
                                                  <div class="text-center">
                                                       <h1 class="card-title">FTP File Manager</h1>
                                                  </div>
                                             </div>
                                             <hr />
                                             <div class="mb-3">
                                                  <label for="fm_usr" class="pb-2"><?php echo lng('Username'); ?></label>
                                                  <input type="text" class="form-control" id="fm_usr" name="fm_usr" required autofocus>
                                             </div>

                                             <div class="mb-3">
                                                  <label for="fm_pwd" class="pb-2"><?php echo lng('Password'); ?></label>
                                                  <input type="password" class="form-control" id="fm_pwd" name="fm_pwd" required>
                                             </div>

                                             <div class="mb-3">
                                                  <?php fm_show_message(); ?>
                                             </div>
                                             <input type="hidden" name="token" value="<?php echo htmlentities($_SESSION['token']); ?>" />
                                             <div class="mb-3">
                                                  <button type="submit" class="btn btn-success btn-block w-100 mt-4" role="button">
                                                       <?php echo lng('Login'); ?>
                                                  </button>
                                             </div>
                                             <div class="d-flex flex-row bd-highlight mb-3 justify-content-between">
                                                  <a class="label-link" id="create-account" href="mailto:hungvo@tscovn.com&cc=yenvu@tscovn.com;trieunguyen@tscovn.com&subject=Create%20new%20account%20for%20FTP%20Files%20Manager&body=Hi%20IT%20Team%2C%0A%0AI%20sent%20you%20a%20request%20to%20create%20FTP%20File%20Manager%20account.%0A%0AStep%201%3A%20I%20already%20read%20a%20term%20and%20policy%20at%20http%3A%2F%2Fmonitor.tscovn.com%3A9001%2FNotification%2520Deploying%2520Web%2520Server%2520Service.pdf%0AStep%202%3A%20I%20download%20http%3A%2F%2Fmonitor.tscovn.com%3A9001%2FACCOUNT%2520REQUEST%2520FORM.pdf%20and%20i%20completed%20it%20as%20file%20i%20will%20attached%0AStep%203%3A%20I%20already%20read%20a%20user%20manual%20at%20http%3A%2F%2Fmonitor.tscovn.com%3A9001%2Fhelp.pdf%0A%0APlease%20provide%20me%20an%20account.%0AThanks%20Team%20for%20support.%0AAs%20send%20this%20email%20i%20agree%20all%20term%20and%20policy%20of%20FTP%20Files%20Manager">Create
                                                       Account</a>
                                                  <a class="label-link" id="forgot-password" href="mailto:hungvo@tscovn.com&cc=yenvu@tscovn.com;trieunguyen@tscovn.com&subject=I%20forgot%20my%20FTP%20password&body=Hi%20IT%20Team%2C%0A%0AI%20sent%20you%20a%20request%20to%20reset%20my%20password%20for%20FTP%20File%20Manager%0AThanks%20Team%20for%20support.">Forgot
                                                       password</a>
                                             </div>
                                        </form>
                                   </div>
                              </div>
                              <div class="footer text-center text-small">
                                   <small>IT Department &copy;
                                        <!-- chỗ này để hiện thông tin version -->
                                        <a href="http://www.tscovn.com/" target="_blank" class="text-decoration-none text-muted" data-version="<?php echo VERSION; ?>">2023 TSCOVN All rights reserved.</a>
                                   </small>
                              </div>
                         </div>
                    </div>
               </div>
          </section>

     <?php
          fm_show_footer_login();
          exit;
     }
}

// update root path
if ($use_auth && isset($_SESSION[FM_SESSION_ID]['logged'])) {
     $root_path = isset($directories_users[$_SESSION[FM_SESSION_ID]['logged']]) ? $directories_users[$_SESSION[FM_SESSION_ID]['logged']] : $root_path;
}

// clean and check $root_path
$root_path = rtrim($root_path, '\\/');
$root_path = str_replace('\\', '/', $root_path);
if (!@is_dir($root_path)) {
     echo "<h1>" . lng('Root path') . " \"{$root_path}\" " . lng('not found!') . " </h1>";
     exit;
}

defined('FM_SHOW_HIDDEN') || define('FM_SHOW_HIDDEN', $show_hidden_files);
defined('FM_ROOT_PATH') || define('FM_ROOT_PATH', $root_path);
defined('FM_LANG') || define('FM_LANG', $lang);
defined('FM_FILE_EXTENSION') || define('FM_FILE_EXTENSION', $allowed_file_extensions);
defined('FM_UPLOAD_EXTENSION') || define('FM_UPLOAD_EXTENSION', $allowed_upload_extensions);
defined('FM_EXCLUDE_ITEMS') || define('FM_EXCLUDE_ITEMS', (version_compare(PHP_VERSION, '7.0.0', '<') ? serialize($exclude_items) : $exclude_items));
defined('FM_DOC_VIEWER') || define('FM_DOC_VIEWER', $online_viewer);
define('FM_READONLY', $global_readonly || ($use_auth && !empty($readonly_users) && isset($_SESSION[FM_SESSION_ID]['logged']) && in_array($_SESSION[FM_SESSION_ID]['logged'], $readonly_users)));
define('FM_ISADMIN', $global_isAdmin || ($use_auth && !empty($isAdmin) && isset($_SESSION[FM_SESSION_ID]['logged']) && in_array($_SESSION[FM_SESSION_ID]['logged'], $isAdmin)));
define('FM_IS_WIN', DIRECTORY_SEPARATOR == '\\');

// always use ?p=
if (!isset($_GET['p']) && empty($_FILES)) {
     fm_redirect(FM_SELF_URL . '?p=');
}

// get path
$p = isset($_GET['p']) ? $_GET['p'] : (isset($_POST['p']) ? $_POST['p'] : '');

// clean path
$p = fm_clean_path($p);

// for ajax request - save
$input = file_get_contents('php://input');
$_POST = (strpos($input, 'ajax') != FALSE && strpos($input, 'save') != FALSE) ? json_decode($input, true) : $_POST;

// instead globals vars
define('FM_PATH', $p);
define('FM_USE_AUTH', $use_auth);
define('FM_EDIT_FILE', $edit_files);
defined('FM_ICONV_INPUT_ENC') || define('FM_ICONV_INPUT_ENC', $iconv_input_encoding);
defined('FM_USE_HIGHLIGHTJS') || define('FM_USE_HIGHLIGHTJS', $use_highlightjs);
defined('FM_HIGHLIGHTJS_STYLE') || define('FM_HIGHLIGHTJS_STYLE', $highlightjs_style);
defined('FM_DATETIME_FORMAT') || define('FM_DATETIME_FORMAT', $datetime_format);

unset($p, $use_auth, $iconv_input_encoding, $use_highlightjs, $highlightjs_style);

/*************************** ACTIONS ***************************/

// Handle all AJAX Request
if ((isset($_SESSION[FM_SESSION_ID]['logged'], $auth_users[$_SESSION[FM_SESSION_ID]['logged']]) || !FM_USE_AUTH) && isset($_POST['ajax'], $_POST['token']) && !FM_READONLY) {
     if (!verifyToken($_POST['token'])) {
          header('HTTP/1.0 401 Unauthorized');
          die("Invalid Token.");
     }

     //search : get list of files from the current folder
     if (isset($_POST['type']) && $_POST['type'] == "search") {
          $dir = $_POST['path'] == "." ? '' : $_POST['path'];
          $response = scan(fm_clean_path($dir), $_POST['content']);
          echo json_encode($response);
          exit();
     }

     // save editor file
     if (isset($_POST['type']) && $_POST['type'] == "save") {
          // get current path
          $path = FM_ROOT_PATH;
          if (FM_PATH != '') {
               $path .= '/' . FM_PATH;
          }
          // check path
          if (!is_dir($path)) {
               fm_redirect(FM_SELF_URL . '?p=');
          }
          $file = $_GET['edit'];
          $file = fm_clean_path($file);
          $file = str_replace('/', '', $file);
          insertTracking('Save file', $path, $file, $_SESSION[FM_SESSION_ID]['logged']);

          if ($file == '' || !is_file($path . '/' . $file)) {
               fm_set_msg(lng('File not found'), 'error');
               $FM_PATH = FM_PATH;
               fm_redirect(FM_SELF_URL . '?p=' . urlencode($FM_PATH));
          }
          header('X-XSS-Protection:0');
          $file_path = $path . '/' . $file;

          $writedata = $_POST['content'];
          $fd = fopen($file_path, "w");
          $write_results = @fwrite($fd, $writedata);
          fclose($fd);
          if ($write_results === false) {
               header("HTTP/1.1 500 Internal Server Error");
               die("Could Not Write File! - Check Permissions / Ownership");
          }
          die(true);
     }

     // backup files
     if (isset($_POST['type']) && $_POST['type'] == "backup" && !empty($_POST['file'])) {
          $fileName = fm_clean_path($_POST['file']);
          $fullPath = FM_ROOT_PATH . '/';
          if (!empty($_POST['path'])) {
               $relativeDirPath = fm_clean_path($_POST['path']);
               $fullPath .= "{$relativeDirPath}/";
          }
          $date = date("dMy-His");
          $newFileName = "{$fileName}-{$date}.bak";
          $fullyQualifiedFileName = $fullPath . $fileName;
          try {
               if (!file_exists($fullyQualifiedFileName)) {
                    throw new Exception("File {$fileName} not found");
               }
               if (copy($fullyQualifiedFileName, $fullPath . $newFileName)) {
                    echo "Backup {$newFileName} created";
                    insertTracking('Create Backup', $fullPath, $newFileName, $_SESSION[FM_SESSION_ID]['logged']);
               } else {
                    throw new Exception("Could not copy file {$fileName}");
               }
          } catch (Exception $e) {
               echo $e->getMessage();
          }
     }

     // Save Config
     if (isset($_POST['type']) && $_POST['type'] == "settings") {
          global $cfg, $lang, $report_errors, $show_hidden_files, $lang_list, $hide_Cols, $theme;
          $newLng = $_POST['js-language'];
          fm_get_translations([]);
          if (!array_key_exists($newLng, $lang_list)) {
               $newLng = 'en';
          }

          $erp = isset($_POST['js-error-report']) && $_POST['js-error-report'] == "true" ? true : false;
          $shf = isset($_POST['js-show-hidden']) && $_POST['js-show-hidden'] == "true" ? true : false;
          $hco = isset($_POST['js-hide-cols']) && $_POST['js-hide-cols'] == "true" ? true : false;
          $te3 = $_POST['js-theme-3'];

          if ($cfg->data['lang'] != $newLng) {
               $cfg->data['lang'] = $newLng;
               $lang = $newLng;
          }
          if ($cfg->data['error_reporting'] != $erp) {
               $cfg->data['error_reporting'] = $erp;
               $report_errors = $erp;
          }
          if ($cfg->data['show_hidden'] != $shf) {
               $cfg->data['show_hidden'] = $shf;
               $show_hidden_files = $shf;
          }
          if ($cfg->data['show_hidden'] != $shf) {
               $cfg->data['show_hidden'] = $shf;
               $show_hidden_files = $shf;
          }
          if ($cfg->data['hide_Cols'] != $hco) {
               $cfg->data['hide_Cols'] = $hco;
               $hide_Cols = $hco;
          }
          if ($cfg->data['theme'] != $te3) {
               $cfg->data['theme'] = $te3;
               $theme = $te3;
          }
          $cfg->save();
          echo true;
     }

     // new password hash
     if (isset($_POST['type']) && $_POST['type'] == "pwdhash") {
          $res = isset($_POST['inputPassword2']) && !empty($_POST['inputPassword2']) ? password_hash($_POST['inputPassword2'], PASSWORD_DEFAULT) : '';
          echo $res;
     }

     //upload using url
     if (isset($_POST['type']) && $_POST['type'] == "upload" && !empty($_REQUEST["uploadurl"])) {
          $path = FM_ROOT_PATH;
          if (FM_PATH != '') {
               $path .= '/' . FM_PATH;
          }

          function event_callback($message)
          {
               global $callback;
               echo json_encode($message);
          }

          function get_file_path()
          {
               global $path, $fileinfo, $temp_file;
               return $path . "/" . basename($fileinfo->name);
          }

          $url = !empty($_REQUEST["uploadurl"]) && preg_match("|^http(s)?://.+$|", stripslashes($_REQUEST["uploadurl"])) ? stripslashes($_REQUEST["uploadurl"]) : null;

          //prevent 127.* domain and known ports
          $domain = parse_url($url, PHP_URL_HOST);
          $port = parse_url($url, PHP_URL_PORT);
          $knownPorts = [22, 23, 25, 3306];

          if (preg_match("/^localhost$|^127(?:\.[0-9]+){0,2}\.[0-9]+$|^(?:0*\:)*?:?0*1$/i", $domain) || in_array($port, $knownPorts)) {
               $err = array("message" => "URL is not allowed");
               event_callback(array("fail" => $err));
               exit();
          }

          $use_curl = false;
          $temp_file = tempnam(sys_get_temp_dir(), "upload-");
          $fileinfo = new stdClass();
          $fileinfo->name = trim(basename($url), ".\x00..\x20");

          $allowed = (FM_UPLOAD_EXTENSION) ? explode(',', FM_UPLOAD_EXTENSION) : false;
          $ext = strtolower(pathinfo($fileinfo->name, PATHINFO_EXTENSION));
          $isFileAllowed = ($allowed) ? in_array($ext, $allowed) : true;

          $err = false;

          if (!$isFileAllowed) {
               $err = array("message" => "File extension is not allowed");
               event_callback(array("fail" => $err));
               exit();
          }

          if (!$url) {
               $success = false;
          } else if ($use_curl) {
               @$fp = fopen($temp_file, "w");
               @$ch = curl_init($url);
               curl_setopt($ch, CURLOPT_NOPROGRESS, false);
               curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
               curl_setopt($ch, CURLOPT_FILE, $fp);
               @$success = curl_exec($ch);
               $curl_info = curl_getinfo($ch);
               if (!$success) {
                    $err = array("message" => curl_error($ch));
               }
               @curl_close($ch);
               fclose($fp);
               $fileinfo->size = $curl_info["size_download"];
               $fileinfo->type = $curl_info["content_type"];
          } else {
               $ctx = stream_context_create();
               @$success = copy($url, $temp_file, $ctx);
               if (!$success) {
                    $err = error_get_last();
               }
          }

          if ($success) {
               $success = rename($temp_file, strtok(get_file_path(), '?'));
          }

          if ($success) {
               event_callback(array("done" => $fileinfo));
          } else {
               unlink($temp_file);
               if (!$err) {
                    $err = array("message" => "Invalid url parameter");
               }
               event_callback(array("fail" => $err));
          }
     }
     exit();
}

// Delete file / folder
if (isset($_GET['del'], $_POST['token']) && !FM_READONLY) {
     $del = str_replace('/', '', fm_clean_path($_GET['del']));
     if ($del != '' && $del != '..' && $del != '.' && verifyToken($_POST['token'])) {
          $path = FM_ROOT_PATH;
          if (FM_PATH != '') {
               $path .= '/' . FM_PATH;
          }
          $is_dir = is_dir($path . '/' . $del);
          if (fm_rdelete($path . '/' . $del)) {
               $msg = $is_dir ? lng('Folder') . ' <b>%s</b> ' . lng('Deleted') : lng('File') . ' <b>%s</b> ' . lng('Deleted');
               insertTracking('Delete', $path, $del, $_SESSION[FM_SESSION_ID]['logged']);
               fm_set_msg(sprintf($msg, fm_enc($del)));
          } else {
               $msg = $is_dir ? lng('Folder') . ' <b>%s</b> ' . lng('not deleted') : lng('File') . ' <b>%s</b> ' . lng('not deleted');
               fm_set_msg(sprintf($msg, fm_enc($del)), 'error');
          }
     } else {
          fm_set_msg(lng('Invalid file or folder name'), 'error');
     }
     $FM_PATH = FM_PATH;
     fm_redirect(FM_SELF_URL . '?p=' . urlencode($FM_PATH));
}

// Create a new file/folder
if (isset($_POST['newfilename'], $_POST['newfile'], $_POST['token']) && !FM_READONLY) {
     $type = urldecode($_POST['newfile']);
     $new = str_replace('/', '', fm_clean_path(strip_tags($_POST['newfilename'])));
     if (fm_isvalid_filename($new) && $new != '' && $new != '..' && $new != '.' && verifyToken($_POST['token'])) {
          $path = FM_ROOT_PATH;
          if (FM_PATH != '') {
               $path .= '/' . FM_PATH;
          }
          if ($type == "file") {
               if (!file_exists($path . '/' . $new)) {
                    if (fm_is_valid_ext($new)) {
                         @fopen($path . '/' . $new, 'w') or die('Cannot open file:  ' . $new);
                         fm_set_msg(sprintf(lng('File') . ' <b>%s</b> ' . lng('Created'), fm_enc($new)));
                         insertTracking('Create File', $path, $new, $_SESSION[FM_SESSION_ID]['logged']);
                    } else {
                         fm_set_msg(lng('File extension is not allowed'), 'error');
                    }
               } else {
                    fm_set_msg(sprintf(lng('File') . ' <b>%s</b> ' . lng('already exists'), fm_enc($new)), 'alert');
               }
          } else {
               if (fm_mkdir($path . '/' . $new, false) === true) {
                    fm_set_msg(sprintf(lng('Folder') . ' <b>%s</b> ' . lng('Created'), $new));
                    insertTracking('Create Folder', $path, $new, $_SESSION[FM_SESSION_ID]['logged']);
               } elseif (fm_mkdir($path . '/' . $new, false) === $path . '/' . $new) {
                    fm_set_msg(sprintf(lng('Folder') . ' <b>%s</b> ' . lng('already exists'), fm_enc($new)), 'alert');
               } else {
                    fm_set_msg(sprintf(lng('Folder') . ' <b>%s</b> ' . lng('not created'), fm_enc($new)), 'error');
               }
          }
     } else {
          fm_set_msg(lng('Invalid characters in file or folder name'), 'error');
     }
     $FM_PATH = FM_PATH;
     fm_redirect(FM_SELF_URL . '?p=' . urlencode($FM_PATH));
}

// Copy folder / file
if (isset($_GET['copy'], $_GET['finish']) && !FM_READONLY) {
     // from
     $copy = urldecode($_GET['copy']);
     $copy = fm_clean_path($copy);
     // empty path
     if ($copy == '') {
          fm_set_msg(lng('Source path not defined'), 'error');
          $FM_PATH = FM_PATH;
          fm_redirect(FM_SELF_URL . '?p=' . urlencode($FM_PATH));
     }
     // abs path from
     $from = FM_ROOT_PATH . '/' . $copy;
     // abs path to
     $dest = FM_ROOT_PATH;
     if (FM_PATH != '') {
          $dest .= '/' . FM_PATH;
     }
     $dest .= '/' . basename($from);
     // move?
     $move = isset($_GET['move']);
     $move = fm_clean_path(urldecode($move));
     // copy/move/duplicate
     if ($from != $dest) {
          $msg_from = trim(FM_PATH . '/' . basename($from), '/');
          if ($move) { // Move and to != from so just perform move
               $rename = fm_rename($from, $dest);
               if ($rename) {
                    fm_set_msg(sprintf(lng('Moved from') . ' <b>%s</b> ' . lng('to') . ' <b>%s</b>', fm_enc($copy), fm_enc($msg_from)));
                    insertTracking('Move', $from, $rename, $_SESSION[FM_SESSION_ID]['logged']);
               } elseif ($rename === null) {
                    fm_set_msg(lng('File or folder with this path already exists'), 'alert');
               } else {
                    fm_set_msg(sprintf(lng('Error while moving from') . ' <b>%s</b> ' . lng('to') . ' <b>%s</b>', fm_enc($copy), fm_enc($msg_from)), 'error');
               }
          } else { // Not move and to != from so copy with original name
               if (fm_rcopy($from, $dest)) {
                    fm_set_msg(sprintf(lng('Copied from') . ' <b>%s</b> ' . lng('to') . ' <b>%s</b>', fm_enc($copy), fm_enc($msg_from)));
                    insertTracking('Copy', $from, $rename, $_SESSION[FM_SESSION_ID]['logged']);
               } else {
                    fm_set_msg(sprintf(lng('Error while copying from') . ' <b>%s</b> ' . lng('to') . ' <b>%s</b>', fm_enc($copy), fm_enc($msg_from)), 'error');
               }
          }
     } else {
          if (!$move) { //Not move and to = from so duplicate
               $msg_from = trim(FM_PATH . '/' . basename($from), '/');
               $fn_parts = pathinfo($from);
               $extension_suffix = '';
               if (!is_dir($from)) {
                    $extension_suffix = '.' . $fn_parts['extension'];
               }
               //Create new name for duplicate
               $fn_duplicate = $fn_parts['dirname'] . '/' . $fn_parts['filename'] . '-' . date('YmdHis') . $extension_suffix;
               $loop_count = 0;
               $max_loop = 1000;
               // Check if a file with the duplicate name already exists, if so, make new name (edge case...)
               while (file_exists($fn_duplicate) & $loop_count < $max_loop) {
                    $fn_parts = pathinfo($fn_duplicate);
                    $fn_duplicate = $fn_parts['dirname'] . '/' . $fn_parts['filename'] . '-copy' . $extension_suffix;
                    $loop_count++;
               }
               if (fm_rcopy($from, $fn_duplicate, False)) {
                    fm_set_msg(sprintf('Copied from <b>%s</b> to <b>%s</b>', fm_enc($copy), fm_enc($fn_duplicate)));
                    insertTracking('Coppied', $from, $fn_duplicate, $_SESSION[FM_SESSION_ID]['logged']);
               } else {
                    fm_set_msg(sprintf('Error while copying from <b>%s</b> to <b>%s</b>', fm_enc($copy), fm_enc($fn_duplicate)), 'error');
               }
          } else {
               fm_set_msg(lng('Paths must be not equal'), 'alert');
          }
     }
     $FM_PATH = FM_PATH;
     fm_redirect(FM_SELF_URL . '?p=' . urlencode($FM_PATH));
}

// Mass copy files/ folders
if (isset($_POST['file'], $_POST['copy_to'], $_POST['finish'], $_POST['token']) && !FM_READONLY) {

     if (!verifyToken($_POST['token'])) {
          fm_set_msg(lng('Invalid Token.'), 'error');
     }

     // from
     $path = FM_ROOT_PATH;
     if (FM_PATH != '') {
          $path .= '/' . FM_PATH;
     }
     // to
     $copy_to_path = FM_ROOT_PATH;
     $copy_to = fm_clean_path($_POST['copy_to']);
     if ($copy_to != '') {
          $copy_to_path .= '/' . $copy_to;
     }
     if ($path == $copy_to_path) {
          fm_set_msg(lng('Paths must be not equal'), 'alert');
          $FM_PATH = FM_PATH;
          fm_redirect(FM_SELF_URL . '?p=' . urlencode($FM_PATH));
     }
     if (!is_dir($copy_to_path)) {
          if (!fm_mkdir($copy_to_path, true)) {
               fm_set_msg('Unable to create destination folder', 'error');
               $FM_PATH = FM_PATH;
               fm_redirect(FM_SELF_URL . '?p=' . urlencode($FM_PATH));
          }
     }
     // move?
     $move = isset($_POST['move']);
     // copy/move
     $errors = 0;
     $files = $_POST['file'];
     if (is_array($files) && count($files)) {
          foreach ($files as $f) {
               if ($f != '') {
                    $f = fm_clean_path($f);
                    // abs path from
                    $from = $path . '/' . $f;
                    // abs path to
                    $dest = $copy_to_path . '/' . $f;
                    // do
                    if ($move) {
                         $rename = fm_rename($from, $dest);
                         if ($rename === false) {
                              $errors++;
                         }
                    } else {
                         if (!fm_rcopy($from, $dest)) {
                              $errors++;
                         }
                    }
               }
          }
          if ($errors == 0) {
               $msg = $move ? 'Selected files and folders moved' : 'Selected files and folders copied';
               fm_set_msg($msg);
          } else {
               $msg = $move ? 'Error while moving items' : 'Error while copying items';
               fm_set_msg($msg, 'error');
          }
     } else {
          fm_set_msg(lng('Nothing selected'), 'alert');
     }
     $FM_PATH = FM_PATH;
     fm_redirect(FM_SELF_URL . '?p=' . urlencode($FM_PATH));
}

// Rename
if (isset($_POST['rename_from'], $_POST['rename_to'], $_POST['token']) && !FM_READONLY) {
     if (!verifyToken($_POST['token'])) {
          fm_set_msg("Invalid Token.", 'error');
     }
     // old name
     $old = urldecode($_POST['rename_from']);
     $old = fm_clean_path($old);
     $old = str_replace('/', '', $old);
     // new name
     $new = urldecode($_POST['rename_to']);
     $new = fm_clean_path(strip_tags($new));
     $new = str_replace('/', '', $new);
     // path
     $path = FM_ROOT_PATH;
     if (FM_PATH != '') {
          $path .= '/' . FM_PATH;
     }
     // rename
     if (fm_isvalid_filename($new) && $old != '' && $new != '') {
          if (fm_rename($path . '/' . $old, $path . '/' . $new)) {
               fm_set_msg(sprintf(lng('Renamed from') . ' <b>%s</b> ' . lng('to') . ' <b>%s</b>', fm_enc($old), fm_enc($new)));
               insertTracking('Rename', $path, $new, $_SESSION[FM_SESSION_ID]['logged'], 'Rename from ' . $old . ' to ' . $new);
          } else {
               fm_set_msg(sprintf(lng('Error while renaming from') . ' <b>%s</b> ' . lng('to') . ' <b>%s</b>', fm_enc($old), fm_enc($new)), 'error');
          }
     } else {
          fm_set_msg(lng('Invalid characters in file name'), 'error');
     }
     $FM_PATH = FM_PATH;
     fm_redirect(FM_SELF_URL . '?p=' . urlencode($FM_PATH));
}

// Download
if (isset($_GET['dl'], $_POST['token'])) {
     if (!verifyToken($_POST['token'])) {
          fm_set_msg("Invalid Token.", 'error');
     }

     $dl = urldecode($_GET['dl']);
     $dl = fm_clean_path($dl);
     $dl = str_replace('/', '', $dl);
     $path = FM_ROOT_PATH;
     if (FM_PATH != '') {
          $path .= '/' . FM_PATH;
     }
     if ($dl != '' && is_file($path . '/' . $dl)) {
          fm_download_file($path . '/' . $dl, $dl, 1024);
          exit;
     } else {
          fm_set_msg(lng('File not found'), 'error');
          $FM_PATH = FM_PATH;
          fm_redirect(FM_SELF_URL . '?p=' . urlencode($FM_PATH));
     }
}

// Upload
if (!empty($_FILES) && !FM_READONLY) {
     if (isset($_POST['token'])) {
          if (!verifyToken($_POST['token'])) {
               $response = array('status' => 'error', 'info' => "Invalid Token.");
               echo json_encode($response);
               exit();
          }
     } else {
          $response = array('status' => 'error', 'info' => "Token Missing.");
          echo json_encode($response);
          exit();
     }

     $chunkIndex = $_POST['dzchunkindex'];
     $chunkTotal = $_POST['dztotalchunkcount'];
     $fullPathInput = fm_clean_path($_REQUEST['fullpath']);

     $f = $_FILES;
     $path = FM_ROOT_PATH;
     $ds = DIRECTORY_SEPARATOR;
     if (FM_PATH != '') {
          $path .= '/' . FM_PATH;
     }

     $errors = 0;
     $uploads = 0;
     $allowed = (FM_UPLOAD_EXTENSION) ? explode(',', FM_UPLOAD_EXTENSION) : false;
     $response = array(
          'status' => 'error',
          'info'   => 'Oops! Try again'
     );

     $filename = $f['file']['name'];
     $tmp_name = $f['file']['tmp_name'];
     $ext = pathinfo($filename, PATHINFO_FILENAME) != '' ? strtolower(pathinfo($filename, PATHINFO_EXTENSION)) : '';
     $isFileAllowed = ($allowed) ? in_array($ext, $allowed) : true;

     if (!fm_isvalid_filename($filename) && !fm_isvalid_filename($fullPathInput)) {
          $response = array(
               'status'    => 'error',
               'info'      => "Invalid File name!",
          );
          echo json_encode($response);
          exit();
     }

     $targetPath = $path . $ds;
     if (is_writable($targetPath)) {
          $fullPath = $path . '/' . basename($fullPathInput);
          $folder = substr($fullPath, 0, strrpos($fullPath, "/"));

          if (!is_dir($folder)) {
               $old = umask(0);
               mkdir($folder, 0777, true);
               umask($old);
          }

          if (empty($f['file']['error']) && !empty($tmp_name) && $tmp_name != 'none' && $isFileAllowed) {
               if ($chunkTotal) {
                    $out = @fopen("{$fullPath}.part", $chunkIndex == 0 ? "wb" : "ab");
                    if ($out) {
                         $in = @fopen($tmp_name, "rb");
                         if ($in) {
                              if (PHP_VERSION_ID < 80009) {
                                   // workaround https://bugs.php.net/bug.php?id=81145
                                   do {
                                        for (;;) {
                                             $buff = fread($in, 4096);
                                             if ($buff === false || $buff === '') {
                                                  break;
                                             }
                                             fwrite($out, $buff);
                                        }
                                   } while (!feof($in));
                              } else {
                                   stream_copy_to_stream($in, $out);
                              }
                              $response = array(
                                   'status'    => 'success',
                                   'info' => "file upload successful"
                              );
                         } else {
                              $response = array(
                                   'status'    => 'error',
                                   'info' => "failed to open output stream",
                                   'errorDetails' => error_get_last()
                              );
                         }
                         @fclose($in);
                         @fclose($out);
                         @unlink($tmp_name);

                         $response = array(
                              'status'    => 'success',
                              'info' => "file upload successful"
                         );
                    } else {
                         $response = array(
                              'status'    => 'error',
                              'info' => "failed to open output stream"
                         );
                    }

                    if ($chunkIndex == $chunkTotal - 1) {
                         if (file_exists($fullPath)) {
                              $ext_1 = $ext ? '.' . $ext : '';
                              $fullPathTarget = $path . '/' . basename($fullPathInput, $ext_1) . '_' . date('ymdHis') . $ext_1;
                         } else {
                              $fullPathTarget = $fullPath;
                         }
                         rename("{$fullPath}.part", $fullPathTarget);
                    }
               } else if (move_uploaded_file($tmp_name, $fullPath)) {
                    // Be sure that the file has been uploaded
                    if (file_exists($fullPath)) {
                         $response = array(
                              'status'    => 'success',
                              'info' => "file upload successful"
                         );
                    } else {
                         $response = array(
                              'status' => 'error',
                              'info'   => 'Couldn\'t upload the requested file.'
                         );
                    }
               } else {
                    $response = array(
                         'status'    => 'error',
                         'info'      => "Error while uploading files. Uploaded files $uploads",
                    );
               }
          }
     } else {
          $response = array(
               'status' => 'error',
               'info'   => 'The specified folder for upload isn\'t writeable.'
          );
     }
     // Return the response
     //insertTracking('Upload', $fullPath, $filename, $_SESSION[FM_SESSION_ID]['logged']);
     echo json_encode($response);
     exit();
}

// Mass deleting
if (isset($_POST['group'], $_POST['delete'], $_POST['token']) && !FM_READONLY) {

     if (!verifyToken($_POST['token'])) {
          fm_set_msg(lng("Invalid Token."), 'error');
     }

     $path = FM_ROOT_PATH;
     if (FM_PATH != '') {
          $path .= '/' . FM_PATH;
     }

     $errors = 0;
     $files = $_POST['file'];
     if (is_array($files) && count($files)) {
          foreach ($files as $f) {
               if ($f != '') {
                    $new_path = $path . '/' . $f;
                    if (!fm_rdelete($new_path)) {
                         $errors++;
                    }
               }
               insertTracking('Delete Selected', $path, $f, $_SESSION[FM_SESSION_ID]['logged']);
          }
          if ($errors == 0) {
               fm_set_msg(lng('Selected files and folder deleted'));
          } else {
               fm_set_msg(lng('Error while deleting items'), 'error');
          }
     } else {
          fm_set_msg(lng('Nothing selected'), 'alert');
     }

     $FM_PATH = FM_PATH;
     fm_redirect(FM_SELF_URL . '?p=' . urlencode($FM_PATH));
}

// Pack files zip, tar
if (isset($_POST['group'], $_POST['token']) && (isset($_POST['zip']) || isset($_POST['tar'])) && !FM_READONLY) {

     if (!verifyToken($_POST['token'])) {
          fm_set_msg(lng("Invalid Token."), 'error');
     }

     $path = FM_ROOT_PATH;
     $ext = 'zip';
     if (FM_PATH != '') {
          $path .= '/' . FM_PATH;
     }

     //set pack type
     $ext = isset($_POST['tar']) ? 'tar' : 'zip';

     if (($ext == "zip" && !class_exists('ZipArchive')) || ($ext == "tar" && !class_exists('PharData'))) {
          fm_set_msg(lng('Operations with archives are not available'), 'error');
          $FM_PATH = FM_PATH;
          fm_redirect(FM_SELF_URL . '?p=' . urlencode($FM_PATH));
     }

     $files = $_POST['file'];
     $sanitized_files = array();

     // clean path
     foreach ($files as $file) {
          array_push($sanitized_files, fm_clean_path($file));
     }

     $files = $sanitized_files;

     if (!empty($files)) {
          chdir($path);

          if (count($files) == 1) {
               $one_file = reset($files);
               $one_file = basename($one_file);
               $zipname = $one_file . '_' . date('ymd_His') . '.' . $ext;
          } else {
               $zipname = 'archive_' . date('ymd_His') . '.' . $ext;
          }

          if ($ext == 'zip') {
               $zipper = new FM_Zipper();
               $res = $zipper->create($zipname, $files);
          } elseif ($ext == 'tar') {
               $tar = new FM_Zipper_Tar();
               $res = $tar->create($zipname, $files);
          }

          if ($res) {
               fm_set_msg(sprintf(lng('Archive') . ' <b>%s</b> ' . lng('Created'), fm_enc($zipname)));
          } else {
               fm_set_msg(lng('Archive not created'), 'error');
          }
     } else {
          fm_set_msg(lng('Nothing selected'), 'alert');
     }

     $FM_PATH = FM_PATH;
     fm_redirect(FM_SELF_URL . '?p=' . urlencode($FM_PATH));
}

// Unpack zip, tar
if (isset($_POST['unzip'], $_POST['token']) && !FM_READONLY) {

     if (!verifyToken($_POST['token'])) {
          fm_set_msg(lng("Invalid Token."), 'error');
     }

     $unzip = urldecode($_POST['unzip']);
     $unzip = fm_clean_path($unzip);
     $unzip = str_replace('/', '', $unzip);
     $isValid = false;

     $path = FM_ROOT_PATH;
     if (FM_PATH != '') {
          $path .= '/' . FM_PATH;
     }

     if ($unzip != '' && is_file($path . '/' . $unzip)) {
          $zip_path = $path . '/' . $unzip;
          $ext = pathinfo($zip_path, PATHINFO_EXTENSION);
          $isValid = true;
     } else {
          fm_set_msg(lng('File not found'), 'error');
     }

     if (($ext == "zip" && !class_exists('ZipArchive')) || ($ext == "tar" && !class_exists('PharData'))) {
          fm_set_msg(lng('Operations with archives are not available'), 'error');
          $FM_PATH = FM_PATH;
          fm_redirect(FM_SELF_URL . '?p=' . urlencode($FM_PATH));
     }

     if ($isValid) {
          //to folder
          $tofolder = '';
          if (isset($_POST['tofolder'])) {
               $tofolder = pathinfo($zip_path, PATHINFO_FILENAME);
               if (fm_mkdir($path . '/' . $tofolder, true)) {
                    $path .= '/' . $tofolder;
               }
          }

          if ($ext == "zip") {
               $zipper = new FM_Zipper();
               $res = $zipper->unzip($zip_path, $path);
          } elseif ($ext == "tar") {
               try {
                    $gzipper = new PharData($zip_path);
                    if (@$gzipper->extractTo($path, null, true)) {
                         $res = true;
                    } else {
                         $res = false;
                    }
               } catch (Exception $e) {
                    //TODO:: need to handle the error
                    $res = true;
               }
          }

          if ($res) {
               fm_set_msg(lng('Archive unpacked'));
          } else {
               fm_set_msg(lng('Archive not unpacked'), 'error');
          }
     } else {
          fm_set_msg(lng('File not found'), 'error');
     }
     $FM_PATH = FM_PATH;
     fm_redirect(FM_SELF_URL . '?p=' . urlencode($FM_PATH));
}

// Change Perms (not for Windows)
if (isset($_POST['chmod'], $_POST['token']) && !FM_READONLY && !FM_IS_WIN) {

     if (!verifyToken($_POST['token'])) {
          fm_set_msg(lng("Invalid Token."), 'error');
     }

     $path = FM_ROOT_PATH;
     if (FM_PATH != '') {
          $path .= '/' . FM_PATH;
     }

     $file = $_POST['chmod'];
     $file = fm_clean_path($file);
     $file = str_replace('/', '', $file);
     if ($file == '' || (!is_file($path . '/' . $file) && !is_dir($path . '/' . $file))) {
          fm_set_msg(lng('File not found'), 'error');
          $FM_PATH = FM_PATH;
          fm_redirect(FM_SELF_URL . '?p=' . urlencode($FM_PATH));
     }

     $mode = 0;
     if (!empty($_POST['ur'])) {
          $mode |= 0400;
     }
     if (!empty($_POST['uw'])) {
          $mode |= 0200;
     }
     if (!empty($_POST['ux'])) {
          $mode |= 0100;
     }
     if (!empty($_POST['gr'])) {
          $mode |= 0040;
     }
     if (!empty($_POST['gw'])) {
          $mode |= 0020;
     }
     if (!empty($_POST['gx'])) {
          $mode |= 0010;
     }
     if (!empty($_POST['or'])) {
          $mode |= 0004;
     }
     if (!empty($_POST['ow'])) {
          $mode |= 0002;
     }
     if (!empty($_POST['ox'])) {
          $mode |= 0001;
     }

     if (@chmod($path . '/' . $file, $mode)) {
          fm_set_msg(lng('Permissions changed'));
     } else {
          fm_set_msg(lng('Permissions not changed'), 'error');
     }

     $FM_PATH = FM_PATH;
     fm_redirect(FM_SELF_URL . '?p=' . urlencode($FM_PATH));
}

/*************************** ACTIONS ***************************/

// get current path
$path = FM_ROOT_PATH;
if (FM_PATH != '') {
     $path .= '/' . FM_PATH;
}

// check path
if (!is_dir($path)) {
     fm_redirect(FM_SELF_URL . '?p=');
}

// get parent folder
$parent = fm_get_parent_path(FM_PATH);

$objects = is_readable($path) ? scandir($path) : array();
$folders = array();
$files = array();
$current_path = array_slice(explode("/", $path), -1)[0];
if (is_array($objects) && fm_is_exclude_items($current_path)) {
     foreach ($objects as $file) {
          if ($file == '.' || $file == '..') {
               continue;
          }
          if (!FM_SHOW_HIDDEN && substr($file, 0, 1) === '.') {
               continue;
          }
          $new_path = $path . '/' . $file;
          if (@is_file($new_path) && fm_is_exclude_items($file)) {
               $files[] = $file;
          } elseif (@is_dir($new_path) && $file != '.' && $file != '..' && fm_is_exclude_items($file)) {
               $folders[] = $file;
          }
     }
}

if (!empty($files)) {
     natcasesort($files);
}
if (!empty($folders)) {
     natcasesort($folders);
}

// upload form
if (isset($_GET['upload']) && !FM_READONLY) {
     fm_show_header(); // HEADER
     fm_show_nav_path(FM_PATH); // current path
     //get the allowed file extensions
     function getUploadExt()
     {
          $extArr = explode(',', FM_UPLOAD_EXTENSION);
          if (FM_UPLOAD_EXTENSION && $extArr) {
               array_walk($extArr, function (&$x) {
                    $x = ".$x";
               });
               return implode(',', $extArr);
          }
          return '';
     }
     ?>
     <?php print_external('css-dropzone'); ?>
     <div class="path">

          <div class="card mb-2 fm-upload-wrapper <?php echo fm_get_theme(); ?>">
               <div class="card-header">
                    <ul class="nav nav-tabs card-header-tabs">
                         <li class="nav-item">
                              <a class="nav-link active" href="#fileUploader" data-target="#fileUploader"><i class="fa fa-arrow-circle-o-up"></i> <?php echo lng('UploadingFiles') ?></a>
                         </li>
                         <li class="nav-item">
                              <a class="nav-link" href="#urlUploader" class="js-url-upload" data-target="#urlUploader"><i class="fa fa-link"></i> <?php echo lng('Upload from URL') ?></a>
                         </li>
                    </ul>
               </div>
               <div class="card-body">
                    <p class="card-text">
                         <a href="?p=<?php echo FM_PATH ?>" class="float-right"><i class="fa fa-chevron-circle-left go-back"></i>
                              <?php echo lng('Back') ?></a>
                         <strong><?php echo lng('DestinationFolder') ?></strong>: <?php echo fm_enc(fm_convert_win(FM_PATH)) ?>
                    </p>

                    <form action="<?php echo htmlspecialchars(FM_SELF_URL) . '?p=' . fm_enc(FM_PATH) ?>" class="dropzone card-tabs-container" id="fileUploader" enctype="multipart/form-data">
                         <input type="hidden" name="p" value="<?php echo fm_enc(FM_PATH) ?>">
                         <input type="hidden" name="fullpath" id="fullpath" value="<?php echo fm_enc(FM_PATH) ?>">
                         <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">
                         <div class="fallback">
                              <input name="file" type="file" multiple />
                         </div>
                    </form>

                    <div class="upload-url-wrapper card-tabs-container hidden" id="urlUploader">
                         <form id="js-form-url-upload" class="row row-cols-lg-auto g-3 align-items-center" onsubmit="return upload_from_url(this);" method="POST" action="">
                              <input type="hidden" name="type" value="upload" aria-label="hidden" aria-hidden="true">
                              <input type="url" placeholder="URL" name="uploadurl" required class="form-control" style="width: 80%">
                              <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">
                              <button type="submit" class="btn btn-primary ms-3"><?php echo lng('Upload') ?></button>
                              <div class="lds-facebook">
                                   <div></div>
                                   <div></div>
                                   <div></div>
                              </div>
                         </form>
                         <div id="js-url-upload__list" class="col-9 mt-3"></div>
                    </div>
               </div>
          </div>
     </div>
     <?php print_external('js-dropzone'); ?>
     <script>
          Dropzone.options.fileUploader = {
               chunking: true,
               chunkSize: <?php echo UPLOAD_CHUNK_SIZE; ?>,
               forceChunking: true,
               retryChunks: true,
               retryChunksLimit: 3,
               parallelUploads: 1,
               parallelChunkUploads: false,
               timeout: 120000,
               maxFilesize: "<?php echo MAX_UPLOAD_SIZE; ?>",
               acceptedFiles: "<?php echo getUploadExt() ?>",
               init: function() {
                    this.on("sending", function(file, xhr, formData) {
                         let _path = (file.fullPath) ? file.fullPath : file.name;
                         document.getElementById("fullpath").value = _path;
                         xhr.ontimeout = (function() {
                              toast('Error: Server Timeout');
                         });
                    }).on("success", function(res) {
                         let _response = JSON.parse(res.xhr.response);

                         if (_response.status == "error") {
                              toast(_response.info);
                         }
                    }).on("error", function(file, response) {
                         toast(response);
                    });
               }
          }
     </script>
<?php
     fm_show_footer();
     exit;
}

// copy form POST
if (isset($_POST['copy']) && !FM_READONLY) {
     $copy_files = isset($_POST['file']) ? $_POST['file'] : null;
     if (!is_array($copy_files) || empty($copy_files)) {
          fm_set_msg(lng('Nothing selected'), 'alert');
          $FM_PATH = FM_PATH;
          fm_redirect(FM_SELF_URL . '?p=' . urlencode($FM_PATH));
     }

     fm_show_header(); // HEADER
     fm_show_nav_path(FM_PATH); // current path
?>
     <div class="path">
          <div class="card <?php echo fm_get_theme(); ?>">
               <div class="card-header">
                    <h6><?php echo lng('Copying') ?></h6>
               </div>
               <div class="card-body">
                    <form action="" method="post">
                         <input type="hidden" name="p" value="<?php echo fm_enc(FM_PATH) ?>">
                         <input type="hidden" name="finish" value="1">
                         <?php
                         foreach ($copy_files as $cf) {
                              echo '<input type="hidden" name="file[]" value="' . fm_enc($cf) . '">' . PHP_EOL;
                         }
                         ?>
                         <p class="break-word"><strong><?php echo lng('Files') ?></strong>:
                              <b><?php echo implode('</b>, <b>', $copy_files) ?></b>
                         </p>
                         <p class="break-word"><strong><?php echo lng('SourceFolder') ?></strong>:
                              <?php echo fm_enc(fm_convert_win(FM_ROOT_PATH . '/' . FM_PATH)) ?><br>
                              <label for="inp_copy_to"><strong><?php echo lng('DestinationFolder') ?></strong>:</label>
                              <?php echo FM_ROOT_PATH ?>/<input type="text" name="copy_to" id="inp_copy_to" value="<?php echo fm_enc(FM_PATH) ?>">
                         </p>
                         <p class="custom-checkbox custom-control"><input type="checkbox" name="move" value="1" id="js-move-files" class="custom-control-input"><label for="js-move-files" class="custom-control-label ms-2"> <?php echo lng('Move') ?></label></p>
                         <p>
                              <b><a href="?p=<?php echo urlencode(FM_PATH) ?>" class="btn btn-outline-danger"><i class="fa fa-times-circle"></i> <?php echo lng('Cancel') ?></a></b>&nbsp;
                              <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">
                              <button type="submit" class="btn btn-success"><i class="fa fa-check-circle"></i>
                                   <?php echo lng('Copy') ?></button>
                         </p>
                    </form>
               </div>
          </div>
     </div>
<?php
     fm_show_footer();
     exit;
}

// copy form
if (isset($_GET['copy']) && !isset($_GET['finish']) && !FM_READONLY) {
     $copy = $_GET['copy'];
     $copy = fm_clean_path($copy);
     if ($copy == '' || !file_exists(FM_ROOT_PATH . '/' . $copy)) {
          fm_set_msg(lng('File not found'), 'error');
          $FM_PATH = FM_PATH;
          fm_redirect(FM_SELF_URL . '?p=' . urlencode($FM_PATH));
     }

     fm_show_header(); // HEADER
     fm_show_nav_path(FM_PATH); // current path
?>
     <div class="path">
          <p><b>Copying</b></p>
          <p class="break-word">
               <strong><?php echo lng('Source path') ?>:</strong>
               <?php echo fm_enc(fm_convert_win(FM_ROOT_PATH . '/' . $copy)) ?><br>
               <strong><?php echo lng('Destination folder') ?>:</strong>
               <?php echo fm_enc(fm_convert_win(FM_ROOT_PATH . '/' . FM_PATH)) ?>
          </p>

          <p style="font-size: xx-large; color: #ff0000;"><i><?php echo lng('Select folder') ?></i></p>
          <ul class="folders break-word h5">
               <?php
               if ($parent !== false) {
               ?>
                    <li><a href="?p=<?php echo urlencode($parent) ?>&amp;copy=<?php echo urlencode($copy) ?>"><i class="fa fa-chevron-circle-left"></i> ..</a></li>
               <?php
               }
               foreach ($folders as $f) {
               ?>
                    <li>
                         <a href="?p=<?php echo urlencode(trim(FM_PATH . '/' . $f, '/')) ?>&amp;copy=<?php echo urlencode($copy) ?>"><i class="fa fa-folder-o"></i> <?php echo fm_convert_win($f) ?></a>
                    </li>
               <?php
               }
               ?>
          </ul>
          <br><br><br>
          <p>
               <b><a href="?p=<?php echo urlencode(FM_PATH) ?>&amp;copy=<?php echo urlencode($copy) ?>&amp;finish=1"><i class="fa fa-check-circle"></i> Copy</a></b> &nbsp;
               <b><a href="?p=<?php echo urlencode(FM_PATH) ?>&amp;copy=<?php echo urlencode($copy) ?>&amp;finish=1&amp;move=1"><i class="fa fa-check-circle"></i> Move</a></b> &nbsp;
               <b><a href="?p=<?php echo urlencode(FM_PATH) ?>" class="text-danger"><i class="fa fa-times-circle"></i>
                         Cancel</a></b>
          </p>
     </div>
<?php
     fm_show_footer();
     exit;
}

if (isset($_GET['settings']) && !FM_READONLY) {
     fm_show_header(); // HEADER
     fm_show_nav_path(FM_PATH); // current path
     global $cfg, $lang, $lang_list;
?>

     <div class="col-md-8 offset-md-2 pt-3">
          <div class="card mb-2 <?php echo fm_get_theme(); ?>">
               <h6 class="card-header d-flex justify-content-between">
                    <span><i class="fa fa-cog"></i> <?php echo lng('Settings') ?></span>
                    <a href="?p=<?php echo FM_PATH ?>" class="text-danger"><i class="fa fa-times-circle-o"></i>
                         <?php echo lng('Cancel') ?></a>
               </h6>
               <div class="card-body">
                    <form id="js-settings-form" action="" method="post" data-type="ajax" onsubmit="return save_settings(this)">
                         <input type="hidden" name="type" value="settings" aria-label="hidden" aria-hidden="true">
                         <div class="form-group row">
                              <label for="js-language" class="col-sm-3 col-form-label"><?php echo lng('Language') ?></label>
                              <div class="col-sm-5">
                                   <select class="form-select" id="js-language" name="js-language">
                                        <?php
                                        function getSelected($l)
                                        {
                                             global $lang;
                                             return ($lang == $l) ? 'selected' : '';
                                        }
                                        foreach ($lang_list as $k => $v) {
                                             echo "<option value='$k' " . getSelected($k) . ">$v</option>";
                                        }
                                        ?>
                                   </select>
                              </div>
                         </div>
                         <Br>
                         <?php if (FM_ISADMIN) { ?>
                              <div class="mt-3 mb-3 row ">
                                   <label for="js-error-report" class="col-sm-3 col-form-label"><?php echo lng('ErrorReporting') ?></label>
                                   <div class="col-sm-9">
                                        <div class="form-check form-switch">
                                             <input class="form-check-input" type="checkbox" role="switch" id="js-error-report" name="js-error-report" value="true" <?php echo $report_errors ? 'checked' : ''; ?> />
                                        </div>
                                   </div>
                              </div>

                              <div class="mb-3 row">
                                   <label for="js-show-hidden" class="col-sm-3 col-form-label"><?php echo lng('ShowHiddenFiles') ?></label>
                                   <div class="col-sm-9">
                                        <div class="form-check form-switch">
                                             <input class="form-check-input" type="checkbox" role="switch" id="js-show-hidden" name="js-show-hidden" value="true" <?php echo $show_hidden_files ? 'checked' : ''; ?> />
                                        </div>
                                   </div>
                              </div>

                              <div class="mb-3 row">
                                   <label for="js-hide-cols" class="col-sm-3 col-form-label"><?php echo lng('HideColumns') ?></label>
                                   <div class="col-sm-9">
                                        <div class="form-check form-switch">
                                             <input class="form-check-input" type="checkbox" role="switch" id="js-hide-cols" name="js-hide-cols" value="true" <?php echo $hide_Cols ? 'checked' : ''; ?> />
                                        </div>
                                   </div>
                              </div>
                         <?php } ?>
                         <div class="mb-3 row">
                              <label for="js-3-1" class="col-sm-3 col-form-label"><?php echo lng('Theme') ?></label>
                              <div class="col-sm-5">
                                   <select class="form-select w-100" id="js-3-0" name="js-theme-3">
                                        <option value='light' <?php if ($theme == "light") {
                                                                      echo "selected";
                                                                 } ?>><?php echo lng('light') ?></option>
                                        <option value='dark' <?php if ($theme == "dark") {
                                                                      echo "selected";
                                                                 } ?>><?php echo lng('dark') ?></option>
                                   </select>
                              </div>
                         </div>
                         <div class="mb-3 row">
                              <label for="js-3-1" class="col-sm-3 col-form-label">Delete file after</label>
                              <div class="col-sm-5">
                                   <input type="text" class="form-control" value="60 Days" disabled />
                                   <small style="color: #ff0000;">
                                        This field is lock by admin
                                   </small>
                              </div>
                         </div>
                         <div class="mb-3 row">
                              <div class="col-sm-10">
                                   <button type="submit" class="btn btn-success"> <i class="fa fa-check-circle"></i>
                                        <?php echo lng('Save'); ?></button>
                              </div>
                         </div>

                    </form>
               </div>
          </div>
     </div>
<?php
     fm_show_footer();
     exit;
}

if (isset($_GET['help'])) {
     fm_show_header(); // HEADER
     fm_show_nav_path(FM_PATH); // current path
     global $cfg, $lang;
?>

     <div class="col-md-8 offset-md-2 pt-3">
          <div class="card mb-2 <?php echo fm_get_theme(); ?>">
               <h6 class="card-header d-flex justify-content-between">
                    <span><i class="fa fa-exclamation-circle"></i> <?php echo lng('Help') ?></span>
                    <a href="?p=<?php echo FM_PATH ?>" class="text-danger"><i class="fa fa-times-circle-o"></i>
                         <?php echo lng('Cancel') ?></a>
               </h6>
               <div class="card-body">
                    <div class="row">
                         <div class="col-xs-12 col-sm-6">
                              <p>
                              <h3><a href="http://www.tscovn.com/" target="_blank" class="app-v-title"> TSCOVN FTP File Manager
                                        <?php echo VERSION; ?></a></h3>
                              </p>
                              <p>Author: IT Department</p>
                              <p>Contact us: <a href="mailto:hungvo@tscovn.com">hungvo@tscovn.com</a> </p>
                         </div>
                         <div class="col-xs-12 col-sm-6">
                              <div class="card">
                                   <ul class="list-group list-group-flush">

                                        <li class="list-group-item"><a href="https://join.skype.com/invite/p0LGaz9GizKF" target="_blank"><i class="fa fa-bug"></i> <?php echo lng('Report Issue') ?></a></li>
                                        <?php if (FM_ISADMIN) { ?>
                                             <li class="list-group-item"><a href="javascript:show_new_pwd();"><i class="fa fa-lock"></i>
                                                       <?php echo lng('Generate new password hash') ?></a></li>
                                        <?php } ?>
                                        <?php if (!FM_READONLY) { ?>
                                             <li class="list-group-item"><a href="http://monitor.tscovn.com:9001/help.pdf" target="_blank"><i class="fa fa-question-circle"></i>
                                                       <?php echo lng('Help Documents') ?> </a> </li>
                                             <li class="list-group-item"><a href="javascript:show_change_pwd();"><i class="fa fa-unlock" aria-hidden="true"></i>
                                                       <?php echo lng('Change Password') ?></a></li>
                                             <li class="list-group-item"><a href="javascript:create_guest();"><i class="fa fa-user-plus"></i>
                                                       <?php echo lng('Create guest user') ?></a></li>
                                             <li class="list-group-item"><a href="javascript:show_change_path();"><i class="fa fa-sitemap" aria-hidden="true"></i>
                                                       Change Path</a></li>
                                        <?php } ?>
                                   </ul>
                              </div>
                         </div>
                    </div>
                    <!-- tạo mật khẩu mới -->
                    <div class="row js-new-pwd hidden mt-2">
                         <div class="col-12">
                              <form class="form-inline" onsubmit="return new_password_hash(this)" method="POST" action="">
                                   <input type="hidden" name="type" value="pwdhash" aria-label="hidden" aria-hidden="true">
                                   <div class="form-group mb-2">
                                        <label for="staticEmail2"><?php echo lng('Generate new password hash') ?></label>
                                   </div>
                                   <div class="form-group mx-sm-3 mb-2">
                                        <label for="inputPassword2" class="sr-only"><?php echo lng('Password') ?></label>
                                        <input type="text" class="form-control btn-sm" id="inputPassword2" name="inputPassword2" placeholder="<?php echo lng('Password') ?>" required>
                                   </div>
                                   <button type="submit" class="btn btn-success btn-sm mb-2"><?php echo lng('Create') ?></button>
                              </form>
                              <input type="text" class="form-control btn-sm" id="js-pwd-result" name="js-pwd-result" />
                         </div>
                    </div>
                    <!-- Đổi đường dẫn cho tài khoản guest -->
                    <div class="row js-change-path hidden mt-2">
                         <div class="col-12">
                              <form class="form" onsubmit="return change_guest_path(this)" method="POST" action="index.php">
                                   <input type="hidden" name="type" value="changePath" aria-label="hidden" aria-hidden="true">
                                   <?php
                                   $user = $_SESSION[FM_SESSION_ID]['logged'];
                                   $query = "SELECT * FROM users WHERE create_pic = '$user'";
                                   $result = $conn->query($query);
                                   if ($result->num_rows == 1) {
                                        $row = $result->fetch_assoc();
                                        $user_guest = $row['username'];
                                        $path = $row['path'];
                                        $currentDate = new DateTime(date('Y-m-d'));
                                        $guestCreateDate = new DateTime($row['guest']);
                                        $interval = $guestCreateDate->diff($currentDate);
                                        $daysLeft = $interval->days;
                                        $items = scandir($path);
                                        echo '                                   
                                        <div class="form-group">
                                             <label for="user_guest">Username</label>
                                             <input type="text" class="form-control" value="' . $user_guest . '" id="user_guest" name="user_guest" disabled>
                                        </div>
                                        <div class="form-group">
                                             <label for="guestCreateDate">Valid date</label>
                                             <input type="text" class="form-control" value="' . $daysLeft . " days left" . '" id="guestCreateDate" name="guestCreateDate" disabled>
                                        </div>
                                        <div class="form-group">
                                             <label for="oldPath">Old Path</label>
                                             <input type="text" class="form-control" value="' . $path . '" id="oldPath" name="oldPath" disabled>
                                        </div>';
                                        echo '
                                        <label for="newPath">New Path</label>
                                        <select class="form-select" id="newPath" name="newPath">
                                        <option selected disabled>Select Folder</option>';
                                        foreach ($items as $item) {

                                             $itemPath = $path . '/' . $item;

                                             if ($item !== '.' && $item !== '..' && is_dir($itemPath)) {
                                                  echo "<option>$path/$item</option>";
                                             }
                                        }

                                        echo '</select><br>
                                        <button type="submit" class="btn btn-success">Update Path</button>';
                                   } else {
                                        $oldPath = "You don't have user guest";
                                        echo '
                                        <div class="form-group">
                                             <a href="javascript:create_guest();" class="btn btn-primary"><i class="fa fa-user-plus"></i>You dont have guest account, Click to create</a>
                                        </div>                                  
                                        ';
                                   } ?>
                              </form>
                         </div>
                    </div>
                    <!-- tạo tài khoản cho khách -->
                    <div class="row js-create-guest hidden mt-2">
                         <div class="col-12">
                              <form class="form" onsubmit="return create_guest_user(this)" method="POST" action="index.php">
                                   <input type="hidden" name="type" value="create_guest_user" aria-label="hidden" aria-hidden="true">
                                   <button type="submit" class="btn btn-success btn-sm mb-2"><?php echo lng('Generate new Guest account') ?></button>
                              </form>
                              <div class="mt-2" id="change-pwd-message"></div>
                         </div>
                    </div>
                    <!-- change password -->
                    <div class="row js-change-pwd hidden mt-2">
                         <div class="col-12">
                              <form class="form" onsubmit="return change_password(this)" method="POST" action="index.php">
                                   <input type="hidden" name="type" value="changepwd" aria-label="hidden" aria-hidden="true">

                                   <div class="form-group">
                                        <label for="oldPassword"><?php echo lng('Old Password') ?></label>
                                        <input type="password" class="form-control" id="oldPassword" name="oldPassword" required>
                                   </div>

                                   <div class="form-group">
                                        <label for="newPassword"><?php echo lng('New Password') ?></label>
                                        <input type="password" class="form-control" id="newPassword" name="newPassword" required>
                                   </div>

                                   <div class="form-group">
                                        <label for="confirmNewPassword"><?php echo lng('Confirm New Password') ?></label>
                                        <input type="password" class="form-control" id="confirmNewPassword" name="confirmNewPassword" required>
                                   </div>

                                   <button type="submit" class="btn btn-success"><?php echo lng('Change Password') ?></button>
                              </form>
                              <div class="mt-2" id="change-pwd-message"></div>
                         </div>
                    </div>

                    <!-- change password -->
               </div>
          </div>
     </div>
<?php
     fm_show_footer();
     exit;
}

// file viewer
if (isset($_GET['view'])) {
     $file = $_GET['view'];
     $file = fm_clean_path($file, false);
     $file = str_replace('/', '', $file);
     if ($file == '' || !is_file($path . '/' . $file) || in_array($file, $GLOBALS['exclude_items'])) {
          fm_set_msg(lng('File not found'), 'error');
          $FM_PATH = FM_PATH;
          fm_redirect(FM_SELF_URL . '?p=' . urlencode($FM_PATH));
     }

     fm_show_header(); // HEADER
     fm_show_nav_path(FM_PATH); // current path

     $file_url = FM_ROOT_URL . fm_convert_win((FM_PATH != '' ? '/' . FM_PATH : '') . '/' . $file);
     $file_path = $path . '/' . $file;
     insertTracking('View File', $file_path, $file, $_SESSION[FM_SESSION_ID]['logged']);
     $ext = strtolower(pathinfo($file_path, PATHINFO_EXTENSION));
     $mime_type = fm_get_mime_type($file_path);
     $filesize_raw = fm_get_size($file_path);
     $filesize = fm_get_filesize($filesize_raw);

     $is_zip = false;
     $is_gzip = false;
     $is_image = false;
     $is_audio = false;
     $is_video = false;
     $is_text = false;
     $is_onlineViewer = false;

     $view_title = 'File';
     $filenames = false; // for zip
     $content = ''; // for text
     $online_viewer = strtolower(FM_DOC_VIEWER);

     if ($online_viewer && $online_viewer !== 'false' && in_array($ext, fm_get_onlineViewer_exts())) {
          $is_onlineViewer = true;
     } elseif ($ext == 'zip' || $ext == 'tar') {
          $is_zip = true;
          $view_title = 'Archive';
          $filenames = fm_get_zif_info($file_path, $ext);
     } elseif (in_array($ext, fm_get_image_exts())) {
          $is_image = true;
          $view_title = 'Image';
     } elseif (in_array($ext, fm_get_audio_exts())) {
          $is_audio = true;
          $view_title = 'Audio';
     } elseif (in_array($ext, fm_get_video_exts())) {
          $is_video = true;
          $view_title = 'Video';
     } elseif (in_array($ext, fm_get_text_exts()) || substr($mime_type, 0, 4) == 'text' || in_array($mime_type, fm_get_text_mimes())) {
          $is_text = true;
          $content = file_get_contents($file_path);
     }

?>
     <div class="row">
          <div class="col-12">
               <p class="break-word"><b><?php echo lng($view_title) ?> "<?php echo fm_enc(fm_convert_win($file)) ?>"</b></p>
               <p class="break-word">
                    <?php $display_path = fm_get_display_path($file_path); ?>
                    <strong><?php echo $display_path['label']; ?>:</strong> <?php echo $display_path['path']; ?><br>
                    <strong>File size:</strong> <?php echo ($filesize_raw <= 1000) ? "$filesize_raw bytes" : $filesize; ?><br>
                    <strong>MIME-type:</strong> <?php echo $mime_type ?><br>
                    <?php
                    // ZIP info
                    if (($is_zip || $is_gzip) && $filenames !== false) {
                         $total_files = 0;
                         $total_comp = 0;
                         $total_uncomp = 0;
                         foreach ($filenames as $fn) {
                              if (!$fn['folder']) {
                                   $total_files++;
                              }
                              $total_comp += $fn['compressed_size'];
                              $total_uncomp += $fn['filesize'];
                         }
                    ?>
                         <?php echo lng('Files in archive') ?>: <?php echo $total_files ?><br>
                         <?php echo lng('Total size') ?>: <?php echo fm_get_filesize($total_uncomp) ?><br>
                         <?php echo lng('Size in archive') ?>: <?php echo fm_get_filesize($total_comp) ?><br>
                         <?php echo lng('Compression') ?>: <?php echo round(($total_comp / max($total_uncomp, 1)) * 100) ?>%<br>
                    <?php
                    }
                    // Image info
                    if ($is_image) {
                         $image_size = getimagesize($file_path);
                         echo '<strong>' . lng('Image size') . ':</strong> ' . (isset($image_size[0]) ? $image_size[0] : '0') . ' x ' . (isset($image_size[1]) ? $image_size[1] : '0') . '<br>';
                    }
                    // Text info
                    if ($is_text) {
                         $is_utf8 = fm_is_utf8($content);
                         if (function_exists('iconv')) {
                              if (!$is_utf8) {
                                   $content = iconv(FM_ICONV_INPUT_ENC, 'UTF-8//IGNORE', $content);
                              }
                         }
                         echo '<strong>' . lng('Charset') . ':</strong> ' . ($is_utf8 ? 'utf-8' : '8 bit') . '<br>';
                    }
                    ?>
               </p>
               <div class="d-flex align-items-center mb-3">
                    <form method="post" class="d-inline ms-2" action="?p=<?php echo urlencode(FM_PATH) ?>&amp;dl=<?php echo urlencode($file) ?>">
                         <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">
                         <button type="submit" class="btn btn-link text-decoration-none fw-bold p-0"><i class="fa fa-cloud-download"></i> <?php echo lng('Download') ?></button> &nbsp;
                    </form>
                    <b class="ms-2"><a href="<?php echo fm_enc($file_url) ?>" data-path="<?php echo fm_enc(copyToClipboard($file_url)) ?>" target="_blank"><i class="fa fa-external-link-square"></i> <?php echo lng('Open') ?></a></b>
                    <?php
                    // ZIP actions
                    if (!FM_READONLY && ($is_zip || $is_gzip) && $filenames !== false) {
                         $zip_name = pathinfo($file_path, PATHINFO_FILENAME);
                    ?>
                         <form method="post" class="d-inline ms-2">
                              <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">
                              <input type="hidden" name="unzip" value="<?php echo urlencode($file); ?>">
                              <button type="submit" class="btn btn-link text-decoration-none fw-bold p-0" style="font-size: 14px;"><i class="fa fa-check-circle"></i> <?php echo lng('UnZip') ?></button>
                         </form>&nbsp;
                         <form method="post" class="d-inline ms-2">
                              <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">
                              <input type="hidden" name="unzip" value="<?php echo urlencode($file); ?>">
                              <input type="hidden" name="tofolder" value="1">
                              <button type="submit" class="btn btn-link text-decoration-none fw-bold p-0" style="font-size: 14px;" title="UnZip to <?php echo fm_enc($zip_name) ?>"><i class="fa fa-check-circle"></i>
                                   <?php echo lng('UnZipToFolder') ?></button>
                         </form>&nbsp;
                    <?php
                    }
                    if ($is_text && !FM_READONLY) {
                    ?>
                         <b class="ms-2"><a href="?p=<?php echo urlencode(trim(FM_PATH)) ?>&amp;edit=<?php echo urlencode($file) ?>" class="edit-file"><i class="fa fa-pencil-square"></i> <?php echo lng('Edit') ?>
                              </a></b> &nbsp;
                         <b class="ms-2"><a href="?p=<?php echo urlencode(trim(FM_PATH)) ?>&amp;edit=<?php echo urlencode($file) ?>&env=ace" class="edit-file"><i class="fa fa-pencil-square-o"></i> <?php echo lng('AdvancedEditor') ?>
                              </a></b> &nbsp;
                    <?php } ?>
                    <b class="ms-2"><a href="?p=<?php echo urlencode(FM_PATH) ?>"><i class="fa fa-chevron-circle-left go-back"></i> <?php echo lng('Back') ?></a></b>
               </div>
               <?php
               if ($is_onlineViewer) {
                    if ($online_viewer == 'google') {
                         echo '<iframe src="https://docs.google.com/viewer?embedded=true&hl=en&url=' . fm_enc($file_url) . '" frameborder="no" style="width:100%;min-height:460px"></iframe>';
                    } else if ($online_viewer == 'microsoft') {
                         echo '<iframe src="https://view.officeapps.live.com/op/embed.aspx?src=' . fm_enc($file_url) . '" frameborder="no" style="width:100%;min-height:460px"></iframe>';
                    }
               } elseif ($is_zip) {
                    // ZIP content
                    if ($filenames !== false) {
                         echo '<code class="maxheight">';
                         foreach ($filenames as $fn) {
                              if ($fn['folder']) {
                                   echo '<b>' . fm_enc($fn['name']) . '</b><br>';
                              } else {
                                   echo $fn['name'] . ' (' . fm_get_filesize($fn['filesize']) . ')<br>';
                              }
                         }
                         echo '</code>';
                    } else {
                         echo '<p>' . lng('Error while fetching archive info') . '</p>';
                    }
               } elseif ($is_image) {
                    // Image content
                    if (in_array($ext, array('gif', 'jpg', 'jpeg', 'png', 'bmp', 'ico', 'svg', 'webp', 'avif'))) {
                         echo '<p><input type="checkbox" id="preview-img-zoomCheck"><label for="preview-img-zoomCheck"><img src="' . fm_enc($file_url) . '" alt="image" class="preview-img"></label></p>';
                    }
               } elseif ($is_audio) {
                    // Audio content
                    echo '<p><audio src="' . fm_enc($file_url) . '" controls preload="metadata"></audio></p>';
               } elseif ($is_video) {
                    // Video content
                    echo '<div class="preview-video"><video src="' . fm_enc($file_url) . '" width="640" height="360" controls preload="metadata"></video></div>';
               } elseif ($is_text) {
                    if (FM_USE_HIGHLIGHTJS) {
                         // highlight
                         $hljs_classes = array(
                              'shtml' => 'xml',
                              'htaccess' => 'apache',
                              'phtml' => 'php',
                              'lock' => 'json',
                              'svg' => 'xml',
                         );
                         $hljs_class = isset($hljs_classes[$ext]) ? 'lang-' . $hljs_classes[$ext] : 'lang-' . $ext;
                         if (empty($ext) || in_array(strtolower($file), fm_get_text_names()) || preg_match('#\.min\.(css|js)$#i', $file)) {
                              $hljs_class = 'nohighlight';
                         }
                         $content = '<pre class="with-hljs"><code class="' . $hljs_class . '">' . fm_enc($content) . '</code></pre>';
                    } elseif (in_array($ext, array('php', 'php4', 'php5', 'phtml', 'phps'))) {
                         // php highlight
                         $content = highlight_string($content, true);
                    } else {
                         $content = '<pre>' . fm_enc($content) . '</pre>';
                    }
                    echo $content;
               }
               ?>
          </div>
     </div>
<?php
     fm_show_footer();
     exit;
}

// file editor
if (isset($_GET['edit']) && !FM_READONLY) {
     $file = $_GET['edit'];
     $file = fm_clean_path($file, false);
     $file = str_replace('/', '', $file);
     if ($file == '' || !is_file($path . '/' . $file) || in_array($file, $GLOBALS['exclude_items'])) {
          fm_set_msg(lng('File not found'), 'error');
          $FM_PATH = FM_PATH;
          fm_redirect(FM_SELF_URL . '?p=' . urlencode($FM_PATH));
     }
     $editFile = ' : <i><b>' . $file . '</b></i>';
     header('X-XSS-Protection:0');
     fm_show_header(); // HEADER
     fm_show_nav_path(FM_PATH); // current path

     $file_url = FM_ROOT_URL . fm_convert_win((FM_PATH != '' ? '/' . FM_PATH : '') . '/' . $file);
     $file_path = $path . '/' . $file;
     insertTracking('Edit File non save', $file_path, $file, $_SESSION[FM_SESSION_ID]['logged']);
     // normal editer
     $isNormalEditor = true;
     if (isset($_GET['env'])) {
          if ($_GET['env'] == "ace") {
               $isNormalEditor = false;
          }
     }

     // Save File
     if (isset($_POST['savedata'])) {

          $writedata = $_POST['savedata'];
          $fd = fopen($file_path, "w");
          @fwrite($fd, $writedata);
          fclose($fd);
          fm_set_msg(lng('File Saved Successfully'));
     }

     $ext = strtolower(pathinfo($file_path, PATHINFO_EXTENSION));
     $mime_type = fm_get_mime_type($file_path);
     $filesize = filesize($file_path);
     $is_text = false;
     $content = ''; // for text

     if (in_array($ext, fm_get_text_exts()) || substr($mime_type, 0, 4) == 'text' || in_array($mime_type, fm_get_text_mimes())) {
          $is_text = true;
          $content = file_get_contents($file_path);
     }

?>
     <div class="path">
          <div class="row">
               <div class="col-xs-12 col-sm-5 col-lg-6 pt-1">
                    <div class="btn-toolbar" role="toolbar">
                         <?php if (!$isNormalEditor) { ?>
                              <div class="btn-group js-ace-toolbar">
                                   <button data-cmd="none" data-option="fullscreen" class="btn btn-sm btn-outline-secondary" id="js-ace-fullscreen" title="<?php echo lng('Fullscreen') ?>"><i class="fa fa-expand" title="<?php echo lng('Fullscreen') ?>"></i></button>
                                   <button data-cmd="find" class="btn btn-sm btn-outline-secondary" id="js-ace-search" title="<?php echo lng('Search') ?>"><i class="fa fa-search" title="<?php echo lng('Search') ?>"></i></button>
                                   <button data-cmd="undo" class="btn btn-sm btn-outline-secondary" id="js-ace-undo" title="<?php echo lng('Undo') ?>"><i class="fa fa-undo" title="<?php echo lng('Undo') ?>"></i></button>
                                   <button data-cmd="redo" class="btn btn-sm btn-outline-secondary" id="js-ace-redo" title="<?php echo lng('Redo') ?>"><i class="fa fa-repeat" title="<?php echo lng('Redo') ?>"></i></button>
                                   <button data-cmd="none" data-option="wrap" class="btn btn-sm btn-outline-secondary" id="js-ace-wordWrap" title="<?php echo lng('Word Wrap') ?>"><i class="fa fa-text-width" title="<?php echo lng('Word Wrap') ?>"></i></button>
                                   <select id="js-ace-mode" data-type="mode" title="<?php echo lng('Select Document Type') ?>" class="btn-outline-secondary border-start-0 d-none d-md-block">
                                        <option>-- <?php echo lng('Select Mode') ?> --</option>
                                   </select>
                                   <select id="js-ace-theme" data-type="theme" title="<?php echo lng('Select Theme') ?>" class="btn-outline-secondary border-start-0 d-none d-lg-block">
                                        <option>-- <?php echo lng('Select Theme') ?> --</option>
                                   </select>
                                   <select id="js-ace-fontSize" data-type="fontSize" title="<?php echo lng('Select Font Size') ?>" class="btn-outline-secondary border-start-0 d-none d-lg-block">
                                        <option>-- <?php echo lng('Select Font Size') ?> --</option>
                                   </select>
                              </div>
                         <?php } ?>
                    </div>
               </div>
               <div class="edit-file-actions col-xs-12 col-sm-7 col-lg-6 text-end pt-1">
                    <a title="<?php echo lng('Back') ?>" class="btn btn-sm btn-outline-primary" href="?p=<?php echo urlencode(trim(FM_PATH)) ?>&amp;view=<?php echo urlencode($file) ?>"><i class="fa fa-reply-all"></i> <?php echo lng('Back') ?></a>
                    <a title="<?php echo lng('BackUp') ?>" class="btn btn-sm btn-outline-primary" href="javascript:void(0);" onclick="backup('<?php echo urlencode(trim(FM_PATH)) ?>','<?php echo urlencode($file) ?>')"><i class="fa fa-database"></i> <?php echo lng('BackUp') ?></a>
                    <?php if ($is_text) { ?>
                         <?php if ($isNormalEditor) { ?>
                              <a title="Advanced" class="btn btn-sm btn-outline-primary" href="?p=<?php echo urlencode(trim(FM_PATH)) ?>&amp;edit=<?php echo urlencode($file) ?>&amp;env=ace"><i class="fa fa-pencil-square-o"></i> <?php echo lng('AdvancedEditor') ?></a>
                              <button type="button" class="btn btn-sm btn-success" name="Save" data-url="<?php echo fm_enc($file_url) ?>" onclick="edit_save(this,'nrl')"><i class="fa fa-floppy-o"></i> Save
                              </button>
                         <?php } else { ?>
                              <a title="Plain Editor" class="btn btn-sm btn-outline-primary" href="?p=<?php echo urlencode(trim(FM_PATH)) ?>&amp;edit=<?php echo urlencode($file) ?>"><i class="fa fa-text-height"></i> <?php echo lng('NormalEditor') ?></a>
                              <button type="button" class="btn btn-sm btn-success" name="Save" data-url="<?php echo fm_enc($file_url) ?>" onclick="edit_save(this,'ace')"><i class="fa fa-floppy-o"></i> <?php echo lng('Save') ?>
                              </button>
                         <?php } ?>
                    <?php } ?>
               </div>
          </div>
          <?php
          if ($is_text && $isNormalEditor) {
               echo '<textarea class="mt-2" id="normal-editor" rows="33" cols="120" style="width: 99.5%;">' . htmlspecialchars($content) . '</textarea>';
               echo '<script>document.addEventListener("keydown", function(e) {if ((window.navigator.platform.match("Mac") ? e.metaKey : e.ctrlKey)  && e.keyCode == 83) { e.preventDefault();edit_save(this,"nrl");}}, false);</script>';
          } elseif ($is_text) {
               echo '<div id="editor" contenteditable="true">' . htmlspecialchars($content) . '</div>';
          } else {
               fm_set_msg(lng('FILE EXTENSION HAS NOT SUPPORTED'), 'error');
          }
          ?>
     </div>
<?php
     fm_show_footer();
     exit;
}

// chmod (not for Windows)
if (isset($_GET['chmod']) && !FM_READONLY && !FM_IS_WIN) {
     $file = $_GET['chmod'];
     $file = fm_clean_path($file);
     $file = str_replace('/', '', $file);
     if ($file == '' || (!is_file($path . '/' . $file) && !is_dir($path . '/' . $file))) {
          fm_set_msg(lng('File not found'), 'error');
          $FM_PATH = FM_PATH;
          fm_redirect(FM_SELF_URL . '?p=' . urlencode($FM_PATH));
     }

     fm_show_header(); // HEADER
     fm_show_nav_path(FM_PATH); // current path

     $file_url = FM_ROOT_URL . (FM_PATH != '' ? '/' . FM_PATH : '') . '/' . $file;
     $file_path = $path . '/' . $file;

     $mode = fileperms($path . '/' . $file);
?>
     <div class="path">
          <div class="card mb-2 <?php echo fm_get_theme(); ?>">
               <h6 class="card-header">
                    <?php echo lng('ChangePermissions') ?>
               </h6>
               <div class="card-body">
                    <p class="card-text">
                         <?php $display_path = fm_get_display_path($file_path); ?>
                         <?php echo $display_path['label']; ?>: <?php echo $display_path['path']; ?><br>
                    </p>
                    <form action="" method="post">
                         <input type="hidden" name="p" value="<?php echo fm_enc(FM_PATH) ?>">
                         <input type="hidden" name="chmod" value="<?php echo fm_enc($file) ?>">

                         <table class="table compact-table <?php echo fm_get_theme(); ?>">
                              <tr>
                                   <td></td>
                                   <td><b><?php echo lng('Owner') ?></b></td>
                                   <td><b><?php echo lng('Group') ?></b></td>
                                   <td><b><?php echo lng('Other') ?></b></td>
                              </tr>
                              <tr>
                                   <td style="text-align: right"><b><?php echo lng('Read') ?></b></td>
                                   <td><label><input type="checkbox" name="ur" value="1" <?php echo ($mode & 00400) ? ' checked' : '' ?>></label></td>
                                   <td><label><input type="checkbox" name="gr" value="1" <?php echo ($mode & 00040) ? ' checked' : '' ?>></label></td>
                                   <td><label><input type="checkbox" name="or" value="1" <?php echo ($mode & 00004) ? ' checked' : '' ?>></label></td>
                              </tr>
                              <tr>
                                   <td style="text-align: right"><b><?php echo lng('Write') ?></b></td>
                                   <td><label><input type="checkbox" name="uw" value="1" <?php echo ($mode & 00200) ? ' checked' : '' ?>></label></td>
                                   <td><label><input type="checkbox" name="gw" value="1" <?php echo ($mode & 00020) ? ' checked' : '' ?>></label></td>
                                   <td><label><input type="checkbox" name="ow" value="1" <?php echo ($mode & 00002) ? ' checked' : '' ?>></label></td>
                              </tr>
                              <tr>
                                   <td style="text-align: right"><b><?php echo lng('Execute') ?></b></td>
                                   <td><label><input type="checkbox" name="ux" value="1" <?php echo ($mode & 00100) ? ' checked' : '' ?>></label></td>
                                   <td><label><input type="checkbox" name="gx" value="1" <?php echo ($mode & 00010) ? ' checked' : '' ?>></label></td>
                                   <td><label><input type="checkbox" name="ox" value="1" <?php echo ($mode & 00001) ? ' checked' : '' ?>></label></td>
                              </tr>
                         </table>

                         <p>
                              <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">
                              <b><a href="?p=<?php echo urlencode(FM_PATH) ?>" class="btn btn-outline-primary"><i class="fa fa-times-circle"></i> <?php echo lng('Cancel') ?></a></b>&nbsp;
                              <button type="submit" class="btn btn-success"><i class="fa fa-check-circle"></i>
                                   <?php echo lng('Change') ?></button>
                         </p>
                    </form>
               </div>
          </div>
     </div>
<?php
     fm_show_footer();
     exit;
}

// --- FILEMANAGER MAIN ---
fm_show_header(); // HEADER
fm_show_nav_path(FM_PATH); // current path

// show alert messages
fm_show_message();

$num_files = count($files);
$num_folders = count($folders);
$all_files_size = 0;
$tableTheme = (FM_THEME == "dark") ? "text-white bg-dark table-dark" : "bg-white";
?>
<form action="" method="post" class="pt-3">
     <input type="hidden" name="p" value="<?php echo fm_enc(FM_PATH) ?>">
     <input type="hidden" name="group" value="1">
     <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">
     <div class="table-responsive">
          <table class="table table-bordered table-hover table-sm <?php echo $tableTheme; ?>" id="main-table">
               <thead class="thead-white">
                    <tr>
                         <?php if (!FM_READONLY) : ?>
                              <th style="width:3%" class="custom-checkbox-header">
                                   <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="js-select-all-items" onclick="checkbox_toggle()">
                                        <label class="custom-control-label" for="js-select-all-items"></label>
                                   </div>
                              </th><?php endif; ?>
                         <th><?php echo lng('Name') ?></th>
                         <th><?php echo lng('Size') ?></th>
                         <th><?php echo lng('Modified') ?></th>
                         <?php if (!FM_IS_WIN && !$hide_Cols) : ?>
                              <th><?php echo lng('Perms') ?></th>
                              <th><?php echo lng('Owner') ?></th><?php endif; ?>
                         <th><?php echo lng('Actions') ?></th>
                    </tr>
               </thead>
               <?php
               // link to parent folder
               if ($parent !== false) {
               ?>
                    <tr><?php if (!FM_READONLY) : ?>
                              <td class="nosort"></td><?php endif; ?>
                         <td class="border-0" data-sort><a href="?p=<?php echo urlencode($parent) ?>"><i class="fa fa-chevron-circle-left go-back"></i> ..</a></td>
                         <td class="border-0" data-order></td>
                         <td class="border-0" data-order></td>
                         <td class="border-0"></td>
                         <?php if (!FM_IS_WIN && !$hide_Cols) { ?>
                              <td class="border-0"></td>
                              <td class="border-0"></td>
                         <?php } ?>
                    </tr>
               <?php
               }
               $ii = 3399;
               foreach ($folders as $f) {
                    $is_link = is_link($path . '/' . $f);
                    $img = $is_link ? 'icon-link_folder' : 'fa fa-folder-o';
                    $modif_raw = filemtime($path . '/' . $f);
                    $modif = date(FM_DATETIME_FORMAT, $modif_raw);
                    $date_sorting = strtotime(date("F d Y H:i:s.", $modif_raw));
                    $filesize_raw = "";
                    $filesize = lng('Folder');
                    $perms = substr(decoct(fileperms($path . '/' . $f)), -4);
                    if (function_exists('posix_getpwuid') && function_exists('posix_getgrgid')) {
                         $owner = posix_getpwuid(fileowner($path . '/' . $f));
                         $group = posix_getgrgid(filegroup($path . '/' . $f));
                         if ($owner === false) {
                              $owner = array('name' => '?');
                         }
                         if ($group === false) {
                              $group = array('name' => '?');
                         }
                    } else {
                         $owner = array('name' => '?');
                         $group = array('name' => '?');
                    }
               ?>
                    <tr>
                         <?php if (!FM_READONLY) : ?>
                              <td class="custom-checkbox-td">
                                   <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="<?php echo $ii ?>" name="file[]" value="<?php echo fm_enc($f) ?>">
                                        <label class="custom-control-label" for="<?php echo $ii ?>"></label>
                                   </div>
                              </td><?php endif; ?>
                         <td data-sort=<?php echo fm_convert_win(fm_enc($f)) ?>>
                              <div class="filename"><a href="?p=<?php echo urlencode(trim(FM_PATH . '/' . $f, '/')) ?>"><i class="<?php echo $img ?>"></i> <?php echo fm_convert_win(fm_enc($f)) ?>
                                   </a><?php echo ($is_link ? ' &rarr; <i>' . readlink($path . '/' . $f) . '</i>' : '') ?></div>
                         </td>
                         <td data-order="a-<?php echo str_pad($filesize_raw, 18, "0", STR_PAD_LEFT); ?>">
                              <?php echo $filesize; ?>
                         </td>
                         <td data-order="a-<?php echo $date_sorting; ?>"><?php echo $modif ?></td>
                         <?php if (!FM_IS_WIN && !$hide_Cols) : ?>
                              <td><?php if (!FM_READONLY) : ?><a title="Change Permissions" href="?p=<?php echo urlencode(FM_PATH) ?>&amp;chmod=<?php echo urlencode($f) ?>"><?php echo $perms ?></a><?php else : ?><?php echo $perms ?><?php endif; ?>
                              </td>
                              <td><?php echo $owner['name'] . ':' . $group['name'] ?></td>
                         <?php endif; ?>
                         <td class="inline-actions"><?php if (!FM_READONLY) : ?>
                                   <a title="<?php echo lng('Delete') ?>" href="?p=<?php echo urlencode(FM_PATH) ?>&amp;del=<?php echo urlencode($f) ?>" onclick="confirmDailog(event, '1028','<?php echo lng('Delete') . ' ' . lng('Folder'); ?>','<?php echo urlencode($f) ?>', this.href);">
                                        <i class="fa fa-trash-o" aria-hidden="true"></i></a>
                                   <a title="<?php echo lng('Rename') ?>" href="#" onclick="rename('<?php echo fm_enc(addslashes(FM_PATH)) ?>', '<?php echo fm_enc(addslashes($f)) ?>');return false;"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                   <a title="<?php echo lng('CopyTo') ?>..." href="?p=&amp;copy=<?php echo urlencode(trim(FM_PATH . '/' . $f, '/')) ?>"><i class="fa fa-files-o" aria-hidden="true"></i></a>
                              <?php endif; ?>
                              <a title="<?php echo lng('DirectLink') ?>" id="<?= $f ?>" href="<?php echo fm_enc(FM_ROOT_URL . (FM_PATH != '' ? '/' . FM_PATH : '') . '/' . $f . '/') ?>" target="_blank"><i class="fa fa-link" aria-hidden="true"></i></a>
                         </td>
                    </tr>
               <?php
                    flush();
                    $ii++;
               }
               $ik = 6070;
               foreach ($files as $f) {
                    $is_link = is_link($path . '/' . $f);
                    $img = $is_link ? 'fa fa-file-text-o' : fm_get_file_icon_class($path . '/' . $f);
                    $modif_raw = filemtime($path . '/' . $f);
                    $modif = date(FM_DATETIME_FORMAT, $modif_raw);
                    $date_sorting = strtotime(date("F d Y H:i:s.", $modif_raw));
                    $filesize_raw = fm_get_size($path . '/' . $f);
                    $filesize = fm_get_filesize($filesize_raw);
                    $filelink = '?p=' . urlencode(FM_PATH) . '&amp;view=' . urlencode($f);
                    $all_files_size += $filesize_raw;
                    $perms = substr(decoct(fileperms($path . '/' . $f)), -4);
                    if (function_exists('posix_getpwuid') && function_exists('posix_getgrgid')) {
                         $owner = posix_getpwuid(fileowner($path . '/' . $f));
                         $group = posix_getgrgid(filegroup($path . '/' . $f));
                         if ($owner === false) {
                              $owner = array('name' => '?');
                         }
                         if ($group === false) {
                              $group = array('name' => '?');
                         }
                    } else {
                         $owner = array('name' => '?');
                         $group = array('name' => '?');
                    }
               ?>
                    <tr>
                         <?php if (!FM_READONLY) : ?>
                              <td class="custom-checkbox-td">
                                   <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="<?php echo $ik ?>" name="file[]" value="<?php echo fm_enc($f) ?>">
                                        <label class="custom-control-label" for="<?php echo $ik ?>"></label>
                                   </div>
                              </td><?php endif; ?>
                         <td data-sort=<?php echo fm_enc($f) ?>>
                              <div class="filename">
                                   <?php
                                   if (in_array(strtolower(pathinfo($f, PATHINFO_EXTENSION)), array('gif', 'jpg', 'jpeg', 'png', 'bmp', 'ico', 'svg', 'webp', 'avif'))) : ?>
                                        <?php $imagePreview = fm_enc(FM_ROOT_URL . (FM_PATH != '' ? '/' . FM_PATH : '') . '/' . $f); ?>
                                        <a href="<?php echo $filelink ?>" data-preview-image="<?php echo $imagePreview ?>" title="<?php echo fm_enc($f) ?>">
                                        <?php else : ?>
                                             <a href="<?php echo $filelink ?>" title="<?php echo $f ?>">
                                             <?php endif; ?>
                                             <i class="<?php echo $img ?>"></i> <?php echo fm_convert_win(fm_enc($f)) ?>
                                             </a>
                                             <?php echo ($is_link ? ' &rarr; <i>' . readlink($path . '/' . $f) . '</i>' : '') ?>
                              </div>
                         </td>
                         <td data-order="b-<?php echo str_pad($filesize_raw, 18, "0", STR_PAD_LEFT); ?>"><span title="<?php printf('%s bytes', $filesize_raw) ?>">
                                   <?php echo $filesize; ?>
                              </span></td>
                         <td data-order="b-<?php echo $date_sorting; ?>"><?php echo $modif ?></td>
                         <?php if (!FM_IS_WIN && !$hide_Cols) : ?>
                              <td><?php if (!FM_READONLY) : ?><a title="<?php echo 'Change Permissions' ?>" href="?p=<?php echo urlencode(FM_PATH) ?>&amp;chmod=<?php echo urlencode($f) ?>"><?php echo $perms ?></a><?php else : ?><?php echo $perms ?><?php endif; ?>
                              </td>
                              <td><?php echo fm_enc($owner['name'] . ':' . $group['name']) ?></td>
                         <?php endif; ?>
                         <td class="inline-actions">
                              <?php if (!FM_READONLY) : ?>
                                   <a title="<?php echo lng('Delete') ?>" href="?p=<?php echo urlencode(FM_PATH) ?>&amp;del=<?php echo urlencode($f) ?>" onclick="confirmDailog(event, 1209, '<?php echo lng('Delete') . ' ' . lng('File'); ?>','<?php echo urlencode($f); ?>', this.href);">
                                        <i class="fa fa-trash-o"></i></a>
                                   <a title="<?php echo lng('Rename') ?>" href="#" onclick="rename('<?php echo fm_enc(addslashes(FM_PATH)) ?>', '<?php echo fm_enc(addslashes($f)) ?>');return false;"><i class="fa fa-pencil-square-o"></i></a>
                                   <a title="<?php echo lng('CopyTo') ?>..." href="?p=<?php echo urlencode(FM_PATH) ?>&amp;copy=<?php echo urlencode(trim(FM_PATH . '/' . $f, '/')) ?>"><i class="fa fa-files-o"></i></a>
                              <?php endif; ?>
                              <a title="<?php echo lng('DirectLink') ?>" id="<?= $f ?>" data-path="<?php echo fm_enc(FM_ROOT_URL . (FM_PATH != '' ? '/' . FM_PATH : '') . '/' . copyToClipboard($f)) ?>" href="<?php echo fm_enc(FM_ROOT_URL . (FM_PATH != '' ? '/' . FM_PATH : '') . '/' . $f) ?>" target="_blank"><i class="fa fa-link"></i></a>

                              <a title="<?php echo lng('Download') ?>" href="?p=<?php echo urlencode(FM_PATH) ?>&amp;dl=<?php echo urlencode($f) ?>" onclick="confirmDailog(event, 1211, '<?php echo lng('Download'); ?>','<?php echo urlencode($f); ?>', this.href);"><i class="fa fa-download"></i></a>
                         </td>
                    </tr>
               <?php
                    flush();
                    $ik++;
               }

               if (empty($folders) && empty($files)) { ?>
                    <tfoot>
                         <tr><?php if (!FM_READONLY) : ?>
                                   <td></td><?php endif; ?>
                              <td colspan="<?php echo (!FM_IS_WIN && !$hide_Cols) ? '6' : '4' ?>">
                                   <em><?php echo lng('Folder is empty') ?></em>
                              </td>
                         </tr>
                    </tfoot>
               <?php
               } else { ?>
                    <tfoot>
                         <tr>
                              <td class="gray" colspan="<?php echo (!FM_IS_WIN && !$hide_Cols) ? (FM_READONLY ? '6' : '7') : (FM_READONLY ? '4' : '5') ?>">
                                   <?php echo lng('FullSize') . ': <span class="badge text-bg-light border-radius-0">' . fm_get_filesize($all_files_size) . '</span>' ?>
                                   <?php echo lng('File') . ': <span class="badge text-bg-light border-radius-0">' . $num_files . '</span>' ?>
                                   <?php echo lng('Folder') . ': <span class="badge text-bg-light border-radius-0">' . $num_folders . '</span>' ?>
                              </td>
                         </tr>
                    </tfoot>
               <?php } ?>
          </table>
     </div>

     <div class="row">
          <?php if (!FM_READONLY) : ?>
               <div class="col-xs-12 col-sm-9">
                    <ul class="list-inline footer-action">
                         <li class="list-inline-item"> <a href="#/select-all" class="btn btn-small btn-outline-primary btn-2" onclick="select_all();return false;"><i class="fa fa-check-square"></i>
                                   <?php echo lng('SelectAll') ?> </a></li>
                         <li class="list-inline-item"><a href="#/unselect-all" class="btn btn-small btn-outline-primary btn-2" onclick="unselect_all();return false;"><i class="fa fa-window-close"></i>
                                   <?php echo lng('UnSelectAll') ?> </a></li>
                         <li class="list-inline-item"><a href="#/invert-all" class="btn btn-small btn-outline-primary btn-2" onclick="invert_all();return false;"><i class="fa fa-th-list"></i>
                                   <?php echo lng('InvertSelection') ?> </a></li>
                         <li class="list-inline-item"><input type="submit" class="hidden" name="delete" id="a-delete" value="Delete" onclick="return confirm('<?php echo lng('Delete selected files and folders?'); ?>')">
                              <a href="javascript:document.getElementById('a-delete').click();" class="btn btn-small btn-outline-primary btn-2"><i class="fa fa-trash"></i>
                                   <?php echo lng('Delete') ?> </a>
                         </li>
                         <li class="list-inline-item"><input type="submit" class="hidden" name="zip" id="a-zip" value="zip" onclick="return confirm('<?php echo lng('Create archive?'); ?>')">
                              <a href="javascript:document.getElementById('a-zip').click();" class="btn btn-small btn-outline-primary btn-2"><i class="fa fa-file-archive-o"></i>
                                   <?php echo lng('Zip') ?> </a>
                         </li>
                         <li class="list-inline-item"><input type="submit" class="hidden" name="tar" id="a-tar" value="tar" onclick="return confirm('<?php echo lng('Create archive?'); ?>')">
                              <a href="javascript:document.getElementById('a-tar').click();" class="btn btn-small btn-outline-primary btn-2"><i class="fa fa-file-archive-o"></i>
                                   <?php echo lng('Tar') ?> </a>
                         </li>
                         <li class="list-inline-item"><input type="submit" class="hidden" name="copy" id="a-copy" value="Copy">
                              <a href="javascript:document.getElementById('a-copy').click();" class="btn btn-small btn-outline-primary btn-2"><i class="fa fa-files-o"></i>
                                   <?php echo lng('Copy') ?> </a>
                         </li>
                         <li class="list-inline-item">
                              <input type="submit" class="hidden" name="upload" id="a-upload" value="Upload">
                              <a class="btn btn-success btn-block w-100" href="?p=<?php echo urlencode(FM_PATH) ?>&amp;upload">
                                   <i class="fa fa-cloud-upload"></i>
                                   <?php echo lng('Upload') ?>
                              </a>

                         </li>
                    </ul>
               </div>
               <div class="col-3 d-none d-sm-block"><a href="#" target="_blank" class="float-right text-muted">TSCOVN FTP File
                         Manager <?php echo VERSION; ?></a></div>
          <?php else : ?>
               <div class="col-12"><a href="#" target="_blank" class="float-right text-muted">TSCOVN FTP File Manager
                         <?php echo VERSION; ?></a></div>
          <?php endif; ?>
     </div>
</form>

<?php
fm_show_footer();

// --- END HTML ---

// Functions

/**
 * It prints the css/js files into html
 * @param key The key of the external file to print.
 */
function print_external($key)
{
     global $external;

     if (!array_key_exists($key, $external)) {
          // throw new Exception('Key missing in external: ' . key);
          echo "<!-- EXTERNAL: MISSING KEY $key -->";
          return;
     }

     echo "$external[$key]";
}

/**
 * Verify CSRF TOKEN and remove after cerify
 * @param string $token
 * @return bool
 */
function verifyToken($token)
{
     if (hash_equals($_SESSION['token'], $token)) {
          return true;
     }
     return false;
}

/**
 * Delete  file or folder (recursively)
 * @param string $path
 * @return bool
 */
function fm_rdelete($path)
{
     if (is_link($path)) {
          return unlink($path);
     } elseif (is_dir($path)) {
          $objects = scandir($path);
          $ok = true;
          if (is_array($objects)) {
               foreach ($objects as $file) {
                    if ($file != '.' && $file != '..') {
                         if (!fm_rdelete($path . '/' . $file)) {
                              $ok = false;
                         }
                    }
               }
          }
          return ($ok) ? rmdir($path) : false;
     } elseif (is_file($path)) {
          return unlink($path);
     }
     return false;
}

/**
 * Recursive chmod
 * @param string $path
 * @param int $filemode
 * @param int $dirmode
 * @return bool
 * @todo Will use in mass chmod
 */
function fm_rchmod($path, $filemode, $dirmode)
{
     if (is_dir($path)) {
          if (!chmod($path, $dirmode)) {
               return false;
          }
          $objects = scandir($path);
          if (is_array($objects)) {
               foreach ($objects as $file) {
                    if ($file != '.' && $file != '..') {
                         if (!fm_rchmod($path . '/' . $file, $filemode, $dirmode)) {
                              return false;
                         }
                    }
               }
          }
          return true;
     } elseif (is_link($path)) {
          return true;
     } elseif (is_file($path)) {
          return chmod($path, $filemode);
     }
     return false;
}

/**
 * Check the file extension which is allowed or not
 * @param string $filename
 * @return bool
 */
function fm_is_valid_ext($filename)
{
     $allowed = (FM_FILE_EXTENSION) ? explode(',', FM_FILE_EXTENSION) : false;

     $ext = pathinfo($filename, PATHINFO_EXTENSION);
     $isFileAllowed = ($allowed) ? in_array($ext, $allowed) : true;

     return ($isFileAllowed) ? true : false;
}

/**
 * Safely rename
 * @param string $old
 * @param string $new
 * @return bool|null
 */
function fm_rename($old, $new)
{
     $isFileAllowed = fm_is_valid_ext($new);

     if (!is_dir($old)) {
          if (!$isFileAllowed) return false;
     }

     return (!file_exists($new) && file_exists($old)) ? rename($old, $new) : null;
}

/**
 * Copy file or folder (recursively).
 * @param string $path
 * @param string $dest
 * @param bool $upd Update files
 * @param bool $force Create folder with same names instead file
 * @return bool
 */
function fm_rcopy($path, $dest, $upd = true, $force = true)
{
     if (is_dir($path)) {
          if (!fm_mkdir($dest, $force)) {
               return false;
          }
          $objects = scandir($path);
          $ok = true;
          if (is_array($objects)) {
               foreach ($objects as $file) {
                    if ($file != '.' && $file != '..') {
                         if (!fm_rcopy($path . '/' . $file, $dest . '/' . $file)) {
                              $ok = false;
                         }
                    }
               }
          }
          return $ok;
     } elseif (is_file($path)) {
          return fm_copy($path, $dest, $upd);
     }
     return false;
}

/**
 * Safely create folder
 * @param string $dir
 * @param bool $force
 * @return bool
 */
function fm_mkdir($dir, $force)
{
     if (file_exists($dir)) {
          if (is_dir($dir)) {
               return $dir;
          } elseif (!$force) {
               return false;
          }
          unlink($dir);
     }
     return mkdir($dir, 0777, true);
}

/**
 * Safely copy file
 * @param string $f1
 * @param string $f2
 * @param bool $upd Indicates if file should be updated with new content
 * @return bool
 */
function fm_copy($f1, $f2, $upd)
{
     $time1 = filemtime($f1);
     if (file_exists($f2)) {
          $time2 = filemtime($f2);
          if ($time2 >= $time1 && $upd) {
               return false;
          }
     }
     $ok = copy($f1, $f2);
     if ($ok) {
          touch($f2, $time1);
     }
     return $ok;
}

/**
 * Get mime type
 * @param string $file_path
 * @return mixed|string
 */
function fm_get_mime_type($file_path)
{
     if (function_exists('finfo_open')) {
          $finfo = finfo_open(FILEINFO_MIME_TYPE);
          $mime = finfo_file($finfo, $file_path);
          finfo_close($finfo);
          return $mime;
     } elseif (function_exists('mime_content_type')) {
          return mime_content_type($file_path);
     } elseif (!stristr(ini_get('disable_functions'), 'shell_exec')) {
          $file = escapeshellarg($file_path);
          $mime = shell_exec('file -bi ' . $file);
          return $mime;
     } else {
          return '--';
     }
}

/**
 * HTTP Redirect
 * @param string $url
 * @param int $code
 */
function fm_redirect($url, $code = 302)
{
     header('Location: ' . $url, true, $code);
     exit;
}

/**
 * Path traversal prevention and clean the url
 * It replaces (consecutive) occurrences of / and \\ with whatever is in DIRECTORY_SEPARATOR, and processes /. and /.. fine.
 * @param $path
 * @return string
 */
function get_absolute_path($path)
{
     $path = str_replace(array('/', '\\'), DIRECTORY_SEPARATOR, $path);
     $parts = array_filter(explode(DIRECTORY_SEPARATOR, $path), 'strlen');
     $absolutes = array();
     foreach ($parts as $part) {
          if ('.' == $part) continue;
          if ('..' == $part) {
               array_pop($absolutes);
          } else {
               $absolutes[] = $part;
          }
     }
     return implode(DIRECTORY_SEPARATOR, $absolutes);
}

/**
 * Clean path
 * @param string $path
 * @return string
 */
function fm_clean_path($path, $trim = true)
{
     $path = $trim ? trim($path) : $path;
     $path = trim($path, '\\/');
     $path = str_replace(array('../', '..\\'), '', $path);
     $path =  get_absolute_path($path);
     if ($path == '..') {
          $path = '';
     }
     return str_replace('\\', '/', $path);
}

/**
 * Get parent path
 * @param string $path
 * @return bool|string
 */
function fm_get_parent_path($path)
{
     $path = fm_clean_path($path);
     if ($path != '') {
          $array = explode('/', $path);
          if (count($array) > 1) {
               $array = array_slice($array, 0, -1);
               return implode('/', $array);
          }
          return '';
     }
     return false;
}

function fm_get_display_path($file_path)
{
     global $path_display_mode, $root_path, $root_url;
     switch ($path_display_mode) {
          case 'relative':
               return array(
                    'label' => 'Path',
                    'path' => fm_enc(fm_convert_win(str_replace($root_path, '', $file_path)))
               );
          case 'host':
               $relative_path = str_replace($root_path, '', $file_path);
               return array(
                    'label' => 'Host Path',
                    'path' => fm_enc(fm_convert_win('/' . $root_url . '/' . ltrim(str_replace('\\', '/', $relative_path), '/')))
               );
          case 'full':
          default:
               return array(
                    'label' => 'Full Path',
                    'path' => fm_enc(fm_convert_win($file_path))
               );
     }
}

/**
 * Check file is in exclude list
 * @param string $file
 * @return bool
 */
function fm_is_exclude_items($file)
{
     $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
     if (isset($exclude_items) and sizeof($exclude_items)) {
          unset($exclude_items);
     }

     $exclude_items = FM_EXCLUDE_ITEMS;
     if (version_compare(PHP_VERSION, '7.0.0', '<')) {
          $exclude_items = unserialize($exclude_items);
     }
     if (!in_array($file, $exclude_items) && !in_array("*.$ext", $exclude_items)) {
          return true;
     }
     return false;
}

/**
 * get language translations from json file
 * @param int $tr
 * @return array
 */
function fm_get_translations($tr)
{
     try {
          $content = @file_get_contents('translation.json');
          if ($content !== FALSE) {
               $lng = json_decode($content, TRUE);
               global $lang_list;
               foreach ($lng["language"] as $key => $value) {
                    $code = $value["code"];
                    $lang_list[$code] = $value["name"];
                    if ($tr)
                         $tr[$code] = $value["translation"];
               }
               return $tr;
          }
     } catch (Exception $e) {
          echo $e;
     }
}

/**
 * @param string $file
 * Recover all file sizes larger than > 2GB.
 * Works on php 32bits and 64bits and supports linux
 * @return int|string
 */
function fm_get_size($file)
{
     static $iswin;
     static $isdarwin;
     if (!isset($iswin)) {
          $iswin = (strtoupper(substr(PHP_OS, 0, 3)) == 'WIN');
     }
     if (!isset($isdarwin)) {
          $isdarwin = (strtoupper(substr(PHP_OS, 0)) == "DARWIN");
     }

     static $exec_works;
     if (!isset($exec_works)) {
          $exec_works = (function_exists('exec') && !ini_get('safe_mode') && @exec('echo EXEC') == 'EXEC');
     }

     // try a shell command
     if ($exec_works) {
          $arg = escapeshellarg($file);
          $cmd = ($iswin) ? "for %F in (\"$file\") do @echo %~zF" : ($isdarwin ? "stat -f%z $arg" : "stat -c%s $arg");
          @exec($cmd, $output);
          if (is_array($output) && ctype_digit($size = trim(implode("\n", $output)))) {
               return $size;
          }
     }

     // try the Windows COM interface
     if ($iswin && class_exists("COM")) {
          try {
               $fsobj = new COM('Scripting.FileSystemObject');
               $f = $fsobj->GetFile(realpath($file));
               $size = $f->Size;
          } catch (Exception $e) {
               $size = null;
          }
          if (ctype_digit($size)) {
               return $size;
          }
     }

     // if all else fails
     return filesize($file);
}

/**
 * Get nice filesize
 * @param int $size
 * @return string
 */
function fm_get_filesize($size)
{
     $size = (float) $size;
     $units = array('B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');
     $power = ($size > 0) ? floor(log($size, 1024)) : 0;
     $power = ($power > (count($units) - 1)) ? (count($units) - 1) : $power;
     return sprintf('%s %s', round($size / pow(1024, $power), 2), $units[$power]);
}

/**
 * Get total size of directory tree.
 *
 * @param  string $directory Relative or absolute directory name.
 * @return int Total number of bytes.
 */
function fm_get_directorysize($directory)
{
     $bytes = 0;
     $directory = realpath($directory);
     if ($directory !== false && $directory != '' && file_exists($directory)) {
          foreach (new RecursiveIteratorIterator(new RecursiveDirectoryIterator($directory, FilesystemIterator::SKIP_DOTS)) as $file) {
               $bytes += $file->getSize();
          }
     }
     return $bytes;
}

/**
 * Get info about zip archive
 * @param string $path
 * @return array|bool
 */
function fm_get_zif_info($path, $ext)
{
     if ($ext == 'zip' && function_exists('zip_open')) {
          $arch = @zip_open($path);
          if ($arch) {
               $filenames = array();
               while ($zip_entry = @zip_read($arch)) {
                    $zip_name = @zip_entry_name($zip_entry);
                    $zip_folder = substr($zip_name, -1) == '/';
                    $filenames[] = array(
                         'name' => $zip_name,
                         'filesize' => @zip_entry_filesize($zip_entry),
                         'compressed_size' => @zip_entry_compressedsize($zip_entry),
                         'folder' => $zip_folder
                         //'compression_method' => zip_entry_compressionmethod($zip_entry),
                    );
               }
               @zip_close($arch);
               return $filenames;
          }
     } elseif ($ext == 'tar' && class_exists('PharData')) {
          $archive = new PharData($path);
          $filenames = array();
          foreach (new RecursiveIteratorIterator($archive) as $file) {
               $parent_info = $file->getPathInfo();
               $zip_name = str_replace("phar://" . $path, '', $file->getPathName());
               $zip_name = substr($zip_name, ($pos = strpos($zip_name, '/')) !== false ? $pos + 1 : 0);
               $zip_folder = $parent_info->getFileName();
               $zip_info = new SplFileInfo($file);
               $filenames[] = array(
                    'name' => $zip_name,
                    'filesize' => $zip_info->getSize(),
                    'compressed_size' => $file->getCompressedSize(),
                    'folder' => $zip_folder
               );
          }
          return $filenames;
     }
     return false;
}

/**
 * Encode html entities
 * @param string $text
 * @return string
 */
function fm_enc($text)
{
     return htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
}

/**
 * Prevent XSS attacks
 * @param string $text
 * @return string
 */
function fm_isvalid_filename($text)
{
     return (strpbrk($text, '/?%*:|"<>') === FALSE) ? true : false;
}

/**
 * Save message in session
 * @param string $msg
 * @param string $status
 */
function fm_set_msg($msg, $status = 'ok')
{
     $_SESSION[FM_SESSION_ID]['message'] = $msg;
     $_SESSION[FM_SESSION_ID]['status'] = $status;
}

/**
 * Check if string is in UTF-8
 * @param string $string
 * @return int
 */
function fm_is_utf8($string)
{
     return preg_match('//u', $string);
}

/**
 * Convert file name to UTF-8 in Windows
 * @param string $filename
 * @return string
 */
function fm_convert_win($filename)
{
     if (FM_IS_WIN && function_exists('iconv')) {
          $filename = iconv(FM_ICONV_INPUT_ENC, 'UTF-8//IGNORE', $filename);
     }
     return $filename;
}

/**
 * @param $obj
 * @return array
 */
function fm_object_to_array($obj)
{
     if (!is_object($obj) && !is_array($obj)) {
          return $obj;
     }
     if (is_object($obj)) {
          $obj = get_object_vars($obj);
     }
     return array_map('fm_object_to_array', $obj);
}

/**
 * Get CSS classname for file
 * @param string $path
 * @return string
 */
function fm_get_file_icon_class($path)
{
     // get extension
     $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));

     switch ($ext) {
          case 'ico':
          case 'gif':
          case 'jpg':
          case 'jpeg':
          case 'jpc':
          case 'jp2':
          case 'jpx':
          case 'xbm':
          case 'wbmp':
          case 'png':
          case 'bmp':
          case 'tif':
          case 'tiff':
          case 'webp':
          case 'avif':
          case 'svg':
               $img = 'fa fa-picture-o';
               break;
          case 'passwd':
          case 'ftpquota':
          case 'sql':
          case 'js':
          case 'ts':
          case 'jsx':
          case 'tsx':
          case 'hbs':
          case 'json':
          case 'sh':
          case 'config':
          case 'twig':
          case 'tpl':
          case 'md':
          case 'gitignore':
          case 'c':
          case 'cpp':
          case 'cs':
          case 'py':
          case 'rs':
          case 'map':
          case 'lock':
          case 'dtd':
               $img = 'fa fa-file-code-o';
               break;
          case 'txt':
          case 'ini':
          case 'conf':
          case 'log':
          case 'htaccess':
          case 'yaml':
          case 'yml':
          case 'toml':
          case 'tmp':
          case 'top':
          case 'bot':
          case 'dat':
          case 'bak':
          case 'htpasswd':
          case 'pl':
               $img = 'fa fa-file-text-o';
               break;
          case 'css':
          case 'less':
          case 'sass':
          case 'scss':
               $img = 'fa fa-css3';
               break;
          case 'bz2':
          case 'zip':
          case 'rar':
          case 'gz':
          case 'tar':
          case '7z':
          case 'xz':
               $img = 'fa fa-file-archive-o';
               break;
          case 'php':
          case 'php4':
          case 'php5':
          case 'phps':
          case 'phtml':
               $img = 'fa fa-code';
               break;
          case 'htm':
          case 'html':
          case 'shtml':
          case 'xhtml':
               $img = 'fa fa-html5';
               break;
          case 'xml':
          case 'xsl':
               $img = 'fa fa-file-excel-o';
               break;
          case 'wav':
          case 'mp3':
          case 'mp2':
          case 'm4a':
          case 'aac':
          case 'ogg':
          case 'oga':
          case 'wma':
          case 'mka':
          case 'flac':
          case 'ac3':
          case 'tds':
               $img = 'fa fa-music';
               break;
          case 'm3u':
          case 'm3u8':
          case 'pls':
          case 'cue':
          case 'xspf':
               $img = 'fa fa-headphones';
               break;
          case 'avi':
          case 'mpg':
          case 'mpeg':
          case 'mp4':
          case 'm4v':
          case 'flv':
          case 'f4v':
          case 'ogm':
          case 'ogv':
          case 'mov':
          case 'mkv':
          case '3gp':
          case 'asf':
          case 'wmv':
          case 'webm':
               $img = 'fa fa-file-video-o';
               break;
          case 'eml':
          case 'msg':
               $img = 'fa fa-envelope-o';
               break;
          case 'xls':
          case 'xlsx':
          case 'ods':
               $img = 'fa fa-file-excel-o';
               break;
          case 'csv':
               $img = 'fa fa-file-text-o';
               break;
          case 'bak':
          case 'swp':
               $img = 'fa fa-clipboard';
               break;
          case 'doc':
          case 'docx':
          case 'odt':
               $img = 'fa fa-file-word-o';
               break;
          case 'ppt':
          case 'pptx':
               $img = 'fa fa-file-powerpoint-o';
               break;
          case 'ttf':
          case 'ttc':
          case 'otf':
          case 'woff':
          case 'woff2':
          case 'eot':
          case 'fon':
               $img = 'fa fa-font';
               break;
          case 'pdf':
               $img = 'fa fa-file-pdf-o';
               break;
          case 'psd':
          case 'ai':
          case 'eps':
          case 'fla':
          case 'swf':
               $img = 'fa fa-file-image-o';
               break;
          case 'exe':
          case 'msi':
               $img = 'fa fa-file-o';
               break;
          case 'bat':
               $img = 'fa fa-terminal';
               break;
          default:
               $img = 'fa fa-info-circle';
     }

     return $img;
}

/**
 * Get image files extensions
 * @return array
 */
function fm_get_image_exts()
{
     return array('ico', 'gif', 'jpg', 'jpeg', 'jpc', 'jp2', 'jpx', 'xbm', 'wbmp', 'png', 'bmp', 'tif', 'tiff', 'psd', 'svg', 'webp', 'avif');
}

/**
 * Get video files extensions
 * @return array
 */
function fm_get_video_exts()
{
     return array('avi', 'webm', 'wmv', 'mp4', 'm4v', 'ogm', 'ogv', 'mov', 'mkv');
}

/**
 * Get audio files extensions
 * @return array
 */
function fm_get_audio_exts()
{
     return array('wav', 'mp3', 'ogg', 'm4a');
}

/**
 * Get text file extensions
 * @return array
 */
function fm_get_text_exts()
{
     return array(
          'txt', 'css', 'ini', 'conf', 'log', 'htaccess', 'passwd', 'ftpquota', 'sql', 'js', 'ts', 'jsx', 'tsx', 'mjs', 'json', 'sh', 'config',
          'php', 'php4', 'php5', 'phps', 'phtml', 'htm', 'html', 'shtml', 'xhtml', 'xml', 'xsl', 'm3u', 'm3u8', 'pls', 'cue', 'bash', 'vue',
          'eml', 'msg', 'csv', 'bat', 'twig', 'tpl', 'md', 'gitignore', 'less', 'sass', 'scss', 'c', 'cpp', 'cs', 'py', 'go', 'zsh', 'swift',
          'map', 'lock', 'dtd', 'svg', 'asp', 'aspx', 'asx', 'asmx', 'ashx', 'jsp', 'jspx', 'cgi', 'dockerfile', 'ruby', 'yml', 'yaml', 'toml',
          'vhost', 'scpt', 'applescript', 'csx', 'cshtml', 'c++', 'coffee', 'cfm', 'rb', 'graphql', 'mustache', 'jinja', 'http', 'handlebars',
          'java', 'es', 'es6', 'markdown', 'wiki', 'tmp', 'top', 'bot', 'dat', 'bak', 'htpasswd', 'pl'
     );
}

/**
 * Get mime types of text files
 * @return array
 */
function fm_get_text_mimes()
{
     return array(
          'application/xml',
          'application/javascript',
          'application/x-javascript',
          'image/svg+xml',
          'message/rfc822',
          'application/json',
     );
}

/**
 * Get file names of text files w/o extensions
 * @return array
 */
function fm_get_text_names()
{
     return array(
          'license',
          'readme',
          'authors',
          'contributors',
          'changelog',
     );
}

/**
 * Get online docs viewer supported files extensions
 * @return array
 */
function fm_get_onlineViewer_exts()
{
     return array('doc', 'docx', 'xls', 'xlsx', 'pdf', 'ppt', 'pptx', 'ai', 'psd', 'dxf', 'xps', 'rar', 'odt', 'ods');
}

/**
 * It returns the mime type of a file based on its extension.
 * @param extension The file extension of the file you want to get the mime type for.
 * @return string|string[] The mime type of the file.
 */
function fm_get_file_mimes($extension)
{
     $fileTypes['swf'] = 'application/x-shockwave-flash';
     $fileTypes['pdf'] = 'application/pdf';
     $fileTypes['exe'] = 'application/octet-stream';
     $fileTypes['zip'] = 'application/zip';
     $fileTypes['doc'] = 'application/msword';
     $fileTypes['xls'] = 'application/vnd.ms-excel';
     $fileTypes['ppt'] = 'application/vnd.ms-powerpoint';
     $fileTypes['gif'] = 'image/gif';
     $fileTypes['png'] = 'image/png';
     $fileTypes['jpeg'] = 'image/jpg';
     $fileTypes['jpg'] = 'image/jpg';
     $fileTypes['webp'] = 'image/webp';
     $fileTypes['avif'] = 'image/avif';
     $fileTypes['rar'] = 'application/rar';

     $fileTypes['ra'] = 'audio/x-pn-realaudio';
     $fileTypes['ram'] = 'audio/x-pn-realaudio';
     $fileTypes['ogg'] = 'audio/x-pn-realaudio';

     $fileTypes['wav'] = 'video/x-msvideo';
     $fileTypes['wmv'] = 'video/x-msvideo';
     $fileTypes['avi'] = 'video/x-msvideo';
     $fileTypes['asf'] = 'video/x-msvideo';
     $fileTypes['divx'] = 'video/x-msvideo';

     $fileTypes['mp3'] = 'audio/mpeg';
     $fileTypes['mp4'] = 'audio/mpeg';
     $fileTypes['mpeg'] = 'video/mpeg';
     $fileTypes['mpg'] = 'video/mpeg';
     $fileTypes['mpe'] = 'video/mpeg';
     $fileTypes['mov'] = 'video/quicktime';
     $fileTypes['swf'] = 'video/quicktime';
     $fileTypes['3gp'] = 'video/quicktime';
     $fileTypes['m4a'] = 'video/quicktime';
     $fileTypes['aac'] = 'video/quicktime';
     $fileTypes['m3u'] = 'video/quicktime';

     $fileTypes['php'] = ['application/x-php'];
     $fileTypes['html'] = ['text/html'];
     $fileTypes['txt'] = ['text/plain'];
     //Unknown mime-types should be 'application/octet-stream'
     if (empty($fileTypes[$extension])) {
          $fileTypes[$extension] = ['application/octet-stream'];
     }
     return $fileTypes[$extension];
}

/**
 * This function scans the files and folder recursively, and return matching files
 * @param string $dir
 * @param string $filter
 * @return array|null
 */
function scan($dir = '', $filter = '')
{
     $path = FM_ROOT_PATH . '/' . $dir;
     if ($path) {
          $ite = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path));
          $rii = new RegexIterator($ite, "/(" . $filter . ")/i");

          $files = array();
          foreach ($rii as $file) {
               if (!$file->isDir()) {
                    $fileName = $file->getFilename();
                    $location = str_replace(FM_ROOT_PATH, '', $file->getPath());
                    $files[] = array(
                         "name" => $fileName,
                         "type" => "file",
                         "path" => $location,
                    );
               }
          }
          return $files;
     }
}

/**
 * Parameters: downloadFile(File Location, File Name,
 * max speed, is streaming
 * If streaming - videos will show as videos, images as images
 * instead of download prompt
 * https://stackoverflow.com/a/13821992/1164642
 */
function fm_download_file($fileLocation, $fileName, $chunkSize  = 1024)
{
     insertTracking("Download File", $fileLocation, $fileName, $_SESSION[FM_SESSION_ID]['logged']);
     if (connection_status() != 0)
          return (false);
     $extension = pathinfo($fileName, PATHINFO_EXTENSION);

     $contentType = fm_get_file_mimes($extension);

     if (is_array($contentType)) {
          $contentType = implode(' ', $contentType);
     }

     $size = filesize($fileLocation);

     if ($size == 0) {
          fm_set_msg(lng('Zero byte file! Aborting download'), 'error');
          $FM_PATH = FM_PATH;
          fm_redirect(FM_SELF_URL . '?p=' . urlencode($FM_PATH));

          return (false);
     }

     @ini_set('magic_quotes_runtime', 0);
     $fp = fopen("$fileLocation", "rb");

     if ($fp === false) {
          fm_set_msg(lng('Cannot open file! Aborting download'), 'error');
          $FM_PATH = FM_PATH;
          fm_redirect(FM_SELF_URL . '?p=' . urlencode($FM_PATH));
          return (false);
     }

     // headers
     header('Content-Description: File Transfer');
     header('Expires: 0');
     header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
     header('Pragma: public');
     header("Content-Transfer-Encoding: binary");
     header("Content-Type: $contentType");

     $contentDisposition = 'attachment';

     if (strstr($_SERVER['HTTP_USER_AGENT'], "MSIE")) {
          $fileName = preg_replace('/\./', '%2e', $fileName, substr_count($fileName, '.') - 1);
          header("Content-Disposition: $contentDisposition;filename=\"$fileName\"");
     } else {
          header("Content-Disposition: $contentDisposition;filename=\"$fileName\"");
     }

     header("Accept-Ranges: bytes");
     $range = 0;

     if (isset($_SERVER['HTTP_RANGE'])) {
          list($a, $range) = explode("=", $_SERVER['HTTP_RANGE']);
          str_replace($range, "-", $range);
          $size2 = $size - 1;
          $new_length = $size - $range;
          header("HTTP/1.1 206 Partial Content");
          header("Content-Length: $new_length");
          header("Content-Range: bytes $range$size2/$size");
     } else {
          $size2 = $size - 1;
          header("Content-Range: bytes 0-$size2/$size");
          header("Content-Length: " . $size);
     }
     $fileLocation = realpath($fileLocation);
     while (ob_get_level()) ob_end_clean();
     readfile($fileLocation);

     fclose($fp);

     return ((connection_status() == 0) and !connection_aborted());
}

/**
 * If the theme is dark, return the text-white and bg-dark classes.
 * @return string the value of the  variable.
 */
function fm_get_theme()
{
     $result = '';
     if (FM_THEME == "dark") {
          $result = "text-white bg-dark";
     }
     return $result;
}

/**
 * Class to work with zip files (using ZipArchive)
 */
class FM_Zipper
{
     private $zip;

     public function __construct()
     {
          $this->zip = new ZipArchive();
     }

     /**
      * Create archive with name $filename and files $files (RELATIVE PATHS!)
      * @param string $filename
      * @param array|string $files
      * @return bool
      */
     public function create($filename, $files)
     {
          $res = $this->zip->open($filename, ZipArchive::CREATE);
          if ($res !== true) {
               return false;
          }
          if (is_array($files)) {
               foreach ($files as $f) {
                    $f = fm_clean_path($f);
                    if (!$this->addFileOrDir($f)) {
                         $this->zip->close();
                         return false;
                    }
               }
               $this->zip->close();
               return true;
          } else {
               if ($this->addFileOrDir($files)) {
                    $this->zip->close();
                    return true;
               }
               return false;
          }
     }

     /**
      * Extract archive $filename to folder $path (RELATIVE OR ABSOLUTE PATHS)
      * @param string $filename
      * @param string $path
      * @return bool
      */
     public function unzip($filename, $path)
     {
          $res = $this->zip->open($filename);
          if ($res !== true) {
               return false;
          }
          if ($this->zip->extractTo($path)) {
               $this->zip->close();
               return true;
          }
          return false;
     }

     /**
      * Add file/folder to archive
      * @param string $filename
      * @return bool
      */
     private function addFileOrDir($filename)
     {
          if (is_file($filename)) {
               return $this->zip->addFile($filename);
          } elseif (is_dir($filename)) {
               return $this->addDir($filename);
          }
          return false;
     }

     /**
      * Add folder recursively
      * @param string $path
      * @return bool
      */
     private function addDir($path)
     {
          if (!$this->zip->addEmptyDir($path)) {
               return false;
          }
          $objects = scandir($path);
          if (is_array($objects)) {
               foreach ($objects as $file) {
                    if ($file != '.' && $file != '..') {
                         if (is_dir($path . '/' . $file)) {
                              if (!$this->addDir($path . '/' . $file)) {
                                   return false;
                              }
                         } elseif (is_file($path . '/' . $file)) {
                              if (!$this->zip->addFile($path . '/' . $file)) {
                                   return false;
                              }
                         }
                    }
               }
               return true;
          }
          return false;
     }
}

/**
 * Class to work with Tar files (using PharData)
 */
class FM_Zipper_Tar
{
     private $tar;

     public function __construct()
     {
          $this->tar = null;
     }

     /**
      * Create archive with name $filename and files $files (RELATIVE PATHS!)
      * @param string $filename
      * @param array|string $files
      * @return bool
      */
     public function create($filename, $files)
     {
          $this->tar = new PharData($filename);
          if (is_array($files)) {
               foreach ($files as $f) {
                    $f = fm_clean_path($f);
                    if (!$this->addFileOrDir($f)) {
                         return false;
                    }
               }
               return true;
          } else {
               if ($this->addFileOrDir($files)) {
                    return true;
               }
               return false;
          }
     }

     /**
      * Extract archive $filename to folder $path (RELATIVE OR ABSOLUTE PATHS)
      * @param string $filename
      * @param string $path
      * @return bool
      */
     public function unzip($filename, $path)
     {
          $res = $this->tar->open($filename);
          if ($res !== true) {
               return false;
          }
          if ($this->tar->extractTo($path)) {
               return true;
          }
          return false;
     }

     /**
      * Add file/folder to archive
      * @param string $filename
      * @return bool
      */
     private function addFileOrDir($filename)
     {
          if (is_file($filename)) {
               try {
                    $this->tar->addFile($filename);
                    return true;
               } catch (Exception $e) {
                    return false;
               }
          } elseif (is_dir($filename)) {
               return $this->addDir($filename);
          }
          return false;
     }

     /**
      * Add folder recursively
      * @param string $path
      * @return bool
      */
     private function addDir($path)
     {
          $objects = scandir($path);
          if (is_array($objects)) {
               foreach ($objects as $file) {
                    if ($file != '.' && $file != '..') {
                         if (is_dir($path . '/' . $file)) {
                              if (!$this->addDir($path . '/' . $file)) {
                                   return false;
                              }
                         } elseif (is_file($path . '/' . $file)) {
                              try {
                                   $this->tar->addFile($path . '/' . $file);
                              } catch (Exception $e) {
                                   return false;
                              }
                         }
                    }
               }
               return true;
          }
          return false;
     }
}

/**
 * Save Configuration
 */
class FM_Config
{
     var $data;

     function __construct()
     {
          global $root_path, $root_url, $CONFIG;
          $fm_url = $root_url . $_SERVER["PHP_SELF"];
          $this->data = array(
               'lang' => 'en',
               'error_reporting' => true,
               'show_hidden' => true
          );
          $data = false;
          if (strlen($CONFIG)) {
               $data = fm_object_to_array(json_decode($CONFIG));
          } else {
               $msg = 'TSCOVN FTP Manager<br>Error: Cannot load configuration <br> Lỗi gòi, Không load được file cài đặt.';
               if (substr($fm_url, -1) == '/') {
                    $fm_url = rtrim($fm_url, '/');
                    $msg .= '<br>';
                    $msg .= '<br>Seems like you have a trailing slash on the URL.';
                    $msg .= '<br>Try this link: <a href="' . $fm_url . '">' . $fm_url . '</a>';
               }
               die($msg);
          }
          if (is_array($data) && count($data)) $this->data = $data;
          else $this->save();
     }

     function save()
     {
          updateConfig($this->data['lang'], $this->data['theme'], $_SESSION[FM_SESSION_ID]['logged']);
          $fm_file = __FILE__;
          $var_name = '$CONFIG';
          $var_value = var_export(json_encode($this->data), true);
          $config_string = "<?php" . chr(13) . chr(10) . "//Default Configuration" . chr(13) . chr(10) . "$var_name = $var_value;" . chr(13) . chr(10);
          if (is_writable($fm_file)) {
               $lines = file($fm_file);
               if ($fh = @fopen($fm_file, "w")) {
                    @fputs($fh, $config_string, strlen($config_string));
                    for ($x = 3; $x < count($lines); $x++) {
                         @fputs($fh, $lines[$x], strlen($lines[$x]));
                    }
                    @fclose($fh);
               }
          }
     }
}

//--- Templates Functions ---

/**
 * Show nav block
 * @param string $path
 */
function fm_show_nav_path($path)
{
     global $lang, $sticky_navbar, $editFile;
     $isStickyNavBar = $sticky_navbar ? 'fixed-top' : '';
     $getTheme = fm_get_theme();
     $getTheme .= " navbar-light";
     if (FM_THEME == "dark") {
          $getTheme .= " navbar-dark";
     } else {
          $getTheme .= " bg-white";
     }
?>
     <nav class="navbar navbar-expand-lg <?php echo $getTheme; ?> mb-4 main-nav <?php echo $isStickyNavBar ?>">
          <a class="navbar-brand" href="?p="><?php echo lng('AppTitle') ?> </a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
               <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarSupportedContent">

               <?php
               $path = fm_clean_path($path);
               $root_url = "<a href='?p='><i class='fa fa-home' aria-hidden='true' title='" . FM_ROOT_PATH . "'></i></a>";
               $sep = '<i class="bread-crumb"> / </i>';
               if ($path != '') {
                    $exploded = explode('/', $path);
                    $count = count($exploded);
                    $array = array();
                    $parent = '';
                    for ($i = 0; $i < $count; $i++) {
                         $parent = trim($parent . '/' . $exploded[$i], '/');
                         $parent_enc = urlencode($parent);
                         $array[] = "<a href='?p={$parent_enc}'>" . fm_enc(fm_convert_win($exploded[$i])) . "</a>";
                    }
                    $root_url .= $sep . implode($sep, $array);
               }
               echo '<div class="col-xs-6 col-sm-5">' . $root_url . $editFile . '</div>';
               ?>

               <div class="col-xs-6 col-sm-7">
                    <ul class="navbar-nav justify-content-end <?php echo fm_get_theme();  ?>">
                         <li class="nav-item mr-2">
                              <div class="input-group input-group-sm mr-1" style="margin-top:4px;">
                                   <input type="text" class="form-control" placeholder="<?php echo lng('Search') ?>" aria-label="<?php echo lng('Search') ?>" aria-describedby="search-addon2" id="search-addon">
                                   <div class="input-group-append">
                                        <span class="input-group-text brl-0 brr-0" id="search-addon2"><i class="fa fa-search"></i></span>
                                   </div>
                                   <div class="input-group-append btn-group">
                                        <span class="input-group-text dropdown-toggle brl-0" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></span>
                                        <div class="dropdown-menu dropdown-menu-right">
                                             <a class="dropdown-item" href="<?php echo $path2 = $path ? $path : '.'; ?>" id="js-search-modal" data-bs-toggle="modal" data-bs-target="#searchModal"><?php echo lng('Advanced Search') ?></a>
                                        </div>
                                   </div>
                              </div>
                         </li>
                         <?php if (!FM_READONLY) : ?>
                              <li class="nav-item">
                                   <a title="<?php echo lng('Upload') ?>" class="nav-link" href="?p=<?php echo urlencode(FM_PATH) ?>&amp;upload"><i class="fa fa-cloud-upload" aria-hidden="true"></i> <?php echo lng('Upload') ?></a>
                              </li>
                              <li class="nav-item">
                                   <a title="<?php echo lng('NewItem') ?>" class="nav-link" href="#createNewItem" data-bs-toggle="modal" data-bs-target="#createNewItem"><i class="fa fa-plus-square"></i>
                                        <?php echo lng('NewItem') ?></a>
                              </li>
                         <?php endif; ?>
                         <?php if (FM_USE_AUTH) : ?>
                              <li class="nav-item avatar dropdown">
                                   <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink-5" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="fa fa-user-circle"></i>
                                        <?php if (isset($_SESSION[FM_SESSION_ID]['logged'])) {
                                             echo $_SESSION[FM_SESSION_ID]['logged'];
                                        } ?></a>
                                   <div class="dropdown-menu text-small shadow <?php echo fm_get_theme(); ?>" aria-labelledby="navbarDropdownMenuLink-5">
                                        <?php if (!FM_READONLY) : ?>
                                             <a title="<?php echo lng('Settings') ?>" class="dropdown-item nav-link khoangcach" href="?p=<?php echo urlencode(FM_PATH) ?>&amp;settings=1"><i class="fa fa-cog" aria-hidden="true"></i> <?php echo lng('Settings') ?></a>
                                        <?php endif ?>
                                        <a title="<?php echo lng('Help') ?>" class="dropdown-item nav-link khoangcach" href="?p=<?php echo urlencode(FM_PATH) ?>&amp;help=2"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> <?php echo lng('Help') ?></a>
                                        <a title="<?php echo lng('Logout') ?>" class="dropdown-item nav-link khoangcach" href="?logout=1"><i class="fa fa-sign-out" aria-hidden="true"></i>
                                             <?php echo lng('Logout') ?></a>
                                   </div>
                              </li>
                         <?php else : ?>
                              <?php if (!FM_READONLY) : ?>
                                   <li class="nav-item">
                                        <a title="<?php echo lng('Settings') ?>" class="dropdown-item nav-link khoangcach" href="?p=<?php echo urlencode(FM_PATH) ?>&amp;settings=1"><i class="fa fa-cog" aria-hidden="true"></i> <?php echo lng('Settings') ?></a>
                                   </li>
                              <?php endif; ?>
                         <?php endif; ?>
                    </ul>
               </div>
          </div>
     </nav>
<?php
}

/**
 * Show alert message from session
 */
function fm_show_message()
{
     if (isset($_SESSION[FM_SESSION_ID]['message'])) {
          $class = isset($_SESSION[FM_SESSION_ID]['status']) ? $_SESSION[FM_SESSION_ID]['status'] : 'ok';
          echo '<p class="message ' . $class . '">' . $_SESSION[FM_SESSION_ID]['message'] . '</p>';
          unset($_SESSION[FM_SESSION_ID]['message']);
          unset($_SESSION[FM_SESSION_ID]['status']);
     }
}

/**
 * Show page header in Login Form
 */
function fm_show_header_login()
{
     $sprites_ver = '20160315';
     header("Content-Type: text/html; charset=utf-8");
     header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
     header("Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0");
     header("Pragma: no-cache");

     global $lang, $root_url, $favicon_path;
?>
     <!DOCTYPE html>
     <html lang="en">

     <head>
          <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
          <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
          <meta name="title" content="TSCOVN FTP File Manager">
          <meta http-equiv="content-language" content="en" />
          <meta name="language" content="English">
          <meta name="description" content="TSCOVN FTP File Manager">
          <meta name="revisit-after" content="1 days">
          <meta name="author" content="Hung IT aka Hùng Đẹp Trai">
          <meta name="robots" content="noindex, nofollow">
          <meta name="googlebot" content="noindex">
          <meta name="keywords" content="TSCOVN, TSUCHIYA, TSCOFTP, TSCOVNFTP">
          <meta property="og:image" content="http://monitor.tscovn.com:9001/images/tsco.png" />
          <link href="https://fonts.cdnfonts.com/css/impact" rel="stylesheet">
          <?php if ($favicon_path) {
               echo '<link rel="icon" href="' . fm_enc($favicon_path) . '" type="image/png">';
          } ?>
          <title><?php echo fm_enc(APP_TITLE) ?></title>
          <?php print_external('pre-jsdelivr'); ?>
          <?php print_external('css-bootstrap'); ?>
          <link rel="stylesheet" href="./css/main.css">
     </head>

     <body class="fm-login-page <?php echo (FM_THEME == "dark") ? 'theme-dark' : ''; ?>">
          <div id="wrapper" class="container-fluid">

          <?php
     }

     /**
      * Show page footer in Login Form
      */
     function fm_show_footer_login()
     {
          ?>
          </div>
          <?php print_external('js-jquery'); ?>
          <?php print_external('js-bootstrap'); ?>
     </body>

     </html>
<?php
     }

     /**
      * Show Header after login
      */
     function fm_show_header()
     {
          $sprites_ver = '20231031';
          header("Content-Type: text/html; charset=utf-8");
          header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
          header("Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0");
          header("Pragma: no-cache");
          global $lang, $root_url, $sticky_navbar, $favicon_path;
          $isStickyNavBar = $sticky_navbar ? 'navbar-fixed' : 'navbar-normal';
?>
     <!DOCTYPE html>
     <html>

     <head>
          <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
          <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
          <meta name="title" content="TSCOVN FTP File Manager">
          <meta http-equiv="content-language" content="en" />
          <meta name="language" content="English">
          <meta name="description" content="TSCOVN FTP File Manager">
          <meta name="revisit-after" content="1 days">
          <meta name="author" content="Hung IT aka Hùng Đẹp Trai">
          <meta name="robots" content="noindex, nofollow">
          <meta name="googlebot" content="noindex">
          <meta name="keywords" content="TSCOVN, TSUCHIYA, TSCOFTP, TSCOVNFTP">
          <meta property="og:image" content="http://monitor.tscovn.com:9001/images/tsco.png" />
          <?php if ($favicon_path) {
               echo '<link rel="icon" href="' . fm_enc($favicon_path) . '" type="image/png">';
          } ?>
          <title><?php echo fm_enc(APP_TITLE) ?></title>
          <?php print_external('pre-jsdelivr'); ?>
          <?php print_external('pre-cloudflare'); ?>
          <?php print_external('css-bootstrap'); ?>
          <?php print_external('css-font-awesome'); ?>
          <?php if (FM_USE_HIGHLIGHTJS && isset($_GET['view'])) : ?>
               <?php print_external('css-highlightjs'); ?>
          <?php endif; ?>
          <script type="text/javascript">
               window.csrf = '<?php echo $_SESSION['token']; ?>';
          </script>

          <link rel="stylesheet" href="./css/light.css">

          <?php
          if (FM_THEME == "dark") : ?>
               <link rel="stylesheet" href="./css/dark.css">

          <?php endif; ?>
     </head>

     <body class="<?php echo (FM_THEME == "dark") ? 'theme-dark' : ''; ?> <?php echo $isStickyNavBar; ?>">
          <div id="wrapper" class="container-fluid">
               <!-- New Item creation -->
               <div class="modal fade" id="createNewItem" tabindex="-1" role="dialog" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="newItemModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                         <form class="modal-content <?php echo fm_get_theme(); ?>" method="post">
                              <div class="modal-header">
                                   <h5 class="modal-title" id="newItemModalLabel"><i class="fa fa-plus-square fa-fw"></i><?php echo lng('CreateNewItem') ?></h5>
                                   <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                              </div>
                              <div class="modal-body">
                                   <p><label for="newfile"><?php echo lng('ItemType') ?> </label></p>
                                   <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="newfile" id="customRadioInline1" name="newfile" value="file">
                                        <label class="form-check-label" for="customRadioInline1"><?php echo lng('File') ?></label>
                                   </div>
                                   <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="newfile" id="customRadioInline2" value="folder" checked>
                                        <label class="form-check-label" for="customRadioInline2"><?php echo lng('Folder') ?></label>
                                   </div>

                                   <p class="mt-3"><label for="newfilename"><?php echo lng('ItemName') ?> </label></p>
                                   <input type="text" name="newfilename" id="newfilename" value="" class="form-control" placeholder="<?php echo lng('Enter here...') ?>" required>
                              </div>
                              <div class="modal-footer">
                                   <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">
                                   <button type="button" class="btn btn-outline-primary" data-bs-dismiss="modal"><i class="fa fa-times-circle"></i> <?php echo lng('Cancel') ?></button>
                                   <button type="submit" class="btn btn-success"><i class="fa fa-check-circle"></i>
                                        <?php echo lng('CreateNow') ?></button>
                              </div>
                         </form>
                    </div>
               </div>

               <!-- Advance Search Modal -->
               <div class="modal fade" id="searchModal" tabindex="-1" role="dialog" aria-labelledby="searchModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                         <div class="modal-content <?php echo fm_get_theme(); ?>">
                              <div class="modal-header">
                                   <h5 class="modal-title col-10" id="searchModalLabel">
                                        <div class="input-group mb-3">
                                             <input type="text" class="form-control" placeholder="<?php echo lng('Search') ?> <?php echo lng('a files') ?>" aria-label="<?php echo lng('Search') ?>" aria-describedby="search-addon3" id="advanced-search" autofocus required>
                                             <span class="input-group-text" id="search-addon3"><i class="fa fa-search"></i></span>
                                        </div>
                                   </h5>
                                   <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                              </div>
                              <div class="modal-body">
                                   <form action="" method="post">
                                        <div class="lds-facebook">
                                             <div></div>
                                             <div></div>
                                             <div></div>
                                        </div>
                                        <ul id="search-wrapper">
                                             <p class="m-2"><?php echo lng('Search file in folder and subfolders...') ?></p>
                                        </ul>
                                   </form>
                              </div>
                         </div>
                    </div>
               </div>

               <!--Rename Modal -->
               <div class="modal modal-alert" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" id="renameDailog">
                    <div class="modal-dialog" role="document">
                         <form class="modal-content rounded-3 shadow <?php echo fm_get_theme(); ?>" method="post" autocomplete="off">
                              <div class="modal-body p-4 text-center">
                                   <h5 class="mb-3"><?php echo lng('Are you sure want to') ?> <?= lng('Rename') ?>?</h5>
                                   <p class="mb-1">
                                        <input type="text" name="rename_to" id="js-rename-to" class="form-control" placeholder="<?php echo lng('Enter new file name') ?>" required>
                                        <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">
                                        <input type="hidden" name="rename_from" id="js-rename-from">
                                   </p>
                              </div>
                              <div class="modal-footer flex-nowrap p-0">
                                   <button type="button" class="btn btn-lg btn-link fs-6 text-decoration-none col-6 m-0 rounded-0 border-end" data-bs-dismiss="modal"><?php echo lng('Cancel') ?></button>
                                   <button type="submit" class="btn btn-lg btn-link fs-6 text-decoration-none col-6 m-0 rounded-0"><strong><?php echo lng('Okay') ?></strong></button>
                              </div>
                         </form>
                    </div>
               </div>

               <!-- Confirm Modal -->
               <script type="text/html" id="js-tpl-confirm">
                    <div class="modal modal-alert confirmDailog" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" id="confirmDailog-<%this.id%>">
                         <div class="modal-dialog" role="document">
                              <form class="modal-content rounded-3 shadow <?php echo fm_get_theme(); ?>" method="post" autocomplete="off" action="<%this.action%>">
                                   <div class="modal-body p-4 text-center">
                                        <h5 class="mb-2"><?php echo lng('Are you sure want to') ?> <%this.title%> ?</h5>
                                        <p class="mb-1"><%this.content%></p>
                                   </div>
                                   <div class="modal-footer flex-nowrap p-0">
                                        <button type="button" class="btn btn-lg btn-link fs-6 text-decoration-none col-6 m-0 rounded-0 border-end" data-bs-dismiss="modal"><?php echo lng('Cancel') ?></button>
                                        <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">
                                        <button type="submit" class="btn btn-lg btn-link fs-6 text-decoration-none col-6 m-0 rounded-0" data-bs-dismiss="modal"><strong><?php echo lng('Okay') ?></strong></button>
                                   </div>
                              </form>
                         </div>
                    </div>
               </script>

          <?php
     }

     /**
      * Show page footer after login
      */
     function fm_show_footer()
     {
          ?>
          </div>
          <?php print_external('js-jquery'); ?>
          <?php print_external('js-bootstrap'); ?>
          <?php print_external('js-jquery-datatables'); ?>
          <?php if (FM_USE_HIGHLIGHTJS && isset($_GET['view'])) : ?>
               <?php print_external('js-highlightjs'); ?>
               <script>
                    hljs.highlightAll();
                    var isHighlightingEnabled = true;
               </script>
          <?php endif; ?>
          <script src="./js/main.js"></script>
          <?php if (isset($_GET['edit']) && isset($_GET['env']) && FM_EDIT_FILE && !FM_READONLY) :

               $ext = pathinfo($_GET["edit"], PATHINFO_EXTENSION);
               $ext =  $ext == "js" ? "javascript" :  $ext;
          ?>
               <?php print_external('js-ace'); ?>
               <script src="./js/skin.js"></script>
          <?php endif; ?>
          <div id="snackbar"></div>
     </body>

     </html>
<?php
     }

     /**
      * Language Translation System
      * @param string $txt
      * @return string
      */
     function lng($txt)
     {
          global $lang;

          // English Language
          $tr['en']['AppName']        = 'TSCOVN Ftp File Manager';
          $tr['en']['AppTitle']           = 'TSCOVN File Manager';
          $tr['en']['Login']          = 'Sign in';
          $tr['en']['Username']           = 'Username';
          $tr['en']['Password']       = 'Password';
          $tr['en']['Logout']             = 'Sign Out';
          $tr['en']['Move']           = 'Move';
          $tr['en']['Copy']               = 'Copy';
          $tr['en']['Save']           = 'Save';
          $tr['en']['SelectAll']          = 'Select all';
          $tr['en']['UnSelectAll']    = 'Unselect all';
          $tr['en']['File']               = 'File';
          $tr['en']['Back']           = 'Back';
          $tr['en']['Size']               = 'Size';
          $tr['en']['Perms']          = 'Perms';
          $tr['en']['Modified']           = 'Modified';
          $tr['en']['Owner']          = 'Owner';
          $tr['en']['Search']             = 'Search';
          $tr['en']['NewItem']        = 'New Item';
          $tr['en']['Folder']             = 'Folder';
          $tr['en']['Delete']         = 'Delete';
          $tr['en']['Rename']             = 'Rename';
          $tr['en']['CopyTo']         = 'Copy to';
          $tr['en']['DirectLink']         = 'Direct link';
          $tr['en']['UploadingFiles'] = 'Upload Files';
          $tr['en']['ChangePermissions']  = 'Change Permissions';
          $tr['en']['Copying']        = 'Copying';
          $tr['en']['CreateNewItem']      = 'Create New Item';
          $tr['en']['Name']           = 'Name';
          $tr['en']['AdvancedEditor']     = 'Advanced Editor';
          $tr['en']['Actions']        = 'Actions';
          $tr['en']['Folder is empty']    = 'Folder is empty';
          $tr['en']['Upload']         = 'Upload';
          $tr['en']['Cancel']             = 'Cancel';
          $tr['en']['InvertSelection'] = 'Invert Selection';
          $tr['en']['DestinationFolder']  = 'Destination Folder';
          $tr['en']['ItemType']       = 'Item Type';
          $tr['en']['ItemName']           = 'Item Name';
          $tr['en']['CreateNow']      = 'Create Now';
          $tr['en']['Download']           = 'Download';
          $tr['en']['Open']           = 'Open';
          $tr['en']['UnZip']              = 'UnZip';
          $tr['en']['UnZipToFolder']  = 'UnZip to folder';
          $tr['en']['Edit']               = 'Edit';
          $tr['en']['NormalEditor']   = 'Normal Editor';
          $tr['en']['BackUp']             = 'Back Up';
          $tr['en']['SourceFolder']   = 'Source Folder';
          $tr['en']['Files']              = 'Files';
          $tr['en']['Move']           = 'Move';
          $tr['en']['Change']             = 'Change';
          $tr['en']['Settings']       = 'Settings';
          $tr['en']['Language']           = 'Language';
          $tr['en']['ErrorReporting'] = 'Error Reporting';
          $tr['en']['ShowHiddenFiles']    = 'Show Hidden Files';
          $tr['en']['Help']           = 'Help';
          $tr['en']['Created']            = 'Created';
          $tr['en']['Help Documents'] = 'Help Documents';
          $tr['en']['Report Issue']       = 'Report Issue';
          $tr['en']['Generate']       = 'Generate';
          $tr['en']['FullSize']           = 'Full Size';
          $tr['en']['HideColumns']    = 'Hide Perms/Owner columns';
          $tr['en']['You are logged in'] = 'You are logged in';
          $tr['en']['Are you sure want to'] = 'Are you sure want to';
          $tr['en']['Nothing selected']   = 'Nothing selected';
          $tr['en']['Paths must be not equal']    = 'Paths must be not equal';
          $tr['en']['Renamed from']       = 'Renamed from';
          $tr['en']['Archive not unpacked']       = 'Archive not unpacked';
          $tr['en']['Deleted']            = 'Deleted';
          $tr['en']['Archive not created']        = 'Archive not created';
          $tr['en']['Copied from']        = 'Copied from';
          $tr['en']['Permissions changed']        = 'Permissions changed';
          $tr['en']['to']                 = 'to';
          $tr['en']['Saved Successfully']         = 'Saved Successfully';
          $tr['en']['not found!']         = 'not found!';
          $tr['en']['File Saved Successfully']    = 'File Saved Successfully';
          $tr['en']['Archive']            = 'Archive';
          $tr['en']['Permissions not changed']    = 'Permissions not changed';
          $tr['en']['Select folder']      = 'Select folder';
          $tr['en']['Source path not defined']    = 'Source path not defined';
          $tr['en']['already exists']     = 'already exists';
          $tr['en']['Error while moving from']    = 'Error while moving from';
          $tr['en']['Create archive?']    = 'Create archive?';
          $tr['en']['Invalid file or folder name']    = 'Invalid file or folder name';
          $tr['en']['Archive unpacked']   = 'Archive unpacked';
          $tr['en']['File extension is not allowed']  = 'File extension is not allowed';
          $tr['en']['Root path']          = 'Root path';
          $tr['en']['Error while renaming from']  = 'Error while renaming from';
          $tr['en']['File not found']     = 'File not found';
          $tr['en']['Error while deleting items'] = 'Error while deleting items';
          $tr['en']['Moved from']         = 'Moved from';
          $tr['en']['Generate new password hash'] = 'Generate new password for Guest account';
          $tr['en']['Generate new Guest account'] = 'Generate new Guest account';
          $tr['en']['Change Password'] = 'Change Password';
          $tr['en']['Login failed. Invalid username or password'] = 'Login failed. Invalid username or password or has expired';
          $tr['en']['password_hash not supported, Upgrade PHP version'] = 'password_hash not supported, Upgrade PHP version';
          $tr['en']['Advanced Search']    = 'Advanced Search';
          $tr['en']['Error while copying from']    = 'Error while copying from';
          $tr['en']['Invalid characters in file name']                = 'Invalid characters in file name';
          $tr['en']['FILE EXTENSION HAS NOT SUPPORTED']               = 'FILE EXTENSION HAS NOT SUPPORTED';
          $tr['en']['Selected files and folder deleted']              = 'Selected files and folder deleted';
          $tr['en']['Error while fetching archive info']              = 'Error while fetching archive info';
          $tr['en']['Delete selected files and folders?']             = 'Delete selected files and folders?';
          $tr['en']['Search file in folder and subfolders...']        = 'Search file in folder and subfolders...';
          $tr['en']['Access denied. IP restriction applicable']       = 'Access denied. IP restriction applicable';
          $tr['en']['Invalid characters in file or folder name']      = 'Invalid characters in file or folder name';
          $tr['en']['Operations with archives are not available']     = 'Operations with archives are not available';
          $tr['en']['File or folder with this path already exists']   = 'File or folder with this path already exists';
          $tr['en']['Source path']   = 'Source path';
          $tr['en']['Destination folder']   = 'Destination folder';
          $tr['en']['Create guest user'] = 'Create guest user';
          $tr['en']['Old Password'] = 'Old Password';
          $tr['en']['New Password'] = 'New Password';
          $tr['en']['Confirm New Password'] = 'Confirm New Password';
          $tr['en']['Upload from URL'] = 'Upload from URL';
          $tr['en']['Theme'] = 'Skin';
          $i18n = fm_get_translations($tr);
          $tr = $i18n ? $i18n : $tr;

          if (!strlen($lang)) $lang = 'en';
          if (isset($tr[$lang][$txt])) return fm_enc($tr[$lang][$txt]);
          else if (isset($tr['en'][$txt])) return fm_enc($tr['en'][$txt]);
          else return "$txt";
     }

?>