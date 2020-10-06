<?php 
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="http://<?=$_SERVER['HTTP_HOST']?>/a4b1/common/css/common.css?ver=1">
    <script src="http://<?=$_SERVER['HTTP_HOST']?>/a4b1/common/js/common.js?ver=1"></script>
    <link rel="stylesheet" href="http://<?= $_SERVER['HTTP_HOST'] ?>/a4b1/game_info/css/review.css">
    <title>게임 정보 리스트</title>
</head>
<?php
    //상수 지정
    define('SCALE', 10);

    //DB에서 게임 정보 가져오기
?>
<body>
    <header>
        <?php include $_SERVER['DOCUMENT_ROOT']."/a4b1/common/lib/header.php";?>
    </header>
    <div id="container_body">
        <div id="top">
            <ul>
                <li>검색</li>
                <li>회원가입</li>
            </ul>
        </div>

        <div id="list">
            <ul>
                <a href="http://<?= $_SERVER['HTTP_HOST'] ?>/a4b1/game_info/game_info_view.php?num=<?=$num?>">
                    <li>
                        <img src="http://<?= $_SERVER['HTTP_HOST'] ?>/a4b1/game_info/img/<?=$image?>">
                        <h3><?=$name?></h3>
                        <p>장르 : <?=$image?></p>
                        <p>지원 플랫폼 : <?=$image?></p>
                        <p>한국어 지원 : <?=$service_kor?></p>
                        <p>작성자 : <?=$create_by?></p>
                        <p>작성일자 : <?=$create_at?></p>
                    </li>
                </a>
            </ul>
        </div>
    </div>
</body>
</html>