<?php 
session_start();
if (!isset($_SESSION["giohang"])) $_SESSION["giohang"]=[];


if (isset($_POST["product"])) {
    $ma_mau = $_POST["mamau"];
    $anh_mau = $_POST["anhmau"];
    $ten_mau = $_POST["tenmau"];
    $gia = $_POST["gia"];
    $size = $_POST["size"];
    $so_luong = $_POST["soluong"];
    $product = [$ma_mau, $anh_mau, $ten_mau, $gia, $so_luong, $size];

    // Append the new product to the existing array
    $_SESSION["giohang"][] = $product;
    session_destroy();
    var_dump($_SESSION["giohang"]);
}
?>