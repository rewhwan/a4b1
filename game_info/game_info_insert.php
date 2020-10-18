<?php
session_start();
//설정한 지역의 시간대로 설정
date_default_timezone_set("Asia/Seoul");
require $_SERVER['DOCUMENT_ROOT'] . "/a4b1/common/lib/db.mysqli.class.php";
include $_SERVER['DOCUMENT_ROOT']."/a4b1/common/lib/submit_function.php";
//싱글톤 객체 불러오기
$db = DB::getInstance();
$dbcon = $db->connector();

//세션 값 이용 관리자 인지 파악하기
if (!isset($_SESSION['admin'])||!isset($_SESSION['id']) || $_SESSION['admin'] < 1) {
    alert_back("권한이 없습니다.");
}
//값 검정하기

//값들 저장하기
$name = $_POST['name'];
$platform = $_POST['platform'];
$developer = $_POST['developer'];
//배열 받아올때는 name에[]들어가도 없애고 받는다.
$genre = $_POST['genre'];
$open_day = $_POST['open_day'];
$grade = $_POST['grade'];
$circulation = $_POST['circulation'];
$service_kor = $_POST['service_kor'];
//정수로 변환
$service_kor = intval($service_kor);
$price = $_POST['price'];
//정수로 변환
$price = intval($price);
$homepage = $_POST['homepage'];
$content = $_POST['content'];
$create_at = date("Y-m-d H:i:s");
$content = test_input($content);

//업로드 한 사람 이름 등록
$create_by = $_SESSION['id'];
//오류 파악
$upload_error1 = $_FILES['title_image']['error'];
if($upload_error1 != null){
    if($upload_error1 != 0 && $upload_error1 != 4){
        switch($upload_error1){
            case UPLOAD_ERR_INI_SIZE : $message = "php.ini에 설정된 최대 파일크기 초과";
            break;
            case UPLOAD_ERR_FORM_SIZE : $message = "HTML 폼에 설정된 최대 파일크기 초과";
            break;
            case UPLOAD_ERR_PARTIAL : $message = "파일의 일부만 업로드됌";
            break;
            case UPLOAD_ERR_NO_TMP_DIR : $message = "웹서버에 임시폴더가 없음";
            break;
            case UPLOAD_ERR_CANT_WRITE : $message = "웹서버에 파일을 쓸 수 없음";
            break;
            case UPLOAD_ERR_EXTENSION : $message = "PHP 확장기능에 의한 업로드 중단";
            break;
            default: $message=$upload_error1;
            break;
        }
        alert_back("game_info_insert_error1 :".$message);
    }
}
//파일업로드 함수
if(isset($_FILES['title_image']) && $upload_error1 != 4){
    $copied_file_name=file_upload("title_image","./img/title/");
    //db 등록을 위한 쿼리문 작성
    $sql = "INSERT into `game_info` values(null,'$name','$content','$developer','$grade','$open_day','$price','$homepage','$service_kor','$circulation','$copied_file_name','$create_by',now(),0)";
}else{
    $sql = "INSERT into `game_info` values(null,'$name','$content','$developer','$grade','$open_day','$price','$homepage','$service_kor','$circulation',null,'$create_by',now(),0)";
}
//쿼리문 실행.
mysqli_query($dbcon,$sql) or die("쿼리문 오류1 : ".mysqli_error($dbcon));
$sql = "SELECT `num` from `game_info` where `name` ='$name'";
$result = mysqli_query($dbcon, $sql) or die("쿼리문 오류2 : ".mysqli_error($dbcon));
$num = "";
while($row = mysqli_fetch_array($result)){
    $num = $row['num'];
}

for($i=0; $i<count($genre); $i++){
    $sql = "INSERT into `game_info_genre` values(null,'$num','$genre[$i]')";
    mysqli_query($dbcon,$sql) or die("쿼리문 오류3 : ".mysqli_error($dbcon));
}

for($i=0; $i<count($platform); $i++){
    $sql = "INSERT into `game_info_platform` values(null,'$num','$platform[$i]')";
    mysqli_query($dbcon,$sql) or die("쿼리문 오류4 : ".mysqli_error($dbcon));
}
//오류 파악
//echo"<script>console.log($count);</script>";
$upload_error_value = null;
if($_FILES['screen_shot']['name'][0] != null){
    $count = count($_FILES['screen_shot']['error']);
    for($i=0; $i<$count; $i++){
        $upload_error_value = $_FILES['screen_shot']['error'][$i];
        if($upload_error_value !=0 && $upload_error_value !=4){
        switch($upload_error_value){
            case UPLOAD_ERR_INI_SIZE : $message = "php.ini에 설정된 최대 파일크기 초과";
            break;
            case UPLOAD_ERR_FORM_SIZE : $message = "HTML 폼에 설정된 최대 파일크기 초과";
            break;
            case UPLOAD_ERR_PARTIAL : $message = "파일의 일부만 업로드됌";
            break;
            case UPLOAD_ERR_NO_TMP_DIR : $message = "웹서버에 임시폴더가 없음";
            break;
            case UPLOAD_ERR_CANT_WRITE : $message = "웹서버에 파일을 쓸 수 없음";
            break;
            case UPLOAD_ERR_EXTENSION : $message = "PHP 확장기능에 의한 업로드 중단";
            break;
            default: $message="알 수 없는 오류";
            break;
        }
        alert_back("game_info_insert_error2 :".$message);
        }
        
    }
}
// echo$_FILES['screen_shot']['name'][0];

//스크린샷 파일이 있을 경우 실행
if(isset($_FILES['screen_shot']) && $upload_error_value != 4 && $_FILES['screen_shot']['name'][0] != null){
    $copied_file_name = array();
    //파일업로드 함수
    $copied_file_name = file_upload_multi("screen_shot","./img/screen/");
    //echo $copied_file_name."<br>";
    //echo count($copied_file_name);
    for($i=0; $i<count($copied_file_name); $i++){
        $sql = "INSERT into `game_info_files` values(null,'$num','$copied_file_name[$i]')";
        mysqli_query($dbcon,$sql) or die("쿼리문 오류5 : ".mysqli_error($dbcon));
    }
}
mysqli_close($dbcon);
echo "<script>location.href='./game_info_list.php';</script>";


