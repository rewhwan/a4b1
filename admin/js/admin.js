function submit_slide() {

    $.ajax({
        url:'./slide_dmi.php',
        contentType: false,
        processData: false,
        type:'POST',
        data:{mode:'insertSlide',slide_file:$('#slide_file')[0].files},
        dataType:'json',
        success:function(data) {
            console.log(data);
        },
    });
};