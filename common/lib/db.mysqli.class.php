<?php


class DB
{
    protected $host = "jbstv.synology.me:3307";

    protected $user = "a4b1";
    protected $password = "Last41game!";

    protected $charset = "utf8";
    protected $port = "3307";

    protected $dbName = "a4b1";

    //싱글톤 패턴
    protected function __construct() {}

    //싱글톤 패턴
    public static function getInstance() {
        static $inst = null;
        if($inst == null) $inst = new DB();
        return $inst;
    }

    public function mysqliConnect() {
        $dbflag = "NO";
        $con = mysqli_connect($this->host,$this->user,$this->password,'');
        $con->set_charset($this->charset);
        if (!$con) die("Connection failed: " . mysqli_connect_error());

        $sql = "show databases;";
        $result = mysqli_query($con,$sql) or die('Error: ' . mysqli_error($con));
        while ($row = mysqli_fetch_row($result)) {
            if ($row[0] === "a4b1") {
                $dbflag = "OK";
                break;
            }
        }

        if ($dbflag === "NO") {
            $sql = "CREATE database a4b1";
            if (mysqli_query($con, $sql)) echo '<script>alert("a4b1 데이터베이스가 생성되었습니다.");</script>';
            else echo "실패원인" . mysqli_error($con);
        }

        $dbcon = mysqli_select_db($con, "a4b1") or die('Error:' . mysqli_error($con));

        return $con;
    }

