    <!doctype html>
    <html lang="ko">
    <?php
    require $_SERVER['DOCUMENT_ROOT'] . "/a4b1/common/lib/db.mysqli.class.php";
    include $_SERVER['DOCUMENT_ROOT'] . "/a4b1/common/lib/submit_function.php";
    //싱글톤 객체 불러오기
    $db = DB::getInstance();
    $db->sessionStart();
    $dbcon = $db->connector();
    // mode로 검색인지 아닌지 파악
    if (isset($_GET['mode'])) {
        $mode = $_GET['mode'];
    } else {
        $mode = "";
    }
    //페이지 파악
    if (isset($_GET["page"]))
                        $page = $_GET["page"];
                    else
                        $page = 1;

                    //검색 기능 mode 가 있는지 확인
                    if ($mode === "search") {
                        $search = $_GET['search'];
                        $search_word = $_GET['search_word'];
                        $sql = "select * from game_review left join game_review_point on num = review_num where $search like '%$search_word%' order by num desc";
                    } else {
                        $sql = "select * from game_review left join game_review_point on num = review_num order by num desc";
                    }

                    $result = mysqli_query($dbcon, $sql);
                    $total_record = mysqli_num_rows($result);
                    if($total_record == 0 && $mode == "search"){
                        alert_back('검색 결과가 없습니다.');
                    }
                    if($total_record == 0 && $mode==""){
                        echo"<script>alert('등록된 리뷰가 없습니다.');</script>";
                    }
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
        <script src="http://<?= $_SERVER['HTTP_HOST'] ?>/a4b1/game_review/js/review.js?ver=1"></script>
    </head>
    <?php
      if($total_record != 0){  
    ?>
    <body id="body">
        <header>
            <?php include $_SERVER['DOCUMENT_ROOT'] . "/a4b1/common/lib/header.php"; ?>
        </header>

        <div id="container_body">
            <div id="top">
                <ul>
                    <select name="search" id="search">
                        <option value="" id="option_no">선택</option>
                        <option value="title" id="option_title">제목</option>
                        <option value="created_by" id="option_created_by">작성자</option>
                        <option value="content" id="option_content">내용</option>
                    </select>
                    <li><input type="text" name="search_word" id="search_word" onkeypress="check_enter(event)"></li>
                    <li><button onclick="check_search()">검색</button></li>
                </ul>
                <?php
                

                if (isset($_GET['search'])  && isset($_GET['search_word'])) {
                    $value = $_GET['search'];
                    $word = $_GET['search_word'];
                    echo "<script>search_word_check('$value','$word');</script>";
                }

            //검색기능 구현 파트
                // $sql = "select *,truncate((story+graphic+time+difficulty)/4,1) AS avg from game_review_point group by review_num order by avg desc;";
                // $result = mysqli_query($dbcon, $sql);
                // $row = mysqli_num_rows($result);
                // $avg = $row['avg'];
                ?>
            </div>


            <div id="list">
                <ul>
                    <?php
                    


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
                        <a href="http://<?= $_SERVER['HTTP_HOST'] ?>/a4b1/game_review/view.php?num=<?= $num ?>&page=<?= $page ?>">
                            <li id="list_info">
                                <img src="http://<?= $image ?>">
                                <h1><?= $title ?></h1>
                                <div>
                                    <div>game : </div>
                                    <div> <?= $name ?></div>
                                </div>
                                <div>
                                    <div>grade : </div>
                                    <div> <?= $avg ?></div>
                                </div>
                                <div>
                                    <div>creater : </div>
                                    <div><?= $created_by ?></div>
                                </div>
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
                        echo "<li><a id='selected_page'> $i </a></li>";
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
            <ul id="review_insert">
                <li><a href="http://<?= $_SERVER['HTTP_HOST'] ?>/a4b1/game_review/review_insert_form.php"><button>글쓰기</button></a></li>
            </ul>

        </div>
        <footer>
            <?php include $_SERVER['DOCUMENT_ROOT'] . "/a4b1/common/lib/footer.php"; ?>
        </footer>

    </body>
    <?php
      }
    ?>            
    </html>