<?php


include("connsql.php");

class Mau
{
    public $ma_mau;
    public $ten_mau;
    public $anh_mau;
    public $size;
    public $so_luong;
    public $gia;
    public $kieu_dang;
    public $chat_lieu;
    public $mau_sac;
    public $kieu_co;
    public $kieu_tay;
    public $kieu_lung;
    public $chu_de;
    public $mo_ta;

    public function __construct($ma_mau, $ten_mau, $anh_mau, $size, $so_luong, $gia, $kieu_dang, $chat_lieu, $mau_sac, $kieu_co, $kieu_tay, $kieu_lung, $chu_de, $mo_ta) {
        $this->ma_mau = $ma_mau;
        $this->ten_mau = $ten_mau;
        $this->anh_mau = $anh_mau;
        $this->size = $size;
        $this->so_luong = $so_luong;
        $this->gia = $gia;
        $this->kieu_dang = $kieu_dang;
        $this->chat_lieu = $chat_lieu;
        $this->mau_sac = $mau_sac;
        $this->kieu_co = $kieu_co;
        $this->kieu_tay = $kieu_tay;
        $this->kieu_lung = $kieu_lung;
        $this->chu_de = $chu_de;
        $this->mo_ta = $mo_ta;
    }

    public function __destruct()
    {
        // Hàm hủy nếu cần thiết
    }
}

// Hàm thêm tài khoản
function addMau(Mau $mau)
{
    $conn = DBConnection::Connect();

    // Kiểm tra xem mã mẫu đã tồn tại hay chưa
    $checkSql = "SELECT COUNT(*) FROM mau WHERE ma_mau = ?";
    $checkStmt = $conn->prepare($checkSql);
    $checkStmt->bind_param("s", $mau->ma_mau);
    $checkStmt->execute();
    $checkStmt->bind_result($count);
    $checkStmt->fetch();
    $checkStmt->close();

    if ($count > 0) {
        // Nếu đã có mã mẫu, thông báo và không thực hiện thêm mới
        $conn->close();
        echo '<script>alert("Mã mẫu này đã tồn tại trong cơ sở dữ liệu.");</script>';
        return false;
    }

    // Nếu mã mẫu chưa tồn tại, thêm mới vào cơ sở dữ liệu
    $success = false;
    $sql = "INSERT INTO mau(ma_mau, ten_mau, anh_mau, size, so_luong, gia, kieu_dang, chat_lieu, mau_sac, kieu_co, kieu_tay, kieu_lung, chu_de, mota) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
    $stmt = $conn->prepare($sql);
    // Corrected binding parameters
    $stmt->bind_param("ssssssssssssss", $mau->ma_mau, $mau->ten_mau, $mau->anh_mau, $mau->size, $mau->so_luong, $mau->gia, $mau->kieu_dang, $mau->chat_lieu, $mau->mau_sac, $mau->kieu_co, $mau->kieu_tay, $mau->kieu_lung, $mau->chu_de, $mau->mo_ta);
    $success = $stmt->execute();
    $stmt->close();
    $conn->close();

    if ($success) {
        echo '<script>alert("Thêm mẫu thành công.");</script>';
    } else {
        echo '<script>alert("Không thể thêm mẫu.");</script>';
    }

    return $success;
}

// Hàm xóa tài khoản
function deleteMau(string $ma_mau)
{
    $success = false;
    $conn = DBConnection::Connect();

    // Delete associated records in the don_hang table
    $deleteDonHang = "DELETE FROM don_hang WHERE ma_mau = ?";
    $stmtDonHang = $conn->prepare($deleteDonHang);
    $stmtDonHang->bind_param("s", $ma_mau);
    $stmtDonHang->execute();
    $stmtDonHang->close();

    // Now, delete the record in the mau table
    $sql = "DELETE FROM mau WHERE ma_mau=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $ma_mau);
    $success = $stmt->execute();
    $stmt->close();

    $conn->close();
    return $success;
}


