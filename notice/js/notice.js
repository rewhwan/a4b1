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

function search() {
    var search_form = document.getElementById('search_form');
    search_form.submit();
}