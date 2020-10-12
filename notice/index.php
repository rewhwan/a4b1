<?php
require $_SERVER['DOCUMENT_ROOT'] . "/a4b1/common/lib/db.mysqli.class.php";
//싱글톤 객체 불러오기
$db = DB::getInstance();
$db->sessionStart();
$dbcon = $db->connector();
?>

<!doctype html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <title>공지사항</title>
    <link rel="stylesheet" href="http://<?= $_SERVER['HTTP_HOST'] ?>/a4b1/common/css/common.css?ver=1">
    <link rel="stylesheet" href="http://<?= $_SERVER['HTTP_HOST'] ?>/a4b1/notice/css/notice.css?ver=1">
    <script src="http://<?= $_SERVER['HTTP_HOST'] ?>/a4b1/common/js/common.js?ver=1"></script>
    <script src="http://<?= $_SERVER['HTTP_HOST'] ?>/a4b1/common/js/common.js?ver=1"></script>
</head>
<body>
    <header>
        <?php include $_SERVER['DOCUMENT_ROOT'] . "/a4b1/common/lib/header.php"; ?>
    </header>

    <section>
        <div id="notice_box">
            <h3>공지사항 > 목록</h3>
            <ul id="notice_list">
                <li>
                    <span class="list1">번호</span>
                    <span class="list2">제목</span>
                    <span class="list3">작성자</span>
                    <span class="list4">첨부</span>
                    <span class="list5">등록일</span>
                    <span class="list6">조회수</span>
                </li>


                <?php

                if (isset($_GET["page"])) $page = $_GET["page"];
                else $page = 1;

                //현재 날짜에서 3일 이내의 긴급 공지를 가져옴 오름차순
                $sql = "SELECT * FROM notice_urgent WHERE date(now())-date(created_at) <=3 order by created_at DESC";
                $result = mysqli_query($dbcon, $sql);

                //쿼리문 결과값을 변수로 저장
                $total_record_urgent_notice = mysqli_num_rows($result);
                $urgent_notice_array = mysqli_fetch_all($result);

                $sql = "select * from notice order by num desc";
                $result = mysqli_query($dbcon, $sql);
                $total_record = mysqli_num_rows($result);

                $scale = 10;

                if ($total_record % $scale == 0)
                    $total_page = floor($total_record / $scale);
                else
                    $total_page = floor($total_record / $scale) + 1;

                $start = ($page - 1) * $scale;

                $number = $start + 1;

                for ($i = $start; $i < $start + $scale && $i < $total_record; $i++) {
                    mysqli_data_seek($result, $i);

                    $row = mysqli_fetch_array($result);

                    $num = $row["num"];
                    $create_by = $row["created_by"];
                    $title = $row["title"];
                    $create_at = $row["created_at"];
                    $file_name = $row["file_name"];
                    $file_copied = $row["file_copied"];
                    $file_type = $row["file_type"];
                    $hit = $row["hit"];
                    if ($row["file_name"])
                        $file_image = "<img src='./image/file.gif'>";
                    else
                        $file_image = " ";
                    ?>
                    <li>
                        <span class="list1"><?= $number ?></span>
                        <span class="list2"><a
                                    href="notice_view.php?num=<?= $num ?>&page=<?= $page ?>"><?= $title ?></a></span>
                        <span class="list3"><?= $create_by ?></span>
                        <span class="list4"><?= $file_image ?></span>
                        <span class="lust5"><?= $create_at ?></span>
                        <span class="list6"><?= $hit ?></span>
                    </li>
                    <?php
                    $number++;
                }
                mysqli_close($dbcon);
                ?>
            </ul>
            <ul id="page_num">
                <?php
                if ($total_page >= 2 && $page >= 2) {

                    $new_page = $page - 1;
                    echo "<li> <a href='index.php?page=$new_page'> ◀ 이전</a> </li>";

                } else {

                    echo "<li>&nbsp;</li>";
                }
                //공지사항 목록 하단 페이지 번호 출력
                for ($i = 1; $i <= $total_page; $i++) {
                    if ($page === $i) {

                        echo "<li><b>$i</b></li>";

                    } else {

                        echo "<li> <a href='index.php?page=$i'> $i </a> </li>";
                    }
                }
                if ($total_page >= 2 && $page != $total_page) {

                    $new_page = $page + 1;
                    echo "<li><a href='index.php?page=$new_page'> 다음 ▶</a></li>";
                } else {

                    echo "<li>&nbsp;</li>";
                }
                ?>
            </ul>
            <ul class="buttons">
                <li>
                    <button onclick="location.href='index.php">목록</button>
                </li>
                <?php
                if (isset($_SESSION['admin'])&&$_SESSION['admin'] >= 1) {
                    ?>
                    <li>
                        <button onclick="location.href='notice_form.php'">글쓰기</button>
                    </li>
                    <?php
                }
                ?>
            </ul>
        </div>
    </section>
</body>
</html>