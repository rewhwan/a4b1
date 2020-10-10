<?php
    require $_SERVER['DOCUMENT_ROOT'] . "/a4b1/common/lib/db.mysqli.class.php";

    //싱글톤 객체 불러오기
    $db = DB::getInstance();
    $db->sessionStart();
    $dbcon = $db->connector();

    $returnArray = array('isSuccess' => null, 'data' => null);

    $name = $_POST['name'];

    $sql = "SELECT * FROM game_info WHERE name like '%". $name ."%'";
    $result = mysqli_query($dbcon, $sql) or die ($db->mysqliError($returnArray, mysqli_error($dbcon)));

    if(mysqli_num_rows($result) != 0) {
        $returnArray['isSuccess'] = 1;
        $returnArray['data'] = mysqli_fetch_all($result,MYSQLI_ASSOC);
    }else {
        $returnArray['isSuccess'] = 0;
    }

    echo json_encode($returnArray);