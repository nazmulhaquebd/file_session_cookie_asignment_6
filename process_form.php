<?php
// Validate form inputs
if(empty($_POST['name']) || empty($_POST['email']) || empty($_POST['password']) || empty($_FILES['profile_picture']['name'])){
    die("Error: All fields are required.");
}

$name = $_POST['name'];
$email = $_POST['email'];
$password = $_POST['password'];

// Validate email format
if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
    die("Error: Invalid email format.");
}

// Save profile picture to server
$target_dir = "uploads/";
$target_file = $target_dir . date("YmdHis") . '_' . basename($_FILES["profile_picture"]["name"]);
if(!move_uploaded_file($_FILES["profile_picture"]["tmp_name"], $target_file)){
    die("Error: Failed to upload profile picture.");
}

// Save user data to CSV file
$data = array($name, $email, $target_file);
$fp = fopen('users.csv', 'a');
fputcsv($fp, $data);
fclose($fp);

// Start session and set cookie
session_start();
$_SESSION['name'] = $name;
setcookie('name', $name, time() + (86400 * 30), "/"); // set cookie for 30 days

header('Location: success.php');
exit;
?>
