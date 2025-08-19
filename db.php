<?php
$host = 'localhost';
$user = 'ufgzffdwyusgm';
$pass = 'ifqlkpgc9quz';
$dbname = 'db2bs38nv35r4c';
 
$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}
?>
 
