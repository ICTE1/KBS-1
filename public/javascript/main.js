
$(document).ready(function(){
    console.log('Doc ready!');

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
        alert('Link gekopieerd naar klembord');
        /* Get the text field */
        var copyText = document.getElementById("sharebutton");

        /* Select the text field */
        copyText.select();
        copyText.setSelectionRange(0, 99999); /*For mobile devices*/

        /* Copy the text inside the text field */
        document.execCommand("copy");

        /* Alert the copied text */
        alert("Copied the text: " + copyText.value);
    });





});



