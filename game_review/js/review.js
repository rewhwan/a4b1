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

    /*리뷰 작성관련 이벤트 함수 등록*/
    $('#title').on('keypress',function () {
        //검색어가 입력되어 있으면 검색버튼을 눌러준다.
        if(event.keyCode == 13) {
            $('#submit_btn').click();
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
//검색기능시 쿠키등록 및 예외처리 함수
function check_search(){
    $search = $("#search").val();
    $search_word = $("#search_word").val();
    if(!$search){
        alert("검색 종류가 선택되지 않았습니다.");
        return false;
    }
    if(!$search_word){
        alert("검색어가 선택되지 않았습니다.");
        return false;
    }
    location.href="./index.php?mode=search&search="+$search+"&search_word="+$search_word;
}

function search_word_check(search,search_word){
    
    switch(search){
       case"title": $("#option_title").attr("selected",true);
       break;
       case"created_by": $("#option_created_by").attr("selected",true);
       break;
       case"content": $("#option_content").attr("selected",true);
       break;
    }
    $("#search_word").val(search_word);
}

//enter 클릭 시 이벤트 적용
function check_enter(event){
    if(event.keyCode == 13){
        check_search();
    }
}