window.onload = function () {
    var id = document.getElementById("id");
    var username = document.getElementById("username");
    var password = document.getElementById("password");
    var password_ck = document.getElementById("password_ck");
    var email = document.getElementById("email");
    var password_certification = document.getElementById("password_certification");
}

function showSignupPopup() {
    window.open('signup.php', 'a', 'width=400,height=400,left=100,top=50,toolbar=1');
}

function checkID() {
    if (/^[a-z]+[a-z]{4,19}$/.test(id.value)) {
        span_id.innerHTML = "사용 가능한 ID 입니다.";
    } else {
        span_id.innerHTML = "ID는 영문 소문자 5글자 이상 19글자 이하 입력해주세요.";
        id.value = "";
        id.focus();
    }
}

function checkName(){
    if(/^[가-힣]{2,4}$/.test(username.value)){
        span_name.innerHTML= "";
    }else{
        span_name.innerHTML = "이름을 정확하게 입력하세요."; 
        username.focus();
    }
}

function checkPW() {
    if (/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/.test(password.value)) {
        span_pw.innerHTML = "사용 가능한 PW 입니다.";
    } else {
        span_pw.innerHTML = '8자리 이상 숫자/대문자/소문자/특수문자를 포함해야 합니다.';
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
    if (/^[0-9a-zA-Z]([-_.]?[0-9a-zA-Z])*@[0-9a-zA-Z]([-_.]?[0-9a-zA-Z])*.[a-zA-Z]{2,3}$/i.test(email.value)) {
        span_email.innerHTML = '';
    } else {
        span_email.innerHTML = '올바르지 않은 이메일 형식입니다 확인해주세요.';
        email.focus();
    }
}


$(document).ready(function () {
    //===================================== 인증번호 =============================================
    //인증번호 발송 버튼 이벤트 함수
    $('#send_code').on('click', function () {
        console.log('in func');
        var exp = /^[0-9]{3,4}$/;
        var phone_one_value = $("#phone_one").val().trim();
        var phone_two_value = $("#phone_two").val().trim();
        var phone_three_value = $("#phone_three").val().trim();

        //입력정보 체크
        if (phone_one_value === "" || phone_two_value === "" || phone_two_value === "") {
            toastr.error('핸드폰 번호에서 입력하지 않은 사항이 있습니다. 다시 확인해주세요!', "핸드폰 번호 입력오류", { timeOut: 3000 });
            $('#phone_one').focus();
            return;
        } else if (!exp.test(phone_two_value) || !exp.test(phone_three_value)) {
            toastr.error('번호는 3~4자의 숫자만 사용 할 수 있습니다.', '핸드폰 번호 오류', { timeOut: 3000 });
            $('#phone_two').focus();
            return;
        } else {
            $.ajax({
                url: "http://localhost/a4b1/login/find_id_pw_check.php",
                type: 'POST',
                dataType: 'json',
                data: {
                    find_type: "send_code",
                    phone_one: phone_one_value,
                    phone_two: phone_two_value,
                    phone_three: phone_three_value
                },
                success: function (data) {

                    $.ajax({
                        url: "http://localhost/a4b1/common/lib/phone_certification.php",
                        type: 'POST',
                        data: {
                            "mode": "send",
                            "phone_one": phone_one_value,
                            "phone_two": phone_two_value,
                            "phone_three": phone_three_value
                        },
                        success: function (data) {
                            phone_code = data;
                            if (data === "발송 실패") {
                                alert("문자 전송 실패되었습니다.");
                                phone_code_pass = false;
                                isAllPass();
                            } else {
                                swal("문자가 전송 되었습니다.", { icon: "success", closeOnClickOutside: false });
                            }
                        }
                    });
                }
            });
        }
    });
});

function checkCode() {
    if (password_certification.value === phone_code) {
        swal("인증번호 정상인증 되었습니다.", { icon: "success", closeOnClickOutside: false });
    } else {
        swal("인증번호가 일치하지 않습니다.", { closeOnClickOutside: false });
    }
}

function lastCheck() {
    if (/^[a-z]+[a-z0-9]{5,19}$/.test(id.value)) {
    } else {
        swal("아이디 를 확인해주세요.", { closeOnClickOutside: false });
        return false;
    }
    if(/^[가-힣]{2,4}$/.test(username.value)){
    }else{
        swal("이름 을 확인해주세요.", { closeOnClickOutside: false });
        return false;
    }
    if (/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/.test(password.value)) {
    } else {
        swal("비밀번호 를 확인해주세요.", { closeOnClickOutside: false });
        return false;
    } if (password.value === password_ck.value) {
    } else {
        swal("패스워드가 일치하지 않습니다.", { closeOnClickOutside: false });
        return false;
    } if (/^[0-9a-zA-Z]([-_.]?[0-9a-zA-Z])*@[0-9a-zA-Z]([-_.]?[0-9a-zA-Z])*.[a-zA-Z]{2,3}$/i.test(email.value)) {
    } else {
        swal("이메일을 확인해주세요.", { closeOnClickOutside: false });
        return false;
    } if (password_certification.value === phone_code) {
    }else{
        swal("인증번호가 일치 하지않습니다..", { closeOnClickOutside: false });
        return false;
    }
    
    $("#signup_form").submit();
}