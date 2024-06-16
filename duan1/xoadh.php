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

// Assuming "ma_don" is a string; adjust the data type accordingly
$ma_don = isset($_GET["ma_don"]) ? $_GET["ma_don"] : "";

// Check if $ma_don is a valid ID (non-empty)
if (empty($ma_don)) {
    die("Invalid ma_don");
}

// SQL query to delete a record
$sqlDelete = "DELETE FROM don_hang WHERE ma_don = ?";
$stmt = $conn->prepare($sqlDelete);

// Check if the prepared statement is successfully created
if ($stmt === false) {
    die("Error in preparing statement: " . $conn->error);
}

// Bind parameters
$stmt->bind_param("s", $ma_don);

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

// Redirect to ql_donhang.php
header("location: ql_donhang.php");
exit;
?>
