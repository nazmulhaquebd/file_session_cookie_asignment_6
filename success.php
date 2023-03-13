<?php
// Start session
session_start();

// Check if cookie is set
if(!isset($_COOKIE['name'])){
    die("Error: Cookie not set.");
}

// Display user data in table
echo "<h1>Welcome, " . $_SESSION['name'] . "!</h1>";

echo "<table border='1'>
<tr>
<th>Name</th>
<th>Email</th>
<th>Profile Picture</th>
</tr>";

if (($handle = fopen("users.csv", "r")) !== FALSE) {
    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
        echo "<tr>";
        echo "<td>" . $data[0] . "</td>";
        echo "<td>" . $data[1] . "</td>";
        echo "<td><img src='" . $data[2] . "' width='100'></td>";
        echo "</tr>";
    }
    fclose($handle);
}

echo "</table>";

// Clear session and cookie
session_unset();
session_destroy();
setcookie('name', '', time() - 3600, "/");
?>
