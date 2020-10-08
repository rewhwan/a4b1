<?php 
    //설정한 지역의 시간대로 설정
    date_default_timezone_set("Asia/Seoul");
    require $_SERVER['DOCUMENT_ROOT'] . "/a4b1/common/lib/db.mysqli.class.php";
    include $_SERVER['DOCUMENT_ROOT']."/a4b1/common/lib/submit_function.php";
    //싱글톤 객체 불러오기
    $db = DB::getInstance();
    $dbcon = $db->connector();

    //세션 값 이용 관리자 인지 파악하기
    if (!isset($_SESSION['id']) || !$_SESSION['admin'] >= 1 || !$_SESSION['id'] == "admin") {
        alert_back("권한이 없습니다.");
    }
    $num = $_GET['num'];

    //댓글 삭제
    $sql = "DELETE from `game_info_ripples` where `info_num` = $num";
    mysqli_query($dbcon,$sql) or die("info_delete_error1 : ".mysqli_error($dbcon));

    //이미지 해제
    $sql = "SELECT * from `game_info_files` where info_num = {$num}";
    $result = mysqli_query($dbcon,$sql) or die("info_delete_error2 : ".mysqli_error($dbcon));

    //해당 정보에 관한 파일이 존재하는지 확인 하는 조건문
    echo mysqli_num_rows($result);
    if(mysqli_num_rows($result) != 0) {
        //파일 삭제 반복문
        while($row = mysqli_fetch_array($result)) {
            $file_path = "./img/screen/".$row['name'];
            unlink($file_path);
        }

        //스크린샷 테이블 내용 삭제
        $sql = "DELETE from `game_info_files` where `info_num` = {$num}";
        mysqli_query($dbcon,$sql) or die("info_delete_error3 : ".mysqli_error($dbcon));
    }
    //플랫폼 정보 내용 삭제
    $sql = "DELETE from `game_info_platform` where `info_num` = {$num}";
    mysqli_query($dbcon,$sql) or die("info_delete_error4 : ".mysqli_error($dbcon));

    //장르 정보 내용 삭제
    $sql = "DELETE from `game_info_genre` where `info_num` = {$num}";
    mysqli_query($dbcon,$sql) or die("info_delete_error5 : ".mysqli_error($dbcon));

    //삭제를 위한 게임정보 검색
    $sql = "SELECT * from `game_info` where `num` = {$num}";
    $result = mysqli_query($dbcon,$sql) or die("info_delete_error6 : ".mysqli_error($dbcon));

    //해당 리뷰에 파일이 존재하는지 확인 하는 조건문
    echo mysqli_num_rows($result);
    if(mysqli_num_rows($result) != 0) {
        //파일 삭제 반복문
        while($row = mysqli_fetch_array($result)) {
            $file_path = "./img/title/".$row['name'];
            unlink($file_path);
        }

        //게임정보 테이블 내용 삭제
        $sql = "DELETE from `game_info` where `num` = {$num}";
        mysqli_query($dbcon,$sql) or die("info_delete_error7 : ".mysqli_error($dbcon));
    }

    mysqli_close($dbcon);

    echo "
    <script>
        alert('삭제가 완료 되었습니다.')
        location.href = 'game_info_list.php?page={$page}';
    </script>";
?>