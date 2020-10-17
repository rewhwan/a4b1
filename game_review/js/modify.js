window.onload = function() {
    $('.story span').click(function() {
        $(this).parent().children('span').removeClass('on');
        $(this).addClass('on').prevAll('span').addClass('on');
        $('#story').attr('value',$(".story .on").length);
        console.log($(".story .on").length);
        return false;
    });

    $('.graphic span').click(function() {
        $(this).parent().children('span').removeClass('on');
        $(this).addClass('on').prevAll('span').addClass('on');
        $('#graphic').attr('value',$(".graphic .on").length);
        console.log($(".graphic .on").length);
        return false;
    });
    $('.time span').click(function() {
        $(this).parent().children('span').removeClass('on');
        $(this).addClass('on').prevAll('span').addClass('on');
        $('#time').attr('value',$(".time .on").length);
        console.log($(".time .on").length);
        return false;
    });

    $('.difficulty span').click(function() {
        $(this).parent().children('span').removeClass('on');
        $(this).addClass('on').prevAll('span').addClass('on');
        $('#difficulty').attr('value',$(".difficulty .on").length);
        console.log($(".difficulty .on").length);
        return false;
    });
}
//검색어 체크 함수
function check_input(){
    if(!$("#title").val()){
        alert("제목을 입력해주세요.");
        $("#title").focus();
        return false;
    }
    if(!$("#content").val()){
        alert("리뷰를 작성해주세요.");
        $("#content").focus();
        return false;
    }
    
    $("#review_modify_form").submit();
}
// 파일 선택 변화시 체크박스 체크 설정
function file_check() {
    var screen_shot = document.getElementById("screen_select");
    if(screen_shot != undefined){
        if(screen_shot.value != '') {
            document.getElementById("screen_select").checked = true;
        }else{
            document.getElementById("screen_select").checked = false;
        }
    }
}