// Hàm lấy danh sách tài khoản
function getAllMau()
{
    $searchMau = isset($_GET['search']) ? $_GET['search'] : '';
    $searchMau = mysqli_real_escape_string(DBConnection::Connect(), $searchMau);
    $dsMau = array();
    $conn = DBConnection::Connect();
    $sql = "SELECT * FROM mau WHERE ma_mau LIKE '%$searchMau%' OR ten_mau LIKE '%$searchMau%'";
    $result = $conn->query($sql);
    while ($row = $result->fetch_assoc()) {
        $dsMau[] = new Mau(
            $row["ma_mau"],
            $row["ten_mau"],
            $row["anh_mau"],
            $row["size"],
            $row["so_luong"],
            $row["gia"],
            $row["kieu_dang"],
            $row["chat_lieu"],
            $row["mau_sac"],
            $row["kieu_co"],
            $row["kieu_tay"],
            $row["kieu_lung"],
            $row["chu_de"],
            $row["mota"]
        );
    }
    $conn->close();
    return $dsMau;
}



if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["action"])) {
    if ($_POST["action"] == "add") {
        // Thêm tài khoản
        $mau = new Mau($_POST["ma_mau"], $_POST["ten_mau"], $_POST["anh_mau"], $_POST["size"], $_POST["so_luong"], $_POST["gia"], $_POST["kieu_dang"], $_POST["chat_lieu"], $_POST["mau_sac"], $_POST["kieu_co"], $_POST["kieu_tay"], $_POST["kieu_lung"], $_POST["chu_de"], $_POST["mo_ta"]);
        addMau($mau);
    
    } elseif ($_POST["action"] == "delete") {
        // Xóa tài khoản
        deleteMau($_POST["ma_mau"]);
    }
}


// Lấy danh sách tài khoản
$dsMau = getAllMau();
?>



<?php require 'main.php'; 
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý Mâu</title>
    <!-- Thêm dòng này để sử dụng Bootstrap qua CDN -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        /* Thêm đoạn CSS để tạo khung */
        <style>
    /* Thêm đoạn CSS để làm rộng nhất có thể */
    body, html {
        width: 100%;
        margin: 0;
        padding: 0;
    }

    .container {
        border: 2px solid #ddd;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        background-color: #fff;
        max-width: 95%;
        width: 100%;
        margin: auto;
    }

    /* Các quy tắc CSS khác ở đây... */
</style>


    </style>
