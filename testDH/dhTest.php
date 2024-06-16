<?php
use PHPUnit\Framework\TestCase;

class dhTest extends TestCase
{
    private $conn;

    protected function setUp(): void
    {
        $this->conn = new mysqli('localhost:3309', 'root', 'admin123', 'ql_aocuoi');
    }

    protected function tearDown(): void
    {
        $this->conn->close();
    }

    public function testDeleteOrder()
{
    // Tạo ra một bản ghi tạm thời
    $ma_don = '1';
    $donHang = new stdClass(); // Tạo một đối tượng stdClass
    $donHang->ma_mau = "M0001";
    // Tiếp tục gán các thuộc tính khác cho $donHang
    // ...

    $sqlInsert = "INSERT INTO don_hang (ma_don, ma_mau, Manv, ho_ten, ten_mau, so_luong, ngay_thue, ngay_het_han, ngay_tra, gia, tinh_trang_thanh_toan, tinh_trang_don_hang) 
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $this->conn->prepare($sqlInsert);
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

    // Kiểm tra xem có ngoại lệ được ném ra hay không
    $this->expectException(mysqli_sql_exception::class);
    $stmt->execute();

    // Thực hiện xóa bản ghi
    $_GET['ma_don'] = 1;
    ob_start();
    include 'duan1/xoadh.php';  
    ob_end_clean();


    $sqlSelect = "SELECT * FROM don_hang WHERE ma_don = 1";
    $stmt = $this->conn->prepare($sqlSelect);
    $stmt->bind_param("s", $ma_don);
    $stmt->execute();
    $result = $stmt->get_result();
    $this->assertEquals(0, $result->num_rows);
    $stmt->close();
}


    public function testDeleteOrderException()
    {
        // Thiết lập giá trị ma_don không hợp lệ
        $_GET['ma_don'] = 'abc';

        // Kiểm tra xem khi thực hiện xóa, có ngoại lệ được ném ra không
        $this->expectException(mysqli_sql_exception::class);
        include 'duan1/xoadh.php'; // Thay thế bằng đường dẫn thực tế đến script của bạn
    }
}
?>
