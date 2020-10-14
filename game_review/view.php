<!doctype html>
<?php
require $_SERVER['DOCUMENT_ROOT'] . "/a4b1/common/lib/db.mysqli.class.php";
//싱글톤 객체 불러오기
$db = DB::getInstance();
$db->sessionStart();
$dbcon = $db->connector();


$num = $_GET["num"];
$page = $_GET["page"];



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

if (is_numeric($name)) {
    //게임 정보를 game_info 테이블에서 가져오는 로직
    $sql2 = "select * from game_info where num = '$name'";
    $result2 = mysqli_query($dbcon, $sql2);
    $row2 = mysqli_fetch_array($result2);

    $name = $row2['name'];
    $image = $_SERVER['HTTP_HOST'] . "/a4b1/game_info/img/title/" . $row2['image'];
} else {
    //등록되어 있는 정보를 그대로 가져오는 로직
    $sql2 = "select * from game_review_files where review_num = '$num' order by num ASC";
    $result2 = mysqli_query($dbcon, $sql2);
    $row2 = mysqli_fetch_assoc($result2);
    if ($row2['name'] == '') $image = $_SERVER['HTTP_HOST'] . "/a4b1/game_review/data/default.png";
    else  $image = $_SERVER['HTTP_HOST'] . "/a4b1/game_review/img/" . $row2['name'];
}

?>
<html>

<head>
    <meta charset="UTF-8">
    <title>게임리뷰 상세보기</title>
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
    <script src="http://<?= $_SERVER['HTTP_HOST'] ?>/a4b1/common/js/common.js"></script>

    <!-- <script src="http://<?= $_SERVER['HTTP_HOST'] ?>/a4b1/game_review/js/view.js"></script> -->
</head>

<header>
    <?php include $_SERVER['DOCUMENT_ROOT'] . "/a4b1/common/lib/header.php"; ?>
</header>

<body>
    <div id="point_container">
        <div id="point">
            <div id="point_group">
                <div id="image_container">
                    <img src="http://<?= $image ?>">
                </div>
                <div id="info">
                    <div id="info_group">
                        <div id="button_group">
                            <?php
                            if ((isset($_SESSION["id"]) && $_SESSION["id"] == "admin") || (isset($_SESSION["id"]) && $_SESSION["id"] == $created_by)) {
                            ?>
                                <a href="http://<?= $_SERVER['HTTP_HOST'] ?>/a4b1/game_review/review_modify_form.php?num=<?= $num ?>&page=<?= $page ?>&title=<?= $title ?>"><button>수정</button></a>
                                <a href="http://<?= $_SERVER['HTTP_HOST'] ?>/a4b1/game_review/review_delete.php?num=<?= $num ?>&page=<?= $page ?>&created_by=<?= $created_by ?>"><button>삭제</button></a>
                            <?php
                            }
                            ?>
                        </div>

                        <div id="user_info">
                            <div>
                                <h2><?= $title ?></h2>
                            </div>
                            <div>game : <?= $name ?></div>
                            <div>user : <?= $created_by ?></div>
                        </div>

                        <div>
                            <div id="star_point">
                                <div id="star1">
                                    <div id="story">
                                        <div>스토리</div>
                                        <div><?= $story ?></div>
                                        <div class="story">
                                            <?php 
                                                for($i=1;$i<=10;$i++) {
                                                    if($i%2 ==1) {
                                                        if($i<=$story) {
                                                            echo "<span class='starR1 on'>별".$i."_왼쪽</span>";
                                                        }else {
                                                            echo "<span class='starR1'>별".$i."_왼쪽</span>";
                                                        }
                                                    }else {
                                                        if($i<=$story) {
                                                            echo "<span class='starR2 on'>별".$i."_오른쪽</span>";
                                                        }else {
                                                            echo "<span class='starR2'>별".$i."_오른쪽</span>";
                                                        }
                                                    }
                                                }
                                            ?>
                                        </div>
                                    </div>
                                    <div id="graphic">
                                        <div>그래픽</div>
                                        <div><?= $graphic ?></div>
                                        <div class="graphic">
                                        <?php 
                                            for($i=1;$i<=10;$i++) {
                                                if($i%2 ==1) {
                                                    if($i<=$graphic) {
                                                        echo "<span class='starR1 on'>별".$i."_왼쪽</span>";
                                                    }else {
                                                        echo "<span class='starR1'>별".$i."_왼쪽</span>";
                                                    }
                                                }else {
                                                    if($i<=$graphic) {
                                                        echo "<span class='starR2 on'>별".$i."_오른쪽</span>";
                                                    }else {
                                                        echo "<span class='starR2'>별".$i."_오른쪽</span>";
                                                    }
                                                }
                                            }
                                        ?>
                                        </div>
                                    </div>
                                </div>
                                <div id="star2">
                                    <div id="time">
                                        <div>런타임</div>
                                        <div><?= $time ?></div>
                                        <div class="time">
                                        <?php 
                                            for($i=1;$i<=10;$i++) {
                                                if($i%2 ==1) {
                                                    if($i<=$time) {
                                                        echo "<span class='starR1 on'>별".$i."_왼쪽</span>";
                                                    }else {
                                                        echo "<span class='starR1'>별".$i."_왼쪽</span>";
                                                    }
                                                }else {
                                                    if($i<=$time) {
                                                        echo "<span class='starR2 on'>별".$i."_오른쪽</span>";
                                                    }else {
                                                        echo "<span class='starR2'>별".$i."_오른쪽</span>";
                                                    }
                                                }
                                            }
                                        ?>
                                        </div>
                                    </div>
                                    <div id="difficulty">
                                        <div>난이도</div>
                                        <div><?= $difficulty ?></div>
                                        <div class="difficulty">
                                        <?php 
                                            for($i=1;$i<=10;$i++) {
                                                if($i%2 ==1) {
                                                    if($i<=$difficulty) {
                                                        echo "<span class='starR1 on'>별".$i."_왼쪽</span>";
                                                    }else {
                                                        echo "<span class='starR1'>별".$i."_왼쪽</span>";
                                                    }
                                                }else {
                                                    if($i<=$difficulty) {
                                                        echo "<span class='starR2 on'>별".$i."_오른쪽</span>";
                                                    }else {
                                                        echo "<span class='starR2'>별".$i."_오른쪽</span>";
                                                    }
                                                }
                                            }
                                        ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="content">
            <div id="user_review_img">
                <div id="img_container">
                    <?php
                    $sql = "select * from game_review_files where review_num = $num";
                    $result = mysqli_query($dbcon, $sql);
        
                    while($row = mysqli_fetch_assoc($result)) {
                        $image = $row['name'];
                    ?>
                        <div>
                            <img src="http://<?= $_SERVER['HTTP_HOST'] ?>/a4b1/game_review/img/<?= $image ?>" ;>
                        </div>
                    <?php
                    }
                    
                    mysqli_close($dbcon)
                    ?>
                </div>
            </div>
            <div id="content_review">
                <div>
                    <p><?= $content ?></p>
                </div>
            </div>
            <div id="prev"><a href="./index.php/"><button>이전</button></a></div>
        </div>
    </div>
</body>
<footer>

</footer>

</html>