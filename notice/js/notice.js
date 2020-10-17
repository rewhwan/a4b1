function check_input() {
    if (!document.notice_form.title.value) {
        alert("제목을 입력하세요!");
        document.notice_form.title.focus();
        return;
    }
    if (!document.notice_form.content.value) {
        alert("내용을 입력하세요!");
        document.notice_form.content.focus();
        return;
    }
    document.notice_form.submit();
}
//검색창에 입력하지않거나 공백을 입력했을경우 예외처리해주는 함수
function notice_search() {
    var search_form = document.getElementById('search_form');
    var keyword = document.getElementById('search');
    $keyword = $("#keyword").val();
    $keyword = $keyword.trim();
    if (!$keyword || $keyword == "") {
        alert("검색어가 입력되지않았습니다.");
        return false;
    }
    alert(keyword.value);
    search_form.submit();
}
//엔터 클릭시 검색정보를 받아서 데이터를 검증후 이벤트 처리하는 함수
function enter_notice(event) {
    if (event.keyCode == 13) notice_search();
}
//검색 데이터 정보를 받아온후 다시 검색창에 띄워주는 함수
function search_word(mode, keyword) {
    switch (mode) {
        case"title":
            $("#option_title").attr("select", true);
            break;
        case"content":
            $("#option_content").attr("select", true);
            break;
    }
    $("#keyword").val(keyword);
}