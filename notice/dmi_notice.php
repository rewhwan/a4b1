<?php
header('Content-Type: text/html; charset=utf-8');

require $_SERVER['DOCUMENT_ROOT'] . "/a4b1/common/lib/db.mysqli.class.php";
include $_SERVER['DOCUMENT_ROOT'] . "/a4b1/common/lib/submit_function.php";

//싱글톤 객체 불러오기
$db = DB::getInstance();
$db->sessionStart();
$dbcon = $db->connector();

//권한체크
if(!isset($_SESSION['admin']) || $_SESSION['admin']<1) echo alert_back("관리자 권한이 없습니다.");

if (isset($_POST['mode']) && $_POST['mode'] == "insert") {


    $title = $_POST['title'];
    $content = $_POST['content'];

    $title = test_input($title);
    $content = test_input($content);

    if ($title == "") {
        echo "<script>alert('제목이 입력되지않았습니다.');history.go(-1);</script>";
        exit;
    }


//현재의 날짜와 시간을 저장
    $created_at = date("y-m-d (h:i)");

//첨부 파일을 임시로 저장할 경로를 설정해준다.
    $upload_dir = './data/';

    $file_name = $_FILES['upfile']['name'];
    $file_type = $_FILES['upfile']['type'];

    $created_by = $_SESSION['id'];

    //긴급공지사항인지 여부 분기점
    if(isset($_POST['cb'])) {
        //파일을 같이 등록했는지 여부 분기점
        if (isset($_FILES['upfile']) && $_FILES['upfile']['error'] != UPLOAD_ERR_NO_FILE) {
            $copied_file_name = file_upload("upfile", "./data/");
            $sql = "insert into notice_urgent values(null,'$title','$content','$file_name','$file_type','$copied_file_name',0,'$created_by',now())";
        }else $sql = "insert into notice_urgent values(null,'$title','$content',null,null,null,0,'$created_by',now())";
    }else {
        if (isset($_FILES['upfile']) && $_FILES['upfile']['error'] != UPLOAD_ERR_NO_FILE) {
            $copied_file_name = file_upload("upfile", "./data/");
            $sql = "insert into notice values(null,'$title','$content','$file_name','$file_type','$copied_file_name',0,'$created_by',now())";
        }else $sql = "insert into notice values(null,'$title','$content',null,null,null,0,'$created_by',now())";
    }

    mysqli_query($dbcon, $sql) or die("쿼리문 오류1 : " . mysqli_error($dbcon));

//    system("chmod -R 000 ./data");
//    echo shell_exec('whoami');
    echo "<script>location.href = 'index.php';</script>";
    exit;
}

//수정 기능
if (isset($_POST['mode']) && $_POST['mode'] == "modify") {
    $num = $_POST['num'];
    $page = $_POST['page'];

    $title = $_POST['title'];
    $content = $_POST['content'];

    $upload_dir = "./data/";

    $title = test_input($title);

    if ($title == "") {
        echo "<script>alert('제목이 입력되지않았습니다.');history.go(-1);</script>";
        exit;
    }

    if(isset($_POST['urgent']) && $_POST['urgent'] == 't') $sql = "SELECT * FROM notice_urgent WHERE num = {$num}";
    else $sql = "select *  from notice where num = {$num}";

    $result = mysqli_query($dbcon, $sql) or die("쿼리문 오류1 : " . mysqli_error($dbcon));
    $row = mysqli_fetch_assoc($result);

    $upload_dir = './data/';

    $file_name = $_FILES['upfile']['name'];
    $file_type = $_FILES['upfile']['type'];

    $created_by = $_SESSION['id'];

    //새로운 파일 등록여부 확인
    if (isset($_FILES['upfile']) && $_FILES['upfile']['error'] != UPLOAD_ERR_NO_FILE) {
        //원래 파일이 존재했으면 삭제 한다.
        if(isset($row['file_copied']) && $row['file_copied']) unlink($upload_dir.$row['file_copied']);
        $copied_file_name = file_upload("upfile", "./data/");

        if(isset($_POST['urgent']) && $_POST['urgent'] == 't') $sql = "update notice_urgent set title='$title',content = '$content',file_name='$file_name',file_type='$file_type',file_copied='$copied_file_name'";
        else $sql = "update notice set title='$title',content = '$content',file_name='$file_name',file_name='$file_name',file_type='$file_type',file_copied='$copied_file_name'";
        $sql .= " where num=$num";
    } else {
        if(isset($_POST['urgent']) && $_POST['urgent'] == 't') $sql = "update notice_urgent set title='$title',content = '$content'";
        else $sql = "update notice set title='$title',content = '$content'";
        $sql .= " where num = $num";
    }
    mysqli_query($dbcon, $sql) or die("쿼리문 오류1 : " . mysqli_error($dbcon));

    echo "<script>location.href = 'index.php'</script>";
    exit;
}
//삭제기능
if (isset($_POST['mode']) && $_POST['mode'] == "delete") {

    $num = $_POST['num'];
    $page = $_POST['page'];

    //파일 삭제하는 로직 추가
    if (isset($_POST['urgent']) && $_POST['urgent'] == 't') $sql = "SELECT * FROM notice_urgent WHERE num = {$num}";
    else $sql = "SELECT * FROM notice WHERE num = {$num}";
    $result = mysqli_query($dbcon, $sql) or die("쿼리문 오류1 : " . mysqli_error($dbcon));
    $row = mysqli_fetch_assoc($result);

    //파일삭제
    if(isset($row['file_copied']) && $row['file_copied']) unlink("./data/" . $row['file_copied']);

    if (isset($_POST['urgent']) && $_POST['urgent'] == 't') $sql = "delete from notice_urgent where num = '$num'";
    else $sql = "delete from notice where num = '$num'";

    mysqli_query($dbcon, $sql) or die("쿼리문 오류1 : " . mysqli_error($dbcon));
    mysqli_close($dbcon);

    echo "<script>alert('삭제 왼료되었습니다.')</script>";

    echo "<script>location.href = 'index.php';</script>";
    exit;
}
?>