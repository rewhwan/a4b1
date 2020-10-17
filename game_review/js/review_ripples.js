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
        url:"http://localhost/a4b1/game_review/insert_ripple.php",
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
            url:"http://localhost/a4b1/game_review/delete_ripple.php",
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