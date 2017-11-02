jQuery(document).ready(function ($) {

    /* Simples Parallax from Tableless */
    $('div.bg-parallax').each(function () {
        var $obj = $(this);
        var offset = $obj.offset();
    });

    /* HOMEPAGE */
    /* WEBDOOR Mobile Nav */    
    $('.carousel-inner').on('swipeleft', function() {
        $('#myCarousel a.right').click();
    });

    $('.carousel-inner').on('swiperight', function() {
        $('#myCarousel a.left').click();    
    });


    /* HOMEPAGE */
    /* MENSAGENS INSPIRADORAS - Carousel */
    $('#mensagens-carousel').carousel({
          interval: 15000,
          pause: 'hover'
    });

    // remove a mensg loading do final da pagina (jquery mobile)
    if ($.mobile !== undefined) {
        $.mobile.loading( 'show', { theme: "b", text: "", textonly: false});
    }

    // rolagem suave quando usar #anchors NAVBAR
    $('.navbar a[href*=#]:not([href=#])').click(function() {
        if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
          var target = $(this.hash);
          target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
          if (target.length) {
            $('html,body').animate({
              scrollTop: target.offset().top
            }, 1000);
            return false;
          }
        }
    });

    /**
     GALERIA DE IMAGENS, configuração 
     **************************************/
    $('.popup-image').magnificPopup({ 
        type: 'image',
        mainClass: 'mfp-with-zoom',
        zoom: {
            enabled: true,
            duration: 300, 
            easing: 'ease-in-out'
            
          },
        gallery:{
            enabled:true
        }
    }); 
      
    $('.popup-youtube, .popup-vimeo, .popup-gmaps').magnificPopup({
      disableOn: 700,
      type: 'iframe',
      mainClass: 'mfp-fade',
      removalDelay: 160,
      preloader: false,

      fixedContentPos: false
    });
      

    /* Marca automaticamente a categoria da página de galerias */
    var cat_id = getParameterByName('term_id');    

    if (cat_id !== "") { 
        $('#category-menu li#cat-' + cat_id).addClass('atual');
    } else {
        $('#category-menu li#cat-todos').addClass('atual');
    }


    $('.post .descricao').slideUp('fast');


    /* Abre Descrição */
    $('.btn_abre_descricao').click(function() {
        $(this).siblings('.descricao').slideToggle('fast');

        $(this).children('i').toggleClass('glyphicon-chevron-down');
        $(this).children('i').toggleClass('glyphicon-chevron-up');

        if ( $(this).children('i').hasClass('glyphicon-chevron-up') ) {
            $(this).css('padding-top', '2px');
        } else {
            $(this).css('padding-top', '5px');
        }
    });

    /* INICIALIZA - fecha todas as descrições */
    $('#page-radio .entry .descricao').slideUp('fast', function() {
        $(this).children('.btn_abre_descricao').css('padding-top', '2px');
    });


    /* WIDGET SIDEBAR */
    $('.widget_search input[type=text]').attr('placeholder', 'Digite e pressione [ENTER] para pesquisar');


});


function getParameterByName(name) 
{
    name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
    var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
        results = regex.exec(location.search);
    return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
}