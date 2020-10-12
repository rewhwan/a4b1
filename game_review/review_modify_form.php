<!doctype html>
<html lang="ko">
<?php
require $_SERVER['DOCUMENT_ROOT'] . "/a4b1/common/lib/db.mysqli.class.php";

//싱글톤 객체 불러오기
$db = DB::getInstance();
$db->sessionStart();
$dbcon = $db->connector();

//수정가능한 계정인지 체크
if (!isset($_SESSION['id']) && ($_SESSION['id'] != 'admin' || $_SESSION['id'] != $created_by)) {
    echo "<script>
        alert('수정권한이 없습니다')
        history.back(-1);
        </script>";
    return;
}

$num = $_GET['num'];
$page = $_GET['page'];

$sql = "select * from game_review left join game_review_point on num = review_num where num = {$num}";
$result = mysqli_query($dbcon, $sql);
$row = mysqli_fetch_array($result);

//game_review table values
$name = $row["name"];
$title = $row["title"];
$content = $row["content"];
$created_at = $row["created_at"];
$created_by = $row["created_by"];

//game_review_point table values
$story = $row["story"];
$graphic = $row["graphic"];
$time = $row["time"];
$difficulty = $row["difficulty"];


$sql = "select * from game_review_files where num = {$num}";
$result = mysqli_query($dbcon, $sql);
$row = mysqli_fetch_array($result);

$file_name = $row['name'];

mysqli_close($dbcon);
?>

<head>
    <meta charset="UTF-8">
    <title>게임리뷰</title>
    <link rel="stylesheet" href="http://<?= $_SERVER['HTTP_HOST'] ?>/a4b1/common/css/common.css?ver=1">
    <link rel="stylesheet" href="http://<?= $_SERVER['HTTP_HOST'] ?>/a4b1/game_review/css/review.css">
    <script src="http://<?= $_SERVER['HTTP_HOST'] ?>/a4b1/common/js/jquery/jquery-3.5.1.min.js"></script>
    <script src="http://<?= $_SERVER['HTTP_HOST'] ?>/a4b1/game_review/js/modify.js"></script>
</head>

<style>

</style>

<body>
    <header>
        <?php include $_SERVER['DOCUMENT_ROOT'] . "/a4b1/common/lib/header.php"; ?>
    </header>
    <div id="form_container">
        <form id="review_modify_form" name="review_modify_form" method="POST" action="review_modify.php" enctype="multipart/form-data">
        
            <input type="hidden" name="num" value="<?=$num?>">
            <input type="hidden" name="page" value="<?=$page?>">
            <input type="hidden" name="name" value="<?=$name?>">
            
            <h2>리뷰 수정하기</h2>
            <ul>
                <li>
                    <p>게임 : </p>
                    <p> <?= $name ?></p>
                </li>
                <li>
                    <p>제목</p> <input type="text" id="title" name="title" value="<?= $title ?>">
                </li>
                <li>
                    <div class="story">
                        <span class="starR1">별1_왼쪽</span>
                        <span class="starR2">별1_오른쪽</span>
                        <span class="starR1">별2_왼쪽</span>
                        <span class="starR2">별2_오른쪽</span>
                        <span class="starR1">별3_왼쪽</span>
                        <span class="starR2">별3_오른쪽</span>
                        <span class="starR1">별4_왼쪽</span>
                        <span class="starR2">별4_오른쪽</span>
                        <span class="starR1">별5_왼쪽</span>
                        <span class="starR2">별5_오른쪽</span>
                        <input type="hidden" id="story" name="story" value="0">
                    </div>
                    <div class="graphic">
                        <span class="starR1">별1_왼쪽</span>
                        <span class="starR2">별1_오른쪽</span>
                        <span class="starR1">별2_왼쪽</span>
                        <span class="starR2">별2_오른쪽</span>
                        <span class="starR1">별3_왼쪽</span>
                        <span class="starR2">별3_오른쪽</span>
                        <span class="starR1">별4_왼쪽</span>
                        <span class="starR2">별4_오른쪽</span>
                        <span class="starR1">별5_왼쪽</span>
                        <span class="starR2">별5_오른쪽</span>
                        <input type="hidden" id="graphic" name="graphic" value="0">
                    </div>
                </li>
                <li>
                    <div class="time">
                        <span class="starR1">별1_왼쪽</span>
                        <span class="starR2">별1_오른쪽</span>
                        <span class="starR1">별2_왼쪽</span>
                        <span class="starR2">별2_오른쪽</span>
                        <span class="starR1">별3_왼쪽</span>
                        <span class="starR2">별3_오른쪽</span>
                        <span class="starR1">별4_왼쪽</span>
                        <span class="starR2">별4_오른쪽</span>
                        <span class="starR1">별5_왼쪽</span>
                        <span class="starR2">별5_오른쪽</span>
                        <input type="hidden" id="time" name="time" value="0">
                    </div>
                    <div class="difficulty">
                        <span class="starR1">별1_왼쪽</span>
                        <span class="starR2">별1_오른쪽</span>
                        <span class="starR1">별2_왼쪽</span>
                        <span class="starR2">별2_오른쪽</span>
                        <span class="starR1">별3_왼쪽</span>
                        <span class="starR2">별3_오른쪽</span>
                        <span class="starR1">별4_왼쪽</span>
                        <span class="starR2">별4_오른쪽</span>
                        <span class="starR1">별5_왼쪽</span>
                        <span class="starR2">별5_오른쪽</span>
                        <input type="hidden" id="difficulty" name="difficulty" value="0">
                    </div>
                </li>
                <li>리뷰남기기 <textarea name="content" cols="30" rows="10" id="content"><?= $content ?></textarea></li>
                <li>
                    <p>이미지 첨부하기</p><input type="file" name="new_file[]" multiple accept="image/*">
                </li>
            </ul>
            <button type="button">취소</button>
            <input type="button" onclick="check_input()" value="등록">
        </form>
    </div>

    <footer>

    </footer>

</body>

</html>