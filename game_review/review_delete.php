<?php
    require $_SERVER['DOCUMENT_ROOT'] . "/a4b1/common/lib/db.mysqli.class.php";
    //싱글톤 객체 불러오기
    $db = DB::getInstance();
    $db->sessionStart();
    $dbcon = $db->connector();

    $num   = $_GET["num"];
    $page   = $_GET["page"];
    $created_by   = $_GET["created_by"];

    if (!isset($_SESSION['id']) && ($_SESSION['id'] != 'admin' || $_SESSION['id'] != $created_by) ) {
        echo "<script>
        alert('삭제권한이 없습니다')
        history.back(-1);
        </script>";
        return;
    }
    //리플 삭제 쿼리
    $sql = "DELETE from game_review_ripples where info_num = $num";
    mysqli_query($dbcon,$sql) or die("delet review ripples error : ".mysqli_error($dbcon));

    $sql = "select * from game_review_files where review_num = {$num}";
    $result = mysqli_query($dbcon,$sql) or die("쿼리문 오류1 : ".mysqli_error($dbcon));;

    //해당 리뷰에 파일이 존재하는지 확인 하는 조건문
    if(mysqli_num_rows($result) != 0) {
        //파일 삭제 반복문
        while($row = mysqli_fetch_array($result)) {
            $file_path = "./img/".$row['name'];
            if($row['name'] != null){
                unlink($file_path);
            }
        }

        //테이블 내용 삭제
        $sql = "delete from game_review_files where review_num = {$num}";
        mysqli_query($dbcon,$sql) or die("쿼리문 오류2 : ".mysqli_error($dbcon));;
    }

    $sql = "delete from game_review_point where review_num = {$num}";
    mysqli_query($dbcon,$sql) or die("쿼리문 오류3 : ".mysqli_error($dbcon));;

    $sql = "delete from game_review where num = {$num}";
    mysqli_query($dbcon,$sql) or die("쿼리문 오류4 : ".mysqli_error($dbcon));;

    mysqli_close($dbcon);

    echo "
    <script>
        alert('삭제가 완료 되었습니다.')
        location.href = 'index.php?num={$num}&page={$page}';
    </script>"
?>