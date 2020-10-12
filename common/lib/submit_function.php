<?php
//알림창을 띄우고 이전페이지로 돌아가는함수
function alert_back($message)
{
    echo "
        <script>
            alert('$message');
            history.go(-1);
        </script>
        ";
    exit();
}

//공백,백슬래쉬를 없애고 특수문자를 html화 해주는 함수
function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data, ENT_QUOTES);

    return $data;
}

function file_upload($file_name, $upload_location)
{
    //파일 값들 확인하기
    //파일업로드기능
    //$_FILES['upfile']로부터 5가지 배열명을 가져와서 저장한다.
    $upload_name = $_FILES["$file_name"]['name']; //f03.jpg
    $upload_type = $_FILES["$file_name"]['type']; //image/gif  file/txt
    $upload_tmp_name = $_FILES["$file_name"]['tmp_name'];
    $upload_error = $_FILES["$file_name"]['error'];
    $upload_size = $_FILES["$file_name"]['size'];

    //오류 파악
    if($upload_error){
        switch($upload_error){
            case UPLOAD_ERR_OK: $message ="업로드 성공적";
            break;
            case UPLOAD_ERR_INI_SIZE : $message = "php.ini에 설정된 최대 파일크기 초과";
            break;
            case UPLOAD_ERR_FORM_SIZE : $message = "HTML 폼에 설정된 최대 파일크기 초과";
            break;
            case UPLOAD_ERR_PARTIAL : $message = "파일의 일부만 업로드됌";
            break;
            case UPLOAD_ERR_NO_FILE : $message = "업로드할 파일이 없음";
            break;
            case UPLOAD_ERR_NO_TMP_DIR : $message = "웹서버에 임시폴더가 없음";
            break;
            case UPLOAD_ERR_CANT_WRITE : $message = "웹서버에 파일을 쓸 수 없음";
            break;
            case UPLOAD_ERR_CANT_WRITE : $message = "웹서버에 파일을 쓸 수 없음";
            break;
            case UPLOAD_ERR_CANT_WRITE : $message = "PHP 확장기능에 의한 업로드 중단";
            break;
            default: $message="알 수 없는 오류";
            break;
        }
        alert_back('4-1. 업로드 에러 이유: '.$message);
    }
    

    $upload_dir = "$upload_location"; //업로드된파일을 저장하는장소지정
    //echo "upload_name".$upload_name."<br>";
    //파일명과 확장자를 구분해서 저장한다.
    //$file = explode(".", $upload_name); //파일명과 확장자구분에서 배열저장
    //$file_name = $file[0];             //파일명
    //$file_extension = $file[1];        //확장자
    //echo $file_extension;

    //확장자 확인을 위한 분리 배열로 리턴
    $type = explode("/", $upload_type);
    if ($type[0] == 'image') {
        switch ($type[1]) {
            case "jpg":
            case "jpeg":
            case "gif":
            case "bmp":
            case 'pjpeg':
            case 'png':
                break;
            default:
                alert_back("이미지 파일이 아닙니다. 확인해주세요");
                break;
        }
    }
    //파일명이 중복되지 않도록 임의파일명을 정한다.
    if (!$upload_error) {
        $new_file_name = date("Y_m_d_H_i_s");
        $copied_file_name = $new_file_name . "_" . "$upload_name";
        //$copied_file_name = $new_file_name . "." . $file_extension;
        $uploaded_file = $upload_dir . $copied_file_name;
        // $uploaded_file = "./data/2019_04_22_15_09_30_파일이름.확장지";
    }

    //업로드된 파일사이즈(2mb)를 체크해서 넘어버리면 돌려보낸다.
    if ($upload_size > 2000000) {
        alert_back('2-1. 이미지파일사이즈가 2MB이상입니다.');
    }

    //임시저장소에 있는 파일을 서버에 지정한 위치로 이동한다.
    if (!move_uploaded_file($upload_tmp_name, $uploaded_file)) {
        alert_back('4-1. 서버 전송 실패');
    }

    return $copied_file_name;
}

