<?php
use PHPUnit\Framework\TestCase;

include 'duan1/ql_taikhoan.php';

class TaiKhoanTest extends TestCase
{
    public function testAddTaiKhoan()
{
    // Tạo mock cho mysqli_stmt
    $stmt = $this->createMock(mysqli_stmt::class);
    $stmt->method('bind_param')->willReturn(true);
    $stmt->method('execute')->willReturn(true);
    $stmt->method('fetch')->willReturn(false); // Giả sử mã nhân viên không tồn tại

    // Cấu hình hành vi mock cho phương thức prepare trên mysqli
    $mysqli = $this->getMockBuilder(mysqli::class)
                   ->disableOriginalConstructor()
                   ->getMock();
    
    $mysqli->method('prepare')
           ->willReturn($stmt); // Trả về một đối tượng mock của mysqli_stmt

    // Tạo đối tượng TaiKhoan mock với các đối số tương ứng và gọi addTaiKhoan
    for ($i = 0; $i < 10; $i++) {
        // Tạo mã nhân viên ngẫu nhiên gồm 8 ký tự
        $employeeCode = substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil(8/strlen($x)) )),1,8);
        $taikhoan = new TaiKhoan($employeeCode, 'user' . $i, 'pass' . $i, 'vaitro' . $i, $i % 2);
        $result = addTaiKhoan($taikhoan, $mysqli); // Gọi hàm addTaiKhoan từ ql_taikhoan.php
        // Kiểm tra xem addTaiKhoan có trả về true cho mỗi lần lặp không
        $this->assertTrue($result, "Thất bại khi thêm TaiKhoan $i"); 
    }
}

public function testAddTaiKhoanWithNullCode()
{
    // Tạo mock cho mysqli_stmt
    $stmt = $this->createMock(mysqli_stmt::class);
    $stmt->method('bind_param')->willReturn(true);
    $stmt->method('execute')->will($this->throwException(new mysqli_sql_exception("Column 'Manv' cannot be null"))); // Giả sử việc thực thi thất bại khi mã nhân viên là null
    
    // Cấu hình hành vi mock cho phương thức prepare trên mysqli
    $mysqli = $this->getMockBuilder(mysqli::class)
                   ->disableOriginalConstructor()
                   ->getMock();
    
    $mysqli->method('prepare')
           ->willReturn($stmt); // Trả về một đối tượng mock của mysqli_stmt
    
    // Tạo đối tượng TaiKhoan mock với mã nhân viên là null và gọi addTaiKhoan
    $taikhoan = new TaiKhoan(null, 'user', 'pass', 'vaitro', 1);
    try {
        $result = addTaiKhoan($taikhoan, $mysqli); // Gọi hàm addTaiKhoan từ ql_taikhoan.php
        $this->fail("Expected exception not thrown"); // Nếu không có ngoại lệ nào được ném ra, thì kiểm thử này sẽ thất bại
    } catch (mysqli_sql_exception $e) {
        $this->assertEquals("Column 'Manv' cannot be null", $e->getMessage()); // Kiểm tra xem ngoại lệ có đúng là "Column 'Manv' cannot be null" không
    }
}


}


?>
