<?php
$name = $_POST['name'];
$num = $_POST['num'];
$content = $_POST['content'];

$returnArray = array('isSuccess'=>array(),'data'=>null);

if(isset($name) && isset($num) && isset($content)){
    //설정한 지역의 시간대로 설정
    date_default_timezone_set('Asia/Seoul');
    require $_SERVER['DOCUMENT_ROOT'] . "/a4b1/common/lib/db.mysqli.class.php";
    include $_SERVER['DOCUMENT_ROOT'] . "/a4b1/common/lib/submit_function.php";
    //싱글톤 객체 불러오기
    $db = DB::getInstance();
    $dbcon = $db->connector();

    $sql = "INSERT into `game_info_ripples` values(null,$num,'$content','$name',now())";
    mysqli_query($dbcon,$sql) or die("ripples insert error1 : ".mysqli_error($dbcon));

    $sql = "SELECT * from `game_info_ripples` where `info_num` =$num order by num desc limit 1";
    $result = mysqli_query($dbcon,$sql) or die("ripples select error1 : ".mysqli_error($dbcon));

    $row = mysqli_fetch_array($result);
    $returnArray['data']=$row; 
    $returnArray['isSuccess']=1;   

}else{
    // echo"실패";
    $returnArray['isSuccess']=0;   
}
    echo json_encode($returnArray);
    mysqli_close($dbcon);
?>
