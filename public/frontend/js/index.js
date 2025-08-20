
const ProCatSlider = () => {
    let ProCat = document.querySelectorAll('.ProCat')
    let prevcat = document.querySelectorAll('.cat-prev')
    let nextcat = document.querySelectorAll('.cat-next')
    let BlogS = document.querySelectorAll('.BlogS')
    let prevBlog = document.querySelectorAll('.Blog-prev')
    let nextBlog = document.querySelectorAll('.Blog-next')
    ProCat.forEach((slider, index) => {
        let result = (slider.children[0].children.length > 1) ? true : false
        const swiper = new Swiper(slider, {
            spaceBetween: 20, slidesPerView: 1,
            navigation: { nextEl: nextcat[index], prevEl: prevcat[index] },
            breakpoints: { '280': { slidesPerView: 1, spaceBetween: 6 }, '360': { slidesPerView: 1.2, spaceBetween: 8 }, '450': { slidesPerView: 1.4, spaceBetween: 12 }, '575': { slidesPerView: 1.6, spaceBetween: 15 }, '768': { slidesPerView: 1.9 }, '992': { slidesPerView: 2.3 }, '1200': { slidesPerView: 2.8 } }
        });
    })
    BlogS.forEach((slider, index) => {
        let result = (slider.children[0].children.length > 1) ? true : false
        const swiper = new Swiper(slider, {
            spaceBetween: 20, slidesPerView: 1,
            navigation: { nextEl: nextBlog[index], prevEl: prevBlog[index] },
            breakpoints: { '280': { slidesPerView: 1.8, spaceBetween: 6 }, '350': { slidesPerView: 2, spaceBetween: 8 }, '450': { slidesPerView: 2, spaceBetween: 12 }, '575': { slidesPerView: 2.5, spaceBetween: 15 }, '768': { slidesPerView: 3 }, '992': { slidesPerView: 3.5 }, '1200': { slidesPerView: 4 } }
        });
    })
}
window.addEventListener('load', ProCatSlider);
const Testis = new Swiper(".Testis", {
    spaceBetween: 50, centeredSlides: true, loop: true,
    autoplay: { delay: 3000 },
    pagination: { el: ".swiper-pagination", dynamicBullets: true, clickable: true, },
    // navigation:{nextEl:".swiper-button-next",prevEl:".swiper-button-prev"},
});
window.addEventListener('load', function () {
    new Masonry('.ProList', {
        itemSelector: '.ProList-item',
        gutter: 0,
        percentPosition: true
    });
});
// const myVideo = document.getElementById('myVideo');
// const videoP = document.getElementById('videoP');
// function togglePlay() {
//   if (myVideo.paused) {
//     myVideo.play();
//     videoP.classList.add('play');
//   } else {
//     myVideo.pause();
//     videoP.classList.remove('play');
//   }
// }
// myVideo.addEventListener('click', togglePlay);
// videoP.addEventListener('click', togglePlay);

var currentX = '';
var currentY = '';
var movementConstant = .035;
$(document).mousemove(function (e) {
    if (currentX == '') currentX = e.pageX;
    var xdiff = e.pageX - currentX;
    currentX = e.pageX;
    if (currentY == '') currentY = e.pageY;
    var ydiff = e.pageY - currentY;
    currentY = e.pageY;

    $('.TextBg').each(function (i, el) {
        var movement = (i + 7) * (xdiff * movementConstant);
        var movementy = (i + 7) * (ydiff * movementConstant);
        var newX = $(el).position().left + movement;
        var newY = $(el).position().top + movementy;
        var cssObj = {
            'left': newX + 'px',
            'top': newY + 'px'
        };
        $(el).css({
            "transform": "translate(" + newX + "px," + newY + "px)"
        });
    });
});
var a = 0;
$(window).scroll(function () {
    function numberWithCommas(n) {
        var parts = n.toString().split(".");
        return parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }
    var oTop = $('.SecCounter').offset().top - window.innerHeight;
    if (a == 0 && $(window).scrollTop() > oTop) {
        $('.counter-value').each(function () {
            var $this = $(this), countTo = $this.attr('data-count');
            $({
                countNum: $this.text()
            }).animate({
                countNum: countTo
            }, {
                duration: 5000,
                easing: 'swing',
                step: function () {
                    $this.text(numberWithCommas(this.countNum));
                },
                complete: function () {
                    $this.text(numberWithCommas(this.countNum));
                    //alert('finished');
                }
            });
        }); a = 1;
    }
});