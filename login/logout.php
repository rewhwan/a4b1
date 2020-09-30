<?php
    session_start();
    session_destroy();
    echo "<script>
            alert('로그아웃에 성공했습니다.');
            location.href='http://".$_SERVER['HTTP_HOST']."/a4b1/index.php'
            </script>";