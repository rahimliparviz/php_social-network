$(function() {

   var win =$(window);
   var offset =10;
   var docH=$(document).height();


   win.on('scroll',(function () {
       var scrollH=win.height() +  win.scrollTop();
       //console.log(docH);
       //console.log(scrollH);
       if( docH <= scrollH){
           //console.log(docH);
           //console.log(scrollH);
        offset+=10;
        $('#loader').show();
           $.post('http://localhost:8080/twitter/core/ajax/fetchPosts.php', {fetchPosts: offset}, function (d) {


               $('.tweets').html(d);
               $('#loader').hide();
           })

       }
   }))






});