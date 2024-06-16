<?php
include("connsql.php");

class DonHang {
    public $ma_don;
    public $ma_mau;
    public $Manv;
    public $ho_ten;
    public $ten_mau;
    public $so_luong;
    public $ngay_thue;
    public $ngay_het_han;
    public $ngay_tra;
    public $gia;
    public $tinh_trang_thanh_toan;
    public $tinh_trang_don_hang;

    public function __construct($ma_don, $ma_mau, $Manv, $ho_ten, $ten_mau, $so_luong, $ngay_thue, $ngay_het_han, $ngay_tra, $gia, $tinh_trang_thanh_toan, $tinh_trang_don_hang) {
        $this->ma_don = $ma_don;
        $this->ma_mau = $ma_mau;
        $this->Manv = $Manv;
        $this->ho_ten = $ho_ten;
        $this->ten_mau = $ten_mau;
        $this->so_luong = $so_luong;
        $this->ngay_thue = $ngay_thue;
        $this->ngay_het_han = $ngay_het_han;
        $this->ngay_tra = $ngay_tra;
        $this->gia = $gia;
        $this->tinh_trang_thanh_toan = $tinh_trang_thanh_toan;
        $this->tinh_trang_don_hang = $tinh_trang_don_hang;
    }

    static function getAllDonHang() {
        $searchDonHang = isset($_GET['search']) ? $_GET['search'] : '';
        $searchDonHang = mysqli_real_escape_string(DBConnection::Connect(), $searchDonHang);
        $dsDonHang = array();
        $conn = DBConnection::Connect();
        $sql = "SELECT * FROM don_hang 
                WHERE ma_don LIKE '%$searchDonHang%' 
                    OR ma_mau LIKE '%$searchDonHang%' 
                    OR Manv LIKE '%$searchDonHang%' 
                    OR ho_ten LIKE '%$searchDonHang%' 
                    OR ten_mau LIKE '%$searchDonHang%' 
                    OR so_luong LIKE '%$searchDonHang%' 
                    OR ngay_thue LIKE '%$searchDonHang%' 
                    OR ngay_het_han LIKE '%$searchDonHang%' 
                    OR ngay_tra LIKE '%$searchDonHang%' 
                    OR gia LIKE '%$searchDonHang%' 
                    OR tinh_trang_thanh_toan LIKE '%$searchDonHang%' 
                    OR tinh_trang_don_hang LIKE '%$searchDonHang%'";
        $result = $conn->query($sql);
        while ($row = $result->fetch_assoc()) {
            $dsDonHang[] = new DonHang(
                $row["ma_don"],
                $row["ma_mau"],
                $row["Manv"],
                $row["ho_ten"],
                $row["ten_mau"],
                $row["so_luong"],
                $row["ngay_thue"],
                $row["ngay_het_han"],
                $row["ngay_tra"],
                $row["gia"],
                $row["tinh_trang_thanh_toan"],
                $row["tinh_trang_don_hang"]
            );
        }
        $conn->close();
        return $dsDonHang;
    }

