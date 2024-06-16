<?php
$servername = "localhost:3309";
$username = "root";
$password = "admin123";
$dbname = "ql_aocuoi";
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("ERRORS" . $conn->connect_error);
}

// Kiểm tra xem có tham số ma_don được truyền từ URL hay không
if (isset($_GET["ma_don"])) {
    $maToEdit = $_GET["ma_don"];

    // Truy vấn SQL để lấy thông tin đơn hàng cần chỉnh sửa
    $sql = "SELECT * FROM don_hang WHERE ma_don = '$maToEdit'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Tạo biến để nhận dữ liệu đơn hàng
        $ma_mauToEdit = $row["ma_mau"];
        $ManvToEdit = $row["Manv"];
        $ho_tenToEdit = $row["ho_ten"];
        $ten_mauToEdit = $row["ten_mau"];
        $so_luongToEdit = $row["so_luong"];
        $ngay_thueToEdit = $row["ngay_thue"];
        $ngay_het_hanToEdit = $row["ngay_het_han"];
        $ngay_traToEdit = $row["ngay_tra"];
        $giaToEdit = $row["gia"];
        $tinh_trang_thanh_toanToEdit = $row["tinh_trang_thanh_toan"];
        $tinh_trang_don_hangToEdit = $row["tinh_trang_don_hang"];
    } else {
        echo "error";
        exit;
    }
}

// Xử lý cập nhật dữ liệu
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["update"])) {
    $ma_mau = $_POST["ma_mau"];
    $Manv = $_POST["Manv"];
    $ho_ten = $_POST["ho_ten"];
    $ten_mau = $_POST["ten_mau"];
    $so_luong = $_POST["so_luong"];
    $ngay_thue = $_POST["ngay_thue"];
    $ngay_het_han = $_POST["ngay_het_han"];
    $ngay_tra = $_POST["ngay_tra"];
    $gia = $_POST["gia"];
    $tinh_trang_thanh_toan = $_POST["tinh_trang_thanh_toan"];
    $tinh_trang_don_hang = $_POST["tinh_trang_don_hang"];

    // Thực hiện truy vấn SQL để cập nhật dữ liệu
    $sqlUpdate = "UPDATE don_hang SET ma_mau=?, Manv=?, ho_ten=?, ten_mau=?, so_luong=?, ngay_thue=?, ngay_het_han=?, ngay_tra=?, gia=?, tinh_trang_thanh_toan=?, tinh_trang_don_hang=? WHERE ma_don=?";
    $stmt = $conn->prepare($sqlUpdate);
    $stmt->bind_param("ssssssssssss", $ma_mau, $Manv, $ho_ten, $ten_mau, $so_luong, $ngay_thue, $ngay_het_han, $ngay_tra, $gia, $tinh_trang_thanh_toan, $tinh_trang_don_hang, $maToEdit);

    if ($stmt->execute()) {
        header("location:ql_donhang.php"); // Thay thế your_page.php bằng trang bạn muốn chuyển hướng sau khi cập nhật
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}
?>

<?php require 'main.php'; 
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chỉnh Sửa Mẫu</title>
    <style>
        body {
            display: flex;
            flex-direction: column;
        }

        .container {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .content-frame {
            border: 1px solid #ddd;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            background-color: #fff;
            max-width: 1500px;
            width: 100%;
            margin: auto;
        }

        .btn-success {
            width: 100%;
        }

        .modal-dialog {
            display: flex;
            align-items: center;
            min-height: calc(100vh - 60px);
        }
    </style>
</head>

<body>
    <!-- Hiển thị thông tin mẫu và form cập nhật -->
    <form action='' method='post'>
    <input type='hidden' name='action' value='edit'>
<input type='hidden' name='ma_don' value='<?php echo $maToEdit; ?>'>
<div class='modal-body'>
    <input type='text' class='form-control' name='ma_mau' required placeholder='Mã Mẫu' value='<?php echo $ma_mauToEdit; ?>'>
    <input type='text' class='form-control' name='Manv' required placeholder='Mã Nhân Viên' value='<?php echo $ManvToEdit; ?>'>
    <input type='text' class='form-control' name='ho_ten' required placeholder='Họ Tên' value='<?php echo $ho_tenToEdit; ?>'>
    <input type='text' class='form-control' name='ten_mau' required placeholder='Tên Mẫu' value='<?php echo $ten_mauToEdit; ?>'>
    <input type='text' class='form-control' name='so_luong' required placeholder='Số Lượng' value='<?php echo $so_luongToEdit; ?>'>
    <input type='text' class='form-control' name='ngay_thue' required placeholder='Ngày Thuê' value='<?php echo $ngay_thueToEdit; ?>'>
    <input type='text' class='form-control' name='ngay_het_han' required placeholder='Ngày Hết Hạn' value='<?php echo $ngay_het_hanToEdit; ?>'>
    <input type='text' class='form-control' name='ngay_tra' required placeholder='Ngày Trả' value='<?php echo $ngay_traToEdit; ?>'>
    <input type='text' class='form-control' name='gia' required placeholder='Giá' value='<?php echo $giaToEdit; ?>'>
    <input type='text' class='form-control' name='tinh_trang_thanh_toan' required placeholder='Tình Trạng Thanh Toán' value='<?php echo $tinh_trang_thanh_toanToEdit; ?>'>
    <input type='text' class='form-control' name='tinh_trang_don_hang' required placeholder='Tình Trạng Đơn Hàng' value='<?php echo $tinh_trang_don_hangToEdit; ?>'>
</div>
<div class='modal-footer'>
    <button type='button' class='btn btn-secondary' data-dismiss='modal'>Hủy</button>
    <button type='submit' class='btn btn-primary' name='update'>Lưu</button>
</div>

    </form>
</body>

</html>
