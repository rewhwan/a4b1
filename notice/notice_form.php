<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>공지사항 작성</title>
    <link rel="stylesheet" href="http://<?= $_SERVER['HTTP_HOST'] ?>/a4b1/common/css/common.css?ver=1">
    <link rel="stylesheet" href="http://<?= $_SERVER['HTTP_HOST'] ?>/a4b1/notice/css/notice.css?ver=1">
    <script src="http://<?= $_SERVER['HTTP_HOST'] ?>/a4b1/common/js/common.js?ver=1"></script>
    <script src="http://<?= $_SERVER['HTTP_HOST'] ?>/a4b1/notice/js/notice.js?ver=1"></script>
</head>
</head>
<body>
    <?php
    session_start();
    ?>
    <header>
        <?php include $_SERVER['DOCUMENT_ROOT'] . "/a4b1/common/lib/header.php"; ?>
    </header>

    <section id="insert_form_notice_container">

        <div id="notice_box">
            <h3 id="notice_title">
                공지사항 > 글 쓰기
            </h3>
            <form name="notice_form" method="post" action="dmi_notice.php" enctype="multipart/form-data">
                <input type="hidden" name="mode" value="insert">
                <ul id="notice_form">
                    <li>
                        <span class="list1">작성자 : </span>
                        <span class="list2"><?= $_SESSION['id']?></span>

                    </li>
                    <li>
                        <span class="list1">제목 : </span>
                        <span class="list2">
                            <input name="title" type="text">
                            <label>긴급공지
                                <input type="checkbox" name="cb">
                            </label>
                        </span>


                    </li>
                    <li id="text_area">
                        <span class="list1">내용 : </span>
                        <span class="list2">
	    				<textarea name="content"></textarea>
	    			</span>
                    </li>
                    <li>
                        <span class="list1"> 첨부 파일</span>
                        <span class="list2"><input type="file" name="upfile"></span>
                    </li>
                </ul>
                <ul class="buttons">
                    <li>
                        <button type="button" onclick="check_input()">등록</button>
                    </li>
                    <li>
                        <button type="button" onclick="location.href='index.php'">목록</button>
                    </li>
                </ul>
            </form>
        </div> <!-- board_box -->
    </section>
    <footer>
        <?php include $_SERVER['DOCUMENT_ROOT'] . "/a4b1/common/lib/footer.php"; ?>
    </footer>
</body>
</html>
