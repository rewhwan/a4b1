function logoutCheck(host) {
    let check = confirm("정말 로그아웃하시겠습니까?");
    if(check) location.href="http://"+host+"/a4b1/login/logout.php";
}