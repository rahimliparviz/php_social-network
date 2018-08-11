$(function() {

    $(document).on('click', '.deleteTweet', function () {
        var t_id = $(this).data('tweet');


        $.post('http://localhost:8080/twitter/core/ajax/deleteTweet.php', {showPopup: t_id}, function (d) {

                $('.popupTweet').html(d);

                $('.close-retweet-popup, .cancel-it').click(function(){
                  $('.retweet-popup').hide();
                });
            $(document).on('click', '.delete-it', function () {


                $.post('http://localhost:8080/twitter/core/ajax/deleteTweet.php', {deleteTweet: t_id}, function (d) {


                    $('.retweet-popup').hide();
                   location.reload();
                })
            })

        })


    });





    $(document).on('click', '.deleteComment', function () {
        var t_id = $(this).data('tweet');
        var c_id = $(this).data('comment');


        $.post('http://localhost:8080/twitter/core/ajax/deleteComment.php', {deleteComment: c_id}, function (d) {
            $.post('http://localhost:8080/twitter/core/ajax/popup.php', { showPopup: t_id }, function(d) {

                $('.popupTweet').html(d);

                $('.tweet-show-popup-box-cut').click(function() {

                    $('.wrap4').hide();
                })
            })
        })
    })
})