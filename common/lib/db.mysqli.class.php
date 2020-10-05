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
}