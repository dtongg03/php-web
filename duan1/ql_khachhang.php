<?php

include("connsql.php");

class KhachHang
{
    public $khid;
    public $ho_ten;
    public $dia_chi;
    public $sdt;
    public $email;

    public function __construct($id, $ht, $dc, $sdt, $em)
    {
        $this->khid = $id;
        $this->ho_ten = $ht;
        $this->dia_chi = $dc;
        $this->sdt = $sdt;
        $this->email = $em;
    }

    function addKhachHang(KhachHang $khachHang)
{
    $conn = DBConnection::Connect();

    // Kiểm tra xem khách hàng đã tồn tại hay chưa
    $checkSql = "SELECT COUNT(*) FROM khach_hang WHERE sdt = ?";
    $checkStmt = $conn->prepare($checkSql);
    $checkStmt->bind_param("s", $khachHang->sdt);
    $checkStmt->execute();
    $checkStmt->bind_result($count);
    $checkStmt->fetch();
    $checkStmt->close();

    if ($count > 0) {
        // Nếu đã có khách hàng, thông báo và không thực hiện thêm mới
        $conn->close();
        echo '<script>alert("Khách hàng này đã tồn tại trong cơ sở dữ liệu.");</script>';
        return false;
    }

    // Nếu khách hàng chưa tồn tại, thêm mới vào cơ sở dữ liệu
    $success = false;
    $sql = "INSERT INTO khach_hang(ho_ten, dia_chi, sdt, email) VALUES(?,?,?,?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $khachHang->ho_ten, $khachHang->dia_chi, $khachHang->sdt, $khachHang->email);
    $success = $stmt->execute();
    $stmt->close();
    $conn->close();

    if ($success) {
        echo '<script>alert("Thêm khách hàng thành công.");</script>';
    } else {
        echo '<script>alert("Không thể thêm khách hàng.");</script>';
    }

    return $success;
}

    function editKhachHang(KhachHang $KhachHang)
    {
        $success = false;
        $conn = DBConnection::Connect();
        $sql = "UPDATE khach_hang SET ho_ten=?, dia_chi=?, sdt=?, email=? WHERE kh_id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssss", $KhachHang->ho_ten, $KhachHang->dia_chi, $KhachHang->sdt, $KhachHang->email, $KhachHang->khid);
        $success = $stmt->execute();
        $stmt->close();
        $conn->close();
        return $success;
    }

    function getAllKH()
    {
        $searchManv = isset($_GET['search']) ? $_GET['search'] : '';
        $searchManv = mysqli_real_escape_string(DBConnection::Connect(), $searchManv);
        $dsKhachHang = array();
        $conn = DBConnection::Connect();
        $sql = "SELECT * FROM khach_hang WHERE kh_id LIKE '%$searchManv%' OR ho_ten LIKE '%$searchManv%'";
        $result = $conn->query($sql);
        while ($row = $result->fetch_assoc()) {
            $dsKhachHang[] = new KhachHang($row["kh_id"], $row["ho_ten"], $row["dia_chi"], $row["sdt"], $row["email"]);
        }
        $conn->close();
        return $dsKhachHang;
    }
}

$dsKhachHangObj = new KhachHang('', '', '', '', '');

// Handle form submissions
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['action'])) {
        $action = $_POST['action'];

        if ($action === 'add') {
            // Validate form data
            $ho_ten = $_POST['ho_ten'];
            $dia_chi = $_POST['dia_chi'];
            $sdt = $_POST['sdt'];
            $email = $_POST['email'];

            // Add the KhachHang
            $addKhachHang = new KhachHang('', $ho_ten, $dia_chi, $sdt, $email);
            $dsKhachHangObj->addKhachHang($addKhachHang);
        } elseif ($action === 'edit') {
            // Validate form data
            $khid = $_POST['khid'];
            $ho_ten = $_POST['ho_ten'];
            $dia_chi = $_POST['dia_chi'];
            $sdt = $_POST['sdt'];
            $email = $_POST['email'];

            // Edit the KhachHang
            $editKhachHang = new KhachHang($khid, $ho_ten, $dia_chi, $sdt, $email);
            $dsKhachHangObj->editKhachHang($editKhachHang);
        } elseif ($action === 'delete') {
            $khidToDelete = $_POST['khid'];

            // Delete the KhachHang
            $dsKhachHangObj->deleteKhachHang($khidToDelete);
        }
    }
}

// Retrieve the updated list of KhachHang
$dsKhachHang = $dsKhachHangObj->getAllKH();

