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
            <title>A4B1 Admin Stage</title>

            <!--Jquery 추가-->
            <script src="http://<?= $_SERVER['HTTP_HOST'] ?>/a4b1/common/js/jquery/jquery-3.5.1.min.js?ver=1"></script>

            <!--alert & toastr 라이브러리 추가-->
            <link rel="stylesheet"
                  href="http://<?= $_SERVER['HTTP_HOST'] ?>/a4b1/common/css/toastr/toastr.min.css?ver=1"/>
            <script src="http://<?= $_SERVER['HTTP_HOST'] ?>/a4b1/common/js/toastr/toastr.min.js?ver=1"></script>
            <script src="http://<?= $_SERVER['HTTP_HOST'] ?>/a4b1/common/js/sweetalert/sweetalert.min.js?ver=1"></script>

            <!--헤더 파일 추가-->
            <link rel="stylesheet" href="http://<?= $_SERVER['HTTP_HOST'] ?>/a4b1/admin/css/admin.css?ver=1">
            <script src="http://<?= $_SERVER['HTTP_HOST'] ?>/a4b1/admin/js/admin.js?ver=1"></script>

            <meta name="viewport"
                  content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        </head>
        <!--관리자 권한에 따른 처리-->
        <?php if (isset($_SESSION['admin']) && $_SESSION['admin'] == 2) { ?>
            <body id="body">
                <?php include $_SERVER['DOCUMENT_ROOT'] . "/a4b1/admin/admin_menu.php" ?>
                <div id="member_table_container">
                    <h2>멤버 권한 관리</h2>
                    <div id="badge_container">
                        <div id="sample_badge">
                            <span>회원 구분 : </span>
                            <span class='badge badge_member'>일반회원</span>
                            <span class='badge badge_director'>부어드민</span>
                            <span class='badge badge_admin'>어드민</span>
                        </div>
                    </div>
                    <div id="member_table">
                        <table>
                            <tr>
                                <th>이름</th>
                                <th>아이디</th>
                                <th>권한 상태</th>
                                <th>일반회원</th>
                                <th>부어드민</th>
                                <th>어드민</th>
                            </tr>
                            <?php
                            $sql = 'SELECT * FROM members';
                            $result = mysqli_query($dbcon, $sql);
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<tr>";

                                echo "<td>{$row['name']}</td>
                                <td>{$row['id']}</td>";

                                if ($row['admin'] == 0) echo "<td><div class='badge badge_member'>일반회원</div></td>";
                                else if ($row['admin'] == 1) echo "<td><div class='badge badge_director'>부어드민</div></td>";
                                else echo "<td><div class='badge badge_admin'>어드민</div></td>";

                                echo "<td><button>변경</button></td>
                                <td><button>변경</button></td>
                                <td><button>변경</button></td>";

                                echo "</tr>";
                            }
                            ?>
                        </table>
                    </div>
                </div>
            </body>
        <?php } ?>
    </html>
<?php
//관리자 인지 여부 체크 -> 접근 권한
if (!isset($_SESSION['admin']) || $_SESSION['admin'] != 2) {
    echo "<script>
            swal({
                title: '권한 없음',
                text: '관리자 권한이 없습니다.',
            icon: 'error',}).then(()=>{location.href='http://" . $_SERVER['HTTP_HOST'] . "/a4b1/'});
        </script>";
}
?>