</head>
<body>

    <div class="container">
        <div class="content">
        
        <form action="ql_mau.php" method="post">
            <div class="form-row">
                <div class="form-group col-md-3">
                    <label for="manv">Mã Mẫu:</label>
                    <input type="text" class="form-control" name="ma_mau" required>
                </div>
                <div class="form-group col-md-3">
                    <label for="user_name">Tên Mẫu:</label>
                    <input type="text" class="form-control" name="ten_mau" required>
                </div>
                <div class="form-group col-md-3">
                    <label for="text">Ảnh Mẫu:</label>
                    <input type="text" class="form-control" name="anh_mau" required>
                </div>
                <div class="form-group col-md-3">
                    <label for="password">size:</label>
                    <input type="text" class="form-control" name="size" required>
                </div>
                <div class="form-group col-md-3">
                    <label for="password">Số Lượng:</label>
                    <input type="text" class="form-control" name="so_luong" required>
                </div>
                <div class="form-group col-md-3">
                    <label for="password">Giá:</label>
                    <input type="text" class="form-control" name="gia" required>
                </div>
                <div class="form-group col-md-3">
                    <label for="password">Kiểu Dáng:</label>
                    <input type="text" class="form-control" name="kieu_dang" required>
                </div>
                <div class="form-group col-md-3">
                    <label for="password">Chất liệu:</label>
                    <input type="text" class="form-control" name="chat_lieu" required>
                </div>
                <div class="form-group col-md-3">
                    <label for="password">Màu Sắc:</label>
                    <input type="text" class="form-control" name="mau_sac" required>
                </div>
                <div class="form-group col-md-3">
                    <label for="password">Kiểu Cổ:</label>
                    <input type="text" class="form-control" name="kieu_co" required>
                </div>
                <div class="form-group col-md-1">
                    <label for="quyen">Kiểu Tay:</label>
                    <input type="text" class="form-control" name="kieu_tay" required>
                </div>
                <div class="form-group col-md-3">
                    <label for="password">Kiểu Lưng:</label>
                    <input type="text" class="form-control" name="kieu_lung" required>
                </div>
                <div class="form-group col-md-3">
                    <label for="password">Chủ Đề:</label>
                    <input type="text" class="form-control" name="chu_de" required>
                </div>
                <div class="form-group col-md-3">
                    <label for="password">Mô tả:</label>
                    <input type="text" class="form-control" name="mo_ta" required>
                </div>
            </div>
            <input type="hidden" name="action" value="add">
            <button type="submit" class="btn btn-primary">Thêm Mẫu</button>
        </form>

        <form class="mt-3">
            <div class="form-row">
                <div class="form-group col-md-3">
                    <label for="search_manv">Tìm kiếm:</label>
                    <input type="text" id="search" class="form-control" name="search">
                </div>
            </div>
            <button type="submit" class="btn btn-primary" id="search-button">Search</button>
        </form>

        <!-- Hiển thị số lượng tài khoản -->
        <h5>Tổng số mẫu: <?php echo count($dsMau); ?></h5>
        <table class="table mt-4">
    <thead>
        <tr>
            <th>Mã</th>
            <th>Tên</th>
            <th>Ảnh</th>
            <th>Size</th>
            <th>SL</th>
            <th>Giá</th>
            <th>Kiểu</th>
            <th>Chất Liệu</th>
            <th>Màu</th>
            <th>Cổ</th>
            <th>Tay</th>
            <th>Lưng</th>
            <th>Chủ Đề</th>
            <th>Mô Tả</th>
            <th>Thao Tác</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($dsMau as $mau) : ?>
            <tr>
                <td><?php echo $mau->ma_mau; ?></td>
                <td><?php echo $mau->ten_mau; ?></td>
                <td>
                    <img height=50 width =45 src="
                    <?php echo $mau->anh_mau; ?>">
                </td>
                <td><?php echo $mau->size; ?></td>
                <td><?php echo $mau->so_luong; ?></td>
                <td><?php echo $mau->gia; ?></td>
                <td><?php echo $mau->kieu_dang; ?></td>
                <td><?php echo $mau->chat_lieu; ?></td>
                <td><?php echo $mau->mau_sac; ?></td>
                <td><?php echo $mau->kieu_co; ?></td>
                <td><?php echo $mau->kieu_tay; ?></td>
                <td><?php echo $mau->kieu_lung; ?></td>
                <td><?php echo $mau->chu_de; ?></td>
                <td><?php echo $mau->mo_ta; ?></td>
                <td>
                <a href="edittemplates.php?ma_mau=<?php echo $mau->ma_mau ?>" class="abc1">EDIT</a>


                    <button type='button' class='btn btn-danger btn-sm' data-toggle='modal' data-target='<?php echo "#confirmDelete{$mau->ma_mau}"; ?>'>Xóa</button>
                    <!-- Modal -->
                    <div class='modal fade' id='<?php echo "confirmDelete{$mau->ma_mau}"; ?>' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>
                        <div class='modal-dialog' role='document'>
                            <div class='modal-content'>
                                <div class='modal-header'>
                                    <h5 class='modal-title' id='exampleModalLabel'>Xác nhận Xóa</h5>
                                    <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                        <span aria-hidden='true'>&times;</span>
                                    </button>
                                </div>
                                <div class='modal-body'>
                                    Bạn có chắc chắn muốn xóa mẫu này?
                                </div>
                                <div class='modal-footer'>
                                    <button type='button' class='btn btn-secondary' data-dismiss='modal'>Hủy</button>
                                    <form action='ql_mau.php' method='post' style='display: inline;'>
                                        <input type='hidden' name='ma_mau' value='<?php echo $mau->ma_mau; ?>'>
                                        <input type='hidden' name='action' value='delete'>
                                        <button type='submit' class='btn btn-danger'>Xóa</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
    <!-- jQuery và Bootstrap JS qua CDN -->
    <!-- Nếu bạn sử dụng Bootstrap 4 -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <!-- Đoạn mã JavaScript để xử lý khi modal được hiển thị -->
</body>
</html>
