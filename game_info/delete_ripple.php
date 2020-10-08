<?php
$num = $_POST['num'];

$returnArray = array('isSuccess'=>array(),'data'=>null);

if(isset($num)){
    //설정한 지역의 시간대로 설정
    date_default_timezone_set('Asia' / 'Seoul');
    require $_SERVER['DOCUMENT_ROOT'] . "/a4b1/common/lib/db.mysqli.class.php";
    include $_SERVER['DOCUMENT_ROOT'] . "/a4b1/common/lib/submit_function.php";
    //싱글톤 객체 불러오기
    $db = DB::getInstance();
    $dbcon = $db->connector();
    $sql = "DELETE from `game_info_ripples` where `num` = $num";
    mysqli_query($dbcon,$sql) or die("delete ripple error : ".mysqli_error($dbcon));
    $returnArray['isSuccess']=1;   
    $returnArray['data']=$num; 

}else{
    // echo"실패";
    $returnArray['isSuccess']=0;   
}
    echo json_encode($returnArray);
?>