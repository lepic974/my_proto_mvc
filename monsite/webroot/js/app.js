


/* JQUERY TEST  */

jQuery(document).ready(function () {




    $("#header_icon").click(function (e) {
        e.preventDefault();
        $('body').toggleClass('with-sidebar');
    })

    $('#site-cache').click(function (e) {
        $('body').removeClass('with-sidebar');
    })

    var duration = 500;
    jQuery(window).scroll(function () {
        if (jQuery(this).scrollTop() > 100) {
            // Si un défillement de 100 pixels ou plus.
            // Ajoute le bouton
            jQuery('.cRetour').fadeIn(duration);
        } else {
            // Sinon enlève le bouton
            jQuery('.cRetour').fadeOut(duration);
        }
    });

    jQuery('.cRetour').click(function (event) {
        // Un clic provoque le retour en haut animé.
        event.preventDefault();
        jQuery('html, body').animate({ scrollTop: 0 }, duration);
        return false;
    })

        /* Carrousel */
    setInterval(function(){  
        $(".slideshow ul li:first-child").animate({"margin-left": -350}, 800, function(){  
            $(this).css("margin-left",0).appendTo(".slideshow ul");  
        });  
      }, 3500);  
       /* Fenetre flotante Action  */
       $(".imageZoom").imageZoom();
});

