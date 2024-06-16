<?php


include("connsql.php");

class TaiKhoan
{
    public $manv;
    public $user_name;
    public $password;
    public $vaitro;
    public $quyen;

    public function __construct($mnv, $us, $pw, $vt, $q)
    {
        $this->manv = $mnv;
        $this->user_name = $us;
        $this->password = $pw;
        $this->vaitro = $vt;
        $this->quyen = $q;
    }

    public function __destruct()
    {
        // Hàm hủy nếu cần thiết
    }
}

// Hàm thêm tài khoản
function addTaiKhoan(TaiKhoan $taikhoan)
{
    $conn = DBConnection::Connect();

    // Kiểm tra xem mã nhân viên đã tồn tại hay chưa
    $checkSql = "SELECT COUNT(*) FROM tai_khoan WHERE Manv = ?";
    $checkStmt = $conn->prepare($checkSql);
    $checkStmt->bind_param("s", $taikhoan->manv);
    $checkStmt->execute();
    $checkStmt->bind_result($count);
    $checkStmt->fetch();
    $checkStmt->close();

    if ($count > 0) {
        // Nếu đã có mã nhân viên, thông báo và không thực hiện thêm mới
        $conn->close();
        echo '<script>alert("Đã có mã nhân viên này trong cơ sở dữ liệu.");</script>';
        return false;
    }

    // Nếu mã nhân viên chưa tồn tại, thêm mới vào cơ sở dữ liệu
    $success = false;
    $sql = "INSERT INTO tai_khoan(Manv, user_name, password, vaitro, quyen) VALUES(?,?,?,?,?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssi", $taikhoan->manv, $taikhoan->user_name, $taikhoan->password, $taikhoan->vaitro, $taikhoan->quyen);
    $success = $stmt->execute();
    $stmt->close();
    $conn->close();

    if ($success) {
        echo '<script>alert("Thêm tài khoản thành công.");</script>';
    } else {
        echo '<script>alert("Không thể thêm tài khoản.");</script>';
    }

    return $success;
}




// Hàm sửa thông tin tài khoản
function editTaiKhoan(TaiKhoan $taikhoan)
{
    $success = false;
    $conn = DBConnection::Connect();
    $sql = "UPDATE tai_khoan SET user_name=?, password=?, vaitro=?, quyen=? WHERE Manv=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $taikhoan->user_name, $taikhoan->password, $taikhoan->vaitro, $taikhoan->quyen, $taikhoan->manv);

    $success = $stmt->execute();
    $stmt->close();
    $conn->close();
    return $success;
    
}


// Hàm xóa tài khoản
function deleteTaiKhoan(string $manv)
{
    $success = false;
    $conn = DBConnection::Connect();
    $sql = "DELETE FROM tai_khoan WHERE Manv=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $manv);
    $success = $stmt->execute();
    $stmt->close();
    $conn->close();
    return $success;
}

// Hàm lấy danh sách tài khoản
function getAllTaiKhoan()
{
    $searchManv = isset($_GET['search']) ? $_GET['search'] : '';
    $searchManv = mysqli_real_escape_string(DBConnection::Connect(), $searchManv);
    $dsTaiKhoan = array();
    $conn = DBConnection::Connect();
    $sql = "SELECT * FROM tai_khoan WHERE Manv LIKE '%$searchManv%' OR user_name LIKE '%$searchManv%'";
    $result = $conn->query($sql);
    while ($row = $result->fetch_assoc()) {
        $dsTaiKhoan[] = new TaiKhoan($row["Manv"], $row["user_name"], $row["password"], $row["vaitro"], $row["quyen"]);
    }
    $conn->close();
    return $dsTaiKhoan;
}


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["action"])) {
    if ($_POST["action"] == "add") {
        // Thêm tài khoản
        $taikhoan = new TaiKhoan($_POST["manv"], $_POST["user_name"], $_POST["password"], $_POST["vaitro"], $_POST["quyen"]);
        addTaiKhoan($taikhoan);
    } elseif ($_POST["action"] == "edit") {
        // Sửa tài khoản
        // Gọi hàm editTaiKhoan nếu cần thiết
    } elseif ($_POST["action"] == "delete") {
        // Xóa tài khoản
        deleteTaiKhoan($_POST["manv"]);
    } 
    elseif ($_POST["action"] == "edit") {
        // Sửa tài khoản
        $editTaiKhoan = new TaiKhoan($_POST["edit_manv_modal"], $_POST["edit_user_name_modal"], $_POST["edit_password_modal"], $_POST["edit_vaitro_modal"], $_POST["edit_quyen_modal"]);
        editTaiKhoan($editTaiKhoan);
    }
    
    elseif ($_POST["action"] == "edittaikhoan") {
        // Chỉnh sửa tài khoản
        $editTaiKhoan = new TaiKhoan($_POST["edit_manv"], $_POST["edit_user_name"], $_POST["edit_password"], $_POST["edit_vaitro"], $_POST["edit_quyen"]);
        editTaiKhoan($editTaiKhoan);
    }
    
}

