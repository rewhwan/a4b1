<?php
require $_SERVER['DOCUMENT_ROOT'] . "/a4b1/common/lib/db.mysqli.class.php";

//싱글톤 객체 불러오기
$db = DB::getInstance();
$db->sessionStart();
?>
<!doctype html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <title>A4B1's Game Box</title>
    <!--css 추가-->
    <link rel="stylesheet" href="http://<?= $_SERVER['HTTP_HOST'] ?>/a4b1/footer/css/terms.css?ver=1">
    <!--Jquery 추가-->
    <script src="http://<?= $_SERVER['HTTP_HOST'] ?>/a4b1/common/js/jquery/jquery-3.5.1.min.js?ver=1"></script>

    <!--헤더 파일 추가-->
    <link rel="stylesheet" href="http://<?= $_SERVER['HTTP_HOST'] ?>/a4b1/common/css/common.css?ver=1">
    <script src="http://<?= $_SERVER['HTTP_HOST'] ?>/a4b1/common/js/common.js?ver=1"></script>

    <!--alert & toastr 라이브러리 추가-->
    <link rel="stylesheet" href="http://<?= $_SERVER['HTTP_HOST'] ?>/a4b1/common/css/toastr/toastr.min.css?ver=1"/>
    <script src="http://<?= $_SERVER['HTTP_HOST'] ?>/a4b1/common/js/toastr/toastr.min.js?ver=1"></script>
    <script src="http://<?= $_SERVER['HTTP_HOST'] ?>/a4b1/common/js/sweetalert/sweetalert.min.js?ver=1"></script>

    <!--메인화면 파일 추가-->
    <link rel="stylesheet" href="http://<?= $_SERVER['HTTP_HOST'] ?>/a4b1/main/css/main.css?ver=1"/>
    <script src="http://<?= $_SERVER['HTTP_HOST'] ?>/a4b1/main/js/main.js?ver=1"></script>

</head>
<body id="body">
    <header>
        <?php include $_SERVER['DOCUMENT_ROOT'] . "/a4b1/common/lib/header.php"; ?>
    </header>
    <div id="privacy_container">
        <div id="privacy">
            <h1>개인 정보 수집 및 이용 동의</h1>
        </div>

        <div id="privacy_content">
            1. 개인정보의 수집항목 및 이용 목적 <br>
            <br>
            A. 회사는 다음과 같이 개인정보를 수집하여 이용합니다. <br>
            ⅰ. 필수항목 : 이름,생년월일,휴대폰번호,이동통신사,암호화된 계정정보,휴대폰 기종, USIM정보,백업/복구용 이메일 정보 <br>
            B. 서비스 이용과정이나 사업처리과정에서 다음과 같은 정보들이 생성되어 수집될 수 있습니다. <br>
            ⅰ. 서비스 신청기록, 이용/해지 기록 등 서비스 이용시 발생한 내역 <br>
            ⅱ. 접속로그, 접속IP정보, 가입경로, 서비스 이용정보 <br>
            C. 이용목적 <br>
            ⅰ. 사용자관리 <br>
            가) 서비스 이용에 따른 본인확인, 개인식별 <br>
            나)가입의사 확인, 가입 <br>
            다) 기기 변경시 개인정보의 이동 <br>
            라) 고지사항 전달 및 가입자 불만 접수 및 처리 의사소통 경로 확보 <br>
            ⅱ. 서비스 제공에 따른 요금정산 <br>
            가) 구매 및 요금결제, 거래내역 관리 <br>
            나) 컨텐츠 제공, 이벤트/경품당첨 결과안내 및 상품배송 <br>
            ⅲ. 마케팅 및 광고 활용 <br>
            가) 가입자에게 최적화된 서비스 제공 <br>
            나) 서비스 이용에 대한 통계 <br>
            다) 서비스 및 상품 안내 <br>
            <br>
            <br>
            2. 개인정보의 수집 방법 <br>
            A. 회사는 이동전화 기타 디지털 디바이스, 서비스 어플리케이션에서의 가입 절차, 이벤트나 경품 행사, 개인정보 취급업무 수탁사 또는 제휴사 등으로부터의 수집, 이동 전화 및 유,무선 인터넷
            서비스 사용시 생성정보 수집 툴을 통한 방법 등으로 개인 정보를 수집합니다. <br>
            3. 개인정보의 보유 및 이용기간 <br>
            A. 가입자의 개인정보는 본 서비스 가입자에게 서비스를 제공하는 기간 동안에 보유 및 이용되고, 서비스 탈회 시 수집된 개인의 정보가 열람 또는 이용될 수 없도록 파기 처리됩니다. <br>
            다만, 관계법령의 규정에 의하여 보존할 필요성이 있는 경우에는 관계법령에 따라 보존합니다. <br>
            B. 가입자의 동의를 받아 보유하고 있는 거래정보에 대해 가입자가 열람을 요구하는 경우에는 지체 없이 해당 정보를 열람/ 확인할 수 있도록 조치합니다. <br>
            C. 가입자가 자발적으로 서비스를 탈회한 경우 서비스 재가입, 임의 해지 등을 반복적으로 행함으로써 본 서비스가 제공하는 할인쿠폰, 이벤트 혜택 등의 경제상의 이익을 불법 편법적으로 수취하거나
            <br>
            이 과정에서 명의도용 등의 행위가 발생하는 것을 방지하기 위한 목적으로 서비스 탈회 후 6개월 동안 사용자의 식별정보를 보관합니다. <br>
            D. 가입자가 서비스 사용을 종료하신 이후 서비스 제공과 관련된 각종 문의사항에 응대하기 위해 서비스 사용로그는 서비스 종료 후 12개월간 보관하며, 위치정보 이용, 제공사실 확인자료는 6개월간
            보관합니다. <br>
            ';
            } else {
            echo '
            1. 광고성 정보의 이용목적 <br>
            회사가 제공하는 이용자 맞춤형 서비스 및 상품 추천, 각종 경품 행사, 이벤트 등의 광고성 정보를 전자우편이나 서신우편, 문자(SMS 또는 카카오 알림톡), 푸시, 전화 등을 통해 이용자에게
            제공합니다. <br>
            <br>
            - 마케팅 수신 동의는 거부하실 수 있으며 동의 이후에라도 고객의 의사에 따라 동의를 철회할 수 있습니다. <br>
            동의를 거부하시더라도 회사가 제공하는 서비스의 이용에 제한이 되지 않습니다. 단, 할인, 이벤트 및 이용자 맞춤형 상품 추천 등의 마케팅 정보 안내 서비스가 제한됩니다. <br>
            <br>
            2. 미동의 시 불이익 사항 <br>
            개인정보보호법 제22조 제5항에 의해 선택정보 사항에 대해서는 동의 거부하시더라도 서비스 이용에 제한되지 않습니다. 단, 할인, 이벤트 및 이용자 맞춤형 상품 추천 등의 마케팅 정보 안내
            서비스가 제한됩니다. <br>
            <br>
            3. 서비스 정보 수신 동의 철회 <br>
            회사에서 제공하는 마케팅 정보를 원하지 않을 경우 ‘내 정보 수정 > 추가 정보’에서 철회를 요청할 수 있습니다. 또한 향후 마케팅 활용에 새롭게 동의하고자 하는 경우에는 ‘내 정보 수정 >
            추가 정보’에서 동의하실 수 있습니다. <br>
            <br>
        </div>
    </div>
    <footer>
        <?php include $_SERVER['DOCUMENT_ROOT'] . "/a4b1/common/lib/footer.php"; ?>
    </footer>
</body>
</html>
