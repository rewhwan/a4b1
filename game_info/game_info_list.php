<?php
session_start();
//설정한 지역의 시간대로 설정
date_default_timezone_set("Asia/Seoul");
require $_SERVER['DOCUMENT_ROOT'] . "/a4b1/common/lib/db.mysqli.class.php";
include $_SERVER['DOCUMENT_ROOT']."/a4b1/common/lib/submit_function.php";
//싱글톤 객체 불러오기
$db = DB::getInstance();
$dbcon = $db->connector();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="http://<?= $_SERVER['HTTP_HOST'] ?>/a4b1/common/css/common.css?ver=1">
    <script src="http://<?= $_SERVER['HTTP_HOST'] ?>/a4b1/common/js/common.js?ver=1"></script>
    <link rel="stylesheet" href="http://<?= $_SERVER['HTTP_HOST'] ?>/a4b1/game_info/css/review.css">
    <title>게임 정보 리스트</title>
</head>

<body>
    <header>
        <?php include $_SERVER['DOCUMENT_ROOT'] . "/a4b1/common/lib/header.php"; ?>
    </header>
    <?php
    //상수 지정
    define('SCALE', 1);

    //전체 레코드수를 가져와 총 페이지 계산
    $sql = "SELECT * from `game_info` order by `num` desc";
    $result = mysqli_query($dbcon, $sql) or die("list select error1 : " . mysqli_error($dbcon));
    $total_record = mysqli_num_rows($result);
    //딱 맞아 떨어지면 그대로 아니면 올림수로 계산
    $total_page = ($total_record % SCALE == 0) ? ($total_record / SCALE) : (ceil($total_record / SCALE));

    //2.페이지가 없으면 디폴트 페이지 1페이지
    if (empty($_GET['page'])) {
        $page = 1;
    } else {
        $page = $_GET['page'];
    }

    $start = ($page - 1) * SCALE;
    $number = $total_record - $start;
    ?>
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
                for ($i = $start; $i < $start + SCALE && $i < $total_record; $i++) {
                    //DB에서 게임 정보 가져오기
                    $sql = "SELECT * from `game_info`";
                    $result = mysqli_query($dbcon, $sql) or die("list select error2 : " . mysqli_error($dbcon));
                    mysqli_data_seek($result, $i);
                    $row = mysqli_fetch_array($result);
                    $num = intval($row['num']);
                    $name = $row['name'];
                    $developer = $row['developer'];
                    $grade = $row['grade'];
                    $release_date = $row['release_date'];
                    $service_kor = $row['service_kor'];
                    if($service_kor == 1){
                        $service_kor = "지원";
                    }else{
                        $service_kor = "미 지원";
                    }
                    $image = $row['image'];
                    $created_by = $row['created_by'];
                    $created_at = $row['created_at'];

                    $sql = "SELECT * from `game_info_genre` where `info_num` = $num";
                    $result = mysqli_query($dbcon, $sql) or die("list select error3 : " . mysqli_error($dbcon));
                    $genre=null;
                    while($row1 = mysqli_fetch_array($result)){
                        if($genre == null){
                            $genre = $row1['genre'];
                        }else{

                            $genre = $genre.",".$row1['genre'];
                        }  
                    }
                    $platform="";
                    $sql = "SELECT * from `game_info_platform` where `info_num` = $num";
                    $result = mysqli_query($dbcon, $sql) or die("list select error4 : " . mysqli_error($dbcon));
                    while($row2 = mysqli_fetch_array($result)){
                        if($platform == null){
                            $platform = $row2['platform'];
                        }else{
                            
                            $platform = $platform.",".$row2['platform'];
                        }
                    } 
                ?>
                <a href="http://<?= $_SERVER['HTTP_HOST'] ?>/a4b1/game_info/game_info_view.php?num=<?= $num ?>">
                    <li>
                        <img src="http://<?= $_SERVER['HTTP_HOST'] ?>/a4b1/game_info/img/title/<?= $image ?>">
                        <h3><?= $name ?></h3>
                        <p>장르 : <?= $genre ?></p>
                        <p>지원 플랫폼 : <?= $platform ?></p>
                        <p>한국어 지원 : <?= $service_kor ?></p>
                        <p>작성자 : <?=$created_by?></p>
                        <p>작성일자 : <?=$created_at?></p>
                    </li>
                </a>
                <?php
                     $number--;
                }
                mysqli_close($dbcon);
                ?>
            </ul>
        </div>
        <div id="page_button">
						<div id="page_num"> 
                        <?php
                         if($i != 1){
                        ?>    
                        <a href="./game_info_list.php?page=<?=$page-1?>">이전◀</a><?php
                         }
                        ?>&nbsp;&nbsp;&nbsp;
							<?php
							for ($i = 1; $i <= $total_page; $i++) {
								if ($page == $i) {
									echo "<b>&nbsp;$i&nbsp;</b>";
								} else {
									echo "<a href='./game_info_list.php?page=$i'>&nbsp;$i&nbsp;</a>";
								}
							}
							?>
                            &nbsp;&nbsp;&nbsp;
                            <?php
                            if($page != $total_page){
                            ?>
                            <a href="./game_info_list.php?page=<?=$page+1?>">▶다음</a>
                            <?php
                                }
                            ?>
							<br><br><br><br><br><br><br>
						</div>
        </div>

</body>

</html>