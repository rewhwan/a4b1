<div id="title_container">
    <div>
        <a href="http://<?= $_SERVER['HTTP_HOST'] ?>/a4b1/admin/">
            <span id="title" class="gfont_1">A4B1</span>
            <span id="title_sub" class="gfont_3">Admin Page</span>
        </a>
    </div>
    <div id="title_function">
        <a href="http://<?= $_SERVER['HTTP_HOST'] ?>/a4b1/">
            <span class="gfont_3">사이트로 돌아가기</span>
        </a>
    </div>
</div>
<div>
    <div id="side_menu">
        <ul>
            <li>
                <a href="http://<?= $_SERVER['HTTP_HOST'] ?>/a4b1/admin/admin_slide.php">
                    <span class="gfont_3">메인 슬라이드 관리<span>
                </a>
            </li>
            <?php if(isset($_SESSION['admin']) && $_SESSION['admin'] == 2) {?>
            <li>
                <a href="http://<?= $_SERVER['HTTP_HOST'] ?>/a4b1/admin/admin_member.php">
                    <span class="gfont_3">멤버 권한 관리<span>
                </a>
            </li>
            <li>
                <a href="http://<?= $_SERVER['HTTP_HOST'] ?>/a4b1/admin/static.php">
                    <span class="gfont_3">통계 정보<span>
                </a>
            </li>
            <?php } ?>
        </ul>
    </div>
</div>