<!doctype html>
<html lang="ko">

<head>
    <meta charset="UTF-8">
    <title>로그인 (A4B1's Game Box)</title>
    <!--Jquery 추가-->
    <script src="http://<?= $_SERVER['HTTP_HOST'] ?>/a4b1/common/js/jquery/jquery-3.5.1.min.js?ver=1"></script>
    <link rel="stylesheet" href="http://<?= $_SERVER['HTTP_HOST'] ?>/a4b1/common/css/common.css?ver=1">
    <link rel="stylesheet" href="http://<?= $_SERVER['HTTP_HOST'] ?>/a4b1/login/css/signup.css?ver=1">
    <script src="http://<?= $_SERVER['HTTP_HOST'] ?>/a4b1/login/js/signup.js"></script>

    <!--alert & toastr 라이브러리 추가-->
        <link rel="stylesheet" href="http://<?= $_SERVER['HTTP_HOST'] ?>/a4b1/common/css/toastr/toastr.min.css?ver=1"/>
        <script src="http://<?= $_SERVER['HTTP_HOST'] ?>/a4b1/common/js/toastr/toastr.min.js?ver=1"></script>
        <script src="http://<?= $_SERVER['HTTP_HOST'] ?>/a4b1/common/js/sweetalert/sweetalert.min.js?ver=1"></script>
</head>

<body>
    <header>
        <?php include $_SERVER['DOCUMENT_ROOT'] . "/a4b1/common/lib/header.php"; ?>
    </header>
    <div id="login_form_container">
        <div id="login_form">
            <h2>SIGNUP</h2>
            <form id="signup_form" name="signup_form" action="signup.php" method="POST" >
                <ul>
                    <li><label for="id">아이디</label><br><input type="text" id="id" name="id" placeholder="ID" autocomplete="off" onblur="checkID()"><br><span id="span_id"></span></li>
                    <li><label for="username">성명</label><br><input type="text" id="username" name="username" placeholder="name" autocomplete="off" onblur="checkName()"><br><span id="span_name"></span></li>
                    <li><label for="password">비밀번호</label><br><input type="password" id="password" name="password" placeholder="Password" autocomplete="off" onblur="checkPW()"><br><span id="span_pw"></span></li>
                    <li><label for="password">비밀번호 확인</label><br><input type="password" id="password_ck" name="password_ck" placeholder="password" autocomplete="off" onblur="checkPWOK()"><br><span id="span_ok"></span></li>
                    <li>
                        <label for="phone_input">전화번호</label><br>
                        <div id="phone_input">
                            <select name="phone_one" id="phone_one">
                                <option value="010" selected> 010 </option>
                                <option value="011"> 011 </option>
                            </select> -
                            <input type="number" name="phone_two" id="phone_two" placeholder=" 0000 "> -
                            <input type="number" name="phone_three" id="phone_three" placeholder=" 0000 " >
                            <input id="send_code" type="button" name="" value=" 인증번호 발송 ">
                        </div>

                        <input type="text" id="password_certification" name="password_certification" placeholder=" 인증번호 입력 " onblur="checkCode()">
                    </li>
                    <li></li>
                        <li id=""><label for="email">E-Mail</label><br><input type="text" id="email" name="email" placeholder="email" autocomplete="off" onkeypress="(event)" onblur="checkEmail()"><br><span id="span_email"></span></li>
                    <li><button id="signup" type="button" onclick="lastCheck()">회원가입</button></li>
                </ul>
            </form>
        </div>
    </div>
</body>

</html>