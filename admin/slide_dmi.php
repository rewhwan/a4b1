<?php
    require $_SERVER['DOCUMENT_ROOT'] . "/a4b1/common/lib/db.mysqli.class.php";
    require $_SERVER['DOCUMENT_ROOT'] . "/a4b1/admin/message.class.php";

    //싱글톤 객체 불러오기
    $db = DB::getInstance();
    $db->sessionStart();
    $dbcon = $db->connector();

    //관리자 인지 여부 체크 -> 접근 권한
    if (!isset($_SESSION['admin']) || $_SESSION['admin'] < 1) {
        alert_back('관리자 권한이 없습니다.');
    }

    if(isset($_REQUEST['mode']) && $_REQUEST['mode']) {
        $msg = new message();
        echo $_REQUEST['mode'];
        switch($_REQUEST['mode']) {
            case 'insertSlide':
                $msg = insertSlide();
                break;
        }
        echo json_encode($msg);
        exit;
    }

    //슬라이드 사진을 추가해주는 함수
    function insertSlide() {
        $msg = new message();

        $sql = 'INSERT INTO main_slide_files VALUES ()';
        $msg->add('errorMsg',$_FILES['slide_file']);
        return $msg;
    }