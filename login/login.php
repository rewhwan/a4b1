<!doctype html>
<html lang="ko">
    <head>
        <meta charset="UTF-8">
        <title>A4B1 Admin Stage</title>

        <!--Jquery 추가-->
        <script src="http://<?= $_SERVER['HTTP_HOST'] ?>/a4b1/common/js/jquery/jquery-3.5.1.min.js?ver=1"></script>

        <!--alert & toastr 라이브러리 추가-->
        <link rel="stylesheet" href="http://<?= $_SERVER['HTTP_HOST'] ?>/a4b1/common/css/toastr/toastr.min.css?ver=1"/>
        <script src="http://<?= $_SERVER['HTTP_HOST'] ?>/a4b1/common/js/toastr/toastr.min.js?ver=1"></script>
        <script src="http://<?= $_SERVER['HTTP_HOST'] ?>/a4b1/common/js/sweetalert/sweetalert.min.js?ver=1"></script>

        <!--헤더 파일 추가-->
        <link rel="stylesheet" href="http://<?= $_SERVER['HTTP_HOST'] ?>/a4b1/admin/css/admin.css?ver=1">

        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    </head>
</html>
<?php
    require $_SERVER['DOCUMENT_ROOT']."/a4b1/common/lib/db.mysqli.class.php";

    //싱글톤 객체 불러오기
    $db = DB::getInstance();
    $db->sessionStart();
    $dbcon = $db->MysqliConnect();

    if(!isset($_POST['id']) || trim($_POST['id']) == '') {
        echo "<script>alert('아이디 값이 입력되지 않았습니다.');history.go(-1);</script>";
        return;
    }

    if(!isset($_POST['password']) || trim($_POST['password']) == '') {
        echo "<script>alert('패스워드 값이 입력되지 않았습니다.');history.go(-1);</script>";
        return;
    }

    $sql = "SELECT * FROM members WHERE id = '{$_POST['id']}'";
    $result = mysqli_query($dbcon,$sql)or die('Error: ' . mysqli_error($dbcon));
    $row = mysqli_fetch_array($result);


    $password = trim($_POST['password']);
    $password = sha1($password,'b1a4');
    $password = addslashes($password);

    $sql = "SELECT * FROM members where id = '{$_POST['id']}' AND password = '{$password}';";

    $result = mysqli_query($dbcon,$sql)or die('Error: ' . mysqli_error($dbcon));
    $row = mysqli_fetch_array($result);

    if(mysqli_num_rows($result) != 1) {
        echo "<script>alert('아이디와 비밀번호가 일치하지 않습니다.');history.go(-1);</script>";
    }else {
        $_SESSION['id'] = $row['id'];
        $_SESSION['admin'] = $row['admin'];
        $_SESSION['name'] = $row['name'];

        echo "<script>alert('로그인에 성공했습니다!.\\n환영합니다! ".$_SESSION['id']."님');history.go(-2);</script>";
    }