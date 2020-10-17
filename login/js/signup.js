window.onload = function () {
    var id = document.getElementById("id");
    var password = document.getElementById("password");
    var password_ck = document.getElementById("password_ck");
    var phone_one = document.getElementById("phone_one");
    var phone_two = document.getElementById("phone_two");
    var phone_three = document.getElementById("phone_three");
    var email = document.getElementById("email");
}

function showSignupPopup() {
    window.open('signup.php', 'a', 'width=400,height=400,left=100,top=50,toolbar=1');
}

function checkID() {
    if (/^[a-z]+[a-z0-9]{5,19}$/.test(id.value)) {
        span_id.innerHTML = "사용 가능한 ID 입니다.";
    } else {
        span_id.innerHTML = "앞자리는 영어(소) 시작 총 글자수는 4~20까지 입력해주세요";
        id.value = "";
        id.focus();
    }
}

function checkPW() {
    if (/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/.test(password.value)) {
        span_pw.innerHTML = "사용 가능한 PW 입니다.";
    } else {
        span_pw.innerHTML = '비밀번호는 8자 이상 숫자/대문자/소문자/특수문자를 포함해야 합니다.';
        password.value = "";
        password.focus();
    }
}


function checkPWOK() {
    if (password.value === password_ck.value) {
        span_ok.innerHTML = "비밀번호 가 일치 합니다.";
    } else {
        span_ok.innerHTML = '비밀번호 가 일치하지 않습니다.';
        password_ck.value = "";
        password_ck.focus();
    }
}

function checkEmail() {
    if (/^[0-9a-zA-Z]([-_.]?[0-9a-zA-Z])*@[0-9a-zA-Z]([-_.]?[0-9a-zA-Z])*.[a-zA-Z]{2,3}$/i.test(email.value)){
        span_email.innerHTML = '';
    } else {
        span_email.innerHTML = '올바르지 않은 이메일 형식입니다 확인해주세요.';
        email.focus();
    }
}
