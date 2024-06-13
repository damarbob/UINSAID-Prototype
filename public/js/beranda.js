// Initialize Swiper JS for Berita
var swiperBerita = new Swiper("#swiper-berita", {
    slidesPerView: 1,
    grabCursor: true,
    spaceBetween: 30,
    loop: true,
    pagination: {
        el: ".swiper-pagination",
        clickable: true,
    },
    navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
    },
    autoplay: {
        delay: 2500,
        disableOnInteraction: false,
    },
});

// Initialize Swiper JS for Kegiatan
var swiperKegiatan = new Swiper("#swiper-kegiatan", {
    slidesPerView: 1,
    grabCursor: true,
    spaceBetween: 30,
    loop: true,
    pagination: {
        el: ".swiper-pagination",
        clickable: true,
    },
    navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
    },
    autoplay: {
        delay: 5000,
        disableOnInteraction: false,
    },
});

$(document).ready(function () {
    var kegiatanTerbaru = daftarKegiatan;
    console.log(kegiatanTerbaru);
    var currentIndex = swiperKegiatan.realIndex;

    function changeBackgroundImage(index) {
        $("#section-kegiatan .section-slideshow").fadeOut("slow", function () {
            // Update the background image
            $(this).css(
                "background-image",
                "url(" + kegiatanTerbaru[index].featured_image + ")"
                // "url(https://www.uinsaid.ac.id/files/upload/IMG-20231104-WA0020.jpg)"
            );
            // Fade back in
            $(this).fadeIn("slow");
        });
    }

    // Initialize with the first image
    changeBackgroundImage(currentIndex);

    swiperKegiatan.on("slideChange", function () {
        currentIndex = swiperKegiatan.realIndex;
        changeBackgroundImage(currentIndex);
    });
});

// Set min height of pengumuman and agenda columns
// document.addEventListener("DOMContentLoaded", function () {
//     function setEqualHeight() {
//         var col1 = document.querySelector(".col-lg-4 .pengumuman-widget");
//         var col2 = document.querySelector(".col-lg-8 .pengumuman-widget");
//         var col1Height = col1.offsetHeight;
//         var col2Height = col2.offsetHeight;
//         var maxHeight = Math.max(col1Height, col2Height);
//         col1.style.minHeight = maxHeight + "px";
//         col2.style.minHeight = maxHeight + "px";
//     }

//     setEqualHeight();
//     window.addEventListener("resize", setEqualHeight);
// });