<?php
require $_SERVER['DOCUMENT_ROOT'] . "/a4b1/common/lib/db.mysqli.class.php";

//싱글톤 객체 불러오기
$db = DB::getInstance();
$db->sessionStart();
$con = $db->connector();

//아이디 비밀번호 찾기 구분 변수
$find_type = $_POST["find_type"];

$returnArray = array('isSuccess' => null, 'data' => null, 'errorMsg' => null);

//아이디 찾기 처리문
if ($find_type === "id") {
    //입력받은 값을 변수로 저장
    if (isset($_POST["find_id_name"])) $name = $_POST["find_id_name"];
    else $name = "";

    if (isset($_POST["find_id_email"])) $email = $_POST["find_id_email"];
    else $email = "";

    $name = mysqli_real_escape_string($con, $name);
    $email = mysqli_real_escape_string($con, $email);

    $sql = "select * from members where name='$name' and email='$email';";
    $result = mysqli_query($con, $sql) or die(mysqliError($returnArray, mysqli_error($con)));

    //결과에 따른 반환값 설정
    if (mysqli_num_rows($result) == 0) {
        $returnArray['isSuccess'] = 0;
    } else {
        $row = mysqli_fetch_array($result);
        $returnArray['isSuccess'] = 1;
        $returnArray['data'] = $row;
    }
    echo json_encode($returnArray);

    //비밀번호 찾기 처리문
} else if ($find_type === "password") {
    if (isset($_POST["find_password_id"])) $id = $_POST["find_password_id"];
    else $id = "";

    if (isset($_POST["phone_one"])) $phone_one = $_POST["phone_one"];
    else $phone_one = "";

    if (isset($_POST["phone_two"])) $phone_two = $_POST["phone_two"];
    else $phone_two = "";

    if (isset($_POST["phone_three"])) $phone_three = $_POST["phone_three"];
    else $phone_three = "";

    $phone = $phone_one . "-" . $phone_two . "-" . $phone_three;

    $id = mysqli_real_escape_string($con, $id);
    $phone = mysqli_real_escape_string($con, $phone);

    $sql = "select * from members where id='$id' and phone='$phone';";
    $result = mysqli_query($con, $sql) or die(mysqliError($returnArray, mysqli_error($con)));

    //결과에 따른 반환값 설정
    if (mysqli_num_rows($result) == 0) {
        $returnArray['isSuccess'] = 0;
    } else {
        $row = mysqli_fetch_array($result);
        $returnArray['isSuccess'] = 1;
        $returnArray['data'] = $row;
    }
    echo json_encode($returnArray);

    //인증코드 보내기 이전에 체크
}else if ($find_type == "send_code") {
    //아이디 입력값 체크
    if (isset($_POST["find_password_id"])) $id = $_POST["find_password_id"];
    else $id = "";

    //핸드폰 번호 체크
    if (isset($_POST["phone_one"])) $phone_one = $_POST["phone_one"];
    else $phone_one = "";

    if (isset($_POST["phone_two"])) $phone_two = $_POST["phone_two"];
    else $phone_two = "";

    if (isset($_POST["phone_three"])) $phone_three = $_POST["phone_three"];
    else $phone_three = "";

    $phone = $phone_one . "-" . $phone_two . "-" . $phone_three;

    $id = mysqli_real_escape_string($con, $id);
    $phone = mysqli_real_escape_string($con, $phone);

    $sql = "select * from members where id='$id' and phone='$phone';";
    $result = mysqli_query($con, $sql) or die(mysqliError($returnArray, mysqli_error($con)));

    if (mysqli_num_rows($result) == 0) {
        $returnArray['isSuccess'] = 0;
    } else {
        $row = mysqli_fetch_array($result);
        $returnArray['isSuccess'] = 1;
        $returnArray['data'] = $row;
    }
    echo json_encode($returnArray);

    //회원가입 중복체크
} else if ($find_type == "signup_duplicate_check") {

    if (isset($_POST["input_name"])) {
        $name = $_POST["input_name"];
    } else {
        $name = "";
    }

    if (isset($_POST["email_one"])) {
        $email_one = $_POST["email_one"];
    } else {
        $email_one = "";
    }

    if (isset($_POST["email_two"])) {
        $email_two = $_POST["email_two"];
    } else {
        $email_two = "";
    }

    $name = mysqli_real_escape_string($con, $name);
    $email_one = mysqli_real_escape_string($con, $email_one);
    $email_two = mysqli_real_escape_string($con, $email_two);

    $email = $email_one . "@" . $email_two;

    $sql = "select * from members where name='$name' and email='$email';";
    $result = mysqli_query($con, $sql) or die("실패원인 : " . mysqli_error($con));

    if (mysqli_num_rows($result) == 0) {
        echo "ok";
    } else {
        $row = mysqli_fetch_array($result);
        echo "{$row['id']}";
    }
}

mysqli_close($con);

function mysqliError($returnArray, $error)
{
    $returnArray['isSuccess'] = 0;
    $returnArray['errorMsg'] = $error;
    echo json_encode($returnArray);
}

?>
