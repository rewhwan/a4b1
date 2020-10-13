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

        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">

        <!--Jquery 추가-->
        <script src="http://<?= $_SERVER['HTTP_HOST'] ?>/a4b1/common/js/jquery/jquery-3.5.1.min.js?ver=1"></script>

        <!--헤더 파일 추가-->
        <link rel="stylesheet" href="http://<?= $_SERVER['HTTP_HOST'] ?>/a4b1/common/css/common.css?ver=1">
        <script src="http://<?= $_SERVER['HTTP_HOST'] ?>/a4b1/common/js/common.js?ver=1"></script>

        <!--리뷰 파일 추가-->
        <link rel="stylesheet" href="http://<?= $_SERVER['HTTP_HOST'] ?>/a4b1/game_review/css/review.css">
        <script src="http://<?= $_SERVER['HTTP_HOST'] ?>/a4b1/game_review/js/review.js?ver=1"></script>

        <!--alert & toastr 라이브러리 추가-->
        <link rel="stylesheet" href="http://<?= $_SERVER['HTTP_HOST'] ?>/a4b1/common/css/toastr/toastr.min.css?ver=1"/>
        <script src="http://<?= $_SERVER['HTTP_HOST'] ?>/a4b1/common/js/toastr/toastr.min.js?ver=1"></script>
        <script src="http://<?= $_SERVER['HTTP_HOST'] ?>/a4b1/common/js/sweetalert/sweetalert.min.js?ver=1"></script>

    </head>

    <style>

    </style>


    <body>
        <header>
            <?php include $_SERVER['DOCUMENT_ROOT'] . "/a4b1/common/lib/header.php"; ?>
        </header>
        <div id="insert_form_container">
            <form id="review_form" name="review_insert_form" method="POST" action="review_insert.php"
                  enctype="multipart/form-data">
                <h2>리뷰 작성하기</h2>
                <ul>
                    <li>
                        <p>게임검색</p>
                        <input type="text" id="game_name" name="game_name" placeholder="리뷰할 게임의 이름을 입력하여 검색">
                        <button type="button" id="game_search" class="btn btn-skype">검색</button>
                    </li>
                    <li id="game_search_result_container">
                        <p>검색결과</p>
                        <select id="game_search_result" name="name"></select>
                    </li>
                    <li>
                        <p>제목</p> <input type="text" id="title" name="title" placeholder="제목을 입력해주세요.">
                    </li>
                    <li>
                        <p>항목별 점수</p>
                        <div id="star_container">
                            <div class="story">
                                <p>스토리</p>
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
                            <div class="graphic">
                                <p>그래픽</p>
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
                    </li>
                    <li>
                        <div id="star_container">
                            <div class="time">
                                <p>러닝타임</p>
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
                            <div class="difficulty">
                                <p>난이도</p>
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
                    </li>
                    <li><p>리뷰내용</p><textarea name="content" id="content" cols="30" rows="10"></textarea></li>
                    <li><p>이미지 파일</p><input type="file" id="new_file" name="new_file[]" multiple accept="image/*"></li>
                </ul>
                <div id="submit_container">
                    <button type="button">취소</button>
                    <button id="submit_btn" type="button" onclick="check_input()">등록</button>
                </div>
            </form>
        </div>

    </body>

</html>