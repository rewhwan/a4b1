function logoutCheck(host) {
    swal({
        text: '정말 로그아웃 하시겠습니까?',
        icon: 'info',
        buttons: {
            cancel: '아니요',
            confirm: {
                text: '예',
                value: true,
            }
        },
    }).then((value) => {
        if(value) {location.href="http://"+host+"/a4b1/login/logout.php"}
    });
}

window.onscroll = function () {
    // 메뉴바 변수 적용
    var menu = document.getElementById("menu");
    var top_menu = document.getElementById('top_menu');
    var offsetTop = top_menu.offsetHeight;
    var scrollTop = document.scrollingElement.scrollTop;

    // body 태그 변수 적용
    var body = document.getElementById("body");

    if(scrollTop > offsetTop) {
        menu.classList.add("leftTopFixed");
        body.classList.add("bodyMenuFixed");
    } else {
        menu.classList.remove("leftTopFixed");
        body.classList.remove("bodyMenuFixed");
    }
}