// Lấy danh sách tài khoản
$dsTaiKhoan = getAllTaiKhoan();
?>



<?php require 'main.php'; 
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý Tài khoản</title>
    <!-- Thêm dòng này để sử dụng Bootstrap qua CDN -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        /* Thêm đoạn CSS để tạo khung */
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
            border: 1px solid #ddd; /* Màu đường viền */
            padding: 20px;
            border-radius: 10px; /* Độ cong của góc */
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* Hiệu ứng bóng */
            background-color: #fff; /* Màu nền */
            max-width: 1500px; /* Độ rộng tối đa */
            width: 100%;
            margin: auto;
        }

        /* Tùy chỉnh kích thước và kiểu dáng nút lưu */
        .btn-success {
            width: 100%;
        }

        /* Thêm đoạn CSS để canh giữa modal theo chiều dọc */
        .modal-dialog {
            display: flex;
            align-items: center;
            min-height: calc(100vh - 60px); /* 60px là chiều cao của thanh tiêu đề modal */
        }

    </style>
</head>
<body>

    <div class="container mt-5">
        <div class="content-frame">
        
        <form action="ql_taikhoan.php" method="post">
            <div class="form-row">
                <div class="form-group col-md-3">
                    <label for="manv">Mã nhân viên:</label>
                    <input type="text" class="form-control" name="manv" required>
                </div>
                <div class="form-group col-md-3">
                    <label for="user_name">Tên đăng nhập:</label>
                    <input type="text" class="form-control" name="user_name" required>
                </div>
                <div class="form-group col-md-3">
                    <label for="password">Mật khẩu:</label>
                    <input type="password" class="form-control" name="password" required>
                </div>
                <div class="form-group col-md-2">
                    <label for="vaitro">Vai trò:</label>
                    <select class="form-control" name="vaitro" required>
                        <option value="admin">Admin</option>
                        <option value="user">User</option>
                    </select>
                </div>
                <div class="form-group col-md-1">
                    <label for="quyen">Quyền:</label>
                    <input type="text" class="form-control" name="quyen" required>
                </div>
            </div>
            <input type="hidden" name="action" value="add">
            <button type="submit" class="btn btn-primary">Thêm Tài khoản</button>
        </form>

        <form class="mt-3">
            <div class="form-row">
                <div class="form-group col-md-3">
                    <label for="search_manv">Tìm kiếm theo Mã NV:</label>
                    <input type="text" id="search" class="form-control" name="search">
                </div>
            </div>
            <button type="submit" class="btn btn-primary" id="search-button">Search</button>
        </form>

        <!-- Hiển thị số lượng tài khoản -->
        <h2 class="mb-4">Danh sách Tài khoản</h2>
        <h5>Tổng số tài khoản: <?php echo count($dsTaiKhoan); ?></h5>
        <table class="table mt-4">
            <thead>
                <tr>
                    <th>Mã NV</th>
                    <th>Tên đăng nhập</th>
                    <th>PassWord</th>
                    <th>Vai trò</th>
                    <th>Quyền</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($dsTaiKhoan as $taikhoan) : ?>
            <tr>
                <td><?php echo $taikhoan->manv; ?></td>
                <td><?php echo $taikhoan->user_name; ?></td>
                <td><?php echo $taikhoan->password; ?></td>
                <td><?php echo $taikhoan->vaitro; ?></td>
                <td><?php echo $taikhoan->quyen; ?></td>
                <td>
                    <button type="button" class="btn btn-warning btn-sm edit-btn" data-toggle="modal" data-target="#editModal" data-manv="<?php echo $taikhoan->manv; ?>" data-username="<?php echo $taikhoan->user_name; ?>" data-password="<?php echo $taikhoan->password; ?>" data-vaitro="<?php echo $taikhoan->vaitro; ?>" data-quyen="<?php echo $taikhoan->quyen; ?>">Sửa</button>

                    <button type='button' class='btn btn-danger btn-sm' data-toggle='modal' data-target='<?php echo "#confirmDelete{$taikhoan->manv}"; ?>'>Xóa</button>
                    <!-- Modal -->
                    <div class='modal fade' id='<?php echo "confirmDelete{$taikhoan->manv}"; ?>' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>
                        <div class='modal-dialog' role='document'>
                            <div class='modal-content'>
                                <div class='modal-header'>
                                    <h5 class='modal-title' id='exampleModalLabel'>Xác nhận Xóa</h5>
                                    <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                        <span aria-hidden='true'>&times;</span>
                                    </button>
                                </div>
                                <div class='modal-body'>
                                    Bạn có chắc chắn muốn xóa tài khoản này?
                                </div>
                                <div class='modal-footer'>
                                    <button type='button' class='btn btn-secondary' data-dismiss='modal'>Hủy</button>
                                    <form action='ql_taikhoan.php' method='post' style='display: inline;'>
                                        <input type='hidden' name='manv' value='<?php echo $taikhoan->manv; ?>'>
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

        </div>

    
    <!-- Modal chỉnh sửa -->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Chỉnh sửa Tài khoản</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Form chỉnh sửa -->
                    <form id="editForm" action="ql_taikhoan.php" method="post">
                        <div class="form-row">
                            <div class="form-group col-md-3">
                                <label for="edit_manv_modal">Mã nhân viên:</label>
                                <input type="text" class="form-control" id="edit_manv_modal" name="edit_manv_modal" readonly>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="edit_user_name_modal">Tên đăng nhập:</label>
                                <input type="text" class="form-control" id="edit_user_name_modal" name="edit_user_name_modal" required>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="edit_password_modal">Mật khẩu:</label>
                                <input type="password" class="form-control" id="edit_password_modal" name="edit_password_modal" required>
                            </div>
                            <div class="form-group col-md-2">
                                <label for="edit_vaitro_modal">Vai trò:</label>
                                <select class="form-control" id="edit_vaitro_modal" name="edit_vaitro_modal" required>
                                    <option value="admin">Admin</option>
                                    <option value="user">User</option>
                                </select>
                            </div>
                            <div class="form-group col-md-1">
                                <label for="edit_quyen_modal">Quyền:</label>
                                <input type="text" class="form-control" id="edit_quyen_modal" name="edit_quyen_modal" required>
                            </div>
                        </div>
                        <input type="hidden" name="action" value="edit_modal">
                        <button type="submit" class="btn btn-success">Lưu Thay Đổi
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery và Bootstrap JS qua CDN -->
    <!-- Nếu bạn sử dụng Bootstrap 4 -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <!-- Đoạn mã JavaScript để xử lý khi modal được hiển thị -->
