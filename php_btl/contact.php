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
        <div class = "container_contact">
            
            <h2>Liên hệ với chúng tôi</h2>
            
            <div class="contact_info">
                <div class="contact_obj">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-geo-fill" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M4 4a4 4 0 1 1 4.5 3.969V13.5a.5.5 0 0 1-1 0V7.97A4 4 0 0 1 4 3.999zm2.493 8.574a.5.5 0 0 1-.411.575c-.712.118-1.28.295-1.655.493a1.3 1.3 0 0 0-.37.265.3.3 0 0 0-.057.09V14l.002.008.016.033a.6.6 0 0 0 .145.15c.165.13.435.27.813.395.751.25 1.82.414 3.024.414s2.273-.163 3.024-.414c.378-.126.648-.265.813-.395a.6.6 0 0 0 .146-.15l.015-.033L12 14v-.004a.3.3 0 0 0-.057-.09 1.3 1.3 0 0 0-.37-.264c-.376-.198-.943-.375-1.655-.493a.5.5 0 1 1 .164-.986c.77.127 1.452.328 1.957.594C12.5 13 13 13.4 13 14c0 .426-.26.752-.544.977-.29.228-.68.413-1.116.558-.878.293-2.059.465-3.34.465s-2.462-.172-3.34-.465c-.436-.145-.826-.33-1.116-.558C3.26 14.752 3 14.426 3 14c0-.599.5-1 .961-1.243.505-.266 1.187-.467 1.957-.594a.5.5 0 0 1 .575.411"/></svg>
                    <h>TP.Hà Nội</h>
                </div>
                <div class="contact_obj">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-telephone-fill" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M1.885.511a1.745 1.745 0 0 1 2.61.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.68.68 0 0 0 .178.643l2.457 2.457a.68.68 0 0 0 .644.178l2.189-.547a1.75 1.75 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.6 18.6 0 0 1-7.01-4.42 18.6 18.6 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877z"/></svg>
                    <h>038.504.5335</h>
                </div>
                <div class="contact_obj">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-envelope-fill" viewBox="0 0 16 16"><path d="M.05 3.555A2 2 0 0 1 2 2h12a2 2 0 0 1 1.95 1.555L8 8.414zM0 4.697v7.104l5.803-3.558zM6.761 8.83l-6.57 4.027A2 2 0 0 0 2 14h12a2 2 0 0 0 1.808-1.144l-6.57-4.027L8 9.586zm3.436-.586L16 11.801V4.697z"/></svg>
                    <h>loi2003zzz@gmail.com</h>
                </div>
                <div class="contact_obj">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-messenger" viewBox="0 0 16 16"><path d="M0 7.76C0 3.301 3.493 0 8 0s8 3.301 8 7.76-3.493 7.76-8 7.76c-.81 0-1.586-.107-2.316-.307a.64.64 0 0 0-.427.03l-1.588.702a.64.64 0 0 1-.898-.566l-.044-1.423a.64.64 0 0 0-.215-.456C.956 12.108 0 10.092 0 7.76m5.546-1.459-2.35 3.728c-.225.358.214.761.551.506l2.525-1.916a.48.48 0 0 1 .578-.002l1.869 1.402a1.2 1.2 0 0 0 1.735-.32l2.35-3.728c.226-.358-.214-.761-.551-.506L9.728 7.381a.48.48 0 0 1-.578.002L7.281 5.98a1.2 1.2 0 0 0-1.735.32z"/></svg>
                    <h>messenger</h>
                </div>
            </div>
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