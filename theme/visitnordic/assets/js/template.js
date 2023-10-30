import jQuery from 'jquery';

jQuery(document).ready(function ($) {

    $(".dropdown-menu > li > a.trigger").on("click", function (n) {
        var i = $(this).next();
        $(this).parent().parent().find(".dropdown-menu:visible").not(i).hide(), i.toggle(), n.stopPropagation()
    });


    $(".dropdown-menu > li > a:not(.trigger)").on("click",function(){
        $(this).closest(".dropdown").find(".dropdown-menu:visible").hide()
    });

    if($('.luminous').length) new Luminous(document.querySelector('.luminous'));

    var trigger = $("body").find('[data-toggle="modal"]');
    trigger.on("click", function () {
        var t = $(this).data("target"), a = $(this).attr("data-title"), i = $(this).attr("data-video") + "&autoplay=1";
        $(t + " .modal-title").text(a), $(t + " iframe").attr("src", i)
    }), $("#video-modal").on("hidden.bs.modal", function () {
        $("#video-modal .embed-responsive-item").attr("src", "")
    });

    $(".dropdown-menu .nav-tabs").click(function (t) {
        t.preventDefault(), $(".show .list-group-item").removeClass("active"), $($(t.target)).tab("show"), t.stopPropagation()
    });

    $(".navbar-toggler").on("click", function(e) {
        $("#navbar-toggle").find(".caret").removeClass("caretup");
    });
    $(".nav-link.trigger").on("click", function(e){
        $(this).find(".caret").toggleClass("caretup");
        $(this).parent().parent().find('.nav-link.trigger').not(this).find(".caret").removeClass("caretup");
    });


    $( ".navbar-toggler-search" ).click(function() {
        $( "#geek-search-180 img" ).click();
    });

    $('.slick').slick({
        autoplay: true,
        autoplaySpeed: 8000,
        dots: true,
        infinite: true,
        fade: true,
        cssEase: 'linear',
        dotsClass: 'carousel-indicators',
        prevArrow: '.carousel-control-prev',
        nextArrow: '.carousel-control-next',
        asNavFor: ($('.slick-nav').length ? '.slick-nav' : false),
        adaptiveHeight: true,
        lazyLoad: 'progressive'
    });

    if ($('.slick-nav').length) {
        $('.slick-nav').slick({
            slidesToShow: 4,
            slidesToScroll: 1,
            asNavFor: '.slick',
            dots: false,
            focusOnSelect: true,
            lazyLoad: 'progressive'
        });
    }

    var offset = 300,
        offset_opacity = 1200,
        scroll_top_duration = 700,
        $back_to_top = $('.cd-top');

    $(window).scroll(function () {
        ( $(this).scrollTop() > offset ) ? $back_to_top.addClass('cd-is-visible') : $back_to_top.removeClass('cd-is-visible cd-fade-out');
        if ($(this).scrollTop() > offset_opacity) {
            $back_to_top.addClass('cd-fade-out');
        }
    });

    $back_to_top.on('click', function (event) {
        event.preventDefault();
        $('body,html').animate({
                scrollTop: 0,
            }, scroll_top_duration
        );
    });

    $(".btn-readmore").each(function (e, n) {
        $(this).on("click", function (e) {
            e.preventDefault(), $(this).parent().find(".readon").slideToggle(), $(this).parent(".readmore").toggleClass("open")
        })
    }), $(".btn-more").each(function (e, n) {
        $(this).on("click", function (e) {
            e.preventDefault();
            var n = $(this).data("count"), t = $(this).parent().find(".readon").length;
            $(this).parent().find(".readon").each(function (e) {
                e <= n - 1 && $(this).slideToggle().removeClass("readon")
            }), t <= n && $(this).fadeOut()
        })
    });

    function setMap(a) {
        resetMap(), $("#nordicmap .map").addClass(a)
    }

    function resetMap() {
        $("#nordicmap .map").removeClass().addClass("map")
    }

    $("#nordicmap") && ($(".mapswitch").hover(function () {
        setMap($(this).data("lang"))
    }, function () {
        resetMap()
    }), $("#nordicmap area").each(function () {
        $(this).hover(function () {
            setMap($(this).attr("id").replace("map-", ""))
        }, function () {
            resetMap()
        }), $(this).click(function (a) {
            a.preventDefault();
            var t = $(this).attr("id").replace("map-", ""), e = $(".mapswitch." + t);
            e && (document.location.href = e.attr("href"))
        })
    }));

    $( ".card-inverse img" ).each(function( index, el ) {
        getImageLightness($( this ).attr('src'), function(brightness){
            $(el).parent().find('.cover').css('background-color', 'rgba(0,0,0,' + (parseInt(brightness)/255) / 4 + ')');
        });
    });
});

function getImageLightness(imageSrc,callback) {
    var img = document.createElement("img");
    img.src = imageSrc;
    img.style.display = "none";
    document.body.appendChild(img);

    var colorSum = 0;

    img.onload = function() {
        // create canvas
        var canvas = document.createElement("canvas");
        canvas.width = this.width;
        canvas.height = this.height;

        var ctx = canvas.getContext("2d");
        ctx.drawImage(this,0,0);

        var imageData = ctx.getImageData(0,0,canvas.width,canvas.height);
        var data = imageData.data;
        var r,g,b,avg;

        for(var x = 0, len = data.length; x < len; x+=4) {
            r = data[x];
            g = data[x+1];
            b = data[x+2];

            avg = Math.floor((r+g+b)/3);
            colorSum += avg;
        }

        var brightness = Math.floor(colorSum / (this.width*this.height));
        callback(brightness);
    }
}