<?php
    require $_SERVER['DOCUMENT_ROOT']."/a4b1/common/lib/db.mysqli.class.php";

    //싱글톤 객체 불러오기
    $db = DB::getInstance();
    $db->sessionStart();
    $db->sessionDestroy();
    echo "<script>
            alert('로그아웃에 성공했습니다.');
            location.href='http://".$_SERVER['HTTP_HOST']."/a4b1/index.php'
            </script>";