$(function() {

    $(document).on('click', '#send', function () {
        var msg = $('#msg').val();
        var get_id=$(this).data('user');


        $.post('http://localhost:8080/twitter/core/ajax/messages.php', {sendMsg: msg,get_id:get_id}, function (d) {

            getMsgs()
            $('#msg').val('');


        })


    });
});