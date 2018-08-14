noti = function () {
    $.get(
        'http://localhost:8080/twitter/core/ajax/noti.php',
        { showNoti: true },
        function(d) {

            console.log(d);
            if (d){
                if (d.noti > 0){
                    $('#notification').addClass('span-i');
                    $('#notification').html(d.noti);
                }
                if (d.msg > 0){
                    $('#messages').show();
                    $('#messages').addClass('span-i');
                    $('#messages').html(d.msg);
                }
            }

    },'json')
}


setInterval(noti,10000);