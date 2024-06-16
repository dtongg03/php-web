<?php   
// Assuming your database connection parameters
$servername = "localhost:3309";
        $username = "root";
        $password = "admin123";
        $dbname = "ql_aocuoi";
        // Khởi tạo kết nối
        $conn = new mysqli($servername, $username, $password, $dbname);
        // Kiểm tra kết nối
        if ($conn->connect_error) {
            die("Kết nối thất bại: " . $conn->connect_error);
        }

// Assuming "kh_id" is an integer; adjust the data type accordingly
$mk = isset($_GET["kh_id"]) ? intval($_GET["kh_id"]) : 0;

// Check if $mk is a valid ID (non-zero)
if ($mk <= 0) {
    die("Invalid kh_id");
}

// SQL query to delete a record
$sqlDelete = "DELETE FROM khach_hang WHERE kh_id = ?";
$stmt = $conn->prepare($sqlDelete);

// Check if the prepared statement is successfully created
if ($stmt === false) {
    die("Error in preparing statement: " . $conn->error);
}

// Bind parameters
$stmt->bind_param("i", $mk);

// Execute the statement
if ($stmt->execute()) {
    echo "<script>alert('XÓA THÀNH CÔNG!');</script>";
} else {
    echo "<script>alert('XÓA THẤT BẠI!');</script>";
    error_log("Thao tác xóa thất bại: " . $stmt->error);
}

// Close the statement and connection
$stmt->close();
$conn->close();

// Redirect to ql_khachhang.php
header("location: ql_khachhang.php");
exit;
?>









?>