<script>
$(document).ready(function () {
    $('.edit-btn').on('click', function () {
        var manv = $(this).data('manv');
        var username = $(this).data('username');
        var password = $(this).data('password');
        var vaitro = $(this).data('vaitro');
        var quyen = $(this).data('quyen');

        $('#edit_manv_modal').val(manv);
        $('#edit_user_name_modal').val(username);
        $('#edit_password_modal').val(password);
        $('#edit_vaitro_modal').val(vaitro);
        $('#edit_quyen_modal').val(quyen);

        $('#editModal').modal('show');
    });

    // Bắt sự kiện submit của form chỉnh sửa
    $('#editForm').submit(function (e) {
        e.preventDefault(); // Ngăn chặn sự kiện submit mặc định

        // Thu thập dữ liệu từ form
        var formData = {
            edit_manv: $('#edit_manv_modal').val(),
            edit_user_name: $('#edit_user_name_modal').val(),
            edit_password: $('#edit_password_modal').val(),
            edit_vaitro: $('#edit_vaitro_modal').val(),
            edit_quyen: $('#edit_quyen_modal').val(),
            action: 'edittaikhoan' // Đặt action tương ứng với chức năng bạn muốn thực hiện
        };

        // Gửi dữ liệu đến server
        $.ajax({
            type: 'POST',
            url: 'ql_taikhoan.php', // Đặt đường dẫn tới file xử lý PHP của bạn
            data: formData,
            success: function (response) {
                // Xử lý phản hồi từ server nếu cần
                console.log(response);
                // Đóng modal sau khi chỉnh sửa thành công
                $('#editModal').modal('hide');
                location.reload();
            },
            error: function (error) {
                console.error(error);
                // Xử lý lỗi nếu cần
            }
        });
    });
});

</script>




</body>
</html>
