var swiper = new Swiper(".thumb-slide", {
    loop: true,
    spaceBetween: 20,
    slidesPerView: 4,
    freeMode: true,
});

const homeSliderDelay = 5000;
var swiper2 = new Swiper(".main-slide", {
    loop: false,
    // init: true,
    spaceBetween: 60,
    thumbs: {
        swiper: swiper,
    },
    autoplay: {
        delay: homeSliderDelay,
        // disableOnInteraction: false,
        pauseOnMouseEnter: true,
    },
    pagination: {
        el: ".paging-main",
    },
    slidesPerView: 1,
    on: {
        slideChange: function (swiper) {
            $(".progress").stop();

            // toggle opacity banner title
            document.querySelectorAll('.banner-title').forEach(elem => {
                elem.classList.remove('banner-active');
            });

            // toggle opacity banner line progress
            document.querySelectorAll('.sliding-banner-progress').forEach(elem => {
                elem.classList.remove('sliding-banner-active');
            })

            const slidersCount = swiper.slides.length;
            const indexCurrentSlide = swiper.realIndex;

            document.querySelectorAll(".progress").forEach((elem) => (elem.style.width = 0));

            const currentSlide = swiper.slides[indexCurrentSlide];

            const currentThumb = swiper.thumbs.swiper.slides[indexCurrentSlide];
            currentThumb.querySelector('.banner-title').classList.add('banner-active');
            currentThumb.querySelector('.sliding-banner-progress').classList.add('sliding-banner-active');

            const progressBar = currentThumb.querySelector(
                `.progress-${indexCurrentSlide}`
            );
            progressBar.style.width = '100%'

            const background = document.querySelector("#bgBanner");
            const vidBackground = document.querySelector("#vidBanner");
            const vidDesktop = document.querySelector("#vidDesktop");
            const vidWrapper = document.querySelector('.bg');

            if (currentSlide != undefined) {
                if (currentSlide.dataset.desktop.indexOf("mp4") >= 0) {
                    vidBackground.classList.remove("d-md-none");
                    vidBackground.classList.add("d-md-block");
                    vidBackground.src = currentSlide.dataset.desktop;
                    vidDesktop.src = currentSlide.dataset.desktop;
                    background.style.backgroundImage = `linear-gradient(180deg, #083E62 46%, #083E62 100%)`;

                    vidWrapper.classList.remove("d-none");
                    vidWrapper.classList.add("d-block");
                } else {
                    vidBackground.src = "";
                    vidDesktop.src = "";
                    vidBackground.classList.remove("d-md-block");
                    vidBackground.classList.add("d-md-none");
                    background.style.backgroundImage = `url(${currentSlide.dataset.desktop})`;

                    vidWrapper.classList.add("d-none");
                    vidWrapper.classList.remove("d-block");
                }
            }
        },
        touchMove: function (swiper) {
            $(".progress").stop().parent().addClass("stopped");
        },
        click: function (swiper) {
            $(".progress").stop().parent().addClass("stopped");
        },
    },
});

// intial load
const progressBar = document.querySelector(`.progress-0`);
progressBar.style.width = '100%';

// Mobile swiper mobile homepage
var swiper2Mobile = new Swiper(".main-slide-mobile", {
    spaceBetween: 20,
    slidesPerView: 1,
    pagination: {
        el: ".main-slide-mobile-paging",
    },
    on: {
        slideChange: function (swiper) {
            const slidersCount = swiper.slides.length;
            const indexCurrentSlide = swiper.realIndex;

            const currentSlide = swiper.slides[indexCurrentSlide];

            const background = document.querySelector("#bgBannerMobile");
            const vidBackgroundWrapper =
                document.querySelector("#vidBannerMobile");
            const vidBackground = document.querySelector("#vidBannerMobile");
            const vidMobile = document.querySelector("#vidMobile");
            const vidWrapper = document.querySelector('.bg-mobile');

            if (currentSlide.dataset.mobile.indexOf("mp4") >= 0) {
                vidBackground.classList.remove("d-none");
                vidBackground.classList.add("d-block");
                vidBackground.src = currentSlide.dataset.mobile;
                vidMobile.src = currentSlide.dataset.mobile;
                background.style.backgroundImage = `linear-gradient(180deg, #083E62 46%, #083E62 100%)`;

                vidWrapper.classList.remove("d-none");
                vidWrapper.classList.add("d-block");
            } else {
                vidBackground.src = "";
                vidMobile.src = "";
                vidBackground.classList.remove("d-block");
                vidBackground.classList.add("d-none");
                background.style.backgroundImage = `url(${currentSlide.dataset.mobile})`;

                vidWrapper.classList.add("d-none");
                vidWrapper.classList.remove("d-block");
            }
        },
    },
});

var swiper3 = new Swiper(".feature-slide", {
    slidesPerView: 1.1,
    spaceBetween: 16,
    navigation: {
        nextEl: ".feature-next",
        prevEl: ".feature-prev",
    },
    pagination: {
        el: ".feature-paging",
    },
    breakpoints: {
        320: {
            slidesPerView: 1.05,
            spaceBetween: 16
        },
        // blackberry z30
        360: {
            slidesPerView: 1.01,
            spaceBetween: 30
        },
        480: {
            slidesPerView: 1.05,
            spaceBetween: 10
        },
        640 : {
            slidesPerView: 1,
            spaceBetween: 16,
        },
        767: {
            slidesPerView: 2,
            spaceBetween: 16,
        },
    },
});


$('.country-head').on('click', function() {
    $('#initialCountryText').hide();
    $('.country-nav').hide();
    $('.country-head').attr('fill', "#AAD0E9");
    $('.country-label').removeAttr('style');
    $(`.country-map`).attr('fill', '#AAD0E9');

    const childClass = $(this).children(':first').attr('class').split(' ')[1];

    $('#countries').show();
    $('.country-detail').hide();
    $(`#${childClass}`).show();
    $(`.${childClass}-nav`).show();

    $(`.label-${childClass}`).css('display', 'block');
    $(`.head-${childClass}`).attr('fill', '#EF6C4F');
    $(`.${childClass}`).attr('fill', '#EF6C4F');
});

$('.country-nav').on('click', function() {
    const target = $(this).data('target');

    $(`.country-head .${target}`).click();
});