    public function createProcedure() {
        $con = mysqli_connect($this->host,$this->user,$this->password,'a4b1');
        if (!$con) die("Connection failed: " . mysqli_connect_error());

        //프로시저가 존재하는지 확인
        $sql = "show procedure status WHERE Db = 'a4b1' AND Name = 'create_tables'";
        $result = mysqli_query($con,$sql) or die('Error: ' . mysqli_error($con));
        $result_num = mysqli_num_rows($result);

        //프로시저 존재여부에 따른 분기점
        if($result_num != 0 ) return false;

        //테이블을 만들어주는 프로시저 생성
        $sql = "
        CREATE PROCEDURE create_tables()
        BEGIN
            CREATE TABLE IF NOT EXISTS `deleted_game_info` (
                `num` int(11) NOT NULL AUTO_INCREMENT,
                `name` varchar(50) NOT NULL,
                `content` text DEFAULT NULL,
                `developer` varchar(30) NOT NULL,
                `grade` varchar(8) NOT NULL,
                `release_date` date NOT NULL,
                `price` int(11) NOT NULL,
                `homepage` varchar(100) NOT NULL,
                `service_kor` tinyint(1) NOT NULL,
                `circulation` varchar(30) NOT NULL,
                `image` varchar(50) DEFAULT NULL,
                `created_by` varchar(15) NOT NULL,
                `created_at` datetime NOT NULL,
                `hit` int(11) NOT NULL,
                PRIMARY KEY (`num`)
            ) ENGINE=InnoDB AUTO_INCREMENT=253 DEFAULT CHARSET=utf8;
        
            CREATE TABLE `deleted_game_info_files` (
                `num` int(11) NOT NULL AUTO_INCREMENT,
                `info_num` int(11) NOT NULL,
                `name` varchar(50) NOT NULL,
                PRIMARY KEY (`num`),
                KEY `info_num` (`info_num`),
                CONSTRAINT `deleted_game_info_files_ibfk_1` FOREIGN KEY (`info_num`) REFERENCES `deleted_game_info` (`num`)
            ) ENGINE=InnoDB AUTO_INCREMENT=328 DEFAULT CHARSET=utf8;
            
            CREATE TABLE `deleted_game_info_genre` (
                `num` int(11) NOT NULL AUTO_INCREMENT,
                `info_num` int(11) NOT NULL,
                `genre` varchar(30) NOT NULL,
                PRIMARY KEY (`num`),
                KEY `info_num` (`info_num`),
                CONSTRAINT `deleted_game_info_genre_ibfk_1` FOREIGN KEY (`info_num`) REFERENCES `deleted_game_info` (`num`)
            ) ENGINE=InnoDB AUTO_INCREMENT=297 DEFAULT CHARSET=utf8;
            
            CREATE TABLE `deleted_game_info_platform` (
                `num` int(11) NOT NULL AUTO_INCREMENT,
                `info_num` int(11) NOT NULL,
                `platform` varchar(30) NOT NULL,
                PRIMARY KEY (`num`),
                KEY `info_num` (`info_num`),
                CONSTRAINT `deleted_game_info_platform_ibfk_1` FOREIGN KEY (`info_num`) REFERENCES `deleted_game_info` (`num`)
            ) ENGINE=InnoDB AUTO_INCREMENT=325 DEFAULT CHARSET=utf8;
            
            CREATE TABLE `deleted_game_review` (
                `num` int(11) NOT NULL AUTO_INCREMENT,
                `name` varchar(30) NOT NULL,
                `title` varchar(30) NOT NULL,
                `content` varchar(1000) NOT NULL,
                `created_at` datetime NOT NULL,
                `created_by` varchar(15) NOT NULL,
                `hit` int(11) NOT NULL,
                PRIMARY KEY (`num`)
            ) ENGINE=InnoDB AUTO_INCREMENT=194 DEFAULT CHARSET=utf8;
            
            CREATE TABLE `deleted_game_review_files` (
                `num` int(11) NOT NULL AUTO_INCREMENT,
                `review_num` int(11) NOT NULL,
                `name` varchar(200) NOT NULL,
                PRIMARY KEY (`num`),
                KEY `review_num` (`review_num`),
                CONSTRAINT `deleted_game_review_files_ibfk_1` FOREIGN KEY (`review_num`) REFERENCES `deleted_game_review` (`num`)
            ) ENGINE=InnoDB AUTO_INCREMENT=448 DEFAULT CHARSET=utf8;
            
            CREATE TABLE `deleted_game_review_point` (
                `review_num` int(11) NOT NULL,
                `story` int(11) NOT NULL,
                `graphic` int(11) NOT NULL,
                `time` int(11) NOT NULL,
                `difficulty` int(11) NOT NULL,
                PRIMARY KEY (`review_num`),
                CONSTRAINT `deleted_game_review_point` FOREIGN KEY (`review_num`) REFERENCES `deleted_game_review` (`num`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
            
            CREATE TABLE `deleted_members` (
                `id` varchar(15) NOT NULL,
                `password` varbinary(80) NOT NULL,
                `name` varchar(8) NOT NULL,
                `phone` varchar(15) NOT NULL,
                `email` varchar(30) DEFAULT NULL,
                `admin` tinyint(2) NOT NULL,
                `created_at` datetime NOT NULL,
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
            
            CREATE TABLE `deleted_notice` (
                `num` int(11) NOT NULL AUTO_INCREMENT,
                `title` varchar(100) NOT NULL,
                `content` text NOT NULL,
                `file_name` varchar(100) DEFAULT NULL,
                `file_type` varchar(10) DEFAULT NULL,
                `file_copied` varchar(100) DEFAULT NULL,
                `hit` int(11) NOT NULL,
                `created_by` varchar(15) NOT NULL,
                `created_at` datetime NOT NULL,
                PRIMARY KEY (`num`)
            ) ENGINE=InnoDB AUTO_INCREMENT=105 DEFAULT CHARSET=utf8;
            
            CREATE TABLE `deleted_notice_urgent` (
                `num` int(11) NOT NULL AUTO_INCREMENT,
                `title` varchar(100) NOT NULL,
                `content` text NOT NULL,
                `file_name` varchar(100) DEFAULT NULL,
                `file_type` varchar(10) DEFAULT NULL,
                `file_copied` varchar(100) DEFAULT NULL,
                `hit` int(11) NOT NULL,
                `created_by` varchar(15) NOT NULL,
                `created_at` datetime NOT NULL,
                PRIMARY KEY (`num`)
            ) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;
            
            CREATE TABLE `game_info` (
                `num` int(11) NOT NULL AUTO_INCREMENT,
                `name` varchar(50) NOT NULL,
                `content` text DEFAULT NULL,
                `developer` varchar(30) NOT NULL,
                `grade` varchar(8) NOT NULL,
                `release_date` date NOT NULL,
                `price` int(11) NOT NULL,
                `homepage` varchar(100) NOT NULL,
                `service_kor` tinyint(1) NOT NULL,
                `circulation` varchar(30) NOT NULL,
                `image` varchar(50) DEFAULT NULL,
                `created_by` varchar(15) NOT NULL,
                `created_at` datetime NOT NULL,
                `hit` int(11) NOT NULL,
                PRIMARY KEY (`num`)
            ) ENGINE=InnoDB AUTO_INCREMENT=253 DEFAULT CHARSET=utf8;
            
            CREATE TABLE `game_info_files` (
                `num` int(11) NOT NULL AUTO_INCREMENT,
                `info_num` int(11) NOT NULL,
                `name` varchar(50) NOT NULL,
                PRIMARY KEY (`num`),
                KEY `info_num` (`info_num`),
                CONSTRAINT `game_info_files_ibfk_1` FOREIGN KEY (`info_num`) REFERENCES `game_info` (`num`)
            ) ENGINE=InnoDB AUTO_INCREMENT=328 DEFAULT CHARSET=utf8;
            
            CREATE TABLE `game_info_genre` (
                `num` int(11) NOT NULL AUTO_INCREMENT,
                `info_num` int(11) NOT NULL,
                `genre` varchar(30) NOT NULL,
                PRIMARY KEY (`num`),
                KEY `info_num` (`info_num`),
                CONSTRAINT `game_info_genre_ibfk_1` FOREIGN KEY (`info_num`) REFERENCES `game_info` (`num`)
            ) ENGINE=InnoDB AUTO_INCREMENT=297 DEFAULT CHARSET=utf8;
            
            CREATE TABLE `game_info_platform` (
                `num` int(11) NOT NULL AUTO_INCREMENT,
                `info_num` int(11) NOT NULL,
                `platform` varchar(30) NOT NULL,
                PRIMARY KEY (`num`),
                KEY `info_num` (`info_num`),
                CONSTRAINT `game_info_platform_ibfk_1` FOREIGN KEY (`info_num`) REFERENCES `game_info` (`num`)
            ) ENGINE=InnoDB AUTO_INCREMENT=325 DEFAULT CHARSET=utf8;
            
            CREATE TABLE `game_info_ripples` (
                `num` int(11) NOT NULL AUTO_INCREMENT,
                `info_num` int(11) NOT NULL,
                `content` text NOT NULL,
                `created_by` varchar(15) NOT NULL,
                `created_at` datetime NOT NULL,
                PRIMARY KEY (`num`),
                KEY `info_num` (`info_num`),
                CONSTRAINT `game_info_ripples_ibfk_1` FOREIGN KEY (`info_num`) REFERENCES `game_info` (`num`)
            ) ENGINE=InnoDB AUTO_INCREMENT=152 DEFAULT CHARSET=utf8;
            
            CREATE TABLE `game_review` (
                `num` int(11) NOT NULL AUTO_INCREMENT,
                `name` varchar(30) NOT NULL,
                `title` varchar(30) NOT NULL,
                `content` varchar(1000) NOT NULL,
                `created_at` datetime NOT NULL,
                `created_by` varchar(15) NOT NULL,
                `hit` int(11) NOT NULL,
                PRIMARY KEY (`num`)
            ) ENGINE=InnoDB AUTO_INCREMENT=194 DEFAULT CHARSET=utf8;
            
            CREATE TABLE `game_review_files` (
                `num` int(11) NOT NULL AUTO_INCREMENT,
                `review_num` int(11) NOT NULL,
                `name` varchar(200) NOT NULL,
                PRIMARY KEY (`num`),
                KEY `review_num` (`review_num`),
                CONSTRAINT `game_review_files_ibfk_1` FOREIGN KEY (`review_num`) REFERENCES `game_review` (`num`)
            ) ENGINE=InnoDB AUTO_INCREMENT=448 DEFAULT CHARSET=utf8;
            
            CREATE TABLE `game_review_point` (
                `review_num` int(11) NOT NULL,
                `story` int(11) NOT NULL,
                `graphic` int(11) NOT NULL,
                `time` int(11) NOT NULL,
                `difficulty` int(11) NOT NULL,
                PRIMARY KEY (`review_num`),
                CONSTRAINT `game_review_point` FOREIGN KEY (`review_num`) REFERENCES `game_review` (`num`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
            
            CREATE TABLE `game_review_ripples` (
                `num` int(11) NOT NULL AUTO_INCREMENT,
                `info_num` int(11) NOT NULL,
                `content` text NOT NULL,
                `created_by` varchar(15) NOT NULL,
                `created_at` datetime NOT NULL,
                PRIMARY KEY (`num`),
                KEY `info_num` (`info_num`),
                CONSTRAINT `game_review_ripples_ibfk_1` FOREIGN KEY (`info_num`) REFERENCES `game_review` (`num`)
            ) ENGINE=InnoDB AUTO_INCREMENT=148 DEFAULT CHARSET=utf8;
            
            CREATE TABLE `main_slide_files` (
                `num` int(11) NOT NULL AUTO_INCREMENT,
                `name` varchar(200) NOT NULL,
                PRIMARY KEY (`num`)
            ) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8;
            
            CREATE TABLE `members` (
                `id` varchar(15) NOT NULL,
                `password` varbinary(80) NOT NULL,
                `name` varchar(8) NOT NULL,
                `phone` varchar(15) NOT NULL,
                `email` varchar(30) DEFAULT NULL,
                `admin` tinyint(2) NOT NULL,
                `created_at` datetime NOT NULL,
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
            
            CREATE TABLE `notice` (
                `num` int(11) NOT NULL AUTO_INCREMENT,
                `title` varchar(100) NOT NULL,
                `content` text NOT NULL,
                `file_name` varchar(100) DEFAULT NULL,
                `file_type` varchar(10) DEFAULT NULL,
                `file_copied` varchar(100) DEFAULT NULL,
                `hit` int(11) NOT NULL,
                `created_by` varchar(15) NOT NULL,
                `created_at` datetime NOT NULL,
                PRIMARY KEY (`num`)
            ) ENGINE=InnoDB AUTO_INCREMENT=105 DEFAULT CHARSET=utf8;
            
            CREATE TABLE `notice_urgent` (
                `num` int(11) NOT NULL AUTO_INCREMENT,
                `title` varchar(100) NOT NULL,
                `content` text NOT NULL,
                `file_name` varchar(100) DEFAULT NULL,
                `file_type` varchar(10) DEFAULT NULL,
                `file_copied` varchar(100) DEFAULT NULL,
                `hit` int(11) NOT NULL,
                `created_by` varchar(15) NOT NULL,
                `created_at` datetime NOT NULL,
                PRIMARY KEY (`num`)
            ) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;
        END;";
        mysqli_query($con,$sql) or die('Error: ' . mysqli_error($con));

    }

    public function createTable() {
        $con = mysqli_connect($this->host,$this->user,$this->password,'a4b1');
        $sql = "CALL create_tables();";
        mysqli_query($con,$sql)  or die('Error: ' . mysqli_error($con));
    }

    public function sessionStart() {
        session_start();
    }

    public function sessionDestroy() {
        session_destroy();
    }

    public function connector() {
        $con = mysqli_connect($this->host,$this->user,$this->password,'a4b1');
        return $con;
    }

    function mysqliError($returnArray, $error){
        $returnArray['isSuccess'] = 0;
        $returnArray['errorMsg'] = $error;
        echo json_encode($returnArray);
    }
}