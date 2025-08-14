function goBack() { window.history.back(); }
function maxLengthCheck(object) {
    if (object.value.length > object.maxLength)
        object.value = object.value.slice(0, object.maxLength)
}
function increment_val() {
    var da = $("#qty").val();
    var newQuantity = parseInt(da) + 1;
    $("#qty").val(newQuantity);
}
function decrement_quantity() {
    var da = $("#qty").val();
    var inputQuantityElement = $("#qty");
    if ($(inputQuantityElement).val() > 1) {
        var newQuantity = parseInt(da) - 1;
        $("#qty").val(newQuantity);
    }
}
var topMenu = jQuery(".Rlink"),
    offset = 190,
    topMenuHeight = topMenu.outerHeight() + offset,
    menuItems = topMenu.find('a[href*="#"]'),
    scrollItems = menuItems.map(function () {
        var href = jQuery(this).attr("href"),
            id = href.substring(href.indexOf('#')),
            item = jQuery(id);
        //console.log(item)
        if (item.length) { return item; }
    });

// so we can get a fancy scroll animation
menuItems.click(function (e) {
    var href = jQuery(this).attr("href"),
        id = href.substring(href.indexOf('#'));
    offsetTop = href === "#" ? 0 : jQuery(id).offset().top - topMenuHeight + 3;
    jQuery('html, body').stop().animate({
        scrollTop: offsetTop
    }, 0);
    e.preventDefault();
});
// Bind to scroll
jQuery(window).scroll(function () {
    var fromTop = jQuery(this).scrollTop() + topMenuHeight;
    var cur = scrollItems.map(function () {
        if (jQuery(this).offset().top < fromTop)
            return this;
    });
    cur = cur[cur.length - 1];
    var id = cur && cur.length ? cur[0].id : "";
    // menuItems.parent().removeClass("active");
    menuItems.removeClass("active");
    if (id) {
        // menuItems.parent().end().filter("[href*='#"+id+"']").parent().addClass("active");
        menuItems.parent().end().filter("[href*='#" + id + "']").addClass("active");
    }
});

