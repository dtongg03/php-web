<?php 
function conn(){
    $servername = "localhost:3309";
    $username = "root";
    $password = "admin123";
    $dbname = "ql_aocuoi";
    // Khởi tạo kết nối
    return $conn = new mysqli($servername, $username, $password, $dbname);
}
function connect(){
    $servername = "localhost:3309";
    $username = "root";
    $password = "admin123";
    $dbname = "ql_aocuoi";
    
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Kết nối thất bại". $conn->connect_error);
    }
}
?>

<?php 
function get_chi_tiet_mau($ma_mau) {
    connect();
    $conn = conn();
    $sql = "SELECT * FROM mau WHERE ma_mau = '$ma_mau';
    ";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    }
    $conn->close();
    // Trả về kết quả
    return $row;
}
?>
<?php 
function get_size($ten_mau) {
    connect();
    $conn = conn();
    $sql = "SELECT size FROM mau WHERE ten_mau = '$ten_mau';";
    $result = $conn->query($sql);
    $size_options_S = "<option value='S' selected disabled>S</option>";
    $size_options_M = "<option value='M' disabled>M</option>";
    $size_options_L = "<option value='L'disabled>L</option>";
    $size_options_XL = "<option value='XL'disabled>XL</option>";

    if ($result->num_rows > 0) {
      $foundSizes = []; // Mảng lưu trữ các size đã tìm thấy
  
      while ($row = $result->fetch_assoc()) {
        $size = $row["size"];
        $foundSizes[] = $size; // Thêm size vào mảng
  
        // $selected = $size === "S" ? "selected" : ""; // Chọn size S mặc định
        // $disabled = !in_array($size, $foundSizes);   // Disabled nếu size chưa được tìm thấy
        // if (!in_array($size, ["S", "M", "L", "XL"])) {
        //     $size_options .= "<option value='$size' disabled>$size</option>";
        //   } else {
        //     $size_options .= "<option value='$size' $selected $disabled>$size</option>";
        //   }

        for($i=0; $i<sizeof($foundSizes); $i++){
            if($foundSizes[$i] === 'S'){
                $size_options_S = "<option value='S' selected>S</option>";
            }
        }

        for($i=0; $i<sizeof($foundSizes); $i++){
            if($foundSizes[$i] === 'M'){
                $size_options_M = "<option value='M'>M</option>";
            }
        }

        for($i=0; $i<sizeof($foundSizes); $i++){
            if($foundSizes[$i] === 'L'){
                $size_options_L = "<option value='L'>L</option>";
            }
        }

        for($i=0; $i<sizeof($foundSizes); $i++){
            if($foundSizes[$i] === 'XL'){
                $size_options_XL = "<option value='XL'>XL</option>";
            }
        }
      }
    }
    $conn->close();
    echo $size_options_S;
    echo $size_options_M;
    echo $size_options_L;
    echo $size_options_XL;

    // $size_options_S = "<option value='S' selected disabled>S</option>";
    // $size_options_M = "<option value='M' disabled>M</option>";
    // $size_options_L = "<option value='L'disabled>L</option>";
    // $size_options_XL = "<option value='XL'disabled>XL</option>";

    // if ($result->num_rows > 0) {
    
    //     while($row = $result->fetch_assoc()) {
    //         $size = $row["size"];
    //         if($size === "S"){
    //             $size_options_S = "<option value='S' selected>S</option>";
    //         }
            
    //     // <option selected >S</option>
    //     // <option value="M">M</option>
    //     // <option value="L">L</option>
    //     // <option value="XL">XL</option>
    //     }

    //     while($row = $result->fetch_assoc()) {
    //         $size = $row["size"];
    //         if($size === "M"){
    //             $size_options_M = "<option value='M'>M</option>";
    //         }
    //     // <option selected >S</option>
    //     // <option value="M">M</option>
    //     // <option value="L">L</option>
    //     // <option value="XL">XL</option>
    //     }

    //     while($row = $result->fetch_assoc()) {
    //         $size = $row["size"];
    //         if($size === "L"){
    //             $size_options_L = "<option value='L'>L</option>";
    //         }
    //     // <option selected >S</option>
    //     // <option value="M">M</option>
    //     // <option value="L">L</option>
    //     // <option value="XL">XL</option>
    //     }

    //     while($row = $result->fetch_assoc()) {
    //         $size = $row["size"];
    //         if($size === "XL"){
    //             $size_options_L = "<option value='XL'>XL</option>";
    //         }
    //     // <option selected >S</option>
    //     // <option value="M">M</option>
    //     // <option value="L">L</option>
    //     // <option value="XL">XL</option>
    //     }
    // }
    // $conn->close();
    // // Trả về kết quả
    // echo $size_options_S;
    // echo $size_options_M;
    // echo $size_options_L;
    // echo $size_options_XL;
    
}
?>

