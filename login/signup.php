<?php
//DB 가져오기
date_default_timezone_set("Asia/Seoul");
require $_SERVER['DOCUMENT_ROOT'] . "/a4b1/common/lib/db.mysqli.class.php";
include $_SERVER['DOCUMENT_ROOT'] . "/a4b1/common/lib/submit_function.php";
//싱글톤 객체 불러오기
$db = DB::getInstance();
$db->sessionStart();
$con = $db->connector();

    //signup_form 으로부터 온 회원 가입정보
    $user_id = $_POST['id'];
    $user_name = $_POST['username'];
    $user_pw = $_POST['password'];

    //user pw 값 암호화
    $user_pw = sha1($user_pw,'b1a4');

    echo $user_pw;
    echo "데이터 타입<br>";
    echo gettype($user_pw);
    echo "<br>";

    $user_phone_one = $_POST['phone_one'];
    $user_phone_two = $_POST['phone_two'];
    $user_phone_three = $_POST['phone_three'];

    $email =  $_POST['email'];

    $user_phone_number = "$user_phone_one"."-"."$user_phone_two"."-"."$user_phone_three";

    $sql = "INSERT into members(id,password,name,phone,email,admin,created_at)";
    $sql .= "values('$user_id','$user_pw','$user_name','$user_phone_number','$email',0,now())";
    
    mysqli_query($con,$sql)or die("member insert error: ".mysqli_error($con));

    mysqli_close($con);

    echo "
	   <script>
	    location.href = './index.php';
	   </script>
	";
?>