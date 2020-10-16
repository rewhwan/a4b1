<?php
    require $_SERVER['DOCUMENT_ROOT'] . "/a4b1/common/lib/db.mysqli.class.php";
    require $_SERVER['DOCUMENT_ROOT'] . "/a4b1/common/lib/submit_function.php";
    require $_SERVER['DOCUMENT_ROOT'] . "/a4b1/admin/message.class.php";

    //싱글톤 객체 불러오기
    $db = DB::getInstance();
    $db->sessionStart();

    //관리자 인지 여부 체크 -> 접근 권한
    if (!isset($_SESSION['admin']) || $_SESSION['admin'] < 1) {
        $msg = new message();
        $msg->error('관리자 권한 없음','관리자 권한이 없습니다.');
        echo json_encode($msg);
        exit;
    }

    if(isset($_REQUEST['mode']) && $_REQUEST['mode']) {
        $msg = new message();
        switch($_REQUEST['mode']) {
            case 'insertSlide':
                $msg = insertSlide($db);
                break;
            case 'deleteSlide':
                $msg = deleteSlide($db);
                break;
        }
        echo json_encode($msg);
        exit;
    }

    //슬라이드 사진을 추가해주는 함수
    function insertSlide($db) {
        $msg = new message();
        $dbcon = $db->connector();

        //파일 등록 오류 파악
        $count = count($_FILES['slide_file']['error']);
        $upload_error_value = UPLOAD_ERR_OK;
        for($i=0; $i<$count; $i++){
            if($_FILES['slide_file']['error'][$i] != UPLOAD_ERR_OK) {
                $upload_error_value = UPLOAD_ERR_NO_FILE;
            }
        }

        //파일에 문제가 있을때 -> 에러메시지 처리, 문제가 없을때 -> 파일 업로드
        if(isset($_FILES['slide_file']) && $upload_error_value != UPLOAD_ERR_NO_FILE) {
            //파일업로드 함수
            $copied_file_name = file_upload_multi("slide_file","../main/slide/");

            //DB 내용 추가
            for($i=0; $i<count($copied_file_name); $i++){
                $sql = "INSERT INTO main_slide_files values(null,'$copied_file_name[$i]')";
                mysqli_query($dbcon,$sql) or die($db->add('errorMsg',mysqli_error($dbcon)));
            }

            //성공 메시지 처리
            $msg->add('successMsg','파일 업로드에 성공했습니다.');
        }else $msg->error($_FILES['slide_file']['error'],'파일 삭제에 문제가 생겼습니다.');

        return $msg;
    }

    //슬라이드 사진을 삭제해주는 함수
    function deleteSlide($db) {
        $msg = new message();
        $dbcon = $db->connector();

        if(isset($_POST['no'])) {
            $sql = "DELETE FROM main_slide_files WHERE num = ".$_POST['no'].";";
            mysqli_query($dbcon,$sql) or die($db->add('errorMsg',mysqli_error($dbcon)));
        }else $db->error('삭제 정보 없음','삭제 처리를 하는데 오류가 발생했습니다. 새로고침이후 다시 이용해 주십시오.');

        //성공 메시지 처리
        $msg->add('successMsg','파일 삭제에 성공했습니다.');
        return $msg;
    }