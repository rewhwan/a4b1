<?php
require $_SERVER['DOCUMENT_ROOT'] . "/a4b1/common/lib/db.mysqli.class.php";
include $_SERVER['DOCUMENT_ROOT'] . "/a4b1/common/lib/submit_function.php";
//싱글톤 객체 불러오기
$db = DB::getInstance();
$db->sessionStart();
$dbcon = $db->connector();

if (!isset($_SESSION['id']) && ($_SESSION['id'] != 'admin' || $_SESSION['id'] != $created_by)) {
    echo "<script>
            alert('수정권한이 없습니다')
            history.back(-1);
            </script>";
    return;
}

$num = $_POST["num"];
$page = $_POST["page"];
$name = $_POST["name"];

//review table upload
$title = $_POST["title"];
$content = $_POST["content"];

//star_point upload
$story = $_POST["story"];
$graphic = $_POST["graphic"];
$time = $_POST["time"];
$difficulty = $_POST["difficulty"];

//review_image_file upload
$new_file = $_FILES["new_file"]["name"];

//default image remove check
$screen_delete_flag = null;
if(isset($_POST['screen_select']) && $_POST['screen_select'] == 'check'){
    $screen_delete_flag = true;
}else{
    $screen_delete_flag = false;
}

$sql = "UPDATE game_review INNER JOIN game_review_point ON num = review_num SET title='$title',content='$content', story = $story,graphic = $graphic,time=$time,difficulty=$difficulty where num = $num";
mysqli_query($dbcon, $sql) or die("쿼리문 오류1 : " . mysqli_error($dbcon));

if (isset($new_file) && $new_file != null) {
    if($screen_delete_flag){
        $sql = "select * from game_review_files where review_num = {$num}";
        $result = mysqli_query($dbcon, $sql) or die("쿼리문 오류2 : " . mysqli_error($dbcon));

        //해당 리뷰에 파일이 존재하는지 확인 하는 조건문
        if (mysqli_num_rows($result) != 0) {
            //파일 삭제 반복문
            while ($row = mysqli_fetch_array($result)) {
                $file_path = "./img/" . $row['name'];
                if ($row['name'] != null) {
                    unlink($file_path);
                }
            }
        }

        //파일 삭제후 table 값 삭제
        $sql = "delete from game_review_files where review_num={$num}";
        mysqli_query($dbcon, $sql);
    }
    //오류 파악
    $count = count($_FILES['new_file']['error']);
    $upload_error_value = UPLOAD_ERR_OK;
    for ($i = 0; $i < $count; $i++) {
        if ($_FILES['new_file']['error'][$i] != UPLOAD_ERR_OK) {
            $upload_error_value = UPLOAD_ERR_NO_FILE;
        }
    }

    //스크린샷 파일이 있을 경우 실행
    if (isset($_FILES['new_file']) && $upload_error_value != UPLOAD_ERR_NO_FILE) {
        $copied_file_name = array();
        //파일업로드 함수
        $copied_file_name = file_upload_multi("new_file", "./img/");
        // echo $copied_file_name."<br>";
        for ($i = 0; $i < count($copied_file_name); $i++) {
            $sql = "INSERT into `game_review_files` values(null,'$num','$copied_file_name[$i]')";
            mysqli_query($dbcon, $sql) or die("쿼리문 오류5 : " . mysqli_error($dbcon));
        }
    }
}
echo "<script>location.href = 'view.php?num=$num&page=$page&name=$name';</script>";

mysqli_close($dbcon);
