<?php 
function conn(){
    $servername = "localhost:3309";
    $username = "root";
    $password = "admin123";
    $dbname = "ql_aocuoi";
    // Khởi tạo kết nối
    return $conn = new mysqli($servername, $username, $password, $dbname);
}
function connect(){
    $servername = "localhost:3309";
    $username = "root";
    $password = "admin123";
    $dbname = "ql_aocuoi";
    
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Kết nối thất bại". $conn->connect_error);
    }
}
?>