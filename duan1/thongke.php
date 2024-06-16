<?php
$servername = "localhost:3309";
$username = "root";
$password = "admin123";
$dbname = "ql_aocuoi";
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("ERRORS" . $conn->connect_error);
}

function getOrderCount() {
    global $conn;
    $sql = "SELECT COUNT(*) as count FROM don_hang WHERE tinh_trang_thanh_toan = 'Đã thanh toán'";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['count'];
    } else {
        return 0;
    }
}

function getRevenue() {
    global $conn;
    $sql = "SELECT SUM(gia) as revenue FROM don_hang WHERE tinh_trang_thanh_toan = 'Đã thanh toán'";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['revenue'];
    } else {
        return 0;
    }
}

function getBestSeller() {
    global $conn;
    $sql = "SELECT ma_mau, COUNT(ma_mau) as count FROM don_hang GROUP BY ma_mau ORDER BY count DESC LIMIT 1";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $maMau = $row['ma_mau'];

        // Bạn có thể thực hiện thêm bất kỳ công việc nào khác liên quan đến sản phẩm bán chạy ở đây

        return $maMau;
    } else {
        return "N/A";
    }
}

// Lấy dữ liệu từ các hàm PHP
$orderCount = getOrderCount();
$revenue = getRevenue();
$bestSeller = getBestSeller();
?>
<?php require 'main.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang Thống Kê</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
        }

        .container {
            padding-top: 50px;
        }

        .card {
            margin-top: 20px;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="row">
        <div class="col-lg-4">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title">Số Đơn Hàng</h5>
                    <p class="card-text" id="orderCount"><?php echo $orderCount; ?></p>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title">Doanh Thu</h5>
                    <p class="card-text" id="revenue"><?php echo $revenue; ?></p>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title">Sản Phẩm Bán Chạy Nhất</h5>
                    <p class="card-text" id="bestSeller"><?php echo $bestSeller; ?></p>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
