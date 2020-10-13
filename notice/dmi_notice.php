<?php
require $_SERVER['DOCUMENT_ROOT'] . "/a4b1/common/lib/db.mysqli.class.php";
include $_SERVER['DOCUMENT_ROOT'] . "/a4b1/common/lib/submit_function.php";

//싱글톤 객체 불러오기
$db = DB::getInstance();
$db->sessionStart();
$dbcon = $db->connector();

if (isset($_POST['mode']) && $_POST['mode'] == "insert") {


    $title = $_POST['title'];
    $content = $_POST['content'];

    $title = test_input($title);
    $content = test_input($content);

//현재의 날짜와 시간을 저장
    $created_at = date("y-m-d (h:i)");

//첨부 파일을 임시로 저장할 경로를 설정해준다.
    $upload_dir = './data/';

    $file_name = $_FILES['upfile']['name'];
    $file_type = $_FILES['upfile']['type'];

    $created_by = $_SESSION['id'];

    if (isset($_FILES['upfile']) && $_FILES['upfile']['error'] != UPLOAD_ERR_NO_FILE) {
        $copied_file_name = file_upload("upfile", "./data/");
        $sql = "insert into notice values(null,'$title','$content','$file_name','$file_type','$copied_file_name',0,'$created_by',now())";
    } else $sql = "insert into notice values(null,'$title','$content',null,null,null,0,'$created_by',now())";

    if (isset($_POST['cb'])) {
        $sql = "insert into notice_urgent value(null,'$title','$content','$file_name','$file_type','$copied_file_name',0,
'$created_by',now())";
    } else {
        $sql = "insert into notice values(null,'$title','$content','$file_name','$file_type','$copied_file_name',0,'$created_by',now())";
    }
    mysqli_query($dbcon, $sql) or die("쿼리문 오류1 : " . mysqli_error($dbcon));

    echo "<script>
             location.href = 'index.php';
      </script>";
}

if (isset($_POST['mode']) && $_POST['mode'] == "modify") {
    $num = $_POST['num'];
    $page = $_POST['page'];

    $title = $_POST['title'];
    $content = $_POST['content'];

    $upload_dir = "./data/";
    $sql = "select *  from notice";
    $result = mysqli_query($dbcon, $sql);
    $row = mysqli_fetch_array($result);

    $upload_dir = './data/';

    $file_name = $_FILES['upfile']['name'];
    $file_type = $_FILES['upfile']['type'];

    $created_by = $_SESSION['id'];

    if (isset($_FILES['upfile']) && $_FILES['upfile']['error'] != UPLOAD_ERR_NO_FILE) {
        $copied_file_name = file_upload("upfile", "./data/");
        $sql = "update notice set title='$title',content = '$content',file_name='$file_name'";
        $sql .= " where num=$num";
    } else {
        $sql = "update notice set title='$title',content = '$content'";
        $sql .= " where num = $num";
    }
    echo "<script>location.href = 'index.php'</script>";

    mysqli_query($dbcon, $sql) or die("쿼리문 오류1 : " . mysqli_error($dbcon));

    exit;
}

if (isset($_POST['mode']) && $_POST['mode'] == "delete") {

    $num = $_POST['num'];
    $page = $_POST['page'];

    //파일 삭제하는 로직 추가
    if (isset($_POST['urgent']) && $_POST['urgent'] == 't') $sql = "SELECT * FROM notice_urgent WHERE num = {$num}";
    else $sql = "SELECT * FROM notice WHERE num = {$num}";
    $result = mysqli_query($dbcon, $sql) or die("쿼리문 오류1 : " . mysqli_error($dbcon));
    $row = mysqli_fetch_assoc($result);
    //파일삭제
    unlink("./data/" . $row['file_copied']);

    if (isset($_POST['urgent']) && $_POST['urgent'] == 't') $sql = "delete from notice_urgent where num = '$num'";
    else $sql = "delete from notice where num = '$num'";

    mysqli_query($dbcon, $sql) or die("쿼리문 오류1 : " . mysqli_error($dbcon));
    mysqli_close($dbcon);

    echo "<script>alert('삭제 왼료되었습니다.')</script>";

    echo "<script>location.href = 'index.php';</script>";
    exit;
} else {
    echo "<script>
                         alert('삭제중 오류 발생!');
                      </script>";
}
?>