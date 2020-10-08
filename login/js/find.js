$(document).ready(function () {
    //아이디 비밀번호 찾기 탭버튼 이벤트 함수
    $('.tab_menu_btn').on('click', function () {
        //버튼 색 제거,추가
        $('.tab_menu_btn').removeClass('on');
        $(this).addClass('on')

        //컨텐츠 제거 후 인덱스에 맞는 컨텐츠 노출
        var idx = $('.tab_menu_btn').index(this);

        $('.tab_box').hide();
        $('.tab_box').eq(idx).show();

        //탭변경 이후 맨처음 input을 focus
        if ($(this).text() == '아이디 찾기') $('#id_form_name').focus();
        else $('#pw_form_id').focus();
    });

    //아이디 찾기 관련 이벤트 함수
    $('#id_form_name').on('keypress', function () {
        if (event.keyCode == 13) $('#find_id_button').click();
    });

    //아이디 찾기 관련 이벤트 함수
    $('#id_form_email').on('keypress', function () {
        if (event.keyCode == 13) $('#find_id_button').click();
    });

    //아이디 찾기 버튼 클릭시 이벤트 함수
    let phone_code = "";
    $('#find_id_button').on('click', function () {
        let idFormName = $('#id_form_name').val().trim();
        let idFormEmail = $('#id_form_email').val().trim();

        //이름입력 확인
        if (!idFormName || idFormName == '') {
            toastr.error('이름을 입력해주세요 (공백입력 불가)', '이름 입력 오류', {timeOut: 3000});
            $('#id_form_name').focus();
            return;
        }

        //이메일 입력 확인
        if (!idFormEmail || idFormEmail == '') {
            toastr.error('이메일를 입력해주세요 (공백입력 불가)', '이메일 입력 오류', {timeOut: 3000});
            return;
        }

        //이메일 정규식 확인
        var checkEmail = /^[a-z0-9_+.-]+@([a-z0-9-]+\.)+[a-z0-9]{2,4}$/;
        if(!checkEmail.test(idFormEmail)) {
            toastr.error('이메일을 제대로 입력해주세요', '이메일 입력 오류', {timeOut: 3000});
            return;
        }

        //ajax통신
        $.ajax({
            url: "http://localhost/a4b1/login/find_id_pw_check.php",
            data: {find_type: "id", find_id_name: idFormName, find_id_email: idFormEmail},
            type: 'POST',
            dataType: 'json',
            success: function (data) {
                console.log(data);
                if (data.isSuccess == 1) swal("아이디 찾기 완료", data.data.name + "님의 아이디는 \"" + data.data.id + "\" 입니다.",
                    "success", {closeOnClickOutside: false});
                else if(data.errorMsg != null) toastr.error(data.errorMsg, 'Mysql 오류');
                else toastr.error('검색 결과와 일치하는 아이디가 없습니다.', '아이디 찾기 오류', {timeOut: 3000});
            }
        });
    });

    //===================================== 인증번호 =============================================
    //인증번호 발송 버튼 이벤트 함수
    $('#send_code').on('click',function () {
        var exp = /^[0-9]{3,4}$/;
        var id_value = $("#pw_form_id").val().trim();
        var phone_one_value = $("#phone_one").val().trim();
        var phone_two_value = $("#phone_two").val().trim();
        var phone_three_value = $("#phone_three").val().trim();

        //입력정보 체크
        if(!id_value || id_value === "") {
            toastr.error('아이디를 입력해주세요.',"아이디 입력 오류", {timeOut: 3000});
            $('#pw_form_id').focus();
            return;
        } else if(phone_one_value === "" || phone_two_value === "" || phone_two_value === "") {
            toastr.error('핸드폰 번호에서 입력하지 않은 사항이 있습니다. 다시 확인해주세요!',"핸드폰 번호 입력오류", {timeOut: 3000});
            $('#phone_one').focus();
            return;
        }  else if ( !exp.test(phone_two_value) || !exp.test(phone_three_value)) {
            toastr.error('번호는 3~4자의 숫자만 사용 할 수 있습니다.', '핸드폰 번호 오류', {timeOut: 3000});
            $('#phone_two').focus();
            return;
        } else {
            $.ajax({
                url: "http://localhost/a4b1/login/find_id_pw_check.php",
                type: 'POST',
                dataType: 'json',
                data: {
                    find_type: "send_code",
                    find_password_id:id_value,
                    phone_one: phone_one_value,
                    phone_two: phone_two_value,
                    phone_three: phone_three_value
                },
                success: function (data) {
                    //연락처와 아이디 정보가 일치할때 인증문자를 보내줌
                    console.log(data);
                    if(data.isSuccess == 0) {
                        swal("일치하는 정보가 없습니다.", "가입할 때 입력했던 정보를 정확히 입력해주세요",
                            "error", {closeOnClickOutside: false});
                    }else {
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
                                    swal("문자가 전송 되었습니다.", {icon: "success",closeOnClickOutside: false});
                                }
                            }
                        });
                    }
                }
            });
        }
    });

    //비밀번호 찾기 관련 이벤트 함수
    $('#pw_form_id').on('keypress', function () {
        if (event.keyCode == 13) $('#send_code').click();
    });

    //비밀번호 찾기 관련 이벤트 함수
    $('#phone_one').on('keypress', function () {
        if (event.keyCode == 13) $('#send_code').click();
    });

    //비밀번호 찾기 관련 이벤트 함수
    $('#phone_two').on('keypress', function () {
        if (event.keyCode == 13) $('#send_code').click();
    });

    //비밀번호 찾기 관련 이벤트 함수
    $('#phone_three').on('keypress', function () {
        if (event.keyCode == 13) $('#send_code').click();
    });

    //====================================== 비밀번호찾기 =============================================
    $('#password_certification').on('keypress', function () {
        if (event.keyCode == 13) $('#find_pw_button').click();
    });

    $('#find_pw_button').on('click',function () {
        //인증번호 입력값
        var code = $("#password_certification").val()

        //문자인증을 실행했는지 확인
        if(!phone_code) {
            swal("문자인증을 먼저 해주세요",  "핸드폰 문자인증을 해주세요 ", "error", {closeOnClickOutside: false});
            $('#send_code').focus();
            return;
        }

        //인증번호가 일치하는지 확인
        if(phone_code == code) {
            var exp = /^[0-9]{3,4}$/;
            var id_value = $("#pw_form_id").val().trim();
            var phone_one_value = $("#phone_one").val().trim();
            var phone_two_value = $("#phone_two").val().trim();
            var phone_three_value = $("#phone_three").val().trim();

            //입력정보 체크
            if(!id_value || id_value === "") {
                toastr.error('아이디를 입력해주세요.',"아이디 입력 오류", {timeOut: 3000});
                $('#pw_form_id').focus();
                return;
            } else if(phone_one_value === "" || phone_two_value === "" || phone_two_value === "") {
                toastr.error('핸드폰 번호에서 입력하지 않은 사항이 있습니다. 다시 확인해주세요!',"핸드폰 번호 입력오류", {timeOut: 3000});
                $('#phone_one').focus();
                return;
            }  else if ( !exp.test(phone_two_value) || !exp.test(phone_three_value)) {
                toastr.error('번호는 3~4자의 숫자만 사용 할 수 있습니다.', '핸드폰 번호 오류', {timeOut: 3000});
                $('#phone_two').focus();
                return;
            }

            if(phone_code == code){
                $.ajax({
                    url: "http://localhost/a4b1/login/find_id_pw_check.php",
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        find_type:'password',
                        find_password_id:id_value,
                        phone_one: phone_one_value,
                        phone_two: phone_two_value,
                        phone_three: phone_three_value,
                    },
                    success: function (data) {
                        swal("비밀번호 검색 완료",  data.data.id+"님의 비밀번호는 \""+data.data.password+"\"입니다.", {icon:"success",closeOnClickOutside: false});
                    }
                });
            }
        }else {
            toastr.error('인증번호를 정확히 입력해주세요', '인증번호 오류', {timeOut: 3000});
            return;
        }
    });

    //첫화면에서 이름입력input이 바로 포커스 되도록함.
    $('#id_form_name').focus();
});