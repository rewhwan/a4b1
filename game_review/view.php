<!doctype html>
<?php
require $_SERVER['DOCUMENT_ROOT'] . "/a4b1/common/lib/db.mysqli.class.php";
//싱글톤 객체 불러오기
$db = DB::getInstance();
$db->sessionStart();
$dbcon = $db->connector();


$num = $_GET["num"];
$page = $_GET["page"];
$name = $_GET["name"];

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

$avg = ($story + $graphic + $time + $difficulty) / 4;

$sql2 = "select image from game_info where name = '철권7'";
$result2 = mysqli_query($dbcon, $sql2);
$row2 = mysqli_fetch_array($result2);

$image = $row2['image'];

mysqli_close($dbcon);
?>
<html>

<head>
    <meta charset="UTF-8">
    <title>게임리뷰 상세보기</title>
    <link rel="stylesheet" href="http://<?= $_SERVER['HTTP_HOST'] ?>/a4b1/common/css/common.css?ver=1">
    <link rel="stylesheet" href="http://<?= $_SERVER['HTTP_HOST'] ?>/a4b1/game_review/css/review.css">
    <script src="http://<?= $_SERVER['HTTP_HOST'] ?>/a4b1/common/js/jquery/jquery-3.5.1.min.js"></script>
    <script src="http://<?= $_SERVER['HTTP_HOST'] ?>/a4b1/common/js/common.js"></script>

    <!-- <script src="http://<?= $_SERVER['HTTP_HOST'] ?>/a4b1/game_review/js/view.js"></script> -->
</head>

<header>
    <?php include $_SERVER['DOCUMENT_ROOT'] . "/a4b1/common/lib/header.php"; ?>
</header>

<body>
    <div id="point_container">
        <div id="point">
            <div id="image_container">
                <img src="http://<?= $_SERVER['HTTP_HOST'] ?>/a4b1/game_info/img/<?= $image ?>">
            </div>
            <div id="info">
                <div id="button_group">
                    <?php
                     if ((isset($_SESSION["id"])&&$_SESSION["id"] == "admin") || (isset($_SESSION["id"])&&$_SESSION["id"] == $created_by)) {
                        ?>
                        <a href="http://<?= $_SERVER['HTTP_HOST'] ?>/a4b1/game_review/review_modify.php?num=<?=$num?>&page=<?=$page?>&title=<?=$title?>"><button>수정</button></a>
                        <a href="http://<?= $_SERVER['HTTP_HOST'] ?>/a4b1/game_review/review_delete.php?num=<?=$num?>&page=<?=$page?>&created_by=<?=$created_by?>"><button>삭제</button></a>
                    <?php
                    }
                    ?>
                </div>
                
                <div id="user_info">
                    <div><?= $title ?></div>
                    <div><?= $name ?></div>
                    <div><?= $created_by    ?></div>
                </div>

                <div>
                    <div id="star_point">
                        <div id="star1">
                            <div>
                                <div>스토리</div>
                                <div><?= $story ?></div>
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
                            </div>
                            <div>
                                <div>그래픽</div>
                                <div><?= $graphic ?></div>
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
                            </div>
                        </div>
                        <div id="star2">
                            <div>
                                <div>러닝타임</div>
                                <div><?= $time ?></div>
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
                            </div>
                            <div>
                                <div>난이도</div>
                                <div><?= $difficulty ?></div>
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
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div>
            <p><?= $content ?></p>
        </div>
    </div>
</body>
<footer>

</footer>

</html>