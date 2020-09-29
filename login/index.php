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
        <div id="login_form">
            <form name="login_form" action="login.php" method="post" onkeypress="prevent(event)">
                <ul>
                    <li><label for="id">아이디</label></li>
                    <li><input type="text" id="id" name="id" autocomplete="off" onkeypress="enterLogin(event)"></li>
                    <li><label for="password">비밀번호</label></li>
                    <li><input type="text" id="password" name="password" autocomplete="off" onkeypress="enterLogin(event)"></li>
                    <li><input type="submit"></li>
                </ul>
            </form>
        </div>

        <div>

        </div>
    </body>
</html>
    