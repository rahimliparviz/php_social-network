$(function() {
    $(document).on('click', '.like-btn', function(e) {
        e.preventDefault();
        var t_id = $(this).data('tweet');
        var user_id = $(this).data('user');
        var counter = $(this).find('.likesCount');
        var count = counter.text();
        var btn = $(this);


        //console.log($t_id);

        $.post('http://localhost:8080/twitter/core/ajax/like.php', { like: t_id, user_id: user_id }, function(d) {
                console.log(d);

                counter.show();
                btn.addClass('unlike-btn');
                btn.removeClass('like-btn');
                count++;
                counter.text(count);
                btn.find('.fa-heart-o').addClass('fa-heart');
                btn.find('.fa-heart').removeClass('fa-heart-o');
            }

        )
    })





    $(document).on('click', '.unlike-btn', function(e) {
        e.preventDefault();

        var t_id = $(this).data('tweet');
        var user_id = $(this).data('user');
        var counter = $(this).find('.likesCount');
        var count = counter.text();
        var btn = $(this);



        $.post('http://localhost:8080/twitter/core/ajax/like.php', { unlike: t_id, user_id: user_id }, function(d) {

                console.log(d)
                counter.show();
                btn.addClass('like-btn');
                btn.removeClass('unlike-btn');
                count--;
                if (count === 0) {
                    counter.hide();
                } else {
                    counter.text(count);
                }
                counter.text(count);
                btn.find('.fa-heart').addClass('fa-heart-o');
                btn.find('.fa-heart-o').removeClass('fa-heart');
            }

        )
    })

});