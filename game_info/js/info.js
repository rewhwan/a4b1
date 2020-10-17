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

function file_check(input) {
    if(input.id == 'title_image') var checkbox_id = 'title_select';
    else var checkbox_id = 'screen_select';

    if(document.getElementById(checkbox_id) != null){
        if(input.value != '') {
            document.getElementById(checkbox_id).checked = true;
        }else{
        document.getElementById(checkbox_id).checked = false;
        }
    }
}
//화면 출력시 댓글을 가져오는 함수
function select_ripple(num,page,userid){
    $num=num;
    $page=page;
    $userid = userid;
    $.ajax({
        url : "./select_ripple.php?num="+num+"&page="+page,
        type : "POST",
        data : {num : num, page:page},
        datatype : 'json',
        success : function(data){
            //console.log(data);
            var json_data = JSON.parse(data);
            //console.log(json_data.isSuccess);
            if(json_data.isSuccess[0] == null){
                $("#ripple_form").append("<li>등록된 댓글이 없습니다.</li>");
                return false;
            }
            if(json_data.isSuccess[0] == 1){
                $("#ripple_form").empty();
                //console.log(json_data.data[0]['created_by']);
                for(i=0;i<json_data.isSuccess[3] && i<json_data.isSuccess[2]; i++){
                $("#ripple_form").append("<li id="+json_data.data[i]['num']
                +"><h3>작성자 : "+json_data.data[i]['created_by']+"</h3><p>작성일자 : "
                +json_data.data[i]['created_at']+"</p><p>"+json_data.data[i]['content']
                +"</p><p><input type='hidden' name='ripples_num' value="
                +json_data.data[i]['num']+"></p><input type='hidden' id='ripple_user' value="+json_data.data[i]['created_by']+"><button onclick=ripple_delete("
                +json_data.data[i]['num']+",'"+json_data.data[i]['created_by']+"')>삭        제</button></li>");
                }

                length = parseInt(json_data.isSuccess[1]);
                $("#page_num").empty();
                for(e=1; e<=length; e++){
                    //console.log(e);
                    $("#page_num").append("<a href='javascript:void(0);' onclick='select_ripple("+$num+",0+"+e+")'>&nbsp;"+e+"&nbsp;</a>");
                }
            }else{
                //alert("댓글로딩 오류");
                //console.log("댓글로딩 오류 또는 댓글이 없음");
                $("#ripple_form").append("<li>등록된 댓글이 없습니다.</li>");
                return false;
            }
        },
        error : function(XMLHttpRequest,textStatus, errorThrown){
            alert("통신실패");
            alert("code:"+XMLHttpRequest.textStatus+"\n"+"message:"+XMLHttpRequest.responseText+"\n"+"error:"+errorThrown);
        }
    });
}
//댓글을 추가하는 함수
function ripple_insert(num,name){
    $name = name;
    $content = $("#ripple_content").val();
    $count = $content.length;
    $num = num;
    if(!$name){
        alert('댓글이용은 로그인이 필요합니다.');
        return false;
    }

    if(!$content || $count < 3){
        alert('댓글이 공백이거나 3글자 미만입니다.');
        return false;
    }

    $.ajax({
        url:"http://localhost/a4b1/game_info/insert_ripple.php",
        type:"POST",
        data: {"name":$name,"content":$content,"num":$num},
        datatype: 'json',
        success : function(data){
            var json_data = JSON.parse(data);
            //console.log(json_data.isSuccess);
            if(json_data.isSuccess == null){
                alert('댓글등록 오류');
                return false;
            }
            if(json_data.isSuccess == 1){
                // $("#ripple_form").prepend("<li id="+json_data.data.num
                // +"><h3>작성자 : "+json_data.data.created_by+"</h3><p>작성일자 : "
                // +json_data.data.created_at+"</p><p>"+json_data.data.content
                // +"</p><p><input type='hidden' name='ripples_num' value="
                // +json_data.data.num+"></p><?php if($_SESSION['id'] == $ripple_create_by){?><button onclick=ripple_delete("
                // +json_data.data.num+")>삭        제</button></li><?php}?>");
                
                // var offsetTOP = $("#"+json_data.data.num).offset().top;
                // $('body').animate({scrollTop : offsetTOP}, 400);
                select_ripple($num,1);
                $("#ripple_content").val("");
            }else{
                alert("댓글달기 오류");
                return false;
            }
            
        },
        
        error : function(XMLHttpRequest,textStatus, errorThrown){
            alert("통신실패");
            alert("code:"+XMLHttpRequest.textStatus+"\n"+"message:"+XMLHttpRequest.responseText+"\n"+"error:"+errorThrown);
        }
    });
}
//댓글을 삭제하는 함수
function ripple_delete(num,user){
    $num = num;
    $user = user;
    $current_user = $("#current_user").val();
    $current_admin = $("#current_admin").val();
    //console.log($current_admin);
    if($num && ($user == $current_user || $current_admin>=1)){
        $.ajax({
            url:"http://localhost/a4b1/game_info/delete_ripple.php",
            type:"POST",
            data: {"num":$num},
            datatype: 'json',
            success : function(data){
                var json_data = JSON.parse(data);
                if(json_data.isSuccess == null){
                    alert("댓글지우기 오류");
                    return false;
                }
                if(json_data.isSuccess == 1){
                    // console.log(json_data.data);
                    $("li").remove("#"+json_data.data);
                }else{
                    alert("댓글지우기 오류");
                    return false;
                }
            },
            error : function(XMLHttpRequest,textStatus, errorThrown){
                alert("통신실패");
                alert("code:"+XMLHttpRequest.textStatus+"\n"+"message:"+XMLHttpRequest.responseText+"\n"+"error:"+errorThrown);
            }
        });
    }else{
        alert('삭제 불가능 : 권한이 없습니다.');
        return false;
    }
        
    
}
//지원 미지원 체크 함수
function service_kor_check(num){
    if(num == 1){
        $("input:radio[id='service_kor1']").attr("checked",true);
        $("input:radio[id='service_kor0']").attr("checked",false);
    }else{
        $("input:radio[id='service_kor0']").attr("checked",true);
        $("input:radio[id='service_kor1']").attr("checked",false);
    }
}
//장르 체크 함수
function genre_check(genre){
    array_genre = genre.split(",");
    for($i = 0; $i<array_genre.length; $i++){
        switch(array_genre[$i]){
            case "액션" : 
                $("input:checkbox[id='act']").attr("checked",true);
            break;
            case "공포" : 
                $("input:checkbox[id='fear']").attr("checked",true);
            break;
            case "어드밴처" : 
                $("input:checkbox[id='adv']").attr("checked",true);
            break;
            case "롤플레잉" : 
                $("input:checkbox[id='roll']").attr("checked",true);
            break;
            case "스포츠" : 
                $("input:checkbox[id='sport']").attr("checked",true);
            break;
            case "레이싱" : 
                $("input:checkbox[id='rac']").attr("checked",true);
            break;
            case "음악" : 
                $("input:checkbox[id='music']").attr("checked",true);
            break;
            case "퍼즐" : 
                $("input:checkbox[id='puzzle']").attr("checked",true);
            break;
            default:break;
        }
    }
}
//플랫폼 체크 함수
function platform_check(platform){
    array_platform = platform.split(",");
    for($i = 0; $i<array_platform.length; $i++){
        switch(array_platform[$i]){
            case "PS3" : 
                $("input:checkbox[id='PS3']").attr("checked",true);
            break;
            case "PS4" : 
                $("input:checkbox[id='PS4']").attr("checked",true);
            break;
            case "PS5" : 
                $("input:checkbox[id='PS5']").attr("checked",true);
            break;
            case "XBOX 360" : 
                $("input:checkbox[id='XBOX 360']").attr("checked",true);
            break;
            case "XBOX ONE" : 
                $("input:checkbox[id='XBOX one']").attr("checked",true);
            break;
            case "NINTENDO SWITCH" : 
                $("input:checkbox[id='nintendo switch']").attr("checked",true);
            break;
            default:break;
        }
    }
}
//등급 체크 함수
function grade_check(grade){
        switch(grade){
            case "전체이용가" : 
                $("input:radio[id='all']").attr("checked",true);
            break;
            case "12세이용가" : 
                $("input:radio[id='12']").attr("checked",true);
            break;
            case "15세이용가" : 
                $("input:radio[id='15']").attr("checked",true);
            break;
            case "청소년이용불가" : 
                $("input:radio[id='18']").attr("checked",true);
            break;
            case "등급면제" : 
                $("input:radio[id='empty']").attr("checked",true);
            break;
            case "테스트용" : 
                $("input:radio[id='test_ver']").attr("checked",true);
            break;
            default:break;
        }
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
    location.href="game_info_list.php?mode=search&search="+$search+"&search_word="+$search_word;
}

//선언된 값을 받아서 검색에 띄워주는 창
function search_word_check(search,search_word){
    
    switch(search){
       case"name": $("#option_name").attr("selected",true);
       break;
       case"grade": $("#option_grade").attr("selected",true);
       break;
       case"genre": $("#option_genre").attr("selected",true);
       break;
       case"platform": $("#option_platform").attr("selected",true);
       break;
    }
    $("#search_word").val(search_word);
}