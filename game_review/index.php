<!doctype html>
<html lang="ko">
<?php
require $_SERVER['DOCUMENT_ROOT'] . "/a4b1/common/lib/db.mysqli.class.php";

//싱글톤 객체 불러오기
$db = DB::getInstance();
$db->sessionStart();
$dbcon = $db->MysqliConnect();
?>

<head>
    <meta charset="UTF-8">
    <title>게임리뷰</title>
    <link rel="stylesheet" href="http://<?= $_SERVER['HTTP_HOST'] ?>/a4b1/common/css/common.css?ver=1">
    <link rel="stylesheet" href="http://<?= $_SERVER['HTTP_HOST'] ?>/a4b1/game_review/css/review.css">
</head>

<body>
    <header>
        <?php include $_SERVER['DOCUMENT_ROOT'] . "/a4b1/common/lib/header.php"; ?>
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
                <?php
                $num  = 1;
                // $page  = $_GET["page"];

                $sql = "select * from game_review where num = $num";
                $result = mysqli_query($dbcon, $sql);
                $row = mysqli_fetch_array($result);

                $num = $row["num"];
                $name = $row["name"];
                $title = $row["title"];
                $created_at = $row["created_at"];
                $created_by = $row["created_by"];

                $sql = "select image from game_info where name = 'The Last of us'";
                $result = mysqli_query($dbcon,$sql);
                $row = mysqli_fetch_array($result);

                $image = $row["image"];
                mysqli_close($dbcon);
                ?>

                <a href="http://<?= $_SERVER['HTTP_HOST'] ?>/a4b1/game_review/view.php?num=<?=$num?> ">
                    <li>
                        <img src="http://<?= $_SERVER['HTTP_HOST'] ?>/a4b1/game_info/image/title/<?=$image?>">
                        <h3><?= $title ?></h3>
                        <p><?= $name ?></p>
                        <p>별점</p>
                        <p><?= $created_by ?></p>
                    </li>
                </a>

            </ul>
        </div>
        <a href="http://<?= $_SERVER['HTTP_HOST'] ?>/a4b1/game_review/review_insert.php">리뷰작성하기</a>
    </div>
    <footer>

    </footer>

</body>

</html>