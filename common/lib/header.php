<div id="header_container">
    <div id="top_menu">
        <ul>
            <?php
                if(isset($_SESSION['id']) && isset($_SESSION['password'])) {
            ?>
                    <li>아이디 : <?=$_SESSION['id']?></li>
                    <li>비밀번호 : <?=$_SESSION['password']?></li>
                    <li>admin : <?=$_SESSION['admin']?></li>
                    <li><a onclick="logoutCheck('<?=$_SERVER['HTTP_HOST']?>')">로그아웃</a></li>
            <?php }else{?>
                    <li><a href="http://<?=$_SERVER['HTTP_HOST']?>/a4b1/login/index.php">로그인</a></li>
                    <li><a href="http://<?=$_SERVER['HTTP_HOST']?>/a4b1/login/index.php">회원가입</a></li>
            <?php }?>
        </ul>
    </div>
    <div id="menu">
        <ul>
            <li><a href="http://<?=$_SERVER['HTTP_HOST']?>/a4b1/index.php">메인</a></li>
            <li><a href="http://<?=$_SERVER['HTTP_HOST']?>/a4b1/game_info/index.php">게임소개</a></li>
            <li><a href="http://<?=$_SERVER['HTTP_HOST']?>/a4b1/game_review/index.php">게임리뷰</a></li>
            <li><a href="http://<?=$_SERVER['HTTP_HOST']?>/a4b1/notice/index.php">공지사항</a></li>
        </ul>
    </div>
</div>