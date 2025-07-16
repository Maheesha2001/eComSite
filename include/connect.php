<?php
// Database connection settings
$host = 'localhost';
$user = 'root';
$password = '';
$database = 'mystore';

// Create connection
$conn = new mysqli($host, $user, $password, $database);

// Check connection
if ($conn->connect_error) {
  echo '<div style="color: #fff; background:rgb(182, 19, 60); padding: 10px; border-radius: 5px; margin: 10px 0; text-align: center;">Database connection failed!!</div>';
 } 
// else {
//     echo '<div style="color: #fff; background: #67bc4f; padding: 10px; border-radius: 5px; margin: 10px 0; text-align: center;">Database connection successful!</div>';
// }
?> 