function file_upload_multi($file_name, $upload_location)
{   
    $screen_shot = [];
    $file_array = $_FILES[$file_name];
    $count = count($file_array['name']);
    //echo"<script>console.log($count);</script>";
    for ($i = 0; $i < $count; $i++) {
        //파일업로드기능
        $upload_name = $file_array['name'][$i]; //f03.jpg
        $upload_type = $file_array['type'][$i]; //image/gif  file/txt
        $upload_tmp_name = $file_array['tmp_name'][$i];
        $upload_error = $file_array['error'][$i];
        $upload_size = $file_array['size'][$i];

        //오류 파악
        if($upload_error){
            switch($upload_error){
                case UPLOAD_ERR_OK: $message ="업로드 성공적";
                break;
                case UPLOAD_ERR_INI_SIZE : $message = "php.ini에 설정된 최대 파일크기 초과";
                break;
                case UPLOAD_ERR_FORM_SIZE : $message = "HTML 폼에 설정된 최대 파일크기 초과";
                break;
                case UPLOAD_ERR_PARTIAL : $message = "파일의 일부만 업로드됌";
                break;
                case UPLOAD_ERR_NO_FILE : $message = "업로드할 파일이 없음";
                break;
                case UPLOAD_ERR_NO_TMP_DIR : $message = "웹서버에 임시폴더가 없음";
                break;
                case UPLOAD_ERR_CANT_WRITE : $message = "웹서버에 파일을 쓸 수 없음";
                break;
                case UPLOAD_ERR_CANT_WRITE : $message = "웹서버에 파일을 쓸 수 없음";
                break;
                case UPLOAD_ERR_CANT_WRITE : $message = "PHP 확장기능에 의한 업로드 중단";
                break;
                default: $message="알 수 없는 오류";
                break;
            }
            alert_back('4. 업로드 에러 이유: '.$message);
        }

        //.업로드될 폴더를 지정한다.
        $upload_dir = "$upload_location"; //업로드된파일을 저장하는장소지정
        //echo "upload_name".$upload_name."<br>";
        //파일명과 확장자를 구분해서 저장한다.
        //$file = explode(".", $upload_name); //파일명과 확장자구분에서 배열저장
        //$file_name = $file[0];             //파일명
        //$file_extension = $file[1];        //확장자
        //echo $file_extension;

        //확장자 확인을 위한 분리 배열로 리턴
        $type = explode("/", $upload_type);
        if ($type[0] == 'image') {
            switch ($type[1]) {
                case "jpg":
                case "jpeg":
                case "gif":
                case "bmp":
                case 'pjpeg':
                case 'png':
                    break;
                default:
                    alert_back("이미지 파일이 아닙니다. 확인해주세요");
                    break;
            }
        }
        //파일명이 중복되지 않도록 임의파일명을 정한다.
        if (!$upload_error) {
            $new_file_name = date("Y_m_d_H_i_s");
            $copied_file_name = $new_file_name . "_" . "$upload_name";
            //$copied_file_name = $new_file_name . "." . $file_extension;
            $uploaded_file = $upload_dir . $copied_file_name;
            // $uploaded_file = "./data/2019_04_22_15_09_30_파일이름.확장지";
        }

        //업로드된 파일사이즈(2mb)를 체크해서 넘어버리면 돌려보낸다.
        if ($upload_size > 2000000) {
            alert_back('2-2. 이미지파일사이즈가 2MB이상입니다.');
        }

        //임시저장소에 있는 파일을 서버에 지정한 위치로 이동한다.
            if (!move_uploaded_file($upload_tmp_name, $uploaded_file)) {
                alert_back('4-2. 서버 전송 실패');
            }
        array_push($screen_shot,$copied_file_name);
    }
    return $screen_shot;
}