function counter() {
    var count = setInterval(function () {
        var c = parseInt($(".preloader-counter").text());
        $(".preloader-counter").text((++c).toString());
        if (c == 100) {
            clearInterval(count);
            $(".preloader-counter").addClass("hide");
            $(".preloader").addClass("active");
        }
    }, 40)
} counter();
$(document).ready(function () {
    $(".navbar .dropdown, .Htop .dropdown-menu").click(function (e) {
        e.stopPropagation();
    })
    // Menu active add function
    var url = window.location;
    $('.menu .navbar-nav li a').filter(function () {
        return this.href == url;
    }).parent().addClass('active');
    $('.menu .LastNav .dropdown-menu a').filter(function () {
        return this.href == url;
    }).addClass('active');
    $('.menu .navbar-nav li .dropdown-menu a').filter(function () {
        return this.href == url;
    }).closest('.dropdown').addClass('active');
    $('.offcanvas .offcanvas-body a').filter(function () {
        return this.href == url;
    }).addClass('active').closest('.collapse').addClass('show');
    $('.offcanvas .offcanvas-body .collapse a').filter(function () {
        return this.href == url;
    }).closest('.FilterOp').find('>a').addClass('active').removeClass('collapsed');
    $('.ComInfoLinks a').filter(function(){
        return this.href == url;
    }).addClass('active');
    
    $('.SearchBox .dropdown-menu').find('a').click(function (e) {
        e.preventDefault();
        var param = $(this).attr("href").replace("#", "");
        var concept = $(this).text();
        $('.SearchBox #search_concept').text(concept);
    });

    $('.Loc .SearchBox').on( "keyup", function() {
        val = $(this).val().toLowerCase();
        $(".Loc ul li").each(function () {
            $(this).toggle($(this).text().toLowerCase().includes(val));
        });
    });
    $('.counter-count').each(function () {
        $(this).prop('Counter', 0).animate({
            Counter: $(this).text()
        }, {
            duration: 5000,
            easing: 'swing',
            step: function (now) {
                $(this).text(Math.ceil(now));
            }
        });
    });
    if ($(window).width() > 992) {
        $('.MenuLeft').addClass('show');
        let prev = 0;
        $(window).scroll(function () {
            if ($(this).scrollTop() > 165) {
                $('.navbar.menu').addClass('is-fixed');
                $('#Hsearch').collapse('hide');
            } else {
                $('.navbar.menu').removeClass('is-fixed');
            }
            let scrollTop = $(window).scrollTop();
            $('.navbar.menu').toggleClass('down', scrollTop < prev);
            prev = scrollTop;
            if ($(this).scrollTop() > 500) {
                $('.BackTop').fadeIn();
            } else {
                $('.BackTop').fadeOut();
            }
        });
    };
    if ($(window).width() < 991) {
        $(window).scroll(function () {
            if ($(this).scrollTop() > 80) {
                $('.navbar.menu').addClass('is-fixed');
                $('#Hsearch').collapse('hide');
            } else {
                $('.navbar.menu').removeClass('is-fixed');
            }
            if ($(this).scrollTop() > 200) {
                $('.BackTop').fadeIn();
            } else {
                $('.BackTop').fadeOut();
            }
        });
    };
    if ($(window).width() < 767) {
        $('footer h3[data-bs-toggle="collapse"]').addClass('collapsed');
        $('footer h3[data-bs-toggle="collapse"]~ul.collapse').removeClass('show');
    }
    $('.BackTop').click(function () {
        $('body,html').animate({ scrollTop: 0 }, 1);
        return false;
    });
    $('#lpass-icon').click(function () {
        if ($(this).hasClass('fa-eye')) {
            $(this).removeClass('fa-eye');
            $(this).addClass('fa-eye-slash');
            $('.lpass').attr('type', 'password');
        } else {
            $(this).removeClass('fa-eye-slash');
            $(this).addClass('fa-eye');
            $('.lpass').attr('type', 'text');
        }
    });
    $('#npass-icon').click(function () {
        if ($(this).hasClass('fa-eye')) {
            $(this).removeClass('fa-eye');
            $(this).addClass('fa-eye-slash');
            $('.npass').attr('type', 'password');
        } else {
            $(this).removeClass('fa-eye-slash');
            $(this).addClass('fa-eye');
            $('.npass').attr('type', 'text');
        }
    });
    $('#cpass-icon').click(function () {
        if ($(this).hasClass('fa-eye')) {
            $(this).removeClass('fa-eye');
            $(this).addClass('fa-eye-slash');
            $('.cpass').attr('type', 'password');
        } else {
            $(this).removeClass('fa-eye-slash');
            $(this).addClass('fa-eye');
            $('.cpass').attr('type', 'text');
        }
    });

    // Country Select //
    var conr;
    $('.CountrySelect .dropdown-menu').find('li').click(function (e) {
        e.preventDefault();
        // var concept = $(this).text();
        var conn = $(this).data('code');
        var spa = $(this).data('text');
        var conc = $(this).data('code');
        // $('.CountrySelect #CountryName').text(concept);
        $('.CountrySelect #CountryName').text(conn);
        $('.CountrySelect a .flagicon').removeClass("fi-" + conr).addClass("fi-" + conc);
        $('.CountrySelect #ccode').val(spa);
        conr = conc;
    });
    $('.CurrencySelect .dropdown-menu').find('li').click(function (e) {
        e.preventDefault();
        var curc = $(this).data('code');
        var curt = $(this).data('name');
        $('.CurrencySelect .dropdown-toggle i').text(curc);
        $('.CurrencySelect .dropdown-toggle span').text(curt);
    });
    if ($(window).width() < 991) {
        $("#AccMenuBar").removeClass('d-none');
        $("#AccountMenu").addClass('collapse');
    };
    $('.CountryCode .dropdown-menu').find('li').click(function (e) {
        e.preventDefault();
        var spa = $(this).data('text');
        var conc = $(this).data('code');
        $('.CountryCode #CountryName').text(spa);
        $('.CountryCode .dropdown-toggle>i').show();
        $('.CountryCode .dropdown-toggle>b').hide();
        $('.CountryCode .dropdown-toggle .flagicon').removeClass("fi-" + conr).addClass("fi-" + conc);
        conr = conc;
    });
    $('.countrylist .SearchConCode').on("keyup", function () {
        val = $(this).val().toLowerCase();
        $(".countrylist li").each(function () {
            $(this).toggle($(this).text().toLowerCase().includes(val));
        });
    });
    // Horizontal Scrolling Div //
    $.fn.hScroll = function (amount) {
        amount = amount || 120;
        $(this).bind("DOMMouseScroll mousewheel", function (event) {
            var oEvent = event.originalEvent,
                direction = oEvent.detail ? oEvent.detail * -amount : oEvent.wheelDelta,
                position = $(this).scrollLeft();
            position += direction > 0 ? -amount : amount;
            $(this).scrollLeft(position);
            event.preventDefault();
        })
    };
    $('.carousel-indicators').hScroll(60); // You can pass (optionally) scrolling amount
    // $(window).scroll(function () {
    //     if ($(this).scrollTop() > 50) {
    //         new bootstrap.Dropdown($('.dropdown-toggle.show')).toggle();
    //         new bootstrap.Dropdown($('.dropdown-menu.show')).toggle();
    //     }
    // });
    
    $('#RealLocation').on('click', function(e) {
        e.preventDefault();
        const $target = $(this);
        openCountryDropDownNav($target);
    });
    function openCountryDropDownNav($target){
        const dropdown = bootstrap.Dropdown.getOrCreateInstance($target[0]);
        dropdown.toggle();
        $(document).off('click.closeDropdown');
        setTimeout(() => {
            $(document).on('click.closeDropdown', function (event) {
                if (!$(event.target).closest('.dropdown').length) {
                    dropdown.hide();
                    $(document).off('click.closeDropdown');
                }
            });
        }, 0);
    }
});
jQuery.event.special.touchstart = {
    setup: function (_, ns, handle) {
        this.addEventListener("touchstart", handle, { passive: !ns.includes("noPreventDefault") });
    }
};
jQuery.event.special.touchmove = {
    setup: function (_, ns, handle) {
        this.addEventListener("touchmove", handle, { passive: !ns.includes("noPreventDefault") });
    }
};
jQuery.event.special.wheel = {
    setup: function (_, ns, handle) {
        this.addEventListener("wheel", handle, { passive: true });
    }
};
jQuery.event.special.mousewheel = {
    setup: function (_, ns, handle) {
        this.addEventListener("mousewheel", handle, { passive: true });
    }
};