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

    //게임검색 엔터키 입력시 검색 실행
    $('#game_name').on('keypress',function () {
        //검색어가 입력되어 있으면 검색버튼을 눌러준다.
        if(event.keyCode == 13) {
            if($(this).val().trim() != '') {
                $('#game_search').click();
            }else {
                toastr.error('검색어를 입력해주세요',"검색어 입력요망", {timeOut: 3000});
                return;
            }
        }
    });

    //검색버튼 클릭시 실행 함수
    $('#game_search').click(function () {
        console.log('검색버튼이 눌렸다.')
        $.ajax({
            url: "http://localhost/a4b1/game_review/review_game_search.php",
            type: 'POST',
            dataType: 'json',
            data: {
               name: $('#game_name').val()
            },
            success: function (data) {
                console.log(data);
                var selector = $('#game_search_result');
                for(var i in data.data) {
                    console.log(data.data[i]);
                    selector.append("<option value="+data.data[i].num+">"+data.data[i].name+"</option>")
                }
            }
        });
    });
}

function check_input(){

    if(!$("#game_search_result").val()){
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

    $("#review_form").submit();
}