<!doctype html>
<html lang="ko">
    <head>
        <meta charset="UTF-8">
        <title>로그인 (A4B1's Game Box)</title>

        <!--Jquery 추가-->
        <script src="http://<?= $_SERVER['HTTP_HOST'] ?>/a4b1/common/js/jquery/jquery-3.5.1.min.js?ver=1"></script>

        <!--alert & toastr 라이브러리 추가-->
        <link rel="stylesheet" href="http://<?= $_SERVER['HTTP_HOST'] ?>/a4b1/common/css/toastr/toastr.min.css?ver=1"/>
        <script src="http://<?= $_SERVER['HTTP_HOST'] ?>/a4b1/common/js/toastr/toastr.min.js?ver=1"></script>
        <script src="http://<?= $_SERVER['HTTP_HOST'] ?>/a4b1/common/js/sweetalert/sweetalert.min.js?ver=1"></script>

        <link rel="stylesheet" href="http://<?=$_SERVER['HTTP_HOST']?>/a4b1/common/css/common.css?ver=1">
        <link rel="stylesheet" href="http://<?=$_SERVER['HTTP_HOST']?>/a4b1/login/css/login.css?ver=1">
        <script src="http://<?=$_SERVER['HTTP_HOST']?>/a4b1/login/js/login.js"></script>
    </head>
    <body>
        <header>
            <?php include $_SERVER['DOCUMENT_ROOT']."/a4b1/common/lib/header.php";?>
        </header>
        <div id="login_form_container">
            <div id="login_form">
                <h2>LOGIN</h2>
                <form name="login_form" action="login.php" method="post" onkeypress="prevent(event)">
                    <ul>
                        <li><input type="text" id="id" name="id" placeholder="ID" autocomplete="off" onkeypress="enterLogin(event)"></li>
                        <li><input type="password" id="password" name="password" placeholder="Password" autocomplete="off" onkeypress="enterLogin(event)"></li>
                        <li><input type="button" onclick="check_input()" value="로그인"></li>
                        <li><a href="http://<?=$_SERVER['HTTP_HOST']?>/a4b1/login/signup_form.php">회원가입</a><a onclick="showPopup()">아이디/비밀번호 찾기</a></li>
                    </ul>
                </form>
            </div>
        </div>
    </body>
</html>
    