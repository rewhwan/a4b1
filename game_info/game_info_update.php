<?php
//설정한 지역의 시간대로 설정
date_default_timezone_set("Asia/Seoul");
require $_SERVER['DOCUMENT_ROOT'] . "/a4b1/common/lib/db.mysqli.class.php";
include $_SERVER['DOCUMENT_ROOT']."/a4b1/common/lib/submit_function.php";
//싱글톤 객체 불러오기
$db = DB::getInstance();
$dbcon = $db->connector();

//세션 값 이용 관리자 인지 파악하기
if (!isset($_SESSION['id']) || !$_SESSION['id'] == "admin") {
    alert_back("권한이 없습니다.");
}
//값 검정하기
$num = $_GET['num'];
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
$created_at = date("Y-m-d H:i:s");
$content = test_input($content);

//업로드 한 사람 이름 등록
$created_by = $_SESSION['id'];

//타이틀이미지 해제
$sql="SELECT * from `game_info` where `num` = $num";
$result = mysqli_query($dbcon,$sql) or die("game_info_update_error1: ".mysqli_error($dbcon));
//echo mysqli_num_rows($result);
if(mysqli_num_rows($result) != 0) {
    //파일 삭제 반복문
    while($row = mysqli_fetch_array($result)) {
        $file_path = "./img/title/".$row['name'];
        unlink($file_path);
    }
}

//이미지 해제
$sql = "SELECT * from `game_info_files` where `info_num` = {$num}";
$result = mysqli_query($dbcon,$sql) or die("game_info_update_error2 : ".mysqli_error($dbcon));

//해당 정보에 관한 파일이 존재하는지 확인 하는 조건문
//echo mysqli_num_rows($result);
if(mysqli_num_rows($result) != 0) {
    //파일 삭제 반복문
    while($row = mysqli_fetch_array($result)) {
        $file_path = "./img/screen/".$row['name'];
        unlink($file_path);
    }
    $sql="DELETE from `game_info_files` where `info_num` = $num";
    $result = mysqli_query($dbcon,$sql) or die("game_info_update_error2-1 : ".mysqli_error($dbcon));
}

//오류 파악
$upload_error1 = $_FILES['title_image']['error'];

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
//파일업로드 함수
if(isset($_FILES['title_image']) && $upload_error1  != 4){
    $copied_file_name=file_upload("title_image","./img/title/");
    //db 등록을 위한 쿼리문 작성
    $sql = "UPDATE  `game_info` set name='$name',content='$content',developer='$developer',grade='$grade',release_date='$open_day',price='$price',homepage='$homepage',service_kor='$service_kor',circulation='$circulation',image='$copied_file_name',created_by='$created_by',created_at=now() where `num`= $num";
}else{
    $sql = "UPDATE  `game_info` set name='$name',content='$content',developer='$developer',grade='$grade',release_date='$open_day',price='$price',homepage='$homepage',service_kor='$service_kor',circulation='$circulation',image=null,created_by='$created_by',created_at=now() where `num`= $num";
}
//쿼리문 실행.
mysqli_query($dbcon,$sql) or die("game_info_update_error3 : ".mysqli_error($dbcon));

for($i=0; $i<count($genre); $i++){
    $sql = "UPDATE  `game_info_genre` set genre='$genre[$i]' where `info_num` = $num";
    mysqli_query($dbcon,$sql) or die("game_info_update_error5 : ".mysqli_error($dbcon));
}

for($i=0; $i<count($platform); $i++){
    $sql = "UPDATE  `game_info_platform` set platform='$platform[$i]' where `info_num` = $num";
    mysqli_query($dbcon,$sql) or die("game_info_update_error6 : ".mysqli_error($dbcon));
}
//오류 파악
$count = count($_FILES['screen_shot']['error']);
$upload_error_value = null;
for($i=0; $i<$count; $i++){
    $upload_error2 = $_FILES['screen_shot']['error'][$i];
    $upload_error_value = $upload_error2;
    if($upload_error2[$i] !=0 && $upload_error2[$i] !=4){
    switch($upload_error2[$i]){
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
//스크린샷 파일이 있을 경우 실행
if(isset($_FILES['screen_shot']) && $upload_error_value != 4){
    echo"<script>console.log('들어왔다.');</script>";
    $copied_file_name = array();
    //파일업로드 함수
    $copied_file_name = file_upload_multi("screen_shot","./img/screen/");
    for($i=0; $i<count($copied_file_name); $i++){
        //$sql = "UPDATE `game_info_files` set name='$copied_file_name[$i]' where `info_num` = $num";
        $sql = "INSERT into `game_info_files` values(null,'$num','$copied_file_name[$i]')";
        mysqli_query($dbcon,$sql) or die("game_info_update_error7 : ".mysqli_error($dbcon));
    }
    
}
mysqli_close($dbcon);
echo "<script>location.href='./game_info_view.php?num=$num';</script>";