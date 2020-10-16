<?php
//DB 가져오기
date_default_timezone_set("Asia/Seoul");
require $_SERVER['DOCUMENT_ROOT'] . "/a4b1/common/lib/db.mysqli.class.php";
include $_SERVER['DOCUMENT_ROOT'] . "/a4b1/common/lib/submit_function.php";
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

//리뷰 내용 테이블 추가
$sql = "insert into game_review(name, title, content, created_at, created_by, hit)";
$sql .= "values('$name','$title','$content',now(),'$userid',0)";
mysqli_query($con, $sql) or die("DB 오류 : Error.Code = 1".mysqli_error($con));

$sql = "SELECT * FROM game_review WHERE created_by = '".$userid."' AND content = '".$content."' ORDER BY num DESC;";
$result = mysqli_query($con, $sql) or die("DB 오류 : Error.Code = 2".mysqli_error($con));

if(mysqli_num_rows($result) != 0) $result_array = mysqli_fetch_array($result);
$resultNum = $result_array['num'];

// 별점 DB 추가
$sql = "insert into game_review_point(review_num,story, graphic, time, difficulty)";
$sql .= "values($resultNum,'$story','$graphic','$time','$difficulty')";
mysqli_query($con, $sql) or die("DB 오류 : Error.Code = 3".mysqli_error($con));;


//스크린샷 파일이 있을 경우 실행
if(isset($_FILES['new_file']) && $_FILES['new_file']['error'] != UPLOAD_ERR_NO_FILE){
    $copied_file_name = array();
    //파일업로드 함수
    $copied_file_name = file_upload_multi("new_file","./img/");
    for($i=0; $i<count($copied_file_name); $i++){
        $sql = "INSERT into game_review_files values(null,$resultNum,'$copied_file_name[$i]')";
        mysqli_query($con,$sql) or die("쿼리문 오류5 : ".mysqli_error($con));
    }
}


//db연결 끊기
mysqli_close($con);

// 완료후 돌아가기
echo "
	   <script>
	    location.href = 'index.php';
	   </script>
	";
?>