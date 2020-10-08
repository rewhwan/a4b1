<!doctype html>
<html lang="ko">
    <head>
        <meta charset="UTF-8">
        <title>아이디/비밀번호 찾기</title>

        <!--Jquery 추가-->
        <script src="http://<?= $_SERVER['HTTP_HOST'] ?>/a4b1/common/js/jquery/jquery-3.5.1.min.js?ver=1"></script>

        <!--헤더 파일 추가-->
        <link rel="stylesheet" href="http://<?= $_SERVER['HTTP_HOST'] ?>/a4b1/common/css/common.css?ver=1">
        <script src="http://<?= $_SERVER['HTTP_HOST'] ?>/a4b1/common/js/common.js?ver=1"></script>

        <!--alert & toastr 라이브러리 추가-->
        <link rel="stylesheet" href="http://<?= $_SERVER['HTTP_HOST'] ?>/a4b1/common/css/toastr/toastr.min.css?ver=1"/>
        <script src="http://<?= $_SERVER['HTTP_HOST'] ?>/a4b1/common/js/toastr/toastr.min.js?ver=1"></script>
        <script src="http://<?= $_SERVER['HTTP_HOST'] ?>/a4b1/common/js/sweetalert/sweetalert.min.js?ver=1"></script>

        <!--찾기 페이지 파일 추가-->
        <link rel="stylesheet" href="http://<?= $_SERVER['HTTP_HOST'] ?>/a4b1/login/css/find.css?ver=1">
        <script src="http://<?= $_SERVER['HTTP_HOST'] ?>/a4b1/login/js/find.js?ver=1"></script>
    </head>
    <body>
        <div class="tab_wrap">
            <div class="tab_menu_container">
                <button class="tab_menu_btn on" type="button">아이디 찾기</button>
                <button class="tab_menu_btn" type="button">비밀번호 찾기</button>
            </div>
            <div class="tab_box_container">
                <div class="tab_box on">
                    <div class="box">
                        <h2>아이디 찾기</h2>
                        <p>가입할때 입력했던 정보를 입력해 주세요.</p>
                        <div id="id_form" class="form">
                            <input type="text" id="id_form_name" name="name" placeholder="이름 입력">
                            <input type="text" id="id_form_email" name="email" placeholder="이메일 입력">
                            <input type="button" id="find_id_button" value="아이디 찾기">
                        </div>
                    </div>
                </div>
                <div class="tab_box">
                    <div class="box">
                        <h2>비밀번호 찾기</h2>
                        <p>가입할때 입력했던 정보를 입력해 주세요.</p>
                        <div id="id_form" class="form">
                            <input type="text" id="pw_form_id" name="name" placeholder="아이디 입력">
                            <div id="phone_input">
                                <select name="phone_one" id="phone_one">
                                    <option value="010" selected> 010 </option>
                                    <option value="011" > 011 </option>
                                </select> -
                                <input type="number" name="phone_two" id="phone_two" placeholder=" 0000 "> -
                                <input type="number" name="phone_three" id="phone_three" placeholder=" 0000 ">
                            </div>
                            <input id="send_code" type="button" name="" value=" 인증번호 발송 ">
                            <input type="text" id="password_certification" name="password_certification" placeholder=" 인증번호 입력 ">
                            <input type="button" id="find_pw_button" value="비밀번호 찾기">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
