<?php
$severname = "localhost:3309";
$username = "root";
$password = "admin123";
$dbname = "ql_aocuoi";
$conn = new mysqli($severname, $username, $password, $dbname);

if ($conn->connect_error) {
    die("ERRORS" . $conn->connect_error);
}

// Kiểm tra xem có tham số ma_mau được truyền từ URL hay không
if (isset($_GET["ma_mau"])) {
    $maToEdit = $_GET["ma_mau"];

    // Truy vấn SQL để lấy thông tin mẫu cần chỉnh sửa
    $sql = "SELECT * FROM mau WHERE ma_mau = '$maToEdit'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Tạo biến để nhận dữ liệu mẫu
        $ten_mauToEdit = $row["ten_mau"];
        $anh_mauToEdit = $row["anh_mau"];
        $sizeToEdit = $row["size"];
        $so_luongToEdit = $row["so_luong"];
        $giaToEdit = $row["gia"];
        $kieu_dangToEdit = $row["kieu_dang"];
        $chat_lieuToEdit = $row["chat_lieu"];
        $mau_sacToEdit = $row["mau_sac"];
        $kieu_coToEdit = $row["kieu_co"];
        $kieu_tayToEdit = $row["kieu_tay"];
        $kieu_lungToEdit = $row["kieu_lung"];
        $chu_deToEdit = $row["chu_de"];
        $mo_taToEdit = $row["mota"];
    } else {
        echo "error";
        exit;
    }
}

// Xử lý cập nhật dữ liệu
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["update"])) {
    $ten_mau = $_POST["ten_mau"];
    $anh_mau = $_POST["anh_mau"];
    $size = $_POST["size"];
    $so_luong = $_POST["so_luong"];
    $gia = $_POST["gia"];
    $kieu_dang = $_POST["kieu_dang"];
    $chat_lieu = $_POST["chat_lieu"];
    $mau_sac = $_POST["mau_sac"];
    $kieu_co = $_POST["kieu_co"];
    $kieu_tay = $_POST["kieu_tay"];
    $kieu_lung = $_POST["kieu_lung"];
    $chu_de = $_POST["chu_de"];
    $mo_ta = $_POST["mo_ta"];

    // Thực hiện truy vấn SQL để cập nhật dữ liệu
    $sqlUpdate = "UPDATE mau SET ten_mau=?, anh_mau=?, size=?, so_luong=?, gia=?, kieu_dang=?, chat_lieu=?, mau_sac=?, kieu_co=?, kieu_tay=?, kieu_lung=?, chu_de=?, mota=? WHERE ma_mau=?";
    $stmt = $conn->prepare($sqlUpdate);
    $stmt->bind_param("ssssssssssssss", $ten_mau, $anh_mau, $size, $so_luong, $gia, $kieu_dang, $chat_lieu, $mau_sac, $kieu_co, $kieu_tay, $kieu_lung, $chu_de, $mo_ta, $maToEdit);

    if ($stmt->execute()) {
        header("location:ql_mau.php");
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
        <input type='hidden' name='ma_mau' value='<?php echo $maToEdit; ?>'>
        <div class='modal-body'>
            <input type='text' class='form-control' name='ten_mau' required placeholder='Tên Mẫu' value='<?php echo $ten_mauToEdit; ?>'>
            <input type='text' class='form-control' name='anh_mau' required placeholder='Ảnh Mẫu' value='<?php echo $anh_mauToEdit; ?>'>
            <input type='text' class='form-control' name='size' required placeholder='Size' value='<?php echo $sizeToEdit; ?>'>
            <input type='text' class='form-control' name='so_luong' required placeholder='Số Lượng' value='<?php echo $so_luongToEdit; ?>'>
            <input type='text' class='form-control' name='gia' required placeholder='Giá' value='<?php echo $giaToEdit; ?>'>
            <input type='text' class='form-control' name='kieu_dang' required placeholder='Kiểu Dáng' value='<?php echo $kieu_dangToEdit; ?>'>
            <input type='text' class='form-control' name='chat_lieu' required placeholder='Chất Liệu' value='<?php echo $chat_lieuToEdit; ?>'>
            <input type='text' class='form-control' name='mau_sac' required placeholder='Màu Sắc' value='<?php echo $mau_sacToEdit; ?>'>
            <input type='text' class='form-control' name='kieu_co' required placeholder='Kiểu Cổ' value='<?php echo $kieu_coToEdit; ?>'>
            <input type='text' class='form-control' name='kieu_tay' required placeholder='Kiểu Tay' value='<?php echo $kieu_tayToEdit; ?>'>
            <input type='text' class='form-control' name='kieu_lung' required placeholder='Kiểu Lưng' value='<?php echo $kieu_lungToEdit; ?>'>
            <input type='text' class='form-control' name='chu_de' required placeholder='Chủ Đề' value='<?php echo $chu_deToEdit; ?>'>
            <input type='text' class='form-control' name='mo_ta' required placeholder='Mô Tả' value='<?php echo $mo_taToEdit; ?>'>
        </div>
        <div class='modal-footer'>
            <button type='button' class='btn btn-secondary' data-dismiss='modal'>Hủy</button>
            <button type='submit' class='btn btn-primary' name='update'>Lưu</button>
        </div>
    </form>
</body>

</html>

