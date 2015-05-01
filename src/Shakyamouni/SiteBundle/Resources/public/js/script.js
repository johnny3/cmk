$(document).ready(function() {
    if($('#carrousel .slides').length>0)
    {
        $('#carrousel .slides').slides({
            play : 6000,
            preload: true,
            preloadImage : '../bundles/shakyamounisite/images/blank.gif',
            effect: 'fade, fade',
            crossfade: true,
            hoverPause : true,
            slideSpeed: 350,
            fadeSpeed: 1500,
            generateNextPrev: false,
            generatePagination: true
        });
    };
    
    $('a.zoombox').zoombox({
        theme       : 'zoombox',        //available themes : zoombox,lightbox, prettyphoto, darkprettyphoto, simple
        opacity     : 0.8,              // Black overlay opacity
        duration    : 800,              // Animation duration
        animation   : true,             // Do we have to animate the box ?
        width       : 600,              // Default width
        height      : 400,              // Default height
        gallery     : true,             // Allow gallery thumb view
        autoplay : false                // Autoplay for video
    });
    
    $('.Question').hide();
    
    $('a[href*="#"]').click(function(){
        var href = $(this).attr("href").split("#");
        var offset = $('#'+href[1]).offset().top
        $('html, body').animate({
            scrollTop: offset
        }, 1500);
        return false;
    });
});


function doSectionHit(slug)
{
    if($('#savoir-plus-'+slug).attr('class') != 'Response body-text')
    {
        $('.Response').each(function(){
            id = '#'+$(this).attr('id');
            $(id).attr('class','Question body-text');
            $(id).slideUp();
            $(id).parent().find('.button2 span:first').html('En savoir plus...');    
        });
        $('#savoir-plus-'+slug).attr('class','Response body-text');
        $('#savoir-plus-'+slug).slideToggle();
        $('#savoir-plus-'+slug).parent().find('.button2 span:first').html('Fermer');
    }else
    {
        $('#savoir-plus-'+slug).attr('class','Question body-text');
        $('#savoir-plus-'+slug).slideUp();
        $('#savoir-plus-'+slug).parent().find('.button2 span:first').html('En savoir plus...');
    }
}

function isValidEmail(email){
    if (email.length == 0){
        return false;
    }
    else if (email.length > 0 && email.match(/^[\w.-]+@[\w.-]+\.[a-zA-Z]{2,6}$/)){
        return true;
    }
    else {
        return false;
    }
}

function msgValidEmail(email){
    var msg = '';
    
    if (email.length == 0){
        msg = 'Email obligatoire';
    }
    else if (email.length > 0 && email.match(/^[\w.-]+@[\w.-]+\.[a-zA-Z]{2,6}$/)){
        msg = '';
    }
    else {
        msg = 'Email non conforme';
    }
    
    return msg;
}
