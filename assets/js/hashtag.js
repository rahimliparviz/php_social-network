$(function() {
    var regex = /[#|@](\w+)$/ig;

    $(document).on('keyup', '.status', function() {
        var content = $.trim($(this).val());
        var text = content.match(regex);
        var max = 140;

        if (text != null) {
            var dataString = '' + text;

            $.ajax({
                type: 'POST',
                url: "http://localhost:8080/twitter/core/ajax/getHashtag.php",
                data: { hashtag: dataString },
                success: function(d) {
                    $('.hash-box ul').html(d);
                    $('.hash-box li').click(function() {
                        var val = $.trim($(this).find('.getValue').text());
                        var oldContent = $('.status').val();
                        var newContent = oldContent.replace(regex, "");
                        // console.log(val);
                        // console.log(content);
                         console.log(oldContent);
                         console.log(newContent);
                        $('.status').val(newContent + val + ' ');
                        $('.hash-box li').hide();
                        $('.status').focus();

                        $('#count').text(max - content.length);

                    })
                }

            })

        } else {
            $('.hash-box li').hide();
        }
        $('#count').text(max - content.length);
        if (content.length >= max) {
            $('#count').css('color', '#f00');
        } else {
            $('#count').css('color', '#000');
        }
    });

});