function submit_slide() {
    let form = $('#insert_slide')[0];
    let formData = new FormData(form);
    $.ajax({
        url:'./slide_dmi.php',
        contentType: false,
        processData: false,
        type:'POST',
        data:formData,
        dataType:'json',
        success:function(data) {
            if(data.isSuccess == true) {
                swal(data.successMsg[0]);
            }else {
                for(var i in data.errorMsg) {
                    swal(data.errorIds[i],data.errorMsg[i],'error');
                }
            }
        },
    });
}

function delete_slide(num) {
    //경고창을 띄워 진짜 삭제할 것인지 체크
    swal({
        title: '삭제 확인',
        text: '정말 사진을 삭제하시겠습니까?',
        icon: 'warning',
        dangerMode: true,
        buttons: {
            cancel: '아니요',
            confirm: {
                text: '예',
                value: true,
            }
        },
    }).then((value) => {
        if(value) {
            $.ajax({
                url: './slide_dmi.php',
                type: 'POST',
                data:{mode:'deleteSlide',no:num},
                dataType: 'json',
                success:function (data) {
                    console.log(data);
                    //삭제 성공여부 분기점
                    if(data.isSuccess == true) {
                        swal('삭제 성공',data.successMsg[0],'success').then(() => {location.reload();});
                    }else {
                        for(var i in data.errorMsg) {
                            swal(data.errorIds[i],data.errorMsg[i],'error');
                        }
                    }
                }
            });
        } else swal('취소를 눌렀구나');
    })
}