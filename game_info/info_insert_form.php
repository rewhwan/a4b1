<?php 
    session_start();
    include $_SERVER['DOCUMENT_ROOT']."/a4b1/common/lib/submit_function.php";
    if(intval($_SESSION['admin']) < 1){
        alert_back("권한이 없습니다.");
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="http://<?= $_SERVER['HTTP_HOST'] ?>/a4b1/common/css/common.css">
    <script src="http://code.jquery.com/jquery-latest.min.js"></script>
    <script src="http://<?=$_SERVER['HTTP_HOST']?>/a4b1/common/js/common.js?ver=1"></script>
    <script src="./js/info.js"></script>
</head>

<body>
    <header>
        <?php include $_SERVER['DOCUMENT_ROOT']."/a4b1/common/lib/header.php";?>
        
    </header>
    <!-- 파일을 보내기위한 인코딩 방식 설정 -->
    <form action="game_info_insert.php" method="post" enctype="multipart/form-data" id="insert_form">
        <ul>
            <li>
                <label for="title_image">타이틀 이미지</label>
                <input type="file" name="title_image" id="title_image" accept="image/*" onchange="file_check(this,'title_image')">
            </li>

            <br>
            <li>
                <label for="name">게임 명</label>
                <input type="text" name="name" id="name">
                <label for="developer">개발사</label>
                <input type="text" name="developer" id="developer">
            </li>
            
            <br>
            <li>
                <label for="platform">플랫폼</label>
                <label>PS3<input type="checkbox" name="platform[]" value="PS3"></label>
                <label>PS4<input type="checkbox" name="platform[]" value="PS4"></label>
                <label>PS5<input type="checkbox" name="platform[]" value="PS5"></label>
                <label>XBOX 360<input type="checkbox" name="platform[]" value="XBOX 360"></label>
                <label>XBOX one<input type="checkbox" name="platform[]" value="XBOX ONE"></label>
                <label>nintendo switch<input type="checkbox" name="platform[]" value="nintendo switch"></label>
            </li>

            <br>
            <li>
                <label for="genre">장르</label>
            </li>
            <li>
                <label>액션<input type="checkbox" name="genre[]" value="액션"></label>
                <label>공포<input type="checkbox" name="genre[]" value="공포"></label>
                <label>어드밴처<input type="checkbox" name="genre[]" value="어드밴처"></label>
                <label>롤플레잉<input type="checkbox" name="genre[]" value="롤플레잉"></label>
                <label>스포츠<input type="checkbox" name="genre[]" value="스포츠"></label>
            </li>
            <li>
                <label>레이싱<input type="checkbox" name="genre[]" value="레이싱"></label>
                <label>음악<input type="checkbox" name="genre[]" value="음악"></label>
                <label>퍼즐<input type="checkbox" name="genre[]" value="퍼즐"></label>
            </li>
            <li>
                <label for="open_day">출시일자</label>
                <input type="date" name="open_day" id="open_day">
            </li>
            <li>
                <span>심의등급</span>
                <br>
                <label for="all">전체이용가<input type="radio" name="grade" id="all" value="전체이용가"></label>
                <label for="12">12세이용가<input type="radio" name="grade" id="12" value="12세이용가"></label>
                <label for="15">15세이용가<input type="radio" name="grade" id="15" value="15세이용가"></label>
                <label for="18">청소년이용불가<input type="radio" name="grade" id="18" value="청소년이용불가"></label>
                <label for="empty">등급면제<input type="radio" name="grade" id="empty" value="등급면제"></label>
                <label for="test_ver">테스트용<input type="radio" name="grade" id="test_ver" value="테스트용"></label>
            </li>

            <br>
            <li>
                <label for="circulation">유통사</label>
                <input type="text" name="circulation" id="circulation">
                <label for="service_kor">한국어 지원</label>
                <label for="service_kor">지원 <input type="radio" name="service_kor" id="service_kor" value="1"></label>
                <label for="service_kor">미 지원 <input type="radio" name="service_kor" id="service_kor" value="0"></label>
                <label for="price">가격</label>
                <input type="number" name="price" id="price">
            </li>
            <br>
            <li>
                <label for="homepage">공식 홈페이지</label>
                <input type="text" name="homepage" id="homepage">
            </li>
            <br>
            <li>
                <label for="content">게임 개요</label>
                <br>
                <textarea name="content" id="content" cols="70" rows="10"></textarea>
            </li>
            <li>
                <label for="screen_shot">게임 내 스크린 샷</label>
                <input type="file" name="screen_shot[]" id="screen_shot" multiple accept="image/*" onchange="file_check(this,'screen_shot')">
            </li>
        </ul>
    </form>
    <?php if(intval($_SESSION['admin']) >= 1){?>
    <button onclick="check_input()">등록하기</button>
    <?php } ?>
</body>

</html>