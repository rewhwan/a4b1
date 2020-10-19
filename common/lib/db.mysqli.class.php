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
        
            CREATE TABLE IF NOT EXISTS `deleted_game_info_files` (
                `num` int(11) NOT NULL AUTO_INCREMENT,
                `info_num` int(11) NOT NULL,
                `name` varchar(50) NOT NULL,
                PRIMARY KEY (`num`)
            ) ENGINE=InnoDB AUTO_INCREMENT=328 DEFAULT CHARSET=utf8;
            
            CREATE TABLE IF NOT EXISTS `deleted_game_info_genre` (
                `num` int(11) NOT NULL AUTO_INCREMENT,
                `info_num` int(11) NOT NULL,
                `genre` varchar(30) NOT NULL,
                PRIMARY KEY (`num`)
            ) ENGINE=InnoDB AUTO_INCREMENT=297 DEFAULT CHARSET=utf8;
            
            CREATE TABLE IF NOT EXISTS `deleted_game_info_platform` (
                `num` int(11) NOT NULL AUTO_INCREMENT,
                `info_num` int(11) NOT NULL,
                `platform` varchar(30) NOT NULL,
                PRIMARY KEY (`num`)
            ) ENGINE=InnoDB AUTO_INCREMENT=325 DEFAULT CHARSET=utf8;
            
            CREATE TABLE IF NOT EXISTS `deleted_game_review` (
                `num` int(11) NOT NULL AUTO_INCREMENT,
                `name` varchar(30) NOT NULL,
                `title` varchar(30) NOT NULL,
                `content` varchar(1000) NOT NULL,
                `created_at` datetime NOT NULL,
                `created_by` varchar(15) NOT NULL,
                `hit` int(11) NOT NULL,
                PRIMARY KEY (`num`)
            ) ENGINE=InnoDB AUTO_INCREMENT=194 DEFAULT CHARSET=utf8;
            
            CREATE TABLE IF NOT EXISTS `deleted_game_review_files` (
                `num` int(11) NOT NULL AUTO_INCREMENT,
                `review_num` int(11) NOT NULL,
                `name` varchar(200) NOT NULL,
                PRIMARY KEY (`num`)
            ) ENGINE=InnoDB AUTO_INCREMENT=448 DEFAULT CHARSET=utf8;
            
            CREATE TABLE IF NOT EXISTS `deleted_game_review_point` (
                `review_num` int(11) NOT NULL,
                `story` int(11) NOT NULL,
                `graphic` int(11) NOT NULL,
                `time` int(11) NOT NULL,
                `difficulty` int(11) NOT NULL,
                PRIMARY KEY (`review_num`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
            
            CREATE TABLE IF NOT EXISTS `deleted_members` (
                `id` varchar(15) NOT NULL,
                `password` varbinary(80) NOT NULL,
                `name` varchar(8) NOT NULL,
                `phone` varchar(15) NOT NULL,
                `email` varchar(30) DEFAULT NULL,
                `admin` tinyint(2) NOT NULL,
                `created_at` datetime NOT NULL,
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
            
            CREATE TABLE IF NOT EXISTS `deleted_notice` (
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
            
            CREATE TABLE IF NOT EXISTS `deleted_notice_urgent` (
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
            
            CREATE TABLE IF NOT EXISTS `game_info` (
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
            
            CREATE TABLE IF NOT EXISTS `game_info_files` (
                `num` int(11) NOT NULL AUTO_INCREMENT,
                `info_num` int(11) NOT NULL,
                `name` varchar(50) NOT NULL,
                PRIMARY KEY (`num`),
                KEY `info_num` (`info_num`),
                CONSTRAINT `game_info_files_ibfk_1` FOREIGN KEY (`info_num`) REFERENCES `game_info` (`num`)
            ) ENGINE=InnoDB AUTO_INCREMENT=328 DEFAULT CHARSET=utf8;
            
            CREATE TABLE IF NOT EXISTS `game_info_genre` (
                `num` int(11) NOT NULL AUTO_INCREMENT,
                `info_num` int(11) NOT NULL,
                `genre` varchar(30) NOT NULL,
                PRIMARY KEY (`num`),
                KEY `info_num` (`info_num`),
                CONSTRAINT `game_info_genre_ibfk_1` FOREIGN KEY (`info_num`) REFERENCES `game_info` (`num`)
            ) ENGINE=InnoDB AUTO_INCREMENT=297 DEFAULT CHARSET=utf8;
            
            CREATE TABLE IF NOT EXISTS `game_info_platform` (
                `num` int(11) NOT NULL AUTO_INCREMENT,
                `info_num` int(11) NOT NULL,
                `platform` varchar(30) NOT NULL,
                PRIMARY KEY (`num`),
                KEY `info_num` (`info_num`),
                CONSTRAINT `game_info_platform_ibfk_1` FOREIGN KEY (`info_num`) REFERENCES `game_info` (`num`)
            ) ENGINE=InnoDB AUTO_INCREMENT=325 DEFAULT CHARSET=utf8;
            
            CREATE TABLE IF NOT EXISTS `game_info_ripples` (
                `num` int(11) NOT NULL AUTO_INCREMENT,
                `info_num` int(11) NOT NULL,
                `content` text NOT NULL,
                `created_by` varchar(15) NOT NULL,
                `created_at` datetime NOT NULL,
                PRIMARY KEY (`num`),
                KEY `info_num` (`info_num`),
                CONSTRAINT `game_info_ripples_ibfk_1` FOREIGN KEY (`info_num`) REFERENCES `game_info` (`num`)
            ) ENGINE=InnoDB AUTO_INCREMENT=152 DEFAULT CHARSET=utf8;
            
            CREATE TABLE IF NOT EXISTS `game_review` (
                `num` int(11) NOT NULL AUTO_INCREMENT,
                `name` varchar(30) NOT NULL,
                `title` varchar(30) NOT NULL,
                `content` varchar(1000) NOT NULL,
                `created_at` datetime NOT NULL,
                `created_by` varchar(15) NOT NULL,
                `hit` int(11) NOT NULL,
                PRIMARY KEY (`num`)
            ) ENGINE=InnoDB AUTO_INCREMENT=194 DEFAULT CHARSET=utf8;
            
            CREATE TABLE IF NOT EXISTS `game_review_files` (
                `num` int(11) NOT NULL AUTO_INCREMENT,
                `review_num` int(11) NOT NULL,
                `name` varchar(200) NOT NULL,
                PRIMARY KEY (`num`),
                KEY `review_num` (`review_num`),
                CONSTRAINT `game_review_files_ibfk_1` FOREIGN KEY (`review_num`) REFERENCES `game_review` (`num`)
            ) ENGINE=InnoDB AUTO_INCREMENT=448 DEFAULT CHARSET=utf8;
            
            CREATE TABLE IF NOT EXISTS `game_review_point` (
                `review_num` int(11) NOT NULL,
                `story` int(11) NOT NULL,
                `graphic` int(11) NOT NULL,
                `time` int(11) NOT NULL,
                `difficulty` int(11) NOT NULL,
                PRIMARY KEY (`review_num`),
                CONSTRAINT `game_review_point` FOREIGN KEY (`review_num`) REFERENCES `game_review` (`num`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
            
            CREATE TABLE IF NOT EXISTS `game_review_ripples` (
                `num` int(11) NOT NULL AUTO_INCREMENT,
                `info_num` int(11) NOT NULL,
                `content` text NOT NULL,
                `created_by` varchar(15) NOT NULL,
                `created_at` datetime NOT NULL,
                PRIMARY KEY (`num`),
                KEY `info_num` (`info_num`),
                CONSTRAINT `game_review_ripples_ibfk_1` FOREIGN KEY (`info_num`) REFERENCES `game_review` (`num`)
            ) ENGINE=InnoDB AUTO_INCREMENT=148 DEFAULT CHARSET=utf8;
            
            CREATE TABLE IF NOT EXISTS `main_slide_files` (
                `num` int(11) NOT NULL AUTO_INCREMENT,
                `name` varchar(200) NOT NULL,
                PRIMARY KEY (`num`)
            ) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8;
            
            CREATE TABLE IF NOT EXISTS `members` (
                `id` varchar(15) NOT NULL,
                `password` varbinary(80) NOT NULL,
                `name` varchar(8) NOT NULL,
                `phone` varchar(15) NOT NULL,
                `email` varchar(30) DEFAULT NULL,
                `admin` tinyint(2) NOT NULL,
                `created_at` datetime NOT NULL,
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
            
            CREATE TABLE IF NOT EXISTS `notice` (
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
            
            CREATE TABLE IF NOT EXISTS `notice_urgent` (
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

        $sql = "
        CREATE PROCEDURE create_dummy_data()
        BEGIN
            INSERT INTO `notice_urgent` VALUES (17, '카카오톡 서비스 점검', '안녕하세요. 카카오입니다.\r\n\r\n항상 카카오 서비스를 이용해 주시는 고객님께 깊은 감사를 드립니다. \r\n\r\n더욱 안정적인 서비스를 제공해 드리기 위해 카카오계정 시스템 점검이 진행될 예정입니다. \r\n\r\n점검 시간 동안 카카오 일부 서비스가 중단되오니 양해 부탁드립니다. \r\n\r\n\r\n\r\n1. 점검 일시\r\n\r\n: 2020년 9월 22일 새벽 2시 ~ 6시 (GMT+09:00)\r\n\r\n  (예상치 못한 문제로 작업이 지연될 경우 시간이 연장될 수 있습니다.)\r\n\r\n\r\n\r\n2. 점검 영향\r\n\r\n: 점검 시간 동안 아래 서비스 이용 불가\r\n\r\n- 카카오계정 가입 (카카오톡 제외)\r\n\r\n- Daum, Melon 신규 가입/통합 \r\n\r\n- Daum 서비스 탈퇴\r\n\r\n- Daum 서비스를 이용 중인 카카오계정 탈퇴 \r\n\r\n\r\n\r\n서비스 이용에 불편을 드린 점 다시 한번 사과드리며, \r\n\r\n보다 편하고 안정적인 서비스로 보답하겠습니다. \r\n\r\n\r\n\r\n감사합니다.', NULL, NULL, NULL, 0, 'admin', '2020-10-17 20:52:03');
            INSERT INTO `notice` VALUES (93, '몬스터헌터월드 new업데이트', '밀라보레아스의 출현!\r\n\r\n\r\n링크 접속이 안될 시 아래 링크를 복사해서 사용해주세요!\r\n\r\n공식 사이트 : https://www.monsterhunter.com/world-iceborne/pc/kr/topics/fatalis/', 'img01.png', 'image/png', '2020_10_15_02_46_10_img01.png', 22, 'admin', '2020-10-15 09:50:17');
            INSERT INTO `notice` VALUES (94, '몬스터 헌터월드 새로운 방어구 & 무기등장', '밀라보레아스 소재 방어구&무기 등장!!!\r\n\r\n\r\n\r\n\r\n링크 접속이 안될 시 아래 링크를 복사해서 사용해주세요!\r\n\r\n공식 사이트 : https://www.monsterhunter.com/world-iceborne/pc/kr/topics/fatalis/', 'images.jpg', 'image/jpeg', '2020_10_15_01_09_13_images.jpg', 23, 'admin', '2020-10-15 10:09:13');
            INSERT INTO `notice` VALUES (95, 'GTA5 블랙 프라이데이 세일', 'steam 블랙 프라이데이 세일 !!', 'gta5.jpg', 'image/jpeg', '2020_10_15_04_21_19_gta5.jpg', 4, 'admin', '2020-10-15 13:21:19');
            INSERT INTO `notice` VALUES (96, '위쳐3 리미티드 에디션 팩 판매', '차세대 콘솔 기념 리미티드 에디션 판매와\r\n기존 게임팩 할인!!', 'Witcher3-Switch-Two_witchers_are_always_better_than_one-RGB-en.7.jpg', 'image/jpeg', '2020_10_15_04_25_26_Witcher3-Switch-Two_witchers_are_always_better_than_one-RGB-en.7.jpg', 5, 'admin', '2020-10-15 13:25:26');
            INSERT INTO `notice` VALUES (97, '젤다의 전설 가격인하!', '꾸준히 닌텐도에서 사랑받아온 옛감성 그래픽 !\r\n젤다의 전설이 가격인하를했습니다!\r\n새로 구매 하실분은 지금이 기회입니다!', 'file.jpg', 'image/jpeg', '2020_10_15_04_28_01_file.jpg', 6, 'admin', '2020-10-15 13:28:01');
            INSERT INTO `notice` VALUES (98, '플레이테이션 게임 순위 !', '링크가 작동안될시 주소를 복사해서 사용해주세요 ㅠㅠ!\r\n\r\nhttps://store.playstation.com/ko-kr/grid/STORE-MSF86012-TOPSALESGAME/1', NULL, NULL, NULL, 10, 'admin', '2020-10-15 13:29:30');
            INSERT INTO `notice` VALUES (99, '스팀 게임 순위', '링크 클릭이 안될시 주소를 복사후 사용해주세요!\r\n\r\nhttps://m.blog.naver.com/114632/221978927743', NULL, NULL, NULL, 10, 'admin', '2020-10-15 13:32:59');
            INSERT INTO `notice` VALUES (100, 'FIFA21 (FS5,XBOX) new 업데이트', '더욱 다양해진 선수!!\r\n민천한 드리블\r\n포지셔닝 개인성\r\n창의적인 달리기 \r\n자연스러운 몸싸움 시스템과\r\n축구 기본기 더욱 업그레이드 된 피파21!!', 'fifa21-hero-medium-mbappe-7x2-xl1.jpg.adapt.crop16x9.320w.jpg', 'image/jpeg', '2020_10_15_04_36_39_fifa21-hero-medium-mbappe-7x2-xl1.jpg.adapt.crop16x9.320w.jpg', 10, 'admin', '2020-10-15 13:36:39');
            INSERT INTO `notice` VALUES (101, '바이오하자드 RE:2 + 바이오하자드 RE:3 에디션 판매중', '레지던트이블영화를 좋아하신분이라면 구매하시면 좋을상품\r\n라쿤시티 에디션', 'biohazard.png', 'image/png', '2020_10_15_04_45_34_biohazard.png', 5, 'admin', '2020-10-15 13:45:34');
            INSERT INTO `notice` VALUES (102, '모여봐요 동물의숲 가울 무료 업데이트 + 할로윈이벤트', '링크 접속이 안될시 링를 직접 복사후 사용해주세요\r\nhttps://www.nintendo.co.kr/software/switch/acbaa/index.html', 'nintendo.png', 'image/png', '2020_10_15_04_48_35_nintendo.png', 16, 'admin', '2020-10-15 13:48:35');
            INSERT INTO `notice` VALUES (103, '슈퍼 마리오 메이커2 new 업데이트 ver3.0', '커스텀 게임환경 코스배경기능 추가!', 'mario.png', 'image/png', '2020_10_15_04_51_10_mario.png', 28, 'admin', '2020-10-15 13:51:10');
            INSERT INTO `members` VALUES ('admin', 0x664819D8C5343676C9225B5ED00A5CDC6F3A1FF3, '관리자', '010-4362-5949', 'derrick11@naver.com', 2, '2020-10-17 20:27:59');
            INSERT INTO `members` VALUES ('jason12', 0xA8E6B4347F3C7D2DF4C26D556C8AC1DD3E8F3100, '제이슨', '010-4635-7719', 'lbhaudwo@naver.com', 1, '2020-10-17 17:55:09');
            INSERT INTO `members` VALUES ('kimbg', 0xAC385DC09DDE874C769FF9491C57385CA158A31C, '김병곤', '010-7287-0130', 'tmxhszi@naver.com', 0, '2020-10-18 17:20:10');
            INSERT INTO `members` VALUES ('kimgb', 0xAC385DC09DDE874C769FF9491C57385CA158A31C, '김병곤', '010-7287-0130', 'tmxhszi@naver.com', 0, '2020-10-18 17:15:16');
            INSERT INTO `members` VALUES ('rlawlsgur', 0x326149ED89273A290D17CDB3F7AC96F912C6704D, '김진혁', '010-4635-7719', 'lbhaudwo@naver.com', 0, '2020-10-17 18:42:10');
            INSERT INTO `members` VALUES ('tester12', 0xA8E6B4347F3C7D2DF4C26D556C8AC1DD3E8F3100, '이민혁', '010-4635-7719', 'lbhaudwo@naver.com', 0, '2020-10-17 17:53:20');
            INSERT INTO `members` VALUES ('yaieya', 0x364C78A63B0DC9E76568B5A80145BB01E2E66574, '야이야', '010-4635-7719', 'lbhaudwo@naver.com', 0, '2020-10-17 17:56:43');
            INSERT INTO `main_slide_files` VALUES (16, '2020_10_16_07_27_31_철권7.png');
            INSERT INTO `main_slide_files` VALUES (17, '2020_10_16_07_28_04_ahri.jpg');
            INSERT INTO `main_slide_files` VALUES (18, '2020_10_16_07_28_04_back1.jpg');
            INSERT INTO `main_slide_files` VALUES (19, '2020_10_16_07_28_04_back2.jpg');
            INSERT INTO `main_slide_files` VALUES (20, '2020_10_16_07_28_04_KakaoTalk_.jpg');
            INSERT INTO `main_slide_files` VALUES (21, '2020_10_16_07_28_04_lastofus.png');
            INSERT INTO `main_slide_files` VALUES (22, '2020_10_16_07_28_04_lastofus_screen1.png');
            INSERT INTO `main_slide_files` VALUES (24, '2020_10_16_07_28_04_supermario.png');
            INSERT INTO `main_slide_files` VALUES (26, '2020_10_16_08_38_27_onur-sahin-Ktf0j8Km40I-unsplash.jpg');
            INSERT INTO `game_review` VALUES (178, '218', '니드포스피드 후기', '[ 니드 포 스피드 히트 ]는 수많은 장점을 품고 등장한 작품입니다. 역대 시리즈들중에서 엄청난 명작이라고까지는 할 수 없지만 최근에 나온 몇몇 [ 니드 포 스피드 ] 작품들보다는 매우 완벽하게 나와준 작품이라고 볼 수 있었습니다. 거대하고 다양한 코스를 지닌 맵이라던지 여전히 우수한 그래픽 퀄리티와 사운드 그리고 더욱더 풍성해지고 다양한 컨텐츠라던지 훌륭한 인터페이스와 각종 디자인과 루트 박스 요소 제거 등 [ 니드 포 스피드 히트 ]는 여태까지 혹평을 계속해서 들어왔던 [ 니드 포 스피드 ] 시리즈를 다시 한번 세워놓은 작품이 되었다고 볼 수 있었습니다. 물론, 아쉬운 점도 몇몇 있었습니다. 버그와 오류 같은 경우가 종종 있었다라거나 캠페인 요소가 매우 짧게 끝났다라는것이 상당히 아쉽기는 하였지만 그래도 게임에 큰 타격을 입힐만한 단점은 아니였습니다. \r\n\r\n 그 정도로 [ 니드 포 스피드 히트 ]는 한번쯤 구매를 해볼 가치가 충분하다고 볼 수 있었던 작품이였습니다. 무엇보다도 소액 결제 없이 플레이어 자신이 직접 노력을 하면서 차량이나 파츠들을 직접 구매할 수 있다라는 점은 상당히 도전감을 크게 끌어들이는 요인이라고 볼 수 있었습니다. [ 니드 포 스피드 히트 ]의 마지막 총점은 10점 만점에 8점입니다. 여태까지 제가 플레이해온 [ 니드 포 스피드 ] 작품들 중 오래간만에 또 인상깊게 본 [ 니드 포 스피드 ] 작품이 아닐까 싶어보입니다. 이상으로 GAME COLOR 의 빅비였고 다음 리뷰에서는 보다 더 알찬 리뷰를 통해 다시 한번 만나뵙도록 하겠습니다. 그럼 읽어주셔서 대단히 감사합니다.', '2020-10-15 15:18:48', 'admin', 0);
            INSERT INTO `game_review` VALUES (179, '225', '젤다의전설 후기', '대망의 엔딩 플레이하면서 한번도 게임오버 화면을 보지 않았다면 나름 진엔딩을 볼수있다. 일단 기본적으로 젤다의 전설 게임 시스템을 따라가는지라, 재미는 어느정도 보장한다 퍼즐요소를 해결해나가는 재미 보스 패턴을 공략하는 재미 등등 애초에 기본 틀 자체가 너무 잘닦여있다고나 할까. 다만 개인적으로는 아쉬움이 많이남는데 ... 먼저 플레이 타임 헤매면서 해도 12~13 시간이면 클리어가 될정도로 굉장히 짧다 애초에 맵 필드가 작은것에서부터 어쩔수 없겟구나 라는 생각은 들었지만 그런부분 감안해도 간판 생각하면 짧긴 짧다.\r\n거기에 캐주얼 적이고 친근한 비주얼을 지녔음에도 불구하고 불친절한 진행은 덤... 브레스 오브더 와일드는 어떤 형태로 공략해도 상관없고 무슨아이템을 어떤방식으로 활용하든 플레이어의 자유고 그에 따라 공략법이 무척이나 다양했는데, 이게임은 그런것처럼 가장하고 있으면서 역설적이게도 완벽한 일자형 진행 게임이다. 기대한것보다 아쉬웠던 게임이다.....', '2020-10-15 17:24:49', 'admin', 0);
            INSERT INTO `game_review` VALUES (180, '226', 'GTA5 후기간다', '전반적 후기는 새로운작업? 미션? 해보려면 추천 집하나 더갖고프거나 루프탑바 갖고싶으면 추천 뭔가 큰 기대를 하고 이번 업데이트 쩔겠다 기대를 갖고 산다면 후회한다 한국에 서비스 규제가 너무많아서 이번 업데이트의 묘미를 절반이상 날렸다는게 너무 아쉽다.\r\n수정 업데이트로 카지노의 칩기능 생겻으니까 카지노가서 도박해보길 추천한다. 카지노내의 칩환전소에 가면 하루에 1000칩 씩주고 1달러에 1칩으로 교환이 가능하다 하루에 5만달러도 교환이 가능하다. 결론은 바뀐게 스토리랑 도박기능이다.... ', '2020-10-15 17:38:00', 'admin', 0);
            INSERT INTO `game_review` VALUES (181, '224', '동물의숲 힐링리뷰', '너~~~무 재미있습니다 힐링 되는 그기분 세상만사 퍼스트 라이프를 접어두고 세컨드라이프만 즐기고 싶습니다. 모든 속세의 굴레에서 벗어나 무인도로 떠나면 마음이 한결가벼워집니다. 이게임을 하면서 그런 기분을 느낄수가 있다니요...ㅠㅜ 바쁘고 빡센 게임에 질려있다면 아무것도 안해도 되는 자유. 게임계의 몰디브 동물의 숲으로 놀러오는건 어떨까요 (스위치와 , 콘솔을 구할수있다면요 ^______^)\r\n\r\n다음 리뷰에서는 모여봐요 동물의숲 꿀팁들을 알려드리겠습니다!', '2020-10-15 17:45:39', 'admin', 0);
            INSERT INTO `game_review` VALUES (182, '226', '명재의 GTA리뷰', '스샷에 포함되지 않은 것 중에는 놀이동산, 골프 등등 훨씬 더 많은 즐길거리가 있지만 너무 스샷이 많아서..ㅠㅠ\r\n\r\n이리저리 해보면 확실히 이 게임이 왜 작년에 라스트 오브 어스와 GOTY 경쟁을 펼쳤는지,\r\n\r\n그리고 왜 올해도 라스트 오브 어스 리마스터와 함께 최고의 게임으로 꼽는지 알 수 있었습니다.\r\n\r\n콘솔 게임기를 가지고 계시고 GTA5를 못해보셨다면 당장 구매하길 추천해 드립니다.\r\n\r\nPC버전을 기다리는 것도 좋지만, 콘솔 게임기, 특히 PS4 유저 분들이라면 내년 1월 18일 즈음엔 GTA5를 할 시간이 없을 테니까요.\r\n\r\n디 오더 : 1886, 블러드본 등의 독점작이 예정되어 있기에 지금 플레이해 보는 것이 더 좋지 않을까 합니다.\r\n\r\n오늘부터 파이널 판타지 13-2가 프리로드가 끝나고 발매되기에 다음 리뷰는 아마 이 녀석이 되지 않을까 싶습니다.\r\n\r\n검은 사막 해보자고 회사 동료들과 친구놈들이 꼬드겨서 그것도 해볼까 하고 있긴 한덴 어찌될지..ㅎㅎ', '2020-10-15 17:55:13', 'admin', 0);
            INSERT INTO `game_review` VALUES (183, '219', '병곤의 몬헌리뷰', '전작에 비해 사실 단순히 몬스터만 추가되거나 맵만 추가가 된건 아니다. 사실 필자는 태도만 플레이 했기 때문에 태도밖에는 모르지만 새로운걸로 특수 납도라는 부분이 생겼다.굳이 무리해서 기안 투구베기를 사용하지 않아도 되지만 체감상 투구베기가 더강하기는 한느낌 그리고 또 클러치라는 부분이 있는데 스크린샷 실패로 일단 몬스터에 간단히 올라타서 공격을 하던가 하는 방법인데 이게 생각보다 상다하누 변화다\r\n빠른 느낌의 전투가 가능하게 되었고 생각보다 상당한 변화다 특히 날고있는 몬스터를 잡기에는 근접 무기로는 힘든데 그런부분에서 플러스 요소였다 아무튼 이번에 몬스터헌터 월드 아이스본을 구매하고 엔딩까지 플레이 해봤다. 구매한지 5일만에 엔딩을 봤으며 생각보다 난이도는 높은편이다. 기존에 나왔던 몬스터도 이 아이스본에서는 훨씬 파워업 했으니 긴장을 해야할것이다. 사실 위에 언급한 새로운 전투 시스템은 체감하지 않으면 모르는 부분이라 새로운 무대와 새로운 몬스터 당연히 컨텐츠는 어느정도는 부족하다고 생각한다. 그중에서 당연히 몬스터가 적은건 점수를 까고싶다 새로 추가된 몬스터 보다는 기존의 몬스터를 아종으로 재탕하는 느낌을 버릴수가 없었다. 이런부분에서는 차후 업데이트를 통한 보완이 필요해 보인다.  ', '2020-10-15 18:07:53', 'admin', 0);
            INSERT INTO `game_review` VALUES (184, '220', '콜옵 콥등이?', '오래간만에 인피니티 워드 팀이 만든 콜오브 듀티를, 그것도 모던워페어 리부트를 하니 당연히 매우 재미있습니다. 콜옵 특유의 현장감은 다른 게임들에서는 맛보기 힘든 무엇인가가 있죠. 다만 옵션 타협을 보거나 그래픽 드라이브를 업그레이드한다는 등 몇 가지의 사전 작업이 필요로 하긴 하지만. 과거 콜옵의 싱글 캠페인에 팬이었던 저와 같은 분들에게는 당연히 요번 작품도 좋은 게임이 될 겁니다. 과거 보다 이야기의 노골적인 표현은 더 심해져서 러시아에는 판매조차 안 한다고 하죠? 전작들과 싱글 캠페인 볼륨 자체는 비슷하긴 한데, 요즘 게임들의 가성비를 생각하면 조금 짧게 느껴질 수도 있지만 게임 가격이 그래도 풀 프라이스는 아니고, 멀티도 재미있게 할 수 있을 테니 멀티플레이를 기대하고 있습니다.\r\n[출처] 콜 오브 듀티 모던 워페어 리부트 싱글 캠페인 리뷰 후기(call of duty modern warfare reboot)|작성자 영수', '2020-10-15 18:11:48', 'admin', 1);
            INSERT INTO `game_review` VALUES (185, '222', '포르자 리뷰', '전작 호라이즌 3는 호주를 배경으로 하고있지만 이는 현실을 기반으로 했다기보다 호주의 유명한 지형을 섞어만든 창조물에 가까웠습니다.\r\n하지만 호라이즌 4의 경우 에든버러의 도심을 상당히 구체적으로 갖고와 현실과 비현실의 경계를 조금씩 무너뜨리고 있습니다.\r\n이러한 형태로 계속 진화해간다면 언젠가는 호라이즌 서울도 볼 수 있을겁니다.\r\n\r\n개인적으로는 즐기는 게임으로서는 호라이즌 3가 약간 더 낫다고 생각합니다.\r\n하지만 호라이즌 3가 플레이 시간이 늘수록 단조롭게 느껴지는건 호라이즌 4가 좀 더 세심하게 만들었기 때문일겁니다.\r\n호라이즌 3보다 차량별 개성이 더 살아난점 역시 칭찬할만합니다.\r\n다만 피드백 설정을 좀 만져야 레이싱휠로 즐길만 하다는점, 상당히 높은 비율을 차지하는 오프로드 주행이 아주 어려워졌다는점은 조금 아쉽습니다.', '2020-10-15 18:17:00', 'admin', 0);
            INSERT INTO `game_review` VALUES (186, '221', '피파20 리뷰', '전체적으로 게임은 전작에 비해 몇가지 개선점을 갖췄지만,\r\n\r\n전작에 비해 그다지 크게 변화하진 못했습니다.\r\n\r\n한국인들 한정으로는 한글화가 된 점만으로도 19에서 넘어갈만 한 큰 이유가 되겠지만,\r\n\r\n이런 점들이 아니라면 오히려 게임 자체로는 뒤로 후퇴한 게 아닌가 싶을 정도로 개선점들이 그다지 마음에 드는 부분이 없습니다.\r\n\r\n물론, 피파 시리즈는 매년 그랬듯 게임 런칭 후 한참 지나 대규모 업데이트가 진행된 후에야 많이 나아짐을 생각해본다면 조금 더 기다려볼 만 합니다만,\r\n\r\n이러한 점도 이제 유저들이 점점 지쳐가는 중이라 봐야겠죠.\r\n\r\n피파 20의 리뷰는 여기까지입니다.\r\n\r\n사실 근래에는 여러가지로 바빠서 게임 리뷰가 점점 늦어지는 것 같습니다.\r\n\r\n개인적으로 공부하는 것들도 많고 하다보니 더더욱 늦어지는 감이 있지만, 그래도 올해의 남은 게임들은 저를 흥분시키기에 충분합니다.\r\n\r\n다음에는 애스트럴 체인, 혹은 콜 오브 듀티 : 모던 워페어 리부트로 찾아뵙겠습니다.', '2020-10-15 18:21:45', 'admin', 7);
            INSERT INTO `game_review_ripples` VALUES (134, 186, '첫번째 댓글입니당', 'user', '2020-10-17 15:45:50');
            INSERT INTO `game_review_ripples` VALUES (136, 184, '콜옵 짱', 'user', '2020-10-17 15:49:11');
            INSERT INTO `game_review_ripples` VALUES (137, 184, '이거는 인정이지', 'admin', '2020-10-17 15:50:15');
            INSERT INTO `game_review_ripples` VALUES (138, 184, '진짜 개꿀잼', 'admin', '2020-10-17 15:53:15');
            INSERT INTO `game_review_ripples` VALUES (139, 186, 'kdgkdgjd', 'admin', '2020-10-17 16:01:50');
            INSERT INTO `game_review_ripples` VALUES (147, 185, '정보감사요', 'admin', '2020-10-18 18:28:24');
            INSERT INTO `game_review_ripples` VALUES (148, 185, '정보 굳굳', 'admin', '2020-10-18 22:30:33');
            INSERT INTO `game_review_ripples` VALUES (149, 185, '굳굳굳', 'admin', '2020-10-18 22:30:38');
            INSERT INTO `game_review_ripples` VALUES (150, 185, '완전 멋져용', 'admin', '2020-10-18 22:30:42');
            INSERT INTO `game_review_point` VALUES (178, 5, 7, 5, 8);
            INSERT INTO `game_review_point` VALUES (179, 8, 6, 3, 2);
            INSERT INTO `game_review_point` VALUES (180, 8, 8, 6, 5);
            INSERT INTO `game_review_point` VALUES (181, 10, 8, 10, 6);
            INSERT INTO `game_review_point` VALUES (182, 10, 8, 9, 8);
            INSERT INTO `game_review_point` VALUES (183, 10, 6, 7, 9);
            INSERT INTO `game_review_point` VALUES (184, 10, 9, 8, 8);
            INSERT INTO `game_review_point` VALUES (185, 6, 10, 4, 8);
            INSERT INTO `game_review_point` VALUES (186, 6, 8, 4, 8);
            INSERT INTO `game_review_files` VALUES (341, 178, '2020_10_15_06_20_14_needfor_screnshot1.png');
            INSERT INTO `game_review_files` VALUES (342, 178, '2020_10_15_06_20_14_needfor_screnshot2.png');
            INSERT INTO `game_review_files` VALUES (343, 178, '2020_10_15_06_20_14_needfor_screnshot3.png');
            INSERT INTO `game_review_files` VALUES (344, 178, '2020_10_15_06_20_14_needfor_screnshot4.png');
            INSERT INTO `game_review_files` VALUES (345, 178, '2020_10_15_06_20_14_needfor_screnshot6.png');
            INSERT INTO `game_review_files` VALUES (346, 178, '2020_10_15_06_20_14_needfor_screnshot7.png');
            INSERT INTO `game_review_files` VALUES (347, 178, '2020_10_15_06_20_14_needfor_screnshot8.png');
            INSERT INTO `game_review_files` VALUES (348, 178, '2020_10_15_06_20_14_needfor_screnshot9.png');
            INSERT INTO `game_review_files` VALUES (349, 179, '2020_10_15_17_24_49_zelda_screnshot1.jpg');
            INSERT INTO `game_review_files` VALUES (350, 179, '2020_10_15_17_24_49_zelda_screnshot2.jpg');
            INSERT INTO `game_review_files` VALUES (351, 179, '2020_10_15_17_24_49_zelda_screnshot3.jpg');
            INSERT INTO `game_review_files` VALUES (352, 179, '2020_10_15_17_24_49_zelda_screnshot4.jpg');
            INSERT INTO `game_review_files` VALUES (353, 179, '2020_10_15_17_24_49_zelda_screnshot5.jpg');
            INSERT INTO `game_review_files` VALUES (354, 179, '2020_10_15_17_24_49_zelda_screnshot6.jpg');
            INSERT INTO `game_review_files` VALUES (355, 179, '2020_10_15_17_24_49_zelda_screnshot7.jpg');
            INSERT INTO `game_review_files` VALUES (356, 180, '2020_10_15_17_38_00_gta_shot1.png');
            INSERT INTO `game_review_files` VALUES (357, 180, '2020_10_15_17_38_00_gta_shot2.jpg');
            INSERT INTO `game_review_files` VALUES (358, 180, '2020_10_15_17_38_00_gta_shot3.jpg');
            INSERT INTO `game_review_files` VALUES (359, 181, '2020_10_15_17_45_39_animal_shot1.jpg');
            INSERT INTO `game_review_files` VALUES (360, 181, '2020_10_15_17_45_39_animal_shot2.jpg');
            INSERT INTO `game_review_files` VALUES (361, 181, '2020_10_15_17_45_39_animal_shot3.jpg');
            INSERT INTO `game_review_files` VALUES (362, 181, '2020_10_15_17_45_39_animal_shot4.jpg');
            INSERT INTO `game_review_files` VALUES (363, 181, '2020_10_15_17_45_39_animal_shot5.jpg');
            INSERT INTO `game_review_files` VALUES (364, 181, '2020_10_15_17_45_39_animal_shot6.jpg');
            INSERT INTO `game_review_files` VALUES (365, 181, '2020_10_15_17_45_39_animal_shot7.jpg');
            INSERT INTO `game_review_files` VALUES (366, 181, '2020_10_15_17_45_39_animal_shot8.jpg');
            INSERT INTO `game_review_files` VALUES (367, 181, '2020_10_15_17_45_39_animal_shot9.jpg');
            INSERT INTO `game_review_files` VALUES (368, 181, '2020_10_15_17_45_39_animal_shot10.jpg');
            INSERT INTO `game_review_files` VALUES (369, 182, '2020_10_15_17_55_13_GTA5_shot1.jpg');
            INSERT INTO `game_review_files` VALUES (370, 182, '2020_10_15_17_55_13_GTA5_shot2.jpg');
            INSERT INTO `game_review_files` VALUES (371, 182, '2020_10_15_17_55_13_GTA5_shot3.jpg');
            INSERT INTO `game_review_files` VALUES (372, 182, '2020_10_15_17_55_13_GTA5_shot4.jpg');
            INSERT INTO `game_review_files` VALUES (373, 182, '2020_10_15_17_55_13_GTA5_shot5.jpg');
            INSERT INTO `game_review_files` VALUES (374, 182, '2020_10_15_17_55_13_GTA5_shot6.jpg');
            INSERT INTO `game_review_files` VALUES (375, 182, '2020_10_15_17_55_13_GTA5_shot7.jpg');
            INSERT INTO `game_review_files` VALUES (376, 183, '2020_10_15_18_07_53_monster_1.jpg');
            INSERT INTO `game_review_files` VALUES (377, 183, '2020_10_15_18_07_53_monster_2.jpg');
            INSERT INTO `game_review_files` VALUES (378, 183, '2020_10_15_18_07_53_monster_3.jpg');
            INSERT INTO `game_review_files` VALUES (379, 183, '2020_10_15_18_07_53_monster_4.jpg');
            INSERT INTO `game_review_files` VALUES (380, 183, '2020_10_15_18_07_53_monster_5.jpg');
            INSERT INTO `game_review_files` VALUES (381, 183, '2020_10_15_18_07_53_monster_6.jpg');
            INSERT INTO `game_review_files` VALUES (382, 183, '2020_10_15_18_07_53_monster_7.jpg');
            INSERT INTO `game_review_files` VALUES (383, 183, '2020_10_15_18_07_53_monster_8.jpg');
            INSERT INTO `game_review_files` VALUES (384, 183, '2020_10_15_18_07_53_monster_9.jpg');
            INSERT INTO `game_review_files` VALUES (385, 184, '2020_10_15_18_11_48_call_1.png');
            INSERT INTO `game_review_files` VALUES (386, 184, '2020_10_15_18_11_48_call_2.png');
            INSERT INTO `game_review_files` VALUES (387, 184, '2020_10_15_18_11_48_call_3.png');
            INSERT INTO `game_review_files` VALUES (388, 184, '2020_10_15_18_11_48_call_4.png');
            INSERT INTO `game_review_files` VALUES (389, 184, '2020_10_15_18_11_48_call_5.png');
            INSERT INTO `game_review_files` VALUES (390, 184, '2020_10_15_18_11_48_call_6.png');
            INSERT INTO `game_review_files` VALUES (391, 184, '2020_10_15_18_11_48_call_7.png');
            INSERT INTO `game_review_files` VALUES (392, 185, '2020_10_15_18_17_00_forza_1.jpg');
            INSERT INTO `game_review_files` VALUES (393, 185, '2020_10_15_18_17_00_forza_2.jpg');
            INSERT INTO `game_review_files` VALUES (394, 185, '2020_10_15_18_17_00_forza_3.jpg');
            INSERT INTO `game_review_files` VALUES (395, 185, '2020_10_15_18_17_00_forza_4.jpg');
            INSERT INTO `game_review_files` VALUES (396, 185, '2020_10_15_18_17_00_forza_5.jpg');
            INSERT INTO `game_review_files` VALUES (397, 185, '2020_10_15_18_17_00_forza_6.jpg');
            INSERT INTO `game_review_files` VALUES (398, 185, '2020_10_15_18_17_00_forza_7.jpg');
            INSERT INTO `game_review_files` VALUES (399, 185, '2020_10_15_18_17_00_forza_8.jpg');
            INSERT INTO `game_review_files` VALUES (400, 185, '2020_10_15_18_17_00_forza_9.jpg');
            INSERT INTO `game_review_files` VALUES (401, 186, '2020_10_15_18_21_45_fifa_1.jpg');
            INSERT INTO `game_review_files` VALUES (402, 186, '2020_10_15_18_21_45_fifa_2.jpg');
            INSERT INTO `game_review_files` VALUES (403, 186, '2020_10_15_18_21_45_fifa_3.jpg');
            INSERT INTO `game_review_files` VALUES (404, 186, '2020_10_15_18_21_45_fifa_4.jpg');
            INSERT INTO `game_review_files` VALUES (405, 186, '2020_10_15_18_21_45_fifa_5.jpg');
            INSERT INTO `game_review_files` VALUES (406, 186, '2020_10_15_18_21_45_fifa_6.jpg');
            INSERT INTO `game_review_files` VALUES (407, 186, '2020_10_15_18_21_45_fifa_7.jpg');
            INSERT INTO `game_review_files` VALUES (408, 186, '2020_10_15_18_21_45_fifa_8.jpg');
            INSERT INTO `game_review_files` VALUES (409, 186, '2020_10_15_18_21_45_fifa_9.jpg');
            INSERT INTO `game_review_files` VALUES (410, 186, '2020_10_15_18_21_45_fifa_10.jpg');
            INSERT INTO `game_review_files` VALUES (411, 186, '2020_10_15_18_21_45_fifa_11.jpg');
            INSERT INTO `game_info` VALUES (218, 'NEED for SPEED', '2015년 11월 3일 콘솔로 먼저 출시된 일렉트로닉 아츠의 아케이드 레이싱 게임 시리즈 니드 포 스피드 시리즈의 리부트 신작. 프로스트바이트 엔진을 사용했다.', 'Electronic Arts Inc.', '12세이용가', '2017-11-10', 34000, 'https://www.ea.com/games/need-for-speed?isLocalized=true', 0, 'PlayStation store', '2020_10_15_12_49_46_needforspeedtitle.jpg', 'admin', '2020-10-15 14:05:47', 0);
            INSERT INTO `game_info` VALUES (219, 'Monster Hunter World', '《몬스터 헌터: 월드》의 확장 컨텐츠. PS4/XB1은 2019년 9월 6일 출시 했으며, PC는 본래 동년 겨울 출시 예정이였으나 발매일이 약간 늦춰져 2020년 1월 10일로 확정되었다.[3] 프로듀서는 마찬가지로 츠지모토 료조이며, 메인 디렉터는 《몬스터 헌터 더블 크로스》의 디렉터를 맡기도 한 이치하라 다이스케. 월드의 디렉터였던 토쿠다 유야는 월드의 무료 업데이트를 지휘하고 있으며, 아이스본에선 세컨드 디렉터를 맡았고 따로 차기 프로젝트를 진행중이라고 한다. 공식 약칭은 MHWI.\r\n\r\n몬스터 헌터 시리즈 최초로 &#039;별도 구매가 필요한 확장 다운로드 컨텐츠&#039;로 기획되었다.[4] 전작들의 G급 타이틀처럼 별도 타이틀로 재구매해야만 하는 방식이 아니라 게임 본편을 소유한 유저가 아이스본 DLC를 구매하여 컨텐츠를 추가하는 형식이다. 이때문에 아이스본만 담은 실물 패키지는 존재하지 않으며 실물 패키지는 월드 합본만 존재한다.\r\n\r\n기존 작품군의 G급 확장판에 해당하는 내용을 담고 있으며, 2018년 12월 10일 특별방송을 통해 공개되었다.', 'CAPCOM CO., LTD.', '15세이용가', '2019-09-06', 38400, 'https://www.monsterhunter.com/world-iceborne/pc/kr/', 1, 'PlayStation store', '2020_10_15_14_14_04_monster-hunter-title.jpg', 'admin', '2020-10-15 14:30:35', 0);
            INSERT INTO `game_info` VALUES (220, '콜 오브 듀티®: 모던 워페어', '인피니티 워드에서 개발, 액티비전에서 배급하는 FPS 게임. 콜 오브 듀티 시리즈의 16번째 작품으로, 모던 워페어 시리즈의 소프트 리부트[9][10] 작품이다.\r\n\r\n전작인 콜 오브 듀티: 블랙 옵스 4에 이어서 PC판은 Battle.net 독점 출시이며, 한국어 자막 및 음성을 지원한다.[11]\r\n\r\n11월 8일에 캠페인을 제외한 컨텐츠를 이용 가능한 15세 버전이 한국 한정으로 출시되었다. 블랙 옵스 4와 마찬가지로 PC방에서만 플레이할 수 있다.', 'Activision', '청소년이용불가', '2019-10-25', 69000, 'https://www.callofduty.com/ko/modernwarfare/home', 1, 'PlayStation store', '2020_10_15_14_30_03_callofduty_title.jpg', 'admin', '2020-10-15 14:30:03', 0);
            INSERT INTO `game_info` VALUES (221, 'EA SPORTS™ FIFA 20', 'FIFA 20는 축구를 소재로 한 비디오 게임으로 EA 스포츠의 FIFA 시리즈 27번째 정규작이다.', 'Electronic Arts Inc.', '전체이용가', '2018-09-27', 72000, 'https://www.ea.com/ko-kr/games/fifa/fifa-20', 1, 'PlayStation store', '2020_10_15_14_55_53_fifa20_title.jpg', 'admin', '2020-10-15 14:55:53', 0);
            INSERT INTO `game_info` VALUES (222, 'Forza Horizon 4', '세계 최고의 자동차 페스티벌에서 모든 것을 바꿀 새로운 시즌이 시작됩니다. 공유된 오픈 월드에서 혼자서 또는 다른 사람들과 팀을 이루어 아름답고 역사가 있는 브리튼 섬을 탐험하세요. 450가지가 넘는 자동차들을 수집, 개조 및 운전하세요. 레이스, 스턴트, 창조, 탐험 중 원하는 길을 골라 Horizon 슈퍼스타가 되세요. Forza Horizon 4 스탠다드 에디션 디지털 번들에는 Forza Horizon 4 정식 버전 게임 및 Formula 드리프트 자동차 팩이 포함됩니다.', 'Playground Games', '12세이용가', '2018-10-01', 26460, 'https://www.xbox.com/ko-KR/games/forza-horizon-4', 1, 'Xbox store', '2020_10_15_15_12_44_ForzaHorizon4_title.jpg', 'admin', '2020-10-15 15:12:44', 0);
            INSERT INTO `game_info` VALUES (223, 'Halo: Reach', '헤일로 워즈에 이은 헤일로 시리즈의 두 번째 프리퀄 작품이자, 번지가 제작한 마지막 헤일로 시리즈 게임으로, 이후 번지는 헤일로 제작 판권을 넘기고 마이크로소프트에서 독립했다.[5]\r\n\r\n2019년 3월 12일에 헤일로: 마스터 치프 컬렉션으로의 편입과 PC판도 같이 발표되었다.', '헤일로: 리치', '청소년이용불가', '2013-01-29', 27500, 'https://www.halowaypoint.com/ko-kr', 1, 'Xbox store', '2020_10_15_15_55_09_halo_title.jpg', 'admin', '2020-10-15 15:55:09', 0);
            INSERT INTO `game_info` VALUES (224, '모여봐요 동물의 숲', '2020년 3월 20일 Nintendo Switch로 전 세계 동시 발매된 동물의 숲 시리즈의 신작 게임. 약칭은 한국에서는 모동숲, 일본에서는 아츠모리(あつ森)이며, 영미권 국가에서는 ACNH(Animal Crossing New Horizons)라고 줄여서 부르기도 한다.', 'Nintendo', '전체이용가', '2020-03-20', 64800, 'https://www.nintendo.co.kr/software/switch/acbaa/', 1, 'Nintendo', '2020_10_15_16_20_46_animal_title.jpg', 'admin', '2020-10-15 16:20:46', 0);
            INSERT INTO `game_info` VALUES (225, '젤다의전설 꿈꾸는 섬', '젤다의 전설 꿈꾸는 섬의 리메이크 게임. 2019년 2월 14일 닌텐도 다이렉트로 공개되었다. Nintendo Switch로 2019년 9월 20일에 전 세계 동시 발매되었다.\r\n\r\n특이하게 지금까지의 리마스터, 리메이크 젤다들이 부제에 원작과 구별 되는 용어를 넣었던것과 달리[1] 부제가 원작을 그대로 따라간 꿈꾸는 섬이다.\r\n\r\n대한민국에도 한국어로 동시 정발되었다. 희망소비자가격은 64,800원이며, 일러스트와 설정화가 수록된 120페이지 분량의 아트북이 포함된 한정판도 74,800원에 발매된다.\r\n\r\nNintendo Switch Lite의 런칭 타이틀이다.', 'Nintendo', '전체이용가', '2019-09-20', 64800, 'https://www.nintendo.co.kr/software/switch/ar3na/', 1, 'Nintendo', '2020_10_15_16_30_03_zelda_title.jpg', 'admin', '2020-10-15 17:25:31', 0);
            INSERT INTO `game_info` VALUES (226, 'Grand Theft Auto V', '어느 날 문득, 동네 건달과 은퇴한 은행 강도, 미치광이 사이코패스는 자신들이 어두운 범죄 세계와 미국 정부 기관, 엔터테인먼트 회사의 가장 끔찍하고 무시무시한 현실과 복잡하게 얽혀 있다는 걸 깨닫습니다. 아무도 믿을 수 없는, 서로조차 믿을 수 없는 이 무자비한 도시에서 살아남기 위해 그들은 여러 번의 위험한 습격에 몸을 던져야 합니다.', 'Take Two Interactive Software', '청소년이용불가', '2013-10-02', 50500, 'https://www.rockstargames.com/kr/', 1, 'PlayStation store', '2020_10_15_16_55_11_GTA_title.jpg', 'admin', '2020-10-17 14:36:21', 4);
            INSERT INTO `game_info` VALUES (251, '컨트롤 얼티밋 에디션', '뉴욕의 비밀 기관이 초현실적인 위협을 받은 뒤, 당신은 새로운 책임자가 되어 &#039;컨트롤&#039;을 되찾고자 합니다. Remedy Entertainment 개발사가 선사하는 이 초자연적 3인칭 액션 어드벤처에서 플레이어는 예측 불가능한 미지의 세계에 맞서 싸우며 초자연적인 능력과 변경 가능한 장비 및 상호 작용하는 주위 환경에 통달해야 합니다.', 'Remedy Entertainment', '청소년이용불가', '2020-10-20', 45000, 'https://store.playstation.com/ko-kr/product/EP4040-CUSA11454_00-CONTROLUEBUNDLE0', 1, 'playstation store', '2020_10_18_18_20_52_control.jpg', 'admin', '2020-10-18 18:20:53', 0);
            INSERT INTO `game_info` VALUES (252, '케이던스 오브 하이랄 : 크립트 오브 더네크로댄서 feat. 젤다의 전설', '리듬에 맞춰 던전을 탐색하는 롤플레잉 게임인 &quot;크립트 오브 더 네크로댄서&quot;를, &quot;젤다의 전설&quot; 시리즈 설정으로 플레이할 수 있는 리듬 액션 어드벤처 게임.\r\n플레이어는 링크 또는 젤다 공주가 되어 무작위로 만들어지는 지상 세계와 던전을 탐색, 퀘스트를 클리어하며 하이랄을 구하기 위해 싸움을 펼칩니다.\r\n&quot;크립트 오브 더 네크로댄서&quot; 의 재미 가득한 요소는 그대로, &quot;젤다의 전설&quot; 시리즈의 친숙한 BGM 이나 캐릭터도 독튿한 픽셀 아트로 다양하게 등장합니다.', 'Brace Yourself Games', '전체이용가', '2020-10-23', 44800, 'https://braceyourselfgames.com/', 1, '닌텐도', '2020_10_18_18_40_45_CADENCEofHYRULE.jpg', 'admin', '2020-10-18 21:22:42', 0);
            INSERT INTO `game_info` VALUES (254, '진 여신전생3 NOCTURENE HD REMASTER', '시리즈 굴지의 명작으로 전설이 된 그 &quot;진 여신전생3 Nocturne&quot; 가 Nintendo Switch와 PlayStation4로 드디어 부활 &quot;원작 존중&quot;을 전제로 그래픽과 게임성이 향상되었다. 팬들을 비롯해 본 타이틀을 처음 플레이 하는 사람들도 지금 꼭 이 &quot;압도적인 악마 체험&quot; 을 해보자.\r\n\r\nSTORY\r\n200X 년, 일상은 돌연히 최후를 맞이 했다. 일본의 수도는 &quot;도쿄 수테&quot;에 의해 마계화. 몇 안 되는 생존자를 남기고, 악마의 세계가 된다. 몰락한 &quot;도쿄&quot;에서 스스로 악마가 된 소년은 &quot;신세계 창조&quot;의 선택과 갈등의 이야기를 자아낸다.', 'ATLUS', '15세이용가', '2020-10-29', 49800, 'http://segagames.co.kr/megaten3HD/', 1, '닌텐도', '2020_10_18_23_24_49_jingoddessremaster.jpg', 'admin', '2020-10-18 23:24:53', 0);
            INSERT INTO `game_info` VALUES (255, '매드 래트 데드', '인간들이여 들어라. 미친 쥐의 이명을.\r\n\r\n리듬 게임과 횡스크롤 액션이 융합된 신감각 액션 게임이 등장!\r\n리듬에 맞춰 버튼을 누르며 캐릳터를 조작.\r\n곡이 끝나기 전에 스테이지의 골을 목표로 합니다.\r\n인간에게 복수를 꾸미고 있는 &quot;매드 래트&quot;, 경쾌한 음악을 새기는 심장[하트] 와 함께 다양한 기믹이 설치된 스테이지를 질주하자!', 'Nippon Ichi Software', '12세이용가', '2020-10-29', 59800, 'http://segagames.co.kr/madratdead/', 1, 'Nippon Ichi Software', '2020_10_18_23_44_45_MADRATDEAD.jpg', 'admin', '2020-10-18 23:44:49', 0);
            INSERT INTO `game_info` VALUES (256, '피크민 3 디럭스', '주인공은 3명의 조사대 &quot;피크민 3 디럭스&quot;의 주인공은 식량 자원을 찾아서 우주로 향한 3명의 조사대,알프,브리트니,찰리입니다. 이들은 어느 한 행성에 착륙하여 만난 &quot;피크민&quot; 이라는 신기한 생명체의 힘을 빌려, 이 행성에서 자라는 과일의 종자를 갖고 고향으로 돌아가기 위해 탐색을 시작합니다.\r\n피크민들의 힘을 빌리자\r\n피크민은 동물 같기도 하고 식물 같기도 한 신기한 생명체, 피크민은 땅에서 잡아 뽑으면, 주인공들의 뒤를 졸졸 따라다닙니다. 피크민들을 던지면 과일 등의 거대한 물건을 옮기거나 조각을 모아 다리를 완성하는 등, 피크민들은 던져진 곳에 따라 부지런히 움직여서 길을 개척합니다. 행성을 탐색하다 보면, 흉포한 원주생들과 만나게 되는 일도 있습니다. 그럴 때도 피크민들은 힘을 합쳐 과감하게 맞서 싸웁니다. 그러나 한 마리 한 마리는 매우 약해서, 원주 생물들에게 잡아 먹히는 일도 있습니다.', 'Monolith Soft', '전체이용가', '2020-10-30', 64800, 'https://www.nintendo.co.jp/wiiu/ac3j/index.html', 1, '닌텐도', '2020_10_18_23_58_53_PIKMIN3DELUXE.jpg', 'admin', '2020-10-18 23:58:56', 0);
            INSERT INTO `game_info_ripples` VALUES (134, 226, '재밌어요\n', 'admin', '2020-10-18 17:22:05');
            INSERT INTO `game_info_ripples` VALUES (135, 226, '자유도가 높아요', 'admin', '2020-10-18 17:22:12');
            INSERT INTO `game_info_ripples` VALUES (136, 226, '개꿀잼\n', 'admin', '2020-10-18 17:22:25');
            INSERT INTO `game_info_ripples` VALUES (137, 226, '빡빡이가 재일쌔요\n', 'admin', '2020-10-18 17:23:02');
            INSERT INTO `game_info_ripples` VALUES (138, 226, '타격감이 좋습니다', 'admin', '2020-10-18 17:23:34');
            INSERT INTO `game_info_ripples` VALUES (139, 226, 'a4b1 굳굳', 'admin', '2020-10-18 17:23:57');
            INSERT INTO `game_info_ripples` VALUES (140, 226, 'GTA 완죤 재미짐', 'admin', '2020-10-18 21:03:52');
            INSERT INTO `game_info_ripples` VALUES (186, 252, '김병곤ㄴ', 'admin', '2020-10-18 22:43:24');
            INSERT INTO `game_info_ripples` VALUES (187, 252, '야우우우', 'admin', '2020-10-18 22:43:29');
            INSERT INTO `game_info_ripples` VALUES (188, 252, '이러지마요', 'admin', '2020-10-18 22:43:32');
            INSERT INTO `game_info_ripples` VALUES (189, 252, '뿌뿌뿌뿌', 'admin', '2020-10-18 22:43:35');
            INSERT INTO `game_info_ripples` VALUES (191, 252, '안녕ㅇㄴㅇㄹ', 'admin', '2020-10-18 22:43:45');
            INSERT INTO `game_info_ripples` VALUES (193, 252, '야야야야야', 'admin', '2020-10-18 22:44:02');
            INSERT INTO `game_info_ripples` VALUES (194, 252, '안녕하쇼오옹', 'admin', '2020-10-18 22:44:06');
            INSERT INTO `game_info_ripples` VALUES (195, 252, '김뿌뿌뿌뿌', 'admin', '2020-10-18 22:44:11');
            INSERT INTO `game_info_ripples` VALUES (196, 252, '얌얌얌얌', 'admin', '2020-10-18 22:44:17');
            INSERT INTO `game_info_ripples` VALUES (197, 252, '뿌뿌뿌뿌', 'admin', '2020-10-18 22:44:20');
            INSERT INTO `game_info_platform` VALUES (286, 218, 'PS4');
            INSERT INTO `game_info_platform` VALUES (287, 219, 'PS4');
            INSERT INTO `game_info_platform` VALUES (288, 220, 'PS4');
            INSERT INTO `game_info_platform` VALUES (289, 221, 'PS4');
            INSERT INTO `game_info_platform` VALUES (290, 222, 'XBOX ONE');
            INSERT INTO `game_info_platform` VALUES (291, 223, 'XBOX 360');
            INSERT INTO `game_info_platform` VALUES (292, 224, 'NINTENDO SWITCH');
            INSERT INTO `game_info_platform` VALUES (293, 225, 'NINTENDO SWITCH');
            INSERT INTO `game_info_platform` VALUES (294, 226, 'PS3');
            INSERT INTO `game_info_platform` VALUES (323, 251, 'PS4');
            INSERT INTO `game_info_platform` VALUES (324, 252, 'NINTENDO SWITCH');
            INSERT INTO `game_info_platform` VALUES (326, 254, 'PS4');
            INSERT INTO `game_info_platform` VALUES (327, 254, 'NINTENDO SWITCH');
            INSERT INTO `game_info_platform` VALUES (328, 255, 'PS4');
            INSERT INTO `game_info_platform` VALUES (329, 255, 'NINTENDO SWITCH');
            INSERT INTO `game_info_platform` VALUES (330, 256, 'NINTENDO SWITCH');
            INSERT INTO `game_info_genre` VALUES (254, 218, '레이싱');
            INSERT INTO `game_info_genre` VALUES (255, 219, '액션');
            INSERT INTO `game_info_genre` VALUES (256, 220, '액션');
            INSERT INTO `game_info_genre` VALUES (257, 221, '스포츠');
            INSERT INTO `game_info_genre` VALUES (258, 222, '스포츠');
            INSERT INTO `game_info_genre` VALUES (259, 222, '레이싱');
            INSERT INTO `game_info_genre` VALUES (260, 223, '액션');
            INSERT INTO `game_info_genre` VALUES (261, 224, '어드밴처');
            INSERT INTO `game_info_genre` VALUES (262, 225, '액션');
            INSERT INTO `game_info_genre` VALUES (263, 225, '어드밴처');
            INSERT INTO `game_info_genre` VALUES (264, 226, '액션');
            INSERT INTO `game_info_genre` VALUES (293, 251, '액션');
            INSERT INTO `game_info_genre` VALUES (294, 251, '어드밴처');
            INSERT INTO `game_info_genre` VALUES (295, 252, '액션');
            INSERT INTO `game_info_genre` VALUES (296, 252, '음악');
            INSERT INTO `game_info_genre` VALUES (298, 254, '롤플레잉');
            INSERT INTO `game_info_genre` VALUES (299, 255, '액션');
            INSERT INTO `game_info_genre` VALUES (300, 255, '음악');
            INSERT INTO `game_info_genre` VALUES (301, 256, '액션');
            INSERT INTO `game_info_files` VALUES (265, 218, '2020_10_15_12_49_46_needscrenimage1.jpg');
            INSERT INTO `game_info_files` VALUES (266, 218, '2020_10_15_12_49_46_needscrenimage2.jpg');
            INSERT INTO `game_info_files` VALUES (267, 218, '2020_10_15_12_49_46_needscrenimage3.jpg');
            INSERT INTO `game_info_files` VALUES (268, 218, '2020_10_15_12_49_46_needscrenimage4.jpg');
            INSERT INTO `game_info_files` VALUES (269, 218, '2020_10_15_12_49_46_needscrenimage5.jpg');
            INSERT INTO `game_info_files` VALUES (270, 219, '2020_10_15_14_14_04_monster-hunter1.jpg');
            INSERT INTO `game_info_files` VALUES (271, 219, '2020_10_15_14_14_04_monster-hunter2.jpg');
            INSERT INTO `game_info_files` VALUES (272, 219, '2020_10_15_14_14_04_monster-hunter3.jpg');
            INSERT INTO `game_info_files` VALUES (273, 219, '2020_10_15_14_14_04_monster-hunter4.jpg');
            INSERT INTO `game_info_files` VALUES (274, 219, '2020_10_15_14_14_04_monster-hunter5.jpg');
            INSERT INTO `game_info_files` VALUES (275, 220, '2020_10_15_14_30_03_callofduty1.jpg');
            INSERT INTO `game_info_files` VALUES (276, 220, '2020_10_15_14_30_03_callofduty2.jpg');
            INSERT INTO `game_info_files` VALUES (277, 220, '2020_10_15_14_30_03_callofduty3.jpg');
            INSERT INTO `game_info_files` VALUES (278, 220, '2020_10_15_14_30_03_callofduty4.jpg');
            INSERT INTO `game_info_files` VALUES (279, 220, '2020_10_15_14_30_03_callofduty5.jpg');
            INSERT INTO `game_info_files` VALUES (280, 221, '2020_10_15_14_55_53_fifa20_1.jpg');
            INSERT INTO `game_info_files` VALUES (281, 221, '2020_10_15_14_55_53_fifa20_2.jpg');
            INSERT INTO `game_info_files` VALUES (282, 221, '2020_10_15_14_55_53_fifa20_3.jpg');
            INSERT INTO `game_info_files` VALUES (283, 221, '2020_10_15_14_55_53_fifa20_4.jpg');
            INSERT INTO `game_info_files` VALUES (284, 221, '2020_10_15_14_55_53_fifa20_5.jpg');
            INSERT INTO `game_info_files` VALUES (285, 221, '2020_10_15_14_55_53_fifa20_6.jpg');
            INSERT INTO `game_info_files` VALUES (286, 222, '2020_10_15_15_12_45_ForzaHorizon4_1.jpg');
            INSERT INTO `game_info_files` VALUES (287, 222, '2020_10_15_15_12_45_ForzaHorizon4_2.jpg');
            INSERT INTO `game_info_files` VALUES (288, 222, '2020_10_15_15_12_45_ForzaHorizon4_3.jpg');
            INSERT INTO `game_info_files` VALUES (289, 222, '2020_10_15_15_12_45_ForzaHorizon4_4.jpg');
            INSERT INTO `game_info_files` VALUES (290, 222, '2020_10_15_15_12_45_ForzaHorizon4_5.jpg');
            INSERT INTO `game_info_files` VALUES (291, 223, '2020_10_15_15_55_09_halo_6.jpg');
            INSERT INTO `game_info_files` VALUES (292, 224, '2020_10_15_16_20_46_animal_1.jpg');
            INSERT INTO `game_info_files` VALUES (293, 224, '2020_10_15_16_20_46_animal_2.jpg');
            INSERT INTO `game_info_files` VALUES (294, 224, '2020_10_15_16_20_46_animal_3.png');
            INSERT INTO `game_info_files` VALUES (295, 224, '2020_10_15_16_20_46_animal_4.jpg');
            INSERT INTO `game_info_files` VALUES (296, 224, '2020_10_15_16_20_46_animal_5.jpg');
            INSERT INTO `game_info_files` VALUES (297, 225, '2020_10_15_16_30_03_zelda_1.jpg');
            INSERT INTO `game_info_files` VALUES (298, 225, '2020_10_15_16_30_03_zelda_2.jpg');
            INSERT INTO `game_info_files` VALUES (299, 225, '2020_10_15_16_30_03_zelda_3.jpg');
            INSERT INTO `game_info_files` VALUES (300, 225, '2020_10_15_16_30_03_zelda_4.jpg');
            INSERT INTO `game_info_files` VALUES (301, 226, '2020_10_15_16_55_11_GTA_1.jpg');
            INSERT INTO `game_info_files` VALUES (302, 226, '2020_10_15_16_55_11_GTA_2.jpg');
            INSERT INTO `game_info_files` VALUES (303, 226, '2020_10_15_16_55_11_GTA_3.jpg');
            INSERT INTO `game_info_files` VALUES (304, 226, '2020_10_15_16_55_11_GTA_4.jpg');
            INSERT INTO `game_info_files` VALUES (305, 226, '2020_10_15_16_55_11_GTA_5.jpg');
            INSERT INTO `game_info_files` VALUES (321, 251, '2020_10_18_18_20_52_control1.jpg');
            INSERT INTO `game_info_files` VALUES (322, 251, '2020_10_18_18_20_52_control2.jpg');
            INSERT INTO `game_info_files` VALUES (323, 251, '2020_10_18_18_20_52_control3.jpg');
            INSERT INTO `game_info_files` VALUES (324, 252, '2020_10_18_18_40_45_crip1.png');
            INSERT INTO `game_info_files` VALUES (325, 252, '2020_10_18_18_40_45_crip2.png');
            INSERT INTO `game_info_files` VALUES (326, 252, '2020_10_18_18_40_45_crip3.png');
            INSERT INTO `game_info_files` VALUES (327, 252, '2020_10_18_18_40_45_crip4.png');
            INSERT INTO `game_info_files` VALUES (328, 254, '2020_10_18_23_24_49_goddess1.PNG');
            INSERT INTO `game_info_files` VALUES (329, 254, '2020_10_18_23_24_49_goddess2.PNG');
            INSERT INTO `game_info_files` VALUES (330, 254, '2020_10_18_23_24_49_goddess3.PNG');
            INSERT INTO `game_info_files` VALUES (331, 255, '2020_10_18_23_44_46_madratdead1.png');
            INSERT INTO `game_info_files` VALUES (332, 255, '2020_10_18_23_44_46_madratdead2.png');
            INSERT INTO `game_info_files` VALUES (333, 255, '2020_10_18_23_44_46_madratdead3.png');
            INSERT INTO `game_info_files` VALUES (334, 256, '2020_10_18_23_58_53_pikmin1.PNG');
            INSERT INTO `game_info_files` VALUES (335, 256, '2020_10_18_23_58_53_pikmin2.PNG');
            INSERT INTO `game_info_files` VALUES (336, 256, '2020_10_18_23_58_53_pikmin3.PNG');
            INSERT INTO `game_info_files` VALUES (337, 256, '2020_10_18_23_58_53_pikmin4.PNG');
        END;";
        mysqli_query($con,$sql) or die('Error: ' . mysqli_error($con));



        echo "<script>alert('프로시저 생성완료')</script>";
    }

    public function createTable() {
        $con = mysqli_connect($this->host,$this->user,$this->password,'a4b1');
        $sql = "CALL create_tables();";
        mysqli_query($con,$sql)  or die('Error: ' . mysqli_error($con));

        $sql = "CALL create_dummy_data();";
        mysqli_query($con,$sql)  or die('Error: ' . mysqli_error($con));

        $triggerArray = array('delete_game_info','delete_game_info_genre','delete_game_info_platform',
            'delete_game_review','delete_game_review_point','delete_members','delete_notice','delete_notice_urgent');
        foreach ($triggerArray as $element) $this->createTrigger($element);

        echo "<script>alert('테이블 및 더미데이터 세팅 완료</script>";
    }

    //트리거 만드는 함수
    public function createTrigger($trigger_name) {
        $flag = "NO";
        $con = mysqli_connect($this->host,$this->user,$this->password,'a4b1');
        $sql = "SHOW TRIGGERS where `trigger` = '$trigger_name';";
        $result = mysqli_query($con, $sql) or die('Error: ' . mysqli_error($con));

        if (mysqli_num_rows($result) > 0) {
            $flag = "OK";
        }

        if ($flag === "NO") {
            switch ($trigger_name) {
                case 'delete_notice':
                    $sql = "CREATE TRIGGER delete_notice
                        AFTER DELETE ON notice
                        FOR EACH ROW 
                        BEGIN
                            INSERT INTO deleted_notice VALUES(OLD.num,OLD.title,OLD.content,OLD.file_name,OLD.file_type,
                            OLD.file_copied,OLD.hit,OLD.created_by,OLD.created_at);
                        END;";
                    break;
                case 'delete_notice_urgent':
                    $sql = "CREATE TRIGGER delete_notice_urgent
                        AFTER DELETE ON notice_urgent
                        FOR EACH ROW 
                        BEGIN
                            INSERT INTO deleted_notice_urgent VALUES(OLD.num,OLD.title,OLD.content,OLD.file_name,OLD.file_type,
                            OLD.file_copied,OLD.hit,OLD.created_by,OLD.created_at);
                        END;";
                    break;
                case 'delete_members':
                    $sql = "CREATE TRIGGER delete_members
                        AFTER DELETE ON members
                        FOR EACH ROW 
                        BEGIN
                            INSERT INTO deleted_members VALUES(OLD.id,OLD.password,OLD.name,OLD.phone,OLD.email,
                            OLD.admin,OLD.created_at);
                        END;";
                    break;
                case 'delete_game_review_point':
                    $sql = "CREATE TRIGGER delete_game_review_point
                        AFTER DELETE ON game_review_point
                        FOR EACH ROW 
                        BEGIN
                            INSERT INTO deleted_game_review_point VALUES(OLD.review_num,OLD.story,OLD.graphic,OLD.time,
                            OLD.difficulty);
                        END;";
                    break;
                case 'delete_game_review':
                    $sql = "CREATE TRIGGER delete_game_review
                        AFTER DELETE ON game_review
                        FOR EACH ROW 
                        BEGIN
                            INSERT INTO deleted_game_review VALUES(OLD.num,OLD.name,OLD.title,OLD.content,OLD.created_at
                            ,OLD.created_by,OLD.hit);
                        END;";
                    break;
                case 'delete_game_info_genre':
                    $sql = "CREATE TRIGGER delete_game_info_genre
                        AFTER DELETE ON game_info_genre
                        FOR EACH ROW 
                        BEGIN
                            INSERT INTO deleted_game_info_genre VALUES(OLD.num,OLD.info_num,OLD.genre);
                        END;";
                    break;
                case 'delete_game_info_platform':
                    $sql = "CREATE TRIGGER delete_game_info_platform
                        AFTER DELETE ON game_info_platform
                        FOR EACH ROW 
                        BEGIN
                            INSERT INTO deleted_game_info_platform VALUES(OLD.num,OLD.info_num,OLD.platform);
                        END;";
                    break;
                case 'delete_game_info':
                    $sql = "CREATE TRIGGER delete_game_info
                        AFTER DELETE ON game_info
                        FOR EACH ROW 
                        BEGIN
                            INSERT INTO deleted_game_info VALUES(OLD.num,OLD.name,OLD.content,OLD.developer,OLD.grade,
                            OLD.release_date,OLD.price,OLD.homepage,OLD.service_kor,OLD.circulation,null,OLD.created_by,
                            OLD.created_at,OLD.hit);
                        END;";
                    break;
                default:
                    echo "<script>alert('해당트리거명이 없습니다. 점검요망!');</script>";
                    break;
            } //end of switch
        }

        if (mysqli_query($con, $sql)) {

        } else {
            echo "트리거 생성 중 실패원인" . mysqli_error($con);
        }
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