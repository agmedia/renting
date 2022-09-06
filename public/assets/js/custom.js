(function($) {

    'use strict'

    //Cache jQuery Selector
    var $window = $(window),
        $header = $('#header'),
        $navigation = $('#navbarSupportedContent'),
        $featureProperty = $('.carousel-main'),
        $sidebarFeatured = $('.featured-property'),
        $partners = $('.partners'),
        $recentReviews = $('.recent-review'),
        $dropdown = $('.dropdown-toggle'), // 13. Our Partner Logos Slider Auto
        $contact = $('#contact-form');

    function handlePreloader() {
        if ($('.page-loader').length) {
            $('.page-loader').delay(500).fadeOut(500);
            $('body').removeClass('page-load');
        }
    }



    //Scroll top by clicking arrow up
    $window.scroll(function() {
        if ($(this).scrollTop() > 500) {
            $('#scroll').fadeIn();
        } else {
            $('#scroll').fadeOut();
        }
    });
    $('#scroll').click(function() {
        $("html, body").animate({
            scrollTop: 0
        }, 1000);
        return !1;
    });

    // Update Header Style + Scroll to Top
    function headerStyle() {
        if ($header.length) {
            var windowpos = $window.scrollTop();
            if (windowpos >= 200) {
                $header.addClass('fixed-top');
            } else {
                $header.removeClass('fixed-top');
            }
        }
    }

    // Scroll trgeted ID specially for One Page nav target scrolling
    $('.one-page-nav a[href*="#"]')
        .not('.one-page-nav [href="#"]')
        .not('.one-page-nav [href="#0"]')
        .click(function(event) {

            if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') && location.hostname == this.hostname) {
                var target = $(this.hash);
                target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
                if (target.length) {
                    event.preventDefault();
                    $('html, body').animate({
                        scrollTop: target.offset().top
                    }, 1000, function() {
                        var $target = $(target);
                        $target.focus();
                        if ($target.is(":focus")) { // Checking if the target was focused
                            return false;
                        } else {
                            $target.attr('tabindex', '-1'); // Adding tabindex for elements not focusable
                            $target.focus(); // Set focus again
                        };
                    });
                }
            }
        });

    $('.dropdown.hover-dropdown').hover(function() {
        $(this).find('.dropdown-menu').stop(true, true).delay(200).fadeIn(300);
    }, function() {
        $(this).find('.dropdown-menu').stop(true, true).delay(200).fadeOut(300);
    });

    // dropdown submenu on hover in desktopand dropdown sub menu on click in mobile 
    $navigation.each(function() {
        $dropdown.on('click', function(e) {
            if ($window.width() < 1100) {
                if ($(this).parent('.dropdown').hasClass('visible')) {
                    //  $(this).parent('.dropdown').children('.dropdown-menu').first().stop(true, true).slideUp(300);
                    //  $(this).parent('.dropdown').removeClass('visible');
                    window.location = $(this).attr('href');
                } else {
                    e.preventDefault();
                    $(this).parent('.dropdown').siblings('.dropdown').children('.dropdown-menu').slideUp(300);
                    $(this).parent('.dropdown').siblings('.dropdown').removeClass('visible');
                    $(this).parent('.dropdown').children('.dropdown-menu').slideDown(300);
                    $(this).parent('.dropdown').addClass('visible');
                }
                e.stopPropagation();
            }
        });

        $('body').on('click', function(e) {
            $dropdown.parent('.dropdown').removeClass('visible');
        });

        $window.on('resize', function() {
            if ($window.width() > 991) {
                $('.dropdown-menu').removeAttr('style');
                $('.dropdown ').removeClass('visible');
            }
        });
    });


    // Auto active class adding with navigation
    $window.on('load', function() {
        var current = location.pathname;
        var $path = current.substring(current.lastIndexOf('/') + 1);
        $('.navbar-nav a').each(function(e) {
            var $this = $(this);
            // if the current path is like this link, make it active
            if ($path == $this.attr('href')) {
                $this.addClass('active');
            } else if ($path == '') {
                $('.navbar-nav li:first-child > a').addClass('active');
            }
        })
    })

    $('<div class="quantity-nav"><div class="quantity-button quantity-up">+</div><div class="quantity-button quantity-down">-</div></div>').insertAfter('.quantity input');
    $('.quantity').each(function() {
        var spinner = $(this),
            input = spinner.find('input[type="number"]'),
            btnUp = spinner.find('.quantity-up'),
            btnDown = spinner.find('.quantity-down'),
            min = input.attr('min'),
            max = input.attr('max');

        btnUp.click(function() {
            var oldValue = parseFloat(input.val());
            if (oldValue >= max) {
                var newVal = oldValue;
            } else {
                var newVal = oldValue + 1;
            }
            spinner.find("input").val(newVal);
            spinner.find("input").trigger("change");
        });

        btnDown.click(function() {
            var oldValue = parseFloat(input.val());
            if (oldValue <= min) {
                var newVal = oldValue;
            } else {
                var newVal = oldValue - 1;
            }
            spinner.find("input").val(newVal);
            spinner.find("input").trigger("change");
        });

    });




    // Fact Counter For Achivement Counting
    function factCounter() {
        if ($('.fact-counter').length) {
            $('.fact-counter .count.animated').each(function() {

                var $t = $(this),
                    n = $t.find(".count-num").attr("data-stop"),
                    r = parseInt($t.find(".count-num").attr("data-speed"), 10);

                if (!$t.hasClass("counted")) {
                    $t.addClass("counted");
                    $({
                        countNum: $t.find(".count-text").text()
                    }).animate({
                        countNum: n
                    }, {
                        duration: r,
                        easing: "linear",
                        step: function() {
                            $t.find(".count-num").text(Math.floor(this.countNum));
                        },
                        complete: function() {
                            $t.find(".count-num").text(this.countNum);
                        }
                    });
                }

                //set skill building height
                var size = $(this).children('.progress-bar').attr('aria-valuenow');
                $(this).children('.progress-bar').css('width', size + '%');


            });
        }
    }


    // Elements Animation
    if ($('.wow').length) {
        var wow = new WOW({
            boxClass: 'wow', // animated element css class (default is wow)
            animateClass: 'animated', // animation css class (default is animated)
            offset: 0, // distance to the element when triggering the animation (default is 0)
            mobile: true, // trigger animations on mobile devices (default is true)
            live: true // act on asynchronously loaded content (default is true)
        });
        wow.init();
    }


    // When document is Scrollig, do
    $window.on('scroll', function() {
        factCounter();
        headerStyle();
    });







    //Put slider space for nav not in mini screen
    if (document.querySelector('.nav-on-top') !== null) {
        var get_height = jQuery('.nav-on-top').height();
        if (get_height > 0 && $window.width() > 991) {
            jQuery('.nav-on-top').next().css('margin-top', get_height);
        }
        $window.on('resize', function() {
            if ($window.width() < 991) {
                jQuery('.nav-on-top').next().css('margin-top', '0');
            } else {
                jQuery('.nav-on-top').next().css('margin-top', get_height);
            }
        });
    }
    if (document.querySelector('.nav-on-banner') !== null) {
        var get_height = jQuery('.nav-on-banner').height();
        if (get_height > 0 && $window.width() > 991) {
            jQuery('.page-banner').css('padding-top', get_height);
        }
        $window.on('resize', function() {
            if ($window.width() < 991) {
                jQuery('.page-banner').css('padding-top', '0');
            } else {
                jQuery('.page-banner').css('padding-top', get_height);
            }
        });
    }

    // 27. Contact Form Validation
    if ($contact.length) {
        $contact.validate({ //#contact-form contact form id
            rules: {
                name: {
                    required: true // Field name here
                },
                email: {
                    required: true, // Field name here
                    email: true
                },
                subject: {
                    required: true
                },
                message: {
                    required: true
                }
            },

            messages: {
                name: "Please enter your Name", //Write here your error message that you want to show in contact form
                email: "Please enter valid Email", //Write here your error message that you want to show in contact form
                subject: "Please enter your Subject", //Write here your error message that you want to show in contact form
                message: "Please write your Message" //Write here your error message that you want to show in contact form
            },

            submitHandler: function(form) {
                $('#send').attr({ 'disabled': 'true', 'value': 'Sending...' });
                $.ajax({
                    type: "POST",
                    url: "email.php",
                    data: $(form).serialize(),
                    success: function() {
                        $('#send').removeAttr('disabled').attr('value', 'Send');
                        $("#success").slideDown("slow");
                        setTimeout(function() {
                            $("#success").slideUp("slow");
                        }, 5000);
                        form.reset();
                    },
                    error: function() {
                        $('#send').removeAttr('disabled').attr('value', 'Send');
                        $("#error").slideDown("slow");
                        setTimeout(function() {
                            $("#error").slideUp("slow");
                        }, 5000);
                    }
                });
                return false; // required to block normal submit since you used ajax
            }

        });
    }










    //  Panel Massage
    var close = document.getElementsByClassName("closebtn");
    var i;
    for (i = 0; i < close.length; i++) {
        close[i].onclick = function() {
            var div = this.parentElement;
            div.style.opacity = "0";
            setTimeout(function() { div.style.display = "none"; }, 600);
        }
    }

    // Dashboard navigation collapse
    if (document.querySelector('.collaps-dashboard') !== null) {
        $('.collaps-dashboard').on('click', function() {
            $('.dashboard-sidebar').toggleClass('active');
            $('.dashboard-sidebar').slideToggle();
        });
    }

    //  Chart Dashboard
    if (document.querySelector('#mychart') !== null) {
        var canvas = document.getElementById("mychart");
        var ctx = canvas.getContext('2d');

        // Data with datasets options
        var data = {
            type: 'bar',
            labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
            datasets: [{
                label: 'Growth',
                fill: true,
                backgroundColor: "#def7e0",
                borderColor: "#17c788",
                data: [0, 150, 450, 400, 480, 630, 580, 500, 530, 400, 430, 600, 400],
            }]
        }

        // Chart declaration with some options:
        var mychart = new Chart(ctx, {
            type: 'line',
            data: data,
        });
    }

    // Cal function after window load
    $window.on('load', function() {
        handlePreloader();
    });


    // 8. Event time counter settings
    $('[data-countdown]').each(function() {
        var $this = $(this),
            finalDate = $(this).data('countdown');

        $this.countdown(finalDate, function(event) {
            $this.html(event.strftime('<span>%D<br><i>Days</i></span> <span>%H<br><i>Hour</i></span> <span>%M<br><i>Min</i></span> <span>%S<br><i>Sec</i></span>'));
        });
    });



    // Color and Layout Settings
    $('.color-panel').each(function() {
        $('.on-panel').on('click', function() {
            $('.color-panel').toggleClass('open');
        });

        $('.color-box li').on('click', function() {
            $('.color-box li').removeClass('active');
            $(this).addClass('active');
            var path = $(this).data('path');
            var logo1 = $(this).data('image');
            var logo2 = $(this).data('target');
            $('#color-change').attr('href', path);
            $('.nav-logo').attr('src', logo1);
            $('.logo-bottom').attr('src', logo2);
        });

        // Template color change
        $(".color-box li").each(function() {
            if ($.cookie('homex_color') && $.cookie('homex_color') == $(this).attr('class')) {
                $(this).addClass('active');
                var path = $(this).data('path');
                var logo1 = $(this).data('image');
                var logo2 = $(this).data('target');
                $('#color-change').attr('href', path);
                $('.nav-logo').attr('src', logo1);
                $('.logo-bottom').attr('src', logo2);
            }
        });

        $(".color-box li").on('click', function() {
            var file_name = $(this).attr('data-name');
            $.cookie('homex_color', file_name, { path: '/', expires: 365 });
        });

        // Layout select with slide button
        $("#layout_type").each(function() {
            var name = $(this).attr('name');
            if ($.cookie(name) && $.cookie(name) == "boxLayout") {
                $(this).prop('checked', true);
                $('#page-wrapper').addClass('box-layout');
            }
        });

        $("#layout_type").change(function() {
            var name = $(this).attr('name');
            if ($(this).prop('checked')) {
                $.cookie(name, 'boxLayout', { path: '/', expires: 365 });
            } else {
                $.cookie(name, '', { path: '/', expires: 365 });
            }
        });

        $('#layout_type').on('click', function() {
            if ($(this).is(':checked')) {
                $('#page-wrapper').addClass('box-layout');
                location.reload();
            } else {
                $('#page-wrapper').removeClass('box-layout');
                location.reload();
            }
        });


        // Background select with check
        $(".box_bg_style li input[type='radio']").on('click', function() {
            $('body').removeAttr('class');
            if ($(this).is(':checked')) {
                var class_nm = $(this).attr('value');
                $('body').addClass(class_nm);
            }
            var name = $("#bg_over").attr('name');
            if ($.cookie(name) && $.cookie(name) == "true") {
                $(this).prop('checked', $.cookie(name));
                $('body').addClass('body_overlay');
            }
        });

        $(".box_bg_style li input[type='radio']").each(function() {
            if ($.cookie('bg_layout') && $.cookie('bg_layout') == $(this).attr('value')) {
                $(this).prop('checked', true);
                $('body').addClass($.cookie('bg_layout'));
            }
        });

        $(".box_bg_style li input[type='radio']").change(function() {
            var name = $(this).attr('value');
            if ($(this).prop('checked')) {
                $.cookie('bg_layout', name, { path: '/', expires: 365 });
            }
        });

        // Background Overly settinhs
        $("#bg_over").each(function() {
            var name = $(this).attr('name');
            if ($.cookie(name) && $.cookie(name) == "true") {
                $(this).prop('checked', $.cookie(name));
                $('body').addClass('body_overlay');
            }
        });

        $("#bg_over").change(function() {
            var name = $(this).attr('name');
            $.cookie(name, $(this).prop('checked'), { path: '/', expires: 365 });
        });

        $('#bg_over').on('click', function() {
            if ($(this).is(':checked')) {
                $('body').addClass('body_overlay');
            } else {
                $('body').removeClass('body_overlay');
            }
        });



    });

})(jQuery);