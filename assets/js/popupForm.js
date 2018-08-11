$(function() {

    $(document).on('click', '.addTweetBtn', function() {
        $('.status').removeClass().addClass('status-removed')
        $('.hash-box').removeClass().addClass('hash-removed')
        $('#count').attr('id', 'count-removed');


        $.post('http://localhost:8080/twitter/core/ajax/tweetForm.php', function(d) {

            $('.popupTweet').html(d);

            $('.closeTweetPopup').click(function() {
                $('.popup-tweet-wrap').hide();
                $('.status-removed').removeClass().addClass('status')
                $('.hash-removed').removeClass().addClass('hash-box')
                $('#count-removed').attr('id', 'count');
            })


        });
    });


    $(document).on('submit', '#popupForm', function(e) {

        e.preventDefault();
        console.log(this);
        var formData = new FormData($(this)[0]);
        formData.append('file', $('#file')[0].files[0]);


        console.log(formData);
        console.log($('#file')[0].files[0])

        $.ajax({
            url: 'http://localhost:8080/twitter/core/ajax/addTweet.php',
            type: "post",
            data: formData,
            success: function(d) {
                console.log(d)
                result = JSON.parse(d);

                if (result['error']) {

                    $('<div class="error-banner"><div class="error-banner-inner"><p id="errorMsg">' + result.error + '</p></div></div>').insertBefore('.header-wrapper');
                    $('.error-banner').hide().slideDown(300).delay(5000).slideUp(300);

                    $('.popup-tweet-wrap').hide()

                } else if (result['success']) {
                    $('<div class="error-banner"><div class="error-banner-inner"><p id="errorMsg">' + result.success + '</p></div></div>').insertBefore('.header-wrapper');
                    $('.error-banner').hide().slideDown(300).delay(5000).slideUp(300);

                    $('.popup-tweet-wrap').hide()
                }
            },
            cache: false,
            contentType: false,
            processData: false

        })

        location.reload();
    });


});