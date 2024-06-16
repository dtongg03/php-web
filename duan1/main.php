<?php
// Đoạn mã phần xử lý đăng nhập và đăng xuất
include("auth.php");

$servername = "localhost:3309";
$username = "root";
$password = "admin123";
$dbname = "ql_aocuoi";

// Xử lý đăng xuất nếu có yêu cầu
if (isset($_POST['logout'])) {
    $isLoggedIn = false;
    $loggedInUsername = "";
    
    // Xóa session và cookie nếu tồn tại
    session_destroy();
    setcookie("user", "", time() - 3600, "/");
    echo '<script>window.location.href = "thongke.php";</script>';
}

// Nếu đã đăng nhập, kiểm tra thông tin từ session
if (isset($_SESSION['user'])) {
    $isLoggedIn = true;
    $loggedInUsername = $_SESSION['user'];

    // Kiểm tra xem session 'quyen' có tồn tại không
    if (isset($_SESSION['quyen'])) {
        $userQuyen = $_SESSION['quyen'];
    } else {
        // Lấy dữ liệu từ cơ sở dữ liệu nếu không tồn tại trong session
        try {
            $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $sql = "SELECT quyen FROM tai_khoan WHERE user_name = :username";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':username', $loggedInUsername);
            $stmt->execute();

            $result = $stmt->fetch(PDO::FETCH_ASSOC);

if ($result) {
    $userQuyen = $result['quyen'];
    $_SESSION['quyen'] = $userQuyen;
    var_dump($userQuyen); // In giá trị của $userQuyen
} else {
    // Xử lý trường hợp không tìm thấy dữ liệu
    echo '<script>alert("Không tìm thấy thông tin quyền");</script>';
    echo '<script>window.location.href = "thongke.php";</script>';
}

        } catch (PDOException $e) {
            echo "Lỗi kết nối CSDL: " . $e->getMessage();
        }

        // Đóng kết nối CSDL
        $conn = null;
    }
}

// Xử lý đăng nhập nếu có yêu cầu POST và chưa đăng nhập
if ($_SERVER["REQUEST_METHOD"] == "POST" && !$isLoggedIn) {
    $user = $_POST["txtUserName"];
    $pass = $_POST["txtPassWord"];

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "SELECT * FROM tai_khoan WHERE user_name = :user AND password = :pass";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':user', $user);
        $stmt->bindParam(':pass', $pass);
        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (!empty($result)) {
            // Đăng nhập thành công
            $isLoggedIn = true;
            $loggedInUsername = $user; // Lưu tên người dùng đã đăng nhập

            // Lưu thông tin người dùng vào session
            $_SESSION['user'] = $user;
            $_SESSION['quyen'] = $result[0]['quyen']; // Lưu giá trị quyen vào session

            // Sử dụng cookie để lưu thông tin đăng nhập (ví dụ: tên người dùng)
            setcookie("user", $user, time() + (86400 * 15), "/"); // Cookie tồn tại trong 15 ngày
            header("location: thongke.php");
        } else {
            // Đăng nhập thất bại
            echo '<script>alert("Đăng nhập thất bại");</script>';
        }
    } catch (PDOException $e) {
        echo "Lỗi kết nối CSDL: " . $e->getMessage();
    }

    // Đóng kết nối CSDL
    $conn = null;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
    <title>YourWeddingBully</title>
</head>
<body>

<!-- Navigation using Bootstrap -->
<!-- Navigation using Bootstrap -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="thongke.php">YourWeddingBully</a>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
            <?php
            // Nếu đã đăng nhập, kiểm tra thông tin từ session
            if ($isLoggedIn) {

                // Kiểm tra quyền trước khi hiển thị các thẻ
                if (isset($userQuyen) && $userQuyen == 1) {
                    echo '<li class="nav-item"><a class="nav-link" href="ql_taikhoan.php">Account</a></li>';
                    // Thêm điều kiện kiểm tra quyền cho ql_mau và ql_donhang
                }else if (isset($userQuyen) && $userQuyen == 2) {
                    // Hiển thị chức năng "Templates" và "Orders"
                    echo '<li class="nav-item"><a class="nav-link" href="ql_khachhang.php">Customers</a></li>';
                }else if (isset($userQuyen) && $userQuyen == 3) {
                    echo '<li class="nav-item"><a class="nav-link" href="ql_mau.php">Templates</a></li>';
                }else if (isset($userQuyen) && $userQuyen == 4) {
                    echo '<li class="nav-item"><a class="nav-link" href="ql_donhang.php">Orders</a></li>';
                }else if (isset($userQuyen) && $userQuyen == 10) {
                    echo '<li class="nav-item"><a class="nav-link" href="ql_taikhoan.php">Account</a></li>';
                    echo '<li class="nav-item"><a class="nav-link" href="ql_khachhang.php">Customers</a></li>';
                    echo '<li class="nav-item"><a class="nav-link" href="ql_mau.php">Templates</a></li>';
                    echo '<li class="nav-item"><a class="nav-link" href="ql_donhang.php">Orders</a></li>';
                }
            } else {
                echo '<button class="btn btn-outline-light my-2 my-sm-0" data-toggle="modal" data-target="#loginModal">Login</button>';
            }
            ?>
        </ul>
    </div>
    <?php
    // Nếu đã đăng nhập, hiển thị tên người dùng và nút đăng xuất
    if ($isLoggedIn) {
        echo '<span class="navbar-text mr-3">Welcome, ' . $loggedInUsername . '</span>';
        echo '<form method="post" action=""><button type="submit" class="btn btn-outline-light my-2 my-sm-0" name="logout">Logout</button></form>';
    }
    ?>
</nav>


<!-- Modal đăng nhập -->
<div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="loginModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="loginModalLabel">Login</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Thêm form đăng nhập ở đây -->
                <form method="post" action="">
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" name="txtUserName" placeholder="Enter your username">
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" name="txtPassWord" placeholder="Enter your password">
                    </div>
                    <button type="submit" class="btn btn-primary" id="loginButton">Login</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.3/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
    // Kiểm tra trạng thái đăng nhập khi trang được tải
    document.addEventListener('DOMContentLoaded', function () {
        // Điều hướng đến trang đăng nhập nếu chưa đăng nhập
        if (!<?php echo json_encode($isLoggedIn); ?>) {
            $('#loginModal').modal('show');
        }
    });
</script>
<!-- Thêm vào cuối thẻ body -->

</body>
</html>
