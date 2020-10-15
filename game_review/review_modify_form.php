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

    <!--Jquery 추가-->
    <script src="http://<?= $_SERVER['HTTP_HOST'] ?>/a4b1/common/js/jquery/jquery-3.5.1.min.js?ver=1"></script>

    <!--alert & toastr 라이브러리 추가-->
    <link rel="stylesheet" href="http://<?= $_SERVER['HTTP_HOST'] ?>/a4b1/common/css/toastr/toastr.min.css?ver=1" />
    <script src="http://<?= $_SERVER['HTTP_HOST'] ?>/a4b1/common/js/toastr/toastr.min.js?ver=1"></script>
    <script src="http://<?= $_SERVER['HTTP_HOST'] ?>/a4b1/common/js/sweetalert/sweetalert.min.js?ver=1"></script>

    <!--헤더 파일 추가-->
    <link rel="stylesheet" href="http://<?= $_SERVER['HTTP_HOST'] ?>/a4b1/common/css/common.css?ver=1">
    <script src="http://<?= $_SERVER['HTTP_HOST'] ?>/a4b1/common/js/common.js?ver=1"></script>

    <link rel="stylesheet" href="http://<?= $_SERVER['HTTP_HOST'] ?>/a4b1/game_review/css/review.css">
    <script src="http://<?= $_SERVER['HTTP_HOST'] ?>/a4b1/common/js/jquery/jquery-3.5.1.min.js"></script>
    <script src="http://<?= $_SERVER['HTTP_HOST'] ?>/a4b1/game_review/js/modify.js"></script>
</head>

<style>

</style>

<body id="body">
    <header>
        <?php include $_SERVER['DOCUMENT_ROOT'] . "/a4b1/common/lib/header.php"; ?>
    </header>
    <div id="form_container">
        <form id="review_modify_form" name="review_modify_form" method="POST" action="review_modify.php" enctype="multipart/form-data">

            <input type="hidden" name="num" value="<?= $num ?>">
            <input type="hidden" name="page" value="<?= $page ?>">
            <input type="hidden" name="name" value="<?= $name ?>">

            <h2>리뷰 수정하기</h2>
            <ul id="modify_list">
                <li>
                    <p>게임이름</p>
                    <?= $name ?>
                </li>
                <li>
                    <p>제목</p> <input type="text" id="title" name="title" value="<?= $title ?>">
                </li>
                <li>
                    <p>별점</p>
                    <div id="star_container">
                        <p>스토리 </p>
                        <div class="story">
                            <?php
                            for ($i = 1; $i <= 10; $i++) {
                                if ($i % 2 == 1) {
                                    if ($i <= $story) {
                                        echo "<span class='starR1 on'>별" . $i . "_왼쪽</span>";
                                    } else {
                                        echo "<span class='starR1'>별" . $i . "_왼쪽</span>";
                                    }
                                } else {
                                    if ($i <= $story) {
                                        echo "<span class='starR2 on'>별" . $i . "_오른쪽</span>";
                                    } else {
                                        echo "<span class='starR2'>별" . $i . "_오른쪽</span>";
                                    }
                                }
                            }
                            ?>
                            <input type="hidden" id="story" name="story" value="0">
                        </div>

                        <p>그래픽</p>
                        <div class="graphic">
                            <?php
                            for ($i = 1; $i <= 10; $i++) {
                                if ($i % 2 == 1) {
                                    if ($i <= $graphic) {
                                        echo "<span class='starR1 on'>별" . $i . "_왼쪽</span>";
                                    } else {
                                        echo "<span class='starR1'>별" . $i . "_왼쪽</span>";
                                    }
                                } else {
                                    if ($i <= $graphic) {
                                        echo "<span class='starR2 on'>별" . $i . "_오른쪽</span>";
                                    } else {
                                        echo "<span class='starR2'>별" . $i . "_오른쪽</span>";
                                    }
                                }
                            }
                            ?>
                            <input type="hidden" id="graphic" name="graphic" value="0">
                        </div>
                    </div>
                </li>
                <li>
                    <div id="star_container">
                        <p>러닝타임</p>
                        <div class="time">
                            <?php
                            for ($i = 1; $i <= 10; $i++) {
                                if ($i % 2 == 1) {
                                    if ($i <= $time) {
                                        echo "<span class='starR1 on'>별" . $i . "_왼쪽</span>";
                                    } else {
                                        echo "<span class='starR1'>별" . $i . "_왼쪽</span>";
                                    }
                                } else {
                                    if ($i <= $time) {
                                        echo "<span class='starR2 on'>별" . $i . "_오른쪽</span>";
                                    } else {
                                        echo "<span class='starR2'>별" . $i . "_오른쪽</span>";
                                    }
                                }
                            }
                            ?>
                            <input type="hidden" id="time" name="time" value="0">
                        </div>

                        <p>난이도</p>
                        <div class="difficulty">
                            <?php
                            for ($i = 1; $i <= 10; $i++) {
                                if ($i % 2 == 1) {
                                    if ($i <= $difficulty) {
                                        echo "<span class='starR1 on'>별" . $i . "_왼쪽</span>";
                                    } else {
                                        echo "<span class='starR1'>별" . $i . "_왼쪽</span>";
                                    }
                                } else {
                                    if ($i <= $difficulty) {
                                        echo "<span class='starR2 on'>별" . $i . "_오른쪽</span>";
                                    } else {
                                        echo "<span class='starR2'>별" . $i . "_오른쪽</span>";
                                    }
                                }
                            }
                            ?>
                            <input type="hidden" id="difficulty" name="difficulty" value="0">
                        </div>
                    </div>
                </li>
                <li>
                    <p>내용</p><textarea name="content" cols="30" rows="10" id="content"><?= $content ?></textarea>
                </li>
                <li>
                    <p>파일첨부</p><input type="file" name="new_file[]" multiple accept="image/*">
                </li>
            </ul>
            <div id="submit_container">
                <a href="./index.php"><button type="button" type="button">취소</button></a>
                <button type="button" onclick="check_input()">등록</button>
            </div>
        </form>
    </div>

    <footer>
        <?php include $_SERVER['DOCUMENT_ROOT'] . "/a4b1/common/lib/footer.php"; ?>
    </footer>

</body>

</html>