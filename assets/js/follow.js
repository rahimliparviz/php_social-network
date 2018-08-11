$(function() {


    $('.follow-btn').click(function() {


        var f_id = $(this).data('follow');
        var p_id = $(this).data('profile');
        $btn = $(this);


        if ($btn.hasClass('following-btn')) {
            $.post('http://localhost:8080/twitter/core/ajax/follow.php', { unfollow: f_id, profile: p_id }, function(d) {


                data = JSON.parse(d);
                console.log(data);
                $btn.removeClass('following-btn');
                $btn.removeClass('unfollow-btn');
                $btn.html('<i class="fa fa-user-plus"></i> Follow');

                $('.count-following').text(data.following);
                $('.count-followers').text(data.followers);

            })

        } else {
            $.post('http://localhost:8080/twitter/core/ajax/follow.php', { follow: f_id, profile: p_id }, function(d) {

                data = JSON.parse(d);

                $btn.removeClass('follow-btn');
                $btn.addClass('following-btn');
                $btn.text('Following');

                $('.count-following').text(data.following);
                $('.count-followers').text(data.followers);

            })
        }

    })

})
$('.follow-btn').hover(function() {

    console.log($(this))
    $btn = $(this);
    if ($btn.hasClass('following-btn')) {
        $btn.addClass('unfollow-btn')
        $btn.text('Unfollow')
    }
}, function() {
    if ($btn.hasClass('following-btn')) {
        $btn.removeClass('unfollow-btn')
        $btn.text('Following')
    }
});