    static function addDonHang(DonHang $donHang) {
        $conn = DBConnection::Connect();
    
        // Kiểm tra tồn tại của mã mẫu
        $checkMauSql = "SELECT COUNT(*) FROM mau WHERE ma_mau = ?";
        $checkMauStmt = $conn->prepare($checkMauSql);
        $checkMauStmt->bind_param("s", $donHang->ma_mau);
        $checkMauStmt->execute();
        $checkMauStmt->bind_result($countMau);
        $checkMauStmt->fetch();
        $checkMauStmt->close();
    
        // Kiểm tra tồn tại của mã nhân viên
        $checkNhanVienSql = "SELECT COUNT(*) FROM tai_khoan WHERE Manv = ?";
        $checkNhanVienStmt = $conn->prepare($checkNhanVienSql);
        $checkNhanVienStmt->bind_param("s", $donHang->Manv);
        $checkNhanVienStmt->execute();
        $checkNhanVienStmt->bind_result($countNhanVien);
        $checkNhanVienStmt->fetch();
        $checkNhanVienStmt->close();
    
        if ($countMau == 0) {
            // Nếu mã mẫu không tồn tại, thông báo và không thực hiện thêm mới
            $conn->close();
            echo '<script>alert("Mã mẫu không tồn tại trong cơ sở dữ liệu.");</script>';
            return false;
        }
    
        if ($countNhanVien == 0) {
            // Nếu mã nhân viên không tồn tại, thông báo và không thực hiện thêm mới
            $conn->close();
            echo '<script>alert("Mã nhân viên không tồn tại trong cơ sở dữ liệu.");</script>';
            return false;
        }
    
        // Kiểm tra số lượng mẫu trước khi thêm đơn hàng
        $checkSoLuongSql = "SELECT so_luong FROM mau WHERE ma_mau = ?";
        $checkSoLuongStmt = $conn->prepare($checkSoLuongSql);
        $checkSoLuongStmt->bind_param("s", $donHang->ma_mau);
        $checkSoLuongStmt->execute();
        $checkSoLuongStmt->bind_result($soLuong);
        $checkSoLuongStmt->fetch();
        $checkSoLuongStmt->close();
    
        if ($soLuong < $donHang->so_luong) {
            // Nếu số lượng không đủ, thông báo và không thực hiện thêm mới
            $conn->close();
            echo '<script>alert("Số lượng mẫu không đủ.");</script>';
            return false;
        }
    
        // Tiếp tục với phần thêm đơn hàng
        $success = false;

        // Nếu cột ma_don có thuộc tính tự động tăng, bỏ qua truyền giá trị
        $maDonParam = $donHang->ma_don ? $donHang->ma_don : null;

        $sql = "INSERT INTO don_hang (ma_don, ma_mau, Manv, ho_ten, ten_mau, so_luong, ngay_thue, ngay_het_han, ngay_tra, gia, tinh_trang_thanh_toan, tinh_trang_don_hang) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        // Binding parameters
        $stmt->bind_param("ssssssssssss", 
            $maDonParam,
            $donHang->ma_mau, 
            $donHang->Manv, 
            $donHang->ho_ten, 
            $donHang->ten_mau, 
            $donHang->so_luong, 
            $donHang->ngay_thue, 
            $donHang->ngay_het_han, 
            $donHang->ngay_tra, 
            $donHang->gia, 
            $donHang->tinh_trang_thanh_toan, 
            $donHang->tinh_trang_don_hang
        );
        $success = $stmt->execute();
        $stmt->close();
        $conn->close();
    
        if ($success) {
            echo '<script>alert("Thêm đơn hàng thành công.");</script>';
        } else {
            echo '<script>alert("Không thể thêm đơn hàng.");</script>';
        }
    
        return $success;
    }
    static function exportDonHangToCSV($dsDonHang) {
        $outputFile = 'donhang_export.csv';
    
        // Mở file CSV để ghi
        $csvFile = fopen($outputFile, 'w');
    
        // Ghi tiêu đề
        fputcsv($csvFile, self::utf8_decode_array_keys(get_object_vars($dsDonHang[0])));
    
        // Ghi dữ liệu
        foreach ($dsDonHang as $donHang) {
            fputcsv($csvFile, self::utf8_decode_array_values(get_object_vars($donHang)));
        }
    
        // Đóng file
        fclose($csvFile);
    
        // Trả về tên file để redirect hoặc sử dụng
        return $outputFile;
    }
    
    static function utf8_decode_array_keys($array) {
        return array_map('utf8_decode', array_keys($array));
    }
    
    static function utf8_decode_array_values($array) {
        return array_map('utf8_decode', $array);
    }
    
}
if (isset($_GET['export'])) {
    $dsDonHang = DonHang::getAllDonHang();
    $exportedFile = DonHang::exportDonHangToCSV($dsDonHang);

    // Nếu có file được xuất, chuyển hướng để tải về
    if ($exportedFile) {
        header("Location: $exportedFile");
        exit();
    }
}
$dsDonHang = DonHang::getAllDonHang();
?>



