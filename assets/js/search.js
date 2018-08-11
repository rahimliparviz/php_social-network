$(function() {
    $('.search').keyup(function() {
        var search = $(this).val();

        $.post('http://localhost:8080/twitter/core/ajax/search.php', { search: search }, function(d) {

            $('.search-result').html(d);
        });
    })
    
    
    
    $(document).on('keyup','.search-user',function () {
        $('.message-recent').hide();
        var search =$(this).val();


        $.post('http://localhost:8080/twitter/core/ajax/searchUserInMsg.php', { search: search }, function(d) {
            $('.message-body').html(d);

        });
    })
});