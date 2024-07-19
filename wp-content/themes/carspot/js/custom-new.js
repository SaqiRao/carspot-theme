(function ($) {
    "use strict";
    /*---------------------
        range slider
    ---------------------*/
    /*---------------------
     ion-range slider
    ---------------------*/
    $(document).ready(function () {
        $(".js-range-slider").ionRangeSlider();
    });
    /*---------------------
     ion-range counter number
    ---------------------*/
    $(".js-range-slider").ionRangeSlider({
        type: "double",
        grid: true,
        min: 0,
        max: 10000,
        from: 500,
        to: 2000,
        step: 10,
        prefix: '$'
    });
    /*---------------------
     banner-carosel js
    ---------------------*/
    $('.banner-carousel').owlCarousel({
        loop: true,
        margin: 10,
        nav: true,
        autoplay: true,
        slideSpeed: 500,
        animateOut: 'fadeOut',
        animateIn: 'fadeIn',
        paginationSpeed: 500,
        autoplayTimeout: 5000,
        autoplayHoverPause: true,
        dots: false,
        responsive: {
            0: {
                items: 1
            },
            768: {
                items: 1
            },
            1000: {
                items: 1
            }
        }
    })
    /*---------------------
     car-type-owl js
    ---------------------*/
// $('.car-type-owl').owlCarousel({
//     loop:true,
//     margin:10,
//     nav:true,
//     autoplay: true,
//     slideSpeed: 500,
//     paginationSpeed: 500,
//     responsiveClass: true,
//     rtl: false,
//     autoplayTimeout: 5000,
//     autoplayHoverPause: true,
//     dots: false,
//     responsive:{
//         0:{
//             items:1
//         },
//         576:{
//             items:3
//         },
//         768:{
//             items:4
//         },
//         992:{
//             items:3
//         },
//         1200:{
//             items:4
//         }
//     }
// });
//     $('.car-brand-owl').owlCarousel({
//         loop:true,
//         margin:10,
//         nav:true,
//         autoplay: true,
//         slideSpeed: 500,
//         rtl: false,
//         responsiveClass: true,
//         paginationSpeed: 500,
//         autoplayTimeout: 5000,
//         autoplayHoverPause: true,
//         dots: false,
//         responsive:{
//             0:{
//                 items:1
//             },
//             576:{
//                 items:3
//             },
//             768:{
//                 items:4
//             },
//             992:{
//                 items:3
//             },
//             1200:{
//                 items:4
//             }
//         }
//     })
    /*---------------------
     featured-cars-owl js
    ---------------------*/
    $('.featured-cars-owl').owlCarousel({
        loop: true,
        margin: 10,
        nav: true,
        autoplay: true,
        slideSpeed: 500,
        paginationSpeed: 500,
        autoplayTimeout: 5000,
        autoplayHoverPause: true,
        dots: false,
        responsive: {
            0: {
                items: 1
            },
            576: {
                items: 2
            },
            768: {
                items: 3
            },
            992: {
                items: 4
            }
        }
    });
    /*---------------------
     explore-city-carousel js
    ---------------------*/
    $('.explore-city-carousel').owlCarousel({
        loop: true,
        margin: 10,
        nav: true,
        autoplay: true,
        slideSpeed: 500,
        paginationSpeed: 500,
        autoplayTimeout: 5000,
        autoplayHoverPause: true,
        dots: false,
        responsive: {
            0: {
                items: 1
            },
            576: {
                items: 2
            },
            768: {
                items: 3
            },
            1000: {
                items: 3
            }
        }
    })

    /*---------------------
     comparison-owl js
    ---------------------*/
    $('.comparison-owl').owlCarousel({
        loop: true,
        margin: 10,
        nav: true,
        autoplay: true,
        slideSpeed: 500,
        paginationSpeed: 500,
        autoplayTimeout: 5000,
        autoplayHoverPause: true,
        dots: false,
        responsive: {
            0: {
                items: 1
            },
            768: {
                items: 1
            },
            1000: {
                items: 2
            }
        }
    })
    /*---------------------
     cars-dtl-carousel js
    ---------------------*/
    $('.cars-dtl-carousel').owlCarousel({
        loop: true,
        animateOut: 'fadeOut',
        animateIn: 'fadeIn',
        nav: true,
        dots: false,
        margin: 0,
        center: true,
        rtl: true,
        smartSpeed: 1000,
        navText: ["<i class='la la-angle-left'></i>", "<i class='la la-angle-right'></i>"],
        responsive: {
            0: {
                items: 1
            },
            768: {
                items: 1
            },
            1000: {
                items: 1
            }
        }
    })
    /*---------------------
     Select-2 selector
    ---------------------*/
    $(document).ready(function () {
        $('.js-example-basic-single').select2();
    });
    /*---------------------
     Filter js
    ---------------------*/
    $(document).ready(function () {
        $('.filter-switcher .filter-btn').click(function () {
            var elem = $('.toggle-list-items');
            if (elem.hasClass('col-xl-3')) {
                elem.removeClass('col-xl-3');
                elem.addClass('col-xl-4');
            }
            if (elem.hasClass('col-lg-3')) {
                elem.removeClass('col-lg-3');
                elem.addClass('col-lg-4');
            }
            $(".carspot-search-filter .filter-switcher .left-cont").css({
                "display": "none",
                "transition": "0.5s ease-in-out"
            });
            $(".carspot-search-filter .filter-switcher .right-cont").css({
                "width": "calc(100% - 333px)",
                "float": "right",
                "transition": "0.5s ease-in-out"
            });
            $(".carspot-search-filter .side-bar-used-cars-list .used-cars-grid-list").css({
                "width": "calc(100% - 333px)",
                "padding-left": "20px",
                "margin-top": "20px",
                "transition": "0.5s ease-in-out"
            });
            $(".carspot-search-filter .side-bar").css({
                "display": "block",
                "width": "333px",
                "opacity": "1",
                "margin-top": "-113px",
                "transition": "0.5s ease-in-out"
            });
            $(".carspot-search-filter .side-bar-used-cars-list").css({
                "margin-top": "0",
                "transition": "0.5s ease-in-out"
            });
            $(".carspot-search-filter .filter-switcher").css({
                "justify-content": "flex-end",
                "margin-left": "20px",
                "transition": "0.5s ease-in-out"
            });
        });
        $('.carspot-search-filter .filter-reverse-btn').click(function () {
            var elem = $('.toggle-list-items');
            if (elem.hasClass('col-xl-4')) {
                elem.removeClass('col-xl-4');
                elem.addClass('col-xl-3');
            }
            if (elem.hasClass('col-lg-4')) {
                elem.removeClass('col-lg-4');
                elem.addClass('col-lg-3');
            }
            $(".carspot-search-filter .filter-switcher .left-cont").css({
                "display": "block",
                "transition": "0.5s ease-in-out"
            });
            $(".carspot-search-filter .side-bar").css({
                "display": "none",
                "opacity": "0",
                "width": "0px",
                "margin-top": "0px",
                "transition": "0.5s ease-in-out"
            });
            $(".carspot-search-filter .filter-switcher .right-cont").css({
                "width": "calc(100% - 0px)",
                "float": "right",
                "transition": "0.5s ease-in-out"
            });
            $(".carspot-search-filter .side-bar-used-cars-list .used-cars-grid-list").css({
                "width": "calc(100% - 0px)",
                "padding-left": "0px",
                "margin-top": "0px",
                "transition": "0.5s ease-in-out"
            });
            $(".carspot-search-filter .filter-switcher").css({
                "justify-content": "space-between",
                "margin-left": "0px",
                "transition": "0.5s ease-in-out"
            });
            $(".carspot-search-filter .side-bar-used-cars-list").css({
                "margin-top": "30px",
                "transition": "0.5s ease-in-out"
            });
        });
        if ($(window).width() < 1200) {
            $('.filter-switcher .filter-btn').on('click', function () {
                $(".carspot-search-filter .filter-switcher .right-cont").css({
                    "width": "calc(100% - 233px)",
                    "float": "right",
                    "transition": "0.5s ease-in-out"
                });
                $(".carspot-search-filter .side-bar-used-cars-list .used-cars-grid-list").css({
                    "width": "calc(100% - 233px)",
                    "padding-left": "20px",
                    "margin-top": "20px",
                    "transition": "0.5s ease-in-out"
                });
            });
            $('.carspot-search-filter .filter-reverse-btn').click(function () {
                $(".carspot-search-filter .filter-switcher .right-cont").css({
                    "width": "calc(100% - 0px)",
                    "float": "right",
                    "transition": "0.5s ease-in-out"
                });
                $(".carspot-search-filter .side-bar-used-cars-list .used-cars-grid-list").css({
                    "width": "calc(100% - 0px)",
                    "padding-left": "0px",
                    "margin-top": "0px",
                    "transition": "0.5s ease-in-out"
                });
            });

        }
        if ($(window).width() < 992) {
            $('.filter-switcher .filter-btn').on('click', function () {
                $(".carspot-search-filter .filter-switcher .right-cont").css({
                    "width": "100%",
                    "float": "right",
                    "margin-left": "0",
                    "transition": "0.5s ease-in-out"
                });
                $(".carspot-search-filter .side-bar").css({
                    "width": "100%",
                    "display": "block",
                    "margin-top": "30px",
                    "border-right": "none",
                    "transition": "0.5s ease-in-out"
                });
                $(".carspot-search-filter .side-bar-used-cars-list .used-cars-grid-list").css({
                    "width": "100%",
                    "padding-left": "0px",
                    "margin-top": "20px",
                    "transition": "0.5s ease-in-out"
                });
                $(".carspot-search-filter .filter-switcher").css({
                    "justify-content": "flex-end",
                    "margin-left": "0px",
                    "transition": "0.5s ease-in-out"
                });
            });
            $('.carspot-search-filter .filter-reverse-btn').on('click', function () {
                $(".carspot-search-filter .filter-switcher .right-cont").css({
                    "width": "calc(100% - 100px)",
                    "float": "right",
                    "margin-left": "20px",
                    "transition": "0.5s ease-in-out"
                });
                $(".carspot-search-filter .side-bar").css({
                    "display": "none",
                    "margin-top": "0px",
                    "border-right": "none",
                    "transition": "0.5s ease-in-out"
                });
                $(".carspot-search-filter .side-bar-used-cars-list .used-cars-grid-list").css({
                    "width": "100%",
                    "padding-left": "0px",
                    "margin-top": "0px",
                    "transition": "0.5s ease-in-out"
                });
                $(".carspot-search-filter .filter-switcher").css({
                    "justify-content": "flex-end",
                    "margin-left": "0px",
                    "transition": "0.5s ease-in-out"
                });
            })
        }
        if ($(window).width() < 480) {
            $('.filter-switcher .filter-btn').on('click', function () {
                $(".carspot-search-filter .filter-switcher .right-cont").css({
                    "width": "100%",
                    "float": "right",
                    "margin-left": "0",
                    "transition": "0.5s ease-in-out"
                });
            });
            $('.carspot-search-filter .filter-reverse-btn').on('click', function () {
                $(".carspot-search-filter .filter-switcher .right-cont").css({
                    "width": "100%",
                    "float": "right",
                    "margin-left": "0",
                    "transition": "0.5s ease-in-out"
                });
            });
        }
    });

    /*
    * Slider in tab for new home page
    * 30/9/2021
    */
    $(document).ready(function ($) {
        initialize_owl($('#owl1'));
        let tabs = [
            {target: '#abrand', owl: '#owl1'},
            {target: '#btype', owl: '#owl2'},
        ];
        // Setup 'bs.tab' event listeners for each tab
        tabs.forEach((tab) => {
            $(`a[href="${tab.target}"]`)
                .on('shown.bs.tab', () => initialize_owl($(tab.owl)))
        });
    });

    function initialize_owl(el) {
        el.owlCarousel({
            loop: true,
            margin: 10,
            nav: true,
            autoplay: true,
            slideSpeed: 500,
            paginationSpeed: 500,
            responsiveClass: true,
            autoplayTimeout: 5000,
            autoplayHoverPause: true,
            dots: false,
            responsive: {
                0: {
                    items: 1
                },
                576: {
                    items: 3
                },
                768: {
                    items: 4
                },
                992: {
                    items: 3
                },
                1200: {
                    items: 4
                }
            }
        });
    }


})(jQuery);

