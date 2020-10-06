function check_input() {
    // if (!$("#title_image").val()) {
    //     alert("타이틀 이미지가 설정되지 않았습니다.");
    //     return false;
    // }
    if (!$("#name").val()) {
        alert("게임명 정보가 설정되지 않았습니다.");
        $("#name").focus();
        return false;
    }
    if (!$("#developer").val()) {
        alert("개발사 정보가 설정되지 않았습니다.");
        $("#developer").focus();
        return false;
    }
    //선택된 개수가 0개일 경우
    if ($('input:checkbox[name="platform[]"]:checked').length == 0) {
        alert("플랫폼 정보가 설정되지 않았습니다.");
        $("#platform").focus();
        return false;
    }
    //선택된 개수가 0개일 경우
    if ($('input:checkbox[name="genre[]"]:checked').length == 0) {
        alert("장르 정보가 설정되지 않았습니다.");
        return false;
    }
    if (!$("#open_day").val()) {
        alert("출시일자 정보가 설정되지 않았습니다.");
        $("#open_day").focus();
        return false;
    }
    //선택된 개수가 0개일 경우
    if ($("input:radio[name='grade']:checked").length == 0) {
        alert("심의등급 정보가 설정되지 않았습니다.");
        return false;
    }
    if (!$("#circulation").val()) {
        alert("유통사 정보가 설정되지 않았습니다.");
        $("#circulation").focus();
        return false;
    }
    //선택된 개수가 0개일 경우
    if ($("input:radio[name='service_kor']:checked").length == 0) {
        alert("한국어 지원 정보가 설정되지 않았습니다.");
        //$("#service_kor").focus();
        return false;
    }
    if (!$("#price").val()) {
        alert("가격 정보가 설정되지 않았습니다.");
        $("#price").focus();
        return false;
    }
    if (!$("#homepage").val()) {
        alert("홈페이지 정보가 설정되지 않았습니다.");
        $("#homepage").focus();
        return false;
    }
    // if (!$("#content").val()) {
    //     alert("게임개요 정보가 설정되지 않았습니다.");
    //     $("#content").focus();
    //     return false;
    // }
    // if (!$("#screen_shot").val()) {
    //     alert("스크린 샷 이미지가 설정되지 않았습니다.");
    //     return false;
    // }

    $("#insert_form").submit();
}

function file_check(file,id) {
    //마지막 .을찾는다.
    pathpoint = file.value.lastIndexOf('.');
    //.을기준으로 1칸뒤기준으로 파일 끝까지 추출
    filepoint = file.value.substring(pathpoint + 1, file.length);
    //소문자로 변경
    filetype = filepoint.toLowerCase();
    //console.log(typeof(filetype));

    //이미지 파일 형식이 아닐경우의 예외처리
    if (!(filetype == "jpg" || filetype == "gif" || filetype == "png" || filetype == "jpeg" || filetype == "bmp")) {
        //console.log("이미지 파일");
        alert("이미지 파일만 선택할 수 있습니다.");
        
        //input의 value 값 초기화
        if(id == "title_image"){
            $("#title_image").val("");
        }else{
            $("#screen_shot").val("");
        }
        return false;
    }
    //bmp일경우 경고문
    if (filetype == "bmp") {
        upload = confirm("BMP 파일은 웹상에서 사용하기에는 부적절한 포맷입니다.\n그래도 계속 하시겠습니까?");
        if (!upload) return false;
    }
}