?>

<?php require 'main.php'; 

// Kiểm tra xem session có tồn tại hay không
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý Khach Hang</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
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

<div class="container mt-5">
    <div class="content-frame">

        <form action="ql_khachhang.php" method="post">
            <div class="form-row">
                <div class="form-group col-md-3">
                    <label for="user_name">Họ và tên:</label>
                    <input type="text" class="form-control" name="ho_ten" required>
                </div>
                <div class="form-group col-md-3">
                    <label for="dia-chi">Địa Chỉ:</label>
                    <input type="text" class="form-control" name="dia_chi" required>
                </div>
                <div class="form-group col-md-1">
                    <label for="sdt">Sdt:</label>
                    <input type="text" class="form-control" name="sdt" required>
                </div>
                <div class="form-group col-md-1">
                    <label for="email">Email:</label>
                    <input type="text" class="form-control" name="email" required>
                </div>
            </div>
            <input type="hidden" name="action" value="add">
            <button type="submit" class="btn btn-primary">Thêm Tài khoản</button>
        </form>

        <form class="mt-3">
            <div class="form-row">
                <div class="form-group col-md-3">
                    <label for="search_manv">Tìm kiếm:</label>
                    <input type="text" id="search" class="form-control" name="search">
                </div>
            </div>
            <button type="submit" class="btn btn-primary" id="search-button">Search</button>
            <button type="submit" class="btn btn-primary" name="export" value="true">Xuất CSV</button>
        </form>

        <h2 class="mb-4">Danh sách Khách Hàng</h2>
        <h5>Tổng số: <?php echo count($dsKhachHang); ?></h5>
        <table class="table mt-4">
            <thead>
            <tr>
                <th>ID Khách Hàng</th>
                <th>Họ Tên</th>
                <th>Địa Chỉ</th>
                <th>Sdt</th>
                <th>Email</th>
                <th>Thao tác</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($dsKhachHang as $KhachHang) : ?>
                <tr>
                    <td><?php echo $KhachHang->khid; ?></td>
                    <td><?php echo $KhachHang->ho_ten; ?></td>
                    <td><?php echo $KhachHang->dia_chi; ?></td>
                    <td><?php echo $KhachHang->sdt; ?></td>
                    <td><?php echo $KhachHang->email; ?></td>
                    <td>
                        <button type="button" class="btn btn-warning btn-sm edit-btn" data-toggle="modal"
                                data-target="#editModal" data-khid="<?php echo $KhachHang->khid; ?>"
                                data-ho_ten="<?php echo $KhachHang->ho_ten; ?>" data-dia_chi="<?php echo $KhachHang->dia_chi; ?>"
                                data-sdt="<?php echo $KhachHang->sdt; ?>" data-email="<?php echo $KhachHang->email; ?>">Sửa
                        </button>

                        <a onclick="return confirm('DO U WANT TO DELETE');"
                        href="xoakh.php?kh_id=<?php echo $KhachHang->khid ?>" class="abc1">Xoa</a>

                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Add/Edit Modal -->
<div class='modal fade' id='editModal' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>
    <form action='ql_khachhang.php' method='post'>
        <input type='hidden' name='action' value='edit'>
        <input type='hidden' name='khid' id='edit-khid'>
        <div class='modal-body'>
            <input type='text' class='form-control' name='ho_ten' id='edit-ho_ten' required>
            <input type='text' class='form-control' name='dia_chi' id='edit-dia_chi' required>
            <input type='text' class='form-control' name='sdt' id='edit-sdt' required>
            <input type='text' class='form-control' name='email' id='edit-email' required>
        </div>
        <div class='modal-footer'>
            <button type='button' class='btn btn-secondary' data-dismiss='modal'>Hủy</button>
            <button type='submit' class='btn btn-primary'>Lưu</button>
        </div>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
    $(document).ready(function () {
        // Set values in the edit modal when edit button is clicked
        $('.edit-btn').on('click', function () {
            var khid = $(this).data('khid');
            var ho_ten = $(this).data('ho_ten');
            var dia_chi = $(this).data('dia_chi');
            var sdt = $(this).data('sdt');
            var email = $(this).data('email');

            $('#edit-khid').val(khid);
            $('#edit-ho_ten').val(ho_ten);
            $('#edit-dia_chi').val(dia_chi);
            $('#edit-sdt').val(sdt);
            $('#edit-email').val(email);

            $('#editModal').modal('show');
        });
    });
</script>
</body>
</html>