<?php 
if(isset($_GET['ma_mau'])) {
    
    $ma_mau = $_GET['ma_mau'];
    $row_product = get_chi_tiet_mau($ma_mau);
    $ten_mau = $row_product['ten_mau'];
    
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your wedding bliss</title>
    <!-- Jquery v3.7.1 -->
    <script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.7.1.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script src="../php_btl/script.js"></script>
    <!-- Bootstrap CSS v5.2.1 -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
        rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
        crossorigin="anonymous"
    />
    <link rel="stylesheet" type="text/css" href="../php_btl/db.css">
</head>
<body>
    <header>
            <div class="container-fluid" id="header">
                <div class="row">
                    <!-- logo -->
                    <div class="col-md-2" style="padding: 15px 0 0 40px;">
                        <a href="../php_btl/home.php">
                            <img src="../php_btl/your-wedding-bliss-logo-zip-file/your-wedding-bliss-logo-zip-file/png/logo-no-background.png" alt="Logo" width="60px" height="60px" class="d-inline-block align-text-top">
                            
                        </a>
                    </div>
                    <!--  -->
                    <!-- infor -->
                    <div class="col bnt">
                        <div class="bnt_list dropdown">
                            <button class="dropbtn"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16"><path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"/></svg></button>
                            <div class="dropdown-content">
                                <div class="search_box">
                                    <div class="search_input">
                                        <input type="text" class="form-control" id="search" placeholder="Search"/>
                                    </div>
                                    <div id="search_result">

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="bnt_list">
                            <a  href="../php_btl/sanpham.php">Trang phục cưới</a>
                        </div>
                        <div class="bnt_list dropdown">
                            <button class="dropbtn">Thư viện mẫu</button>
                            <div class="dropdown-content">
                                <a href="../php_btl/sanpham_chude.php?chu_de=Trong Sáng">Trong sáng</a>
                                <a href="../php_btl/sanpham_chude.php?chu_de=Tiệc Tùng">Tiệc tùng</a>
                                <a href="../php_btl/sanpham_chude.php?chu_de=Sang Trọng">Sang trọng</a>
                            </div>
                        </div>
                        <div class="bnt_list">
                            <a  href="../php_btl/contact.php">Contact</a>
                        </div>
                        
                    </div>    
                </div>        
            </div>
            <div class="container-fluid" style="min-height: 84px "> </div>
    </header>

    <main>

        <!-- Product details -->
        <div class="container" style="min-height: 550px; margin-top: 10px;">
                  
            <div class="row">
                <div class="col-6 product_details">
                    <img src="<?php echo $row_product["anh_mau"]?>" >
                </div>
                <div class="col-6 product_details">
                    <form method="post" action="thanh_toan.php"  id="form_product">
                        <input type="hidden" name="anhmau" value="<?php echo $row_product["anh_mau"]?>"> 
                        <input type="hidden" name="tenmau" value="<?php echo $row_product["ten_mau"]?>">
                        <input type="hidden" name="gia" value="<?php echo $row_product["gia"]?>">   
                        <h1><?php echo $row_product["ten_mau"]?></h1>
                        <h><?php echo $row_product["mota"]?></h>
                        <h5>Giá thuê: <?php echo $row_product["gia"]?> đ</h5>
                        
                        <div class="dropdown">
                            <select type="text" class="form-select" name="size"  required>
                                <?php 
                                get_size($ten_mau);
                                // for($i = 0; $i < sizeof($size_options); $i++){
                                //     echo $size_options[$i];
                                // } 
                                ?>
                                <!-- <option selected>S</option>
                                <option value="M">M</option>
                                <option value="L">L</option>
                                <option value="XL">XL</option> -->
                            </select>
                        
                        </div>
                        <div class="product_pay">
                            <input type="number" name="soluong" step="1" value="1"  min="1" max="99" >
                            <button type="submit" name="product">Thanh toán</button>

                        </div>
                        <div class="product_supple">
                            <h>
                                <svg aria-hidden="true" class="e-font-icon-svg e-fas-check" viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg"><path d="M173.898 439.404l-166.4-166.4c-9.997-9.997-9.997-26.206 0-36.204l36.203-36.204c9.997-9.998 26.207-9.998 36.204 0L192 312.69 432.095 72.596c9.997-9.997 26.207-9.997 36.204 0l36.203 36.204c9.997 9.997 9.997 26.206 0 36.204l-294.4 294.401c-9.998 9.997-26.207 9.997-36.204-.001z"></path></svg>
                                Sản phẩm là thiết kế riêng của Your Wedding Bliss
                            </h>
                            <h>
                                <svg aria-hidden="true" class="e-font-icon-svg e-fas-check" viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg"><path d="M173.898 439.404l-166.4-166.4c-9.997-9.997-9.997-26.206 0-36.204l36.203-36.204c9.997-9.998 26.207-9.998 36.204 0L192 312.69 432.095 72.596c9.997-9.997 26.207-9.997 36.204 0l36.203 36.204c9.997 9.997 9.997 26.206 0 36.204l-294.4 294.401c-9.998 9.997-26.207 9.997-36.204-.001z"></path></svg>
                                Giá niêm yết cho size S-XL hoặc số đo tương đương
                            </h>
                            <h>
                                <svg aria-hidden="true" class="e-font-icon-svg e-fas-check" viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg"><path d="M173.898 439.404l-166.4-166.4c-9.997-9.997-9.997-26.206 0-36.204l36.203-36.204c9.997-9.998 26.207-9.998 36.204 0L192 312.69 432.095 72.596c9.997-9.997 26.207-9.997 36.204 0l36.203 36.204c9.997 9.997 9.997 26.206 0 36.204l-294.4 294.401c-9.998 9.997-26.207 9.997-36.204-.001z"></path></svg>
                                Giá chưa bao gồm phụ kiện cưới (mấn, lúp...)
                            </h> 
                            <h> 
                                <svg aria-hidden="true" class="e-font-icon-svg e-fas-check" viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg"><path d="M173.898 439.404l-166.4-166.4c-9.997-9.997-9.997-26.206 0-36.204l36.203-36.204c9.997-9.998 26.207-9.998 36.204 0L192 312.69 432.095 72.596c9.997-9.997 26.207-9.997 36.204 0l36.203 36.204c9.997 9.997 9.997 26.206 0 36.204l-294.4 294.401c-9.998 9.997-26.207 9.997-36.204-.001z"></path></svg> 
                                Khách có thể thay đổi kiểu dáng, màu sắc...
                            </h>
                            <h> 
                                <svg aria-hidden="true" class="e-font-icon-svg e-fas-check" viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg"><path d="M173.898 439.404l-166.4-166.4c-9.997-9.997-9.997-26.206 0-36.204l36.203-36.204c9.997-9.998 26.207-9.998 36.204 0L192 312.69 432.095 72.596c9.997-9.997 26.207-9.997 36.204 0l36.203 36.204c9.997 9.997 9.997 26.206 0 36.204l-294.4 294.401c-9.998 9.997-26.207 9.997-36.204-.001z"></path></svg>   
                                Thời gian hoàn thiện 6-12 tuần, tùy thiết kế.
                            </h>
                            <h>
                                <svg aria-hidden="true" class="e-font-icon-svg e-fas-shipping-fast" viewBox="0 0 640 512" xmlns="http://www.w3.org/2000/svg"><path d="M624 352h-16V243.9c0-12.7-5.1-24.9-14.1-33.9L494 110.1c-9-9-21.2-14.1-33.9-14.1H416V48c0-26.5-21.5-48-48-48H112C85.5 0 64 21.5 64 48v48H8c-4.4 0-8 3.6-8 8v16c0 4.4 3.6 8 8 8h272c4.4 0 8 3.6 8 8v16c0 4.4-3.6 8-8 8H40c-4.4 0-8 3.6-8 8v16c0 4.4 3.6 8 8 8h208c4.4 0 8 3.6 8 8v16c0 4.4-3.6 8-8 8H8c-4.4 0-8 3.6-8 8v16c0 4.4 3.6 8 8 8h208c4.4 0 8 3.6 8 8v16c0 4.4-3.6 8-8 8H64v128c0 53 43 96 96 96s96-43 96-96h128c0 53 43 96 96 96s96-43 96-96h48c8.8 0 16-7.2 16-16v-32c0-8.8-7.2-16-16-16zM160 464c-26.5 0-48-21.5-48-48s21.5-48 48-48 48 21.5 48 48-21.5 48-48 48zm320 0c-26.5 0-48-21.5-48-48s21.5-48 48-48 48 21.5 48 48-21.5 48-48 48zm80-208H416V144h44.1l99.9 99.9V256z"></path></svg>
                                Miễn phí ship trong nước khi mua hàng online.
                            </h>
                            <h> 
                                <svg aria-hidden="true" class="e-font-icon-svg e-fas-check" viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg"><path d="M173.898 439.404l-166.4-166.4c-9.997-9.997-9.997-26.206 0-36.204l36.203-36.204c9.997-9.998 26.207-9.998 36.204 0L192 312.69 432.095 72.596c9.997-9.997 26.207-9.997 36.204 0l36.203 36.204c9.997 9.997 9.997 26.206 0 36.204l-294.4 294.401c-9.998 9.997-26.207 9.997-36.204-.001z"></path></svg>
                                Hủy đơn hàng trong 48h, không phát sinh phí.
                            </h>   
                            <h> 
                                <svg aria-hidden="true" class="e-font-icon-svg e-fas-check" viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg"><path d="M173.898 439.404l-166.4-166.4c-9.997-9.997-9.997-26.206 0-36.204l36.203-36.204c9.997-9.998 26.207-9.998 36.204 0L192 312.69 432.095 72.596c9.997-9.997 26.207-9.997 36.204 0l36.203 36.204c9.997 9.997 9.997 26.206 0 36.204l-294.4 294.401c-9.998 9.997-26.207 9.997-36.204-.001z"></path></svg>
                                Không chấp nhận đổi trả.
                            </h>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- info -->
        <div class="container product_info" style="min-height: 380px; margin-top: 40px;">
            <h2>Thông tin chi tiết</h2>
            <table class="table table-bordered table-hover" name="table_info">
                <tbody>
                <tr>
                    <th scope="row">Kiểu dáng</th>
                    <td><?php echo $row_product["kieu_dang"]?></td>
                </tr>
                <tr>
                    <th scope="row">Màu sắc</th>
                    <td><?php echo $row_product["mau_sac"]?></td>
                </tr>
                <tr>
                    <th scope="row">Chất liệu</th>
                    <td><?php echo $row_product["chat_lieu"]?></td>
                </tr>
                <tr>
                    <th scope="row">Kiểu cổ</th>
                    <td><?php echo $row_product["kieu_co"]?></td>
                </tr>
                <tr>
                    <th scope="row">Kiểu tay</th>
                    <td><?php echo $row_product["kieu_tay"]?></td>
                </tr>
                <tr>
                    <th scope="row">Kiểu lưng</th>
                    <td><?php echo $row_product["kieu_lung"]?></td>
                </tr>
                <tr>
                    <th scope="row">Size</th>
                    <td><?php echo $row_product["size"]?></td>
                </tr>
                </tbody>
            </table>

        </div>

        <div class="container" style="min-height: 500px; margin-top: 40px;">
            <?php
                connect();
                $conn = conn();
                $chu_de =$row_product["chu_de"];
                $sql = "SELECT ma_mau, ten_mau, anh_mau, gia, chu_de
                FROM mau
                WHERE chu_de = '$chu_de'
                AND ma_mau <> '$ma_mau'
                ORDER BY RAND()
                LIMIT 4;";

                $result = $conn->query($sql);
                if ($result->num_rows == 0) {
                    echo"danh sách trống!";
                }
            ?>

            <div class="title_center">
                <h3 class="border-bottom border-secondary-subtle">Sản phẩm liên quan</h3>
            </div>
            <div class="row"> 
            
            <?php
                
                while ($row = $result->fetch_assoc()) {
                    // Tạo thẻ div với nội dung lấy từ cơ sở dữ liệu
                    echo '
                    <div class="col-md-3">
                        <div class="card">
                            <img src="'. $row['anh_mau'] . '" width="100%" class="card-img-top">
                            <div>
                                <a href="../php_btl/chitietsanpham.php?ma_mau='.$row["ma_mau"].'" class="btn card-col card-foot">Xem chi tiết
                                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="24"  fill="currentColor" class="bi bi-bag" viewBox="0 0 16 16">
                                    <path d="M8 1a2.5 2.5 0 0 1 2.5 2.5V4h-5v-.5A2.5 2.5 0 0 1 8 1m3.5 3v-.5a3.5 3.5 0 1 0-7 0V4H1v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V4zM2 5h12v9a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1z"/>
                            </svg>
                                </a>
                            </div>
                        </div>
                        <div class="price">
                            <h>' . $row['ten_mau'] . '</h>
                            <p>Giá thuê: ' . $row['gia'] . ' vnđ</p>
                        </div>
                    </div>
                    ';
                }
            ?>
        </div>
    </main>

    <footer>
        <div class="container-fluid" style="min-height: 500px; width: 100%;">
            <div style="height: 50px; border-bottom: 3px rgb(178, 178, 178) solid;"></div>
            <div class="row " style="min-height: 400px; margin: 10px 0 10px 0">
                <div class="col-md-3 pad ">
                    <img src="../php_btl/your-wedding-bliss-logo-zip-file/your-wedding-bliss-logo-zip-file/png/logo-no-background.png" alt="Logo" width="130px" height="130px" class="d-inline-block align-text-top">
                    <div class="e-font" style="width: 100%;">
                        <h5>Theo dõi tại</h5>
                        <div class="e-font-icon">
                            <div>
                                <svg class="e-font-icon-svg e-fab-facebook" viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg"><path d="M504 256C504 119 393 8 256 8S8 119 8 256c0 123.78 90.69 226.38 209.25 245V327.69h-63V256h63v-54.64c0-62.15 37-96.48 93.67-96.48 27.14 0 55.52 4.84 55.52 4.84v61h-31.28c-30.8 0-40.41 19.12-40.41 38.73V256h68.78l-11 71.69h-57.78V501C413.31 482.38 504 379.78 504 256z"></path></svg>
                            </div>
                            <div>
                                <svg class="e-font-icon-svg e-fab-instagram" viewBox="0 0 448 512" xmlns="http://www.w3.org/2000/svg"><path d="M224.1 141c-63.6 0-114.9 51.3-114.9 114.9s51.3 114.9 114.9 114.9S339 319.5 339 255.9 287.7 141 224.1 141zm0 189.6c-41.1 0-74.7-33.5-74.7-74.7s33.5-74.7 74.7-74.7 74.7 33.5 74.7 74.7-33.6 74.7-74.7 74.7zm146.4-194.3c0 14.9-12 26.8-26.8 26.8-14.9 0-26.8-12-26.8-26.8s12-26.8 26.8-26.8 26.8 12 26.8 26.8zm76.1 27.2c-1.7-35.9-9.9-67.7-36.2-93.9-26.2-26.2-58-34.4-93.9-36.2-37-2.1-147.9-2.1-184.9 0-35.8 1.7-67.6 9.9-93.9 36.1s-34.4 58-36.2 93.9c-2.1 37-2.1 147.9 0 184.9 1.7 35.9 9.9 67.7 36.2 93.9s58 34.4 93.9 36.2c37 2.1 147.9 2.1 184.9 0 35.9-1.7 67.7-9.9 93.9-36.2 26.2-26.2 34.4-58 36.2-93.9 2.1-37 2.1-147.8 0-184.8zM398.8 388c-7.8 19.6-22.9 34.7-42.6 42.6-29.5 11.7-99.5 9-132.1 9s-102.7 2.6-132.1-9c-19.6-7.8-34.7-22.9-42.6-42.6-11.7-29.5-9-99.5-9-132.1s-2.6-102.7 9-132.1c7.8-19.6 22.9-34.7 42.6-42.6 29.5-11.7 99.5-9 132.1-9s102.7-2.6 132.1 9c19.6 7.8 34.7 22.9 42.6 42.6 11.7 29.5 9 99.5 9 132.1s2.7 102.7-9 132.1z"></path></svg>
                            </div>
                            <div>
                                <svg class="e-font-icon-svg e-fab-youtube" viewBox="0 0 576 512" xmlns="http://www.w3.org/2000/svg"><path d="M549.655 124.083c-6.281-23.65-24.787-42.276-48.284-48.597C458.781 64 288 64 288 64S117.22 64 74.629 75.486c-23.497 6.322-42.003 24.947-48.284 48.597-11.412 42.867-11.412 132.305-11.412 132.305s0 89.438 11.412 132.305c6.281 23.65 24.787 41.5 48.284 47.821C117.22 448 288 448 288 448s170.78 0 213.371-11.486c23.497-6.321 42.003-24.171 48.284-47.821 11.412-42.867 11.412-132.305 11.412-132.305s0-89.438-11.412-132.305zm-317.51 213.508V175.185l142.739 81.205-142.739 81.201z"></path></svg>
                            </div>
                            <div>
                                <svg class="e-font-icon-svg e-fab-tiktok" viewBox="0 0 448 512" xmlns="http://www.w3.org/2000/svg"><path d="M448,209.91a210.06,210.06,0,0,1-122.77-39.25V349.38A162.55,162.55,0,1,1,185,188.31V278.2a74.62,74.62,0,1,0,52.23,71.18V0l88,0a121.18,121.18,0,0,0,1.86,22.17h0A122.18,122.18,0,0,0,381,102.39a121.43,121.43,0,0,0,67,20.14Z"></path></svg>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 pad">
                    <h5>Showroom</h5>
                </div>
                <div class="col-md-3 pad">
                    <h5>Danh mục sản phẩm</h5>
                </div>
                <div class="col-md-3 pad_fake">
                    <h5>Thông tin hướng dẫn</h5>
                </div>
            </div>
            <div style="height: 50px; border-top: 3px rgb(178, 178, 178) solid;"></div>
        </div>
    </footer>


    <script
        src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous"
    ></script>

    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
        crossorigin="anonymous"
    ></script>
</body>
</html>