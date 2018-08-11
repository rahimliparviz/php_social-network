$(function() {
    $(document).on('click', '#postComment', function() {
        var t_id = $("#commentField").data('tweet');
        var cm = $("#commentField").val();
        if (cm != '') {
            $.post('http://localhost:8080/twitter/core/ajax/comment.php', { tw_id: t_id, comment: cm }, function(d) {
                //console.log(d);
                $('#comments').html(d);

                $('#commentField').val('');
            })
        }
    })




});