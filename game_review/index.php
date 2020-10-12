    <!doctype html>
<html lang="ko">
<?php
require $_SERVER['DOCUMENT_ROOT'] . "/a4b1/common/lib/db.mysqli.class.php";

//싱글톤 객체 불러오기
$db = DB::getInstance();
$db->sessionStart();
$dbcon = $db->connector();
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
                if (isset($_GET["page"]))
                    $page = $_GET["page"];
                else
                    $page = 1;

                $sql = "select * from game_review left join game_review_point on num = review_num order by num desc";
                $result = mysqli_query($dbcon, $sql);
                $total_record = mysqli_num_rows($result);

                //1페이지의 개수 상수로 정해놓기
                $scale = 8;

                // 전체 페이지 수($total_page) 계산 
                if ($total_record % $scale == 0)
                    $total_page = floor($total_record / $scale);
                else
                    $total_page = floor($total_record / $scale) + 1;

                // 전체 페이지 수($total_page) 계산 
                if ($total_record % $scale == 0)
                    $total_page = floor($total_record / $scale);
                else
                    $total_page = floor($total_record / $scale) + 1;

                // 표시할 페이지($page)에 따라 $start 계산  
                $start = ($page - 1) * $scale;

                $number = $start + 1;


                for ($i = $start; $i < $start + $scale && $i < $total_record; $i++) {
                    mysqli_data_seek($result, $i);

                    $row = mysqli_fetch_array($result);

                    $num = $row["num"];
                    $name = $row["name"];
                    $title = $row["title"];
                    $created_at = $row["created_at"];
                    $created_by = $row["created_by"];

                    //별점저장 로직
                    $story = $row["story"];
                    $graphic = $row["graphic"];
                    $time = $row["time"];
                    $difficulty = $row["difficulty"];
    
                    $avg = ($story + $graphic + $time + $difficulty) / 4;

                    //게임정보를 등록되어있는것에서 가져올지말지 분기점
                    if(is_numeric($name)) {
                        //게임 정보를 game_info 테이블에서 가져오는 로직
                        $sql2 = "select * from game_info where num = '$name'";
                        $result2 = mysqli_query($dbcon, $sql2);
                        $row2 = mysqli_fetch_array($result2);
                        
                        $name = $row2['name'];
                        $image = $_SERVER['HTTP_HOST']."/a4b1/game_info/img/title/".$row2['image'];
                    }else {
                        //등록되어 있는 정보를 그대로 가져오는 로직
                        $sql2 = "select * from game_review_files where review_num = '$num' order by num ASC";
                        $result2 = mysqli_query($dbcon, $sql2);
                        $row2 = mysqli_fetch_assoc($result2);
                        if($row2['name'] == '') $image = $_SERVER['HTTP_HOST']."/a4b1/game_review/data/default.png";
                        else  $image = $_SERVER['HTTP_HOST']."/a4b1/game_review/img/".$row2['name'];
                    }
                ?>
                    <a href="http://<?= $_SERVER['HTTP_HOST'] ?>/a4b1/game_review/view.php?num=<?= $num ?>&page=<?= $page ?>&image=<?=$image?> ">
                        <li>
                            <img src="http://<?= $image ?>">
                            <h2><?= $title ?></h2>
                            <p><?= $name ?></p>
                            <p><?= $avg ?></p>
                            <p><?= $created_by ?></p>
                        </li>
                    </a>
                <?php
                $number++;
                }
                mysqli_close($dbcon);
                ?>
            </ul>
        </div>
                <ul id="page_num">
                    <?php
                    if ($total_page >= 2 && $page >= 2) {
                        $new_page = $page - 1;
                        echo "<li><a href='index.php?page=$new_page'>◀ 이전</a> </li>";
                    } else
                        echo "<li>&nbsp;</li>";
    
                    // 게시판 목록 하단에 페이지 링크 번호 출력
                    for ($i = 1; $i <= $total_page; $i++) {
                        if ($page == $i)     // 현재 페이지 번호 링크 안함
                        {
                            echo "<li><b> $i </b></li>";
                        } else {
                            echo "<li><a href='index.php?page=$i'> $i </a><li>";
                        }
                    }
                    if ($total_page >= 2 && $page != $total_page) {
                        $new_page = $page + 1;
                        echo "<li> <a href='index.php?page=$new_page'>다음 ▶</a> </li>";
                    } else
                        echo "<li>&nbsp;</li>";
                    ?>
                </ul>
                <ul id="review_insert"><li><a href="http://<?= $_SERVER['HTTP_HOST'] ?>/a4b1/game_review/review_insert_form.php">리뷰작성하기</a></li></ul>
        
    </div>
    <footer>

    </footer>

</body>

</html>