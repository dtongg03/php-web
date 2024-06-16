<?php
// Tạo mảng dữ liệu từ bảng mẫu
$data = [
    [
        "ten" => "Nguyễn Văn A",
        "tuoi" => 20,
        "diachi" => "Hà Nội",
    ],
    [
        "ten" => "Trần Thị B",
        "tuoi" => 25,
        "diachi" => "Hồ Chí Minh",
    ],
];
$i =0;
?>
<?php 
function conn(){
    $servername = "localhost:3306";
    $username = "root";
    $password = "loiha12345";
    $dbname = "db_thue_ao_cuoi";
    // Khởi tạo kết nối
    return $conn = new mysqli($servername, $username, $password, $dbname);
}
function connect(){
    $servername = "localhost:3306";
    $username = "root";
    $password = "loiha12345";
    $dbname = "db_thue_ao_cuoi";
    // Khởi tạo kết nối
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Kiểm tra kết nối
    if ($conn->connect_error) {
    die("Kết nối thất bại " . $conn->connect_error);
    }else{
        echo"ketes noi thanh cong";
    }
}


function get_hoa_don() {
    connect();
    $conn = conn();
    $sql = "SELECT anh_mau FROM mau WHERE ma_mau = '1';";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    }
    // Trả về kết quả
    return $row;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</head>
<body>
    <div class="container-fluir">
        <?php
            // Vòng lặp foreach để hiển thị dữ liệu từng row
            foreach ($data as $key => $row) {
            // Tạo thẻ con
            echo "<div class='card' id='card-{$i}'>";

            // Hiển thị dữ liệu của từng cột
            foreach ($row as $key => $value) {
            echo "<p><strong>$key:</strong> $value</p>";
            }

            // Đóng thẻ con
            echo "</div>";

            // Tăng biến đếm
            $i++;
            }
        ?>
    </div>

    <div>
        <?php $row = get_hoa_don()?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
</body>
</html>