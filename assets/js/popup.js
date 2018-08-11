$(function() {
    $(document).on('click', '.t-show-popup', function() {


        $t_id = $(this).data('tweet');
        $user_id = $(this).data('user');

        $.post('http://localhost:8080/twitter/core/ajax/popup.php', { showPopup: $t_id }, function(d) {

            $('.popupTweet').html(d);

            $('.tweet-show-popup-box-cut').click(function() {

                $('.wrap4').hide();
            })
        })

        $(document).on('click', '.ImagePopup', function(e) {
e.stopPropagation();
            $t_id = $(this).data('tweet');
            $.post('http://localhost:8080/twitter/core/ajax/imgPopup.php', { showImg: $t_id }, function(d) {
                $('.popupTweet').html(d);
                $('.close-imagePopup').click(function () {
                    $('.img-popup').hide();
                });
            })
        })


    })
});