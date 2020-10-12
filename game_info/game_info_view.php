<?php
session_start();
//설정한 지역의 시간대로 설정
date_default_timezone_set('Asia' / 'Seoul');
require $_SERVER['DOCUMENT_ROOT'] . "/a4b1/common/lib/db.mysqli.class.php";
include $_SERVER['DOCUMENT_ROOT'] . "/a4b1/common/lib/submit_function.php";
//싱글톤 객체 불러오기
$db = DB::getInstance();
$dbcon = $db->connector();

$num = $_GET['num'];
//DB에서 게임 정보 가져오기
$sql = "SELECT * from `game_info` where `num` = $num";
$result = mysqli_query($dbcon, $sql) or die("list select error2 : " . mysqli_error($dbcon));
mysqli_data_seek($result, $i);
$row = mysqli_fetch_array($result);
$name = $row['name'];
$developer = $row['developer'];
$grade = $row['grade'];
$release_date = $row['release_date'];
$service_kor = $row['service_kor'];
if ($service_kor == 1) {
    $service_kor = "지원";
} else {
    $service_kor = "미 지원";
}
$image = $row['image'];
$circulation = $row['circulation'];
$created_by = $row['created_by'];
$created_at = $row['created_at'];
$price = $row['price'] . "원";
$homepage = $row['homepage'];
$content = test_input($row['content']);
//코드를 문자로 치환
$content = html_entity_decode($content);

$sql = "SELECT * from `game_info_genre` where `info_num` = $num";
$result = mysqli_query($dbcon, $sql) or die("list select error3 : " . mysqli_error($dbcon));
while ($row1 = mysqli_fetch_array($result)) {
    if (isset($genre)) {
        $genre = $genre . "," . $row1['genre'];
    } else {
        $genre = $row1['genre'];
    }
}
$sql = "SELECT * from `game_info_platform` where `info_num` = $num";
$result = mysqli_query($dbcon, $sql) or die("list select error4 : " . mysqli_error($dbcon));
while ($row2 = mysqli_fetch_array($result)) {
    if (isset($platform)) {
        $platform = $platform . "," . $row2['platform'];
    } else {
        $platform = $row2['platform'];
    }
}
$sql = "SELECT * from `game_info_files` where `info_num` = $num";
$result = mysqli_query($dbcon, $sql) or die("list select error5 : " . mysqli_error($dbcon));
while ($row3 = mysqli_fetch_array($result)) {
    if (isset($platform)) {
        $screen = $screen . "," . $row3['name'];
    } else {
        $screen = $row3['name'];
    }
}
// //상수 지정
// define('SCALE', 5);

// //전체 레코드수를 가져와 총 페이지 계산
// $sql = "SELECT * from `game_info_ripples` where `info_num` = $num order by `num` desc";
// $result = mysqli_query($dbcon, $sql) or die("list select error1 : " . mysqli_error($dbcon));
// $total_record = mysqli_num_rows($result);
// //딱 맞아 떨어지면 그대로 아니면 올림수로 계산
// $total_page = ($total_record % SCALE == 0) ? ($total_record / SCALE) : (ceil($total_record / SCALE));

// //2.페이지가 없으면 디폴트 페이지 1페이지
// if (empty($_GET['page'])) {
//     $page = 1;
// } else {
//     $page = $_GET['page'];
// }

// $start = ($page - 1) * SCALE;
// $number = $total_record - $start;
?>
<!DOCTYPE html>
<html lang="ko">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="http://<?= $_SERVER['HTTP_HOST'] ?>/a4b1/common/css/common.css?ver=1">
    <link rel="stylesheet" href="http://<?= $_SERVER['HTTP_HOST'] ?>/a4b1/game_info/css/insert_form.css">
    <script src="http://<?= $_SERVER['HTTP_HOST'] ?>/a4b1/common/js/common.js?ver=1"></script>
    <script src="http://<?= $_SERVER['HTTP_HOST'] ?>/a4b1/common/js/jquery/jquery-3.5.1.min.js?ver=1"></script>
    <script src="./js/info.js"></script>
    <script>select_ripple(<?=$num?>,1)</script>
    <title>게임 상세 정보</title>
</head>

<body>
    <header>
        <?php include $_SERVER['DOCUMENT_ROOT'] . "/a4b1/common/lib/header.php"; ?>
    </header>
    <div id="image_container">
        <img src="./img/title/<?= $image ?>" alt="">
    </div>
    <div id="game_info_view">
        <div>
            <h1>게임명 : <?= $name ?></h1>
            <p>지원 플랫폼 : <?= $platform ?></p>
            <p>개발사 : <?= $developer ?></p>
        </div>
        <div>
            <p>장르 : <?= $genre ?></p>
            <p>출시일자 : <?= $release_date ?></p>
            <p>등급 : <?= $grade ?></p>
        </div>
        <div>
            <p>유통사 : <?= $circulation ?></p>
            <p>한국어 지원 : <?= $service_kor ?></p>
            <p>가격 : <?= $price ?></p>
        </div>
        <div>
            <a href="<?= $homepage ?>">공식홈페이지</a>
        </div>
    </div>
    <br>
    <div id="game_content">
        <p id="content"><?= $content ?></p>
    </div>
    <div id="screen_shot_show">
        <ul>
            <li>
                <?php
                if(isset($screen)){
                    $screen_shot = explode(",",$screen);
                    $count= count($screen_shot);
                    for($i=0; $i<$count; $i++){
                        $screen_image= $screen_shot[$i];
                ?>
                    <img src="./img/screen/<?=$screen_image?>" alt="">
                <?php
                    }
                }    
                ?> 
            </li>
        </ul>
    </div>
    
    <div id="ripple_regist">
        <div id="ripple2">
            <p>댓글입력</p>
            <br>
            <input type="hidden" name="userid" id="userid" value="<?= $_SESSION['id'] ?>">
            <!-- <input type="hidden" name="num" id="num" value=""> -->
            <textarea name="content" id="content" cols="70" rows="10"></textarea>
            <button onclick="ripple_insert(<?= $num ?>)">댓글달기</button>
        </div>
    </div>
    <div id="ripple_bag">
        <ul id="ripple_form">
            
        </ul>
        <div id="page">
            <div id="page_button">
                <div id="page_num">
                </div>  
            </div>
            <div>
                <?php
                if(isset($_SESSION['id']) && ($_SESSION['id'] == "admin" || intval($_SESSION['admin']) >= 1)){
                ?>
                    <button onclick="location.href='./info_update_form.php?num=<?=$num?>'">정보 수정</button>
                    <button onclick="location.href='./game_info_delete.php?num=<?=$num?>'">정보 삭제</button>
                <?php
                }
                ?>
            </div>
        </div>
    </div>
    
    <button onclick="history.go(-1)">뒤로 가기</button>
</body>

</html>