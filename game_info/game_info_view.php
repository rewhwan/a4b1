<?php
    //설정한 지역의 시간대로 설정
    date_default_timezone_set('Asia'/'Seoul');
    require $_SERVER['DOCUMENT_ROOT'] . "/a4b1/common/lib/db.mysqli.class.php";

    //싱글톤 객체 불러오기
    $db = DB::getInstance();
    $dbcon = $db->MysqliConnect();
    //쿼리문 작성
    $sql = "SELECT * from game_info";
    //쿼리문 실행
    $result = mysqli_query($dbcon,$sql) or die("문제사항 : ".mysqli_error($dbcon));
    while($row = mysqli_fetch_array($result)){
        $num = $row["num"];
        $name = $row["name"];
        $content = $row["content"];
        $developer = $row["developer"];
        $grade = $row["grade"];
        $release_date = $row["release_date"];
        $price = $row["price"];
        $price = strval($price);
        $homepage = $row["homepage"];
        $service_kor = $row["service_kor"];
        if($service_kor == 1){
            $service_kor = "지원";
        }else{
            $service_kor = "미 지원";
        }
        $circulation = $row["circulation"];
        $image = $row["image"];
        $create_by = $row["create_by"];
        $create_at = $row["create_at"];

        echo"$num,,$name,,$content,,$developer,,$grade,,$release_date,,$price,,$homepage,,$service_kor,,$circulation,,$image,,$create_by,,$create_at";
        echo"<img src='http://".$_SERVER['HTTP_HOST']."/a4b1/game_info/img/title/$image'>";
    }
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="http://<?=$_SERVER['HTTP_HOST']?>/a4b1/common/css/common.css?ver=1">
    <script src="http://<?=$_SERVER['HTTP_HOST']?>/a4b1/common/js/common.js?ver=1"></script>
    <title>Document</title>
</head>
<body>
    <header>
        <?php include $_SERVER['DOCUMENT_ROOT']."/a4b1/common/lib/header.php";?>
    </header>
</body>
</html>