<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>공지사항</title>
    <link rel="stylesheet" href="http://<?= $_SERVER['HTTP_HOST'] ?>/a4b1/common/css/common.css?ver=1">
    <link rel="stylesheet" href="http://<?= $_SERVER['HTTP_HOST'] ?>/a4b1/notice/css/notice.css?ver=1">
    <script src="http://<?= $_SERVER['HTTP_HOST'] ?>/a4b1/common/js/common.js?ver=1"></script>
    <script src="http://<?= $_SERVER['HTTP_HOST'] ?>/a4b1/notice/js/notice.js?ver=1"></script>
</head>
<body>
    <header>
        <?php include $_SERVER['DOCUMENT_ROOT'] . "/a4b1/common/lib/header.php"; ?>
    </header>
    <section>
        <div id="notice_box">
            <h3 id="notice_title">
                게시판 > 수정
            </h3>
            <?php
            $num = $_GET['num'];
            $page = $_GET['page'];

            $mode = "insert";
            require $_SERVER['DOCUMENT_ROOT'] . "/a4b1/common/lib/db.mysqli.class.php";
            //싱글톤 객체 불러오기
            $db = DB::getInstance();
            $db->sessionStart();
            $dbcon = $db->connector();

            if(isset($_GET['urgent']) && $_GET['urgent'] == 't') $sql = "SELECT * FROM notice_urgent WHERE num ={$num}";
            else $sql = "SELECT * FROM notice WHERE num = {$num}";

            $result = mysqli_query($dbcon,$sql) or die("쿼리문 오류1 : " . mysqli_error($dbcon));;
            $row = mysqli_fetch_array($result);

            $create_by = $row["created_by"];
            $title = $row["title"];
            $content = $row["content"];
            $create_at = $row["created_at"];
            $file_name = $row["file_name"];
            $file_copied = $row["file_copied"];
            $file_type = $row["file_type"];
            $hit = $row["hit"];
            ?>
        <form name="notice_form" method="post" action="dmi_notice.php" enctype="multipart/form-data">
            <ul id="notice_form">
                <li>
                    <?php
                        if(isset($_GET['urgent']) && $_GET['urgent'] == 't') {
                    ?>
                    <input type="hidden" name="urgent" value="t">
                    <?php } ?>
                    <input type="hidden" name="mode" value="modify">
                    <input type="hidden" name="num" value="<?=$num?>">
                    <input type="hidden" name="page" value="<?=$page?>">
                    <span class="list1">작성자 : </span>
                    <span class="list2"><?= $_SESSION['id'] ?></span>
                </li>
                <li>
                    <span class="list1">제목 : </span>
                    <span class="list2"><input name="title" type="text" value="<?= $title ?>"></span>
                </li>
                <li id="text_area">
                    <span class="list1">내용 : </span>
                    <span class="list2">
	    				<textarea name="content"><?= $content ?></textarea>
	    			</span>
                </li>
                <?php
                    if($file_copied) {
                ?>
                <li>
                    <span class="list1">현재 첨부 파일 : </span>
                    <span class="list2"><?= $file_name ?></span>
                </li>
                <?php } ?>
                <li>
                    <span class="list1">변경할 첨부 파일 : </span>
                    <input type="file" name="upfile" value="<?= $file_name ?>">
                </li>
            </ul>
            <ul class="buttons">
                <li>
                    <button type="button" onclick="check_input()">수정</button>
                </li>
                <li>
                    <button type="button" onclick="location.href='index.php?page=<?=$page?>'">목록</button>
                </li>
            </ul>
        </form>
        </div> <!-- board_box -->
    </section>
</body>
</html>
