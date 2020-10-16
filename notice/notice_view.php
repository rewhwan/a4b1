<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>공지사항</title>
    <link rel="stylesheet" href="http://<?= $_SERVER['HTTP_HOST'] ?>/a4b1/common/css/common.css?ver=1">
    <link rel="stylesheet" href="http://<?= $_SERVER['HTTP_HOST'] ?>/a4b1/notice/css/notice.css?ver=1">
    <script src="http://<?= $_SERVER['HTTP_HOST'] ?>/a4b1/common/js/common.js?ver=1"></script>
    <script src="http://<?= $_SERVER['HTTP_HOST'] ?>/a4b1/notice/js/notice.js?"></script>
</head>
<body id="body">
    <?php
    require $_SERVER['DOCUMENT_ROOT'] . "/a4b1/common/lib/db.mysqli.class.php";
    include $_SERVER['DOCUMENT_ROOT'] . "/a4b1/common/lib/submit_function.php";
    //싱글톤 객체 불러오기
    $db = DB::getInstance();
    $db->sessionStart();
    $dbcon = $db->connector();
    ?>
    <header>
        <?php include $_SERVER['DOCUMENT_ROOT'] . "/a4b1/common/lib/header.php"; ?>
    </header>
    <section id="view_notice_container">
        <div id="notice_box">
            <h3 class="title">
                공지사항 > 내용
            </h3>
            <?php
            $num = $_GET["num"];
            $page = $_GET["page"];
            $urgent = $_GET["urgent"];

            //공지사항폼에서 긴급공지로 올릴때
            if(isset($_GET["urgent"]) && $urgent == 't') $sql = "select * from notice_urgent where num={$num}";
            else $sql = "select * from notice where num=$num";

            $result = mysqli_query($dbcon, $sql);

            $row = mysqli_fetch_array($result);
            $created_by = $row["created_by"];
            $created_at = $row["created_at"];
            $title = $row["title"];
            $content = $row["content"];
            $file_name = $row["file_name"];
            $file_type = $row["file_type"];
            $file_copied = $row["file_copied"];//데이터에 저장되어 있는 이름
            $hit = $row["hit"];

            $content = str_replace(" ", "&nbsp;", $content);
            $content = str_replace("\n", "<br>", $content);

            $new_hit = $hit + 1;

            if(isset($_GET["urgent"]) && $urgent == 't') $sql = "update notice_urgent set hit=$new_hit where num='$num'";
            else $sql = "update notice set hit=$new_hit where num='$num'";
            mysqli_query($dbcon, $sql);
            ?>
            <ul id="view_content">
                <li>
                    <span class="list1"><b>제목 :</b> <?= $title ?></span>
                    <span class="list2"><b>작성자 :</b> <?= $created_by ?> <b>등록일 :</b> <?= $created_at ?></span>
                </li>
                <li>
                    <?php
                    if ($file_name) {
                        $real_name = $file_copied;
                        $file_path = "./data/" . $real_name;
                        $file_size = filesize($file_path);//filesize php 라이브러리 함수

                        echo "▷ 첨부파일 : $file_name ($file_size Byte) &nbsp;&nbsp;&nbsp;&nbsp;
			       		<a href='notice_download.php?num=$num&real_name=$real_name&file_name=$file_name&file_type=$file_type'>[저장]</a><br><br>";
                        echo "<img src='./data/".$file_copied."' id='notice_view_image'>";
                    }
                    ?>
                    <br>
                    <?= $content ?>
                </li>
            </ul>
            <ul class="buttons">
                <li>
                    <button onclick="location.href='index.php?page=<?= $page ?>'">목록</button>
                </li>
                <?php
                if (isset($_SESSION['admin'])&&$_SESSION['admin'] >= 1) {
                    ?>
                    <li>
                        <?php if(isset($_GET["urgent"]) && $urgent == 't') { ?>
                            <button onclick="location.href='notice_modify_form.php?num=<?= $num ?>&page=<?= $page ?>&urgent=t'">수정
                        <?php }else { ?>
                            <button onclick="location.href='notice_modify_form.php?num=<?= $num ?>&page=<?= $page ?>'">수정
                        <?php } ?>
                        </button>
                    </li>
                    <form name="notice_form" method="post" action="dmi_notice.php"
                          enctype="multipart/form-data">
                        <li>
                            <button>삭제</button>
                            <input type="hidden" name="mode" value="delete">
                            <?php if(isset($_GET["urgent"]) && $urgent == 't') { ?>
                                <input type="hidden" name="urgent" value="t">
                            <?php } ?>
                            <input type="hidden" name="num" value="<?= $num ?>">
                            <input type="hidden" name="page" value="<?= $page ?>">
                        </li>
                    </form>
                    <li>
                        <button onclick="location.href='notice_form.php'">글쓰기</button>
                    </li>
                    <?php
                }
                ?>
            </ul>
        </div> <!-- notice_box -->
    </section>
    <footer>
        <?php include $_SERVER['DOCUMENT_ROOT'] . "/a4b1/common/lib/footer.php"; ?>
    </footer>
</body>
</html>