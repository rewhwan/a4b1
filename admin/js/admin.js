function submit_slide() {
    console.log($('#slide_file')[0].files[0]);
    $.ajax({
        url:'./slide_dmi.php',
        type:'post',
        data:{mode:'insertSlide',file:$('#slide_file')[0]},
        contentType:false,
        processData:false,
        success:function(data) {
            console.log(data);
        },
    });
};