<?php require 'main.php';  
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý Đơn Hàng</title>
    <!-- Thêm dòng này để sử dụng Bootstrap qua CDN -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        /* Thêm đoạn CSS để tạo khung */
        body {
            display: flex;
            flex-direction: column;
        }

        .container {
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
        .abc1, #addButton {
            display: inline-block;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            cursor: pointer;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f0f0f0;
            color: #333;
            font-size: 16px;
            margin: 10px 0 0 0;
        }

        .abc1:hover, .abc2:hover {
            background-color: #ddd;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="content">
    
        <!-- Form Nhập Liệu -->
        <form action="ql_donhang.php" method="post">
            <div class="form-row">
                <div class="form-group col-md-3">
                    <label for="ma_mau">Mã Mẫu:</label>
                    <input type="text" class="form-control" name="ma_mau" required>
                </div>
                <div class="form-group col-md-3">
                    <label for="Manv">Mã Nhân Viên:</label>
                    <input type="text" class="form-control" name="Manv" required>
                </div>
                <div class="form-group col-md-3">
                    <label for="ho_ten">Họ Tên:</label>
                    <input type="text" class="form-control" name="ho_ten" required>
                </div>
                <div class="form-group col-md-3">
                    <label for="ten_mau">Tên Mẫu:</label>
                    <input type="text" class="form-control" name="ten_mau" required>
                </div>
                <div class="form-group col-md-3">
                    <label for="so_luong">Số Lượng:</label>
                    <input type="text" class="form-control" name="so_luong" required>
                </div>
                <div class="form-group col-md-3">
                    <label for="ngay_thue">Ngày Thuê:</label>
                    <input type="date" class="form-control" name="ngay_thue" required>
                </div>
                <div class="form-group col-md-3">
                    <label for="ngay_het_han">Ngày Hết Hạn:</label>
                    <input type="date" class="form-control" name="ngay_het_han" required>
                </div>
                <div class="form-group col-md-3">
                    <label for="ngay_tra">Ngày Trả:</label>
                    <input type="date" class="form-control" name="ngay_tra">
                </div>
                <div class="form-group col-md-3">
                    <label for="gia">Giá:</label>
                    <input type="text" class="form-control" name="gia" required>
                </div>
                <div class="form-group col-md-3">
                    <label for="tinh_trang_thanh_toan">Tình Trạng Thanh Toán:</label>
                    <input type="text" class="form-control" name="tinh_trang_thanh_toan" required>
                </div>
                <div class="form-group col-md-3">
                    <label for="tinh_trang_don_hang">Tình Trạng Đơn Hàng:</label>
                    <input type="text" class="form-control" name="tinh_trang_don_hang" required>
                </div>
            </div>
            <input type="hidden" name="action" value="add">
            <button type="submit" class="btn btn-primary">Thêm Đơn Hàng</button>
        </form>

        <!-- Form Tìm Kiếm -->
        <form class="mt-3">
            <div class="form-row">
                <div class="form-group col-md-3">
                    <label for="search_mau">Tìm kiếm:</label>
                    <input type="text" id="search" class="form-control" name="search">
                </div>
            </div>
            <button type="submit" class="btn btn-primary" id="search-button">Search</button>
            <button type="submit" class="btn btn-primary" name="export" value="true">Xuất CSV</button>
        </form>

        <h5>Tổng số đơn hàng: <?php echo count($dsDonHang); ?></h5>

        <!-- Bảng Hiển Thị Danh Sách Đơn Hàng -->
        <table class="table mt-4">
            <thead>
                <tr>
                    <th>Mã Đơn</th>
                    <th>Mã Mẫu</th>
                    <th>Mã Nhân Viên</th>
                    <th>Họ Tên</th>
                    <th>Tên Mẫu</th>
                    <th>Số Lượng</th>
                    <th>Ngày Thuê</th>
                    <th>Ngày Hết Hạn</th>
                    <th>Ngày Trả</th>
                    <th>Giá</th>
                    <th>Thanh Toán</th>
                    <th>Tình Trạng Đơn Hàng</th>
                    <th>Thao Tác</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($dsDonHang as $donHang) : ?>
                    <tr>
                        <td><?php echo $donHang->ma_don; ?></td>
                        <td><?php echo $donHang->ma_mau; ?></td>
                        <td><?php echo $donHang->Manv; ?></td>
                        <td><?php echo $donHang->ho_ten; ?></td>
                        <td><?php echo $donHang->ten_mau; ?></td>
                        <td><?php echo $donHang->so_luong; ?></td>
                        <td><?php echo $donHang->ngay_thue; ?></td>
                        <td><?php echo $donHang->ngay_het_han; ?></td>
                        <td><?php echo $donHang->ngay_tra; ?></td>
                        <td><?php echo $donHang->gia; ?></td>
                        <td><?php echo $donHang->tinh_trang_thanh_toan; ?></td>
                        <td><?php echo $donHang->tinh_trang_don_hang; ?></td>
                        <td>
                            <a href="editdonhang.php?ma_don=<?php echo $donHang->ma_don ?>" class="abc1">EDIT</a>
                            <a onclick="return confirm('DO U WANT TO DELETE');"
                        href="xoadh.php?ma_don=<?php echo $donHang->ma_don ?>" class="abc1">DELETE</a>
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
    </div>
</div>
</body>
</html>


        <!-- jQuery và Bootstrap JS qua CDN -->
        <!-- Nếu bạn sử dụng Bootstrap 4 -->
        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

        <!-- Đoạn mã JavaScript để xử lý khi modal được hiển thị -->
    </body>
</html>
