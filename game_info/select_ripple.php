<?php
        if(isset($_REQUEST['num'])){
        //설정한 지역의 시간대로 설정
        date_default_timezone_set('Asia/Seoul');
        require $_SERVER['DOCUMENT_ROOT'] . "/a4b1/common/lib/db.mysqli.class.php";
        include $_SERVER['DOCUMENT_ROOT'] . "/a4b1/common/lib/submit_function.php";
        //싱글톤 객체 불러오기
        $db = DB::getInstance();
        $dbcon = $db->connector();

        //상수 지정
        define('SCALE', 5);
        $num = $_REQUEST['num'];
        //전체 레코드수를 가져와 총 페이지 계산
        $sql = "SELECT * from `game_info_ripples` where `info_num` = $num order by `num` desc";
        $result = mysqli_query($dbcon, $sql) or die("list select error1 : " . mysqli_error($dbcon));
        $total_record = mysqli_num_rows($result);
        //딱 맞아 떨어지면 그대로 아니면 올림수로 계산
        $total_page = ($total_record % SCALE == 0) ? ($total_record / SCALE) : (ceil($total_record / SCALE));

        //2.페이지가 없으면 디폴트 페이지 1페이지
        if (empty($_REQUEST['page'])) {
            $page = 1;
        } else {
            $page = $_REQUEST['page'];
        }
        $returnArray = array('isSuccess'=>array(),'data'=>array());

        $start = ($page - 1) * SCALE;
        $number = $total_record - $start;
        $e=0;
        //while ($row = mysqli_fetch_array($result4)) {
        for ($i = $start; $i < $start + SCALE && $i < $total_record; $i++) {
            $sql = "SELECT * from `game_info_ripples` where `info_num` = $num order by num desc";
            $result4 = mysqli_query($dbcon, $sql) or die("ripple select error1 : ".mysqli_error($dbcon));
            mysqli_data_seek($result4, $i);
            $row = mysqli_fetch_array($result4);
            $count = mysqli_num_rows($result4);
            // $ripple_content = $row['content'];
            // $ripple_create_by = $row['created_by'];
            // $ripple_create_at = $row['created_at'];
            // $ripple_num = $row['num'];
            
            $returnArray['isSuccess'][0]=1;
            $returnArray['isSuccess'][1]=$total_page;
            $returnArray['isSuccess'][2]=$count;
            $returnArray['isSuccess'][3]=SCALE;
            
            
            $returnArray['data'][$e]=$row;
            $e++;
            
            
            $number--;
            }
        }else{
            $returnArray['isSuccess']=0;
        }
        mysqli_close($dbcon);
        echo json_encode($returnArray);
        ?>