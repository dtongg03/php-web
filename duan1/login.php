


<?php 
$servername = "localhost:3309";
$username = "root";
$password = "admin123";
$dbname = "ql_aocuoi";

try {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $user = $_POST["txtUserName"];
        $pass = $_POST["txtPassWord"];

        $sql = "SELECT * FROM tai_khoan WHERE user_name = :user AND password = :pass";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':user', $user);
        $stmt->bindParam(':pass', $pass);
        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (!empty($result)) {
            // Đăng nhập thành công
            // Chuyển hướng đến trang thongke.php
            header("Location: thongke.php");
            exit(); // Đảm bảo kết thúc script sau khi chuyển hướng
        } else {
            // Đăng nhập thất bại, có thể chuyển hướng hoặc hiển thị thông báo
            echo '<script>alert("Đăng nhập thất bại");</script>';
        }
    }
} catch (PDOException $e) {
    echo "Lỗi kết nối CSDL: " . $e->getMessage();
}

// Đóng kết nối CSDL
$conn = null;
?>
