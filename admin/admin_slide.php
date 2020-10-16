<?php
require $_SERVER['DOCUMENT_ROOT'] . "/a4b1/common/lib/db.mysqli.class.php";

//싱글톤 객체 불러오기
$db = DB::getInstance();
$db->sessionStart();
$dbcon = $db->connector();

//관리자 인지 여부 체크 -> 접근 권한
if(!isset($_SESSION['admin']) || $_SESSION['admin'] < 1) {
    echo "<script>alert('접근 권한이 없습니다.')</script>";
}
?>
<!doctype html>
<html lang="ko">
    <head>
        <meta charset="UTF-8">
        <title>A4B1 Admin Stage</title>

        <!--Jquery 추가-->
        <script src="http://<?= $_SERVER['HTTP_HOST'] ?>/a4b1/common/js/jquery/jquery-3.5.1.min.js?ver=1"></script>

        <!--alert & toastr 라이브러리 추가-->
        <link rel="stylesheet" href="http://<?= $_SERVER['HTTP_HOST'] ?>/a4b1/common/css/toastr/toastr.min.css?ver=1"/>
        <script src="http://<?= $_SERVER['HTTP_HOST'] ?>/a4b1/common/js/toastr/toastr.min.js?ver=1"></script>
        <script src="http://<?= $_SERVER['HTTP_HOST'] ?>/a4b1/common/js/sweetalert/sweetalert.min.js?ver=1"></script>

       <!--헤더 파일 추가-->
       <link rel="stylesheet" href="http://<?= $_SERVER['HTTP_HOST'] ?>/a4b1/admin/css/admin.css?ver=1">
       <script src="http://<?= $_SERVER['HTTP_HOST'] ?>/a4b1/admin/js/admin.js?ver=1"></script>

        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    </head>
    <body id="body">
        <?php include $_SERVER['DOCUMENT_ROOT'] . "/a4b1/admin/admin_menu.php"?>
        <div id="slide_content">
            <h2>메인페이스 슬라이드쇼 사진 관리</h2>
            <ul id="image_content">
                <?php
                    $sql = 'SELECT * FROM main_slide_files ORDER BY num ASC';
                    $result = mysqli_query($dbcon,$sql);
                    $resultArray = mysqli_fetch_all($result);

                    for($i=1;$i<=count($resultArray);$i++) {
                        if($i%3 == 1) echo "<li> ";
                            echo "
                                <div id='slide_card'>
                                    <div id='slide_image_container'>
                                        <img class='slide_preview' src='http://".$_SERVER['HTTP_HOST']."/a4b1/main/slide/".$resultArray[$i-1][1]."'>
                                    </div>
                                    <div id='slide_menu_container'>
                                        <span>".$i."</span>
                                        <span id='image_title'>".$resultArray[$i-1][1]."</span>
                                        <img class='cursor_pointer' onclick='delete_slide(".$resultArray[$i-1][0].")' src='http://".$_SERVER['HTTP_HOST']."/a4b1/main/img/delete.png'>
                                    </div>
                                </div>
                            ";
                        if($i%3 == 0) echo "</li>";

                    }
                ?>
            </ul>
        </div>
    </body>

    <div id="insert_form">
        <h2>슬라이드쇼 사진 추가</h2>
        <div id="insert_form_container">
            <form id="insert_slide" method="post">
                파일추가 : <input type="file" id="slide_file" name="slide_file[]" multiple accept="image/*">
                <input type="hidden" name="mode" value="insertSlide">
                <button type="button" onclick="submit_slide()">추가</button>
            </form>
        </div>
    </div>
</html>
