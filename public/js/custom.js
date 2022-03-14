$(document).ready(function () {
    if($('select').length){
        $('select').niceSelect();
    }
    $('.slideer').slick({
        dots: true,
        arrows: false
    });

    /*====================================
			Mobile Menu
	======================================*/
    $('.main-category').slicknav({
        prependTo: ".mobile_nav",
        duration: 300,
        animateIn: 'fadeIn',
        animateOut: 'fadeOut',
        closeOnClick: true,
    });


    //click event category menu 
    $('#cat_menu').on('click', function () {
        $(this).toggleClass('active');
        $(this).siblings('.main-category').addClass('visible');
    });

    //click event cart menu 
    $('#cart_menu').on('click', function () {
        $(this).toggleClass('active');
        $(this).siblings('.shopping-item').addClass('visible');
    });

    $('#wishlist_link').on('click', function () {
        $(this).toggleClass('active');
        $(this).siblings('.wishlistings').addClass('visible');
    });

});

$(document).on("click", function (event) {
    var $trigger1 = $("#cat_menu");
    var $trigger2 = $("#cart_menu");
    var $trigger3 = $(".shopping-item");
    var $trigger4 = $("#wishlist_link");
    if ($trigger1 !== event.target && !$trigger1.has(event.target).length) {
        $(".main-category").removeClass("visible");
    }
    if ($trigger2 !== event.target && !$trigger2.has(event.target).length && $trigger3 !== event.target && !$trigger3.has(event.target).length) {
        $(".shopping-item").removeClass("visible");
    }

    if ($trigger4 !== event.target && !$trigger4.has(event.target).length) {
        $(".wishlistings").removeClass("visible");
    }
});
$(document).ready(function () {
    $('.owl-carousel').owlCarousel({
        loop: true,
        margin: 20,
        dots: false,
        nav: true,
        responsiveClass: true,
        responsive: {
            0: {
                items: 2,
                nav: true
            },
            800: {
                items: 3,
                nav: false
            },
            1000: {
                items: 5,
                nav: true,
                loop: false
            }
        }
    });
});