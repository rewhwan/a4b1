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

function check_input(){

    if(!$("#name").val()){
        alert("게임이 선택되지 않았습니다.");
        $("#name").focus();
        return false;
    }
    if(!$("#title").val()){
        alert("리뷰제목 이 입력되지 않았습니다.");
        $("#title").focus();
        return false;
    }
    if(!$("#story").val()){
        alert("스토리 별점 이 입력되지 않았습니다.");
        $("#story").focus();
        return false;
    }
    if(!$("#graphic").val()){
        alert("그래픽 별점 이 입력되지 않았습니다.");
        $("#graphic").focus();
        return false;
    }
    if(!$("#time").val()){
        alert("러닝타임 별점 이 입력되지 않았습니다.");
        $("#time").focus();
        return false;
    }
    if(!$("#difficulty").val()){
        alert("난이도 별점 이 입력되지 않았습니다.");
        $("#difficulty").focus();
        return false;
    }
    if(!$("#content").val()){
        alert("리뷰가 입력되지 않았습니다.");
        $("#content").focus();
        return false;
    }
    if(!$("").val()){
        alert("리뷰가 입력되지 않았습니다.");
        $("#content").focus();
        return false;
    }

    $("#review_form").submit();
}