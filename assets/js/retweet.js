$(function() {
    $(document).on('click', '.retweet', function() {
        $t_id = $(this).data('tweet');
        $user_id = $(this).data('user');
        $counter = $(this).find('.retweetsCount');
        $count = $counter.text();
        $btn = $(this);

        $.post('http://localhost:8080/twitter/core/ajax/retweet.php', { showPopup: $t_id, user_id: $user_id }, function(d) {

            $('.popupTweet').html(d);

            $('.close-retweet-popup').click(function() {
                $('.retweet-popup').hide();
            })
        })
    })



    $(document).on('click', '.retweet-it', function() {
        var comment = $('.retweetMsg').val();

        $.post('http://localhost:8080/twitter/core/ajax/retweet.php', { retweet: $t_id, user_id: $user_id, comment: comment }, function(d) {


            $('.retweet-popup').hide();
            $count++;
            $counter.text($count);

            $btn.removeClass('retweet').addClass('retweeted');

        })
    })
});