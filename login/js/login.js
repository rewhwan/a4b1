//전역변수 세팅
let loginFormDiv;
let loginForm;
let inputID;
let inputPassword;

//아이디를 바로 입력할 수 있도록 포커스 처리
window.onload = function () {
    loginFormDiv  = document.getElementById("login_form");
    inputID = loginFormDiv.querySelector("#id");
    inputPassword = loginFormDiv.querySelector("#password");
    loginForm = loginFormDiv.querySelector("form");

    inputID.focus();
}

//정보를 입력하고 엔터키를 입력하면 데이터 검증후 로그인을 수행하도록 하는 이번트 함수
function enterLogin(event) {
    if(event.keyCode == 13) check_input();
}

//폼태그 기본이벤트 방지
function prevent() {
    if(event.keyCode == 13){
        event.preventDefault();
    }
}

//아이디 비밀번호 값 검증이후 제출
function check_input() {

    if (!inputID.value || inputID.value.trim() === '') {
        swal({
            title: '아이디 입력 오류',
            text: '아이디를 제대로 입력해 주세요.',
            icon: 'warning'
        });
        inputID.value = '';
        inputID.focus();
        return;
    }

    if (!inputPassword.value || inputPassword.value.trim() === '') {
        if (!inputID.value || inputID.value.trim() === '') {
            swal({
                title: '비밀번호 입력 오류',
                text: '비밀번호를 제대로 입력해 주세요.',
                icon: 'warning'
            });
            alert("비밀번호를 입력해주세요.")
            inputPassword.value = '';
            inputPassword.focus();
            return;
        }
    }
    loginForm.submit();
}

//아이디 비밀번호 찾기 버튼 클릭시 팝업창으로 보여줌
function showPopup() {
    window.open('find_id_pw.php','a','width=400,height=400,left=100,top=50,toolbar=1');
}