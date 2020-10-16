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
                console.log('성공이다');
                swal(data.successMsg[0]);
            }else {
                console.log('실패다');
                for(var i in data.errorMsg) {
                    console.log(i);
                    swal(data.errorIds[i],data.errorMsg[i],'error');
                }

            }

        },
    });
}