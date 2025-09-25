<?php
$servername = "db";        
$username   = "root";      
$password   = "root";      
$dbname     = "pi2_db";       

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}
?>
