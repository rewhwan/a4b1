<?php
require $_SERVER['DOCUMENT_ROOT'] . "/a4b1/common/lib/db.mysqli.class.php";
require $_SERVER['DOCUMENT_ROOT'] . "/a4b1/common/lib/submit_function.php";
require $_SERVER['DOCUMENT_ROOT'] . "/a4b1/admin/message.class.php";

//싱글톤 객체 불러오기
$db = DB::getInstance();
$db->sessionStart();

//관리자 인지 여부 체크 -> 접근 권한
if (!isset($_SESSION['admin']) || $_SESSION['admin'] != 2) {
    $msg = new message();
    $msg->error('관리자 권한 없음','관리자 권한이 없습니다.');
    echo json_encode($msg);
    exit;
}

if(isset($_REQUEST['mode']) && $_REQUEST['mode']) {
    $msg = new message();
    switch($_REQUEST['mode']) {
        case 'updatePermission':
            $msg = updatePermission($db);
            break;
        case 'deleteSlide':
            $msg = deleteSlide($db);
            break;
    }
    echo json_encode($msg);
    exit;
}

function updatePermission($db) {
    $msg = new message();
    $dbcon = $db->connector();

    //입력값 검증
    if(isset($_POST['id']) && isset($_POST['permission'])) {
        $id = $_POST['id'];
        $permission = $_POST['permission'];
    }else {
        $msg->error('서버 통신 오류','서버 통신에 오류가 발생했습니다.');
        return $msg;
    }

    switch ($permission) {
        case'일반회원':
            $admin = 0;
            break;
        case'부어드민':
            $admin = 1;
            break;
        case'어드민':
            $admin = 2;
            break;
    }

    $sql = "UPDATE members SET admin ={$admin} WHERE id = '{$id}';";
    mysqli_query($dbcon,$sql) or die($msg->add('errorMsg',mysqli_error($dbcon)));

    //성공메시지 반환
    $msg->add('successMsg','권한 수정에 성공했습니다.');
    return $msg;
}