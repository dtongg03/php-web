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
if(isset($_POST["input_search"])){
    connect();
    $conn = conn();
    $input = $_POST['input_search'];

    $sql= "SELECT ma_mau, anh_mau, ten_mau FROM mau WHERE ten_mau LIKE '%$input%'";
    $result = $conn->query( $sql );
    if($result->num_rows == 0){
        echo"<h6 class='text-danger text-center mt-3'>Không tìm thấy</h6>"; 
        
    }
    
    while($row = $result->fetch_assoc()){ 
        echo'<a href="../php_btl/chitietsanpham.php?ma_mau='.$row["ma_mau"].'">
            <div class="search_card">
                <h>'.$row["ten_mau"].'</h>
                <img src="'.$row["anh_mau"].'" width=20%>
            </div>
        </a>';
    
    }
}
$conn->close();
?>