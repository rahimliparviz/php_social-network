$(function() {


    $(document).on('click', '.deleteMsg', function() {
            var msg_id= $(this).data('msg')

        $('.message-del-inner').height('100px');

        $(document).on('click', '.cancel', function() {

            $('.message-del-inner').height('0px');
        })


        $(document).on('click', '.delete', function() {


            $.post('http://localhost:8080/twitter/core/ajax/messages.php', { delMsg: msg_id }, function(d) {
                console.log(d)
                $('.message-del-inner').height('0px');
                getMsgs();
            })
        })



    });



    $(document).on('click', '#messagePopup', function() {
        var getMsgs = 1;
        $.post('http://localhost:8080/twitter/core/ajax/messages.php', { showMsg: getMsgs }, function(d) {
            $('.popupTweet').html(d);
        })
    });


    $(document).on('click', '.people-message', function() {
        var getId = $(this).data('user');


        $.post('http://localhost:8080/twitter/core/ajax/messages.php', { showChat: getId }, function(d) {
            console.log(getId)
console.log(d);

            $('.popupTweet').html(d);

            if (autoscroll) {
                scrolldown()
            }

            $('#chat').on('scroll', function() {
                if ($(this).scrollTop() < this.scrollHeight - $(this).height()) {
                    autoscroll = false;
                } else {
                    autoscroll = true;
                }
            })

            $('.close-msgPopup').click(function() {
                clearInterval(timer);
            })


        })

        getMsgs = function() {

            $.post('http://localhost:8080/twitter/core/ajax/messages.php', { showChatMsg: getId }, function(d) {
                $('.main-msg-inner').html(d);

                if (autoscroll) {
                    scrolldown()
                }

                $('#chat').on('scroll', function() {
                    if ($(this).scrollTop() < this.scrollHeight - $(this).height()) {
                        autoscroll = false;
                    } else {
                        autoscroll = true;
                    }
                })

                $('.close-msgPopup').click(function() {
                    clearInterval(timer);
                })
            })
        }
        var timer = setInterval(getMsgs, 1000);

        getMsgs();
        autoscroll = true;

        scrolldown = function() {
            $("#chat").scrollTop($('#chat')[0].scrollHeight);
        }

        $(document).on('click', '.back-messages', function() {
            var getMsgs = 1;
            $.post('http://localhost:8080/twitter/core/ajax/messages.php', { showMsg: getMsgs }, function(d) {
                $('.popupTweet').html(d);
                clearInterval(timer);
            })
        });
    });
});