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
        $.ajax({
            url: "http://localhost/a4b1/game_review/review_game_search.php",
            type: 'POST',
            dataType: 'json',
            data: {
               name: $('#game_name').val()
            },
            success: function (data) {
                let selectorContainer = $('#game_search_result_container');
                console.log(data);
                console.log(data.isSuccess);
                console.log(data.data);
                if(data.isSuccess != 0 && data.data != null) {
                    selectorContainer.css('display','flex');
                    selectorContainer.empty();
                    selectorContainer.append("<p>검색결과</p>");
                    selectorContainer.append("<select id='game_search_result' name='name'></select>");
                    let selector = $('#game_search_result');
                    for(var i in data.data) {
                        console.log(data.data[i]);
                        selector.append("<option value="+data.data[i].num+">"+data.data[i].name+"</option>")
                    }
                }else {
                    toastr.error('다른검색어로 검색하거나 게임이름을 입력하고 리뷰를 등록해주세요.','게임 검색 결과가 없습니다.');
                    selectorContainer.css('display','flex');
                    selectorContainer.empty();
                    selectorContainer.append("<p>게임이름</p>");
                    selectorContainer.append("<input type='text' id='game_search_result' name='name'>");
                }
            }
        });
    });

    /*리뷰 작성관련 이벤트 함수 등록*/
    $('#title').on('keypress',function () {
        //검색어가 입력되어 있으면 검색버튼을 눌러준다.
        if(event.keyCode == 13) {
            $('#submit').click();
        }
    });

    $('#content').on('keypress',function () {
        //검색어가 입력되어 있으면 검색버튼을 눌러준다.
        if(event.keyCode == 13) {
            $('#submit').click();
        }
    });
}

function check_input(){

    if(!$("#game_search_result").val()){
        alert("게임이 선택되지 않았습니다.");
        $("#name").focus();
        return false;
    }
    if(!$("#title").val()){
        toastr.error('제목이 입력되지 않았습니다',"제목 입력요망", {timeOut: 3000});
        $("#title").focus();
        return false;
    }
    if(!$("#story").val()){
        toastr.error('스토리 별점 이 입력되지 않았습니다.',"별점 입력요망", {timeOut: 3000});
        $("#story").focus();
        return false;
    }
    if(!$("#graphic").val()){
        toastr.error('그래픽 별점 이 입력되지 않았습니다.',"별점 입력요망", {timeOut: 3000});
        $("#graphic").focus();
        return false;
    }
    if(!$("#time").val()){
        toastr.error('러닝타임 별점 이 입력되지 않았습니다.',"별점 입력요망", {timeOut: 3000});
        $("#time").focus();
        return false;
    }
    if(!$("#difficulty").val()){
        toastr.error('난이도 별점 이 입력되지 않았습니다.',"별점 입력요망", {timeOut: 3000});
        $("#difficulty").focus();
        return false;
    }
    if(!$("#content").val()){
        toastr.error('리뷰가 입력되지 않았습니다.',"리뷰 입력요망", {timeOut: 3000});
        $("#content").focus();
        return false;
    }

    $("#review_form").submit();
}