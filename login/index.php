<!doctype html>
<html lang="ko">
    <head>
        <meta charset="UTF-8">
        <title>로그인 (A4B1's Game Box)</title>
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
                        <li><input type="submit" value="로그인"></li>
                        <li><a>회원가입</a><a>아이디 찾기</a><a>비밀번호 찾기</a></li>
                    </ul>
                </form>
            </div>
        </div>
    </body>
</html>
    