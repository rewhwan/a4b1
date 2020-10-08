<?php
//DB 가져오기
date_default_timezone_set("Asia/Seoul");
require $_SERVER['DOCUMENT_ROOT'] . "/a4b1/common/lib/db.mysqli.class.php";
include $_SERVER['DOCUMENT_ROOT'] . "/a4b1/game_info/function.php";
//싱글톤 객체 불러오기
$db = DB::getInstance();
$db->sessionStart();
$con = $db->connector();

//SESSION 값에 id 가있는지 확인하기 
if (isset($_SESSION['id'])) $userid = $_SESSION['id'];
else $userid = "";

//로그인 상태인지 점검
if (!$userid) {
    alert_back("로그인후 이용하세요.");
}

//review table upload
$name = $_POST["name"];
$title = $_POST["title"];
$content = $_POST["content"];


//star_point upload
$story = $_POST["story"];
$graphic = $_POST["graphic"];
$time = $_POST["time"];
$difficulty = $_POST["difficulty"];


//file 저장하기
$copied_file_name = file_upload_multi("file", "./data/");

echo "alert($uploaded_file)";

//review table insert
$sql = "insert into game_review(name, title, content, created_at, created_by)";
$sql .= "values('$name','$title','$content',now(),'$userid')";
mysqli_query($con, $sql);

if(isset($_FILES['screen_shot']) && $_FILES['screen_shot']['error'] != UPLOAD_ERR_NO_FILE){
    $copied_file_name = array();
    //파일업로드 함수
    $copied_file_name = file_upload_multi("screen_shot","./img/");
    for($i=0; $i<count($copied_file_name); $i++){
        $sql = "INSERT into `game_review_files` values(null,'$num','$copied_file_name[$i]')";
        mysqli_query($dbcon,$sql) or die("쿼리문 오류5 : ".mysqli_error($dbcon));
    }
}

// review_point table insert
$sql = "insert into game_review_point(story, graphic, time, difficulty)";
$sql .= "values('$story','$graphic','$time','$difficulty')";
mysqli_query($con, $sql);

//db연결 끊기
mysqli_close($con);

// 완료후 돌아가기
echo "
	   <script>
	    location.href = 'index.php';
	   </script>
	";
?>