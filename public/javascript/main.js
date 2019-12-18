
$(document).ready(function(){


    $(".fancybox").fancybox({
        openEffect: "none",
        closeEffect: "none"
    });

    $(".zoom").hover(function(){

        $(this).addClass('transition');
    }, function(){

        $(this).removeClass('transition');
    });



    let sharebutton = document.getElementById('sharebutton');

    sharebutton.addEventListener('click',    function   () {
        let url = window.location.href;
        try {
         
        navigator.clipboard.writeText(url).then(function() {
            alert('Link gekopieerd naar klembord')
          }, function() {
            alert('Kan niet naar klembord schrijven. :-(');
          });   
        } catch (error) {
            alert('Kan niet naar klembord schrijven. :-(');
            
        }
    });

});



