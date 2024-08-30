$(document).ready(function () {
  /* Swiper */

  // Initialize Swiper JS for Hero
  var swiperHero = new Swiper("#swiper-hero", {
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

  var hero = daftarHero;
  var currentIndex = swiperHero.realIndex;

  function changeBackgroundImage(index) {
    $("#hero .section-slideshow").fadeOut("slow", function () {
      // Update the background image
      $(this).css(
        "background-image",
        "url(" + hero[index].featured_image + ")"
        // "url(https://www.uinsaid.ac.id/files/upload/IMG-20231104-WA0020.jpg)"
      );
      // Fade back in
      $(this).fadeIn("slow");
    });
  }

  // Initialize with the first image
  changeBackgroundImage(currentIndex);

  swiperHero.on("slideChange", function () {
    currentIndex = swiperHero.realIndex;
    changeBackgroundImage(currentIndex);
  });

  // Initialize Swiper JS for Berita
  var swiperBerita = new Swiper("#swiper-berita", {
    slidesPerView: 1,
    grabCursor: true,
    spaceBetween: 10,
    loop: true,
    pagination: {
      el: ".swiper-pagination",
      clickable: true,
    },
    navigation: {
      nextEl: ".berita-swiper-button-next",
      prevEl: ".berita-swiper-button-prev",
    },
    autoplay: {
      delay: 2500,
      disableOnInteraction: false,
    },
    grid: {
      fill: 'row',
      rows: 3
    },
    loopAddBlankSlides: true,
    breakpoints: {
      640: {
        slidesPerView: 1,
        spaceBetween: 10,
        grid: {
          fill: 'row',
          rows: 3
        },
        loopAddBlankSlides: true,
      },
      768: {
        slidesPerView: 2,
        spaceBetween: 20,
        grid: {
          fill: 'column',
          rows: 1
        }
      },
      1024: {
        slidesPerView: 3,
        spaceBetween: 30,
        grid: {
          fill: 'column',
          rows: 1
        }
      },
    },
  });

  // Initialize Swiper JS for Prestasi
  var swiperPrestasi = new Swiper("#swiper-prestasi", {
    slidesPerView: 1,
    grabCursor: true,
    spaceBetween: 10,
    loop: true,
    pagination: {
      el: ".swiper-pagination",
      clickable: true,
    },
    navigation: {
      nextEl: ".prestasi-swiper-button-next",
      prevEl: ".prestasi-swiper-button-prev",
    },
    autoplay: {
      delay: 2500,
      disableOnInteraction: false,
    },
    breakpoints: {
      640: {
        slidesPerView: 1,
        spaceBetween: 10,
      },
      768: {
        slidesPerView: 2,
        spaceBetween: 20,
      },
      1024: {
        slidesPerView: 3,
        spaceBetween: 30,
      },
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

  // $(document).ready(function () {
  //   var kegiatanTerbaru = daftarKegiatan;
  //   console.log(kegiatanTerbaru);
  //   var currentIndex = swiperKegiatan.realIndex;

  //   function changeBackgroundImage(index) {
  //     $("#section-kegiatan .section-slideshow").fadeOut("slow", function () {
  //       // Update the background image
  //       $(this).css(
  //         "background-image",
  //         "url(" + kegiatanTerbaru[index].featured_image + ")"
  //         // "url(https://www.uinsaid.ac.id/files/upload/IMG-20231104-WA0020.jpg)"
  //       );
  //       // Fade back in
  //       $(this).fadeIn("slow");
  //     });
  //   }

  //   // Initialize with the first image
  //   changeBackgroundImage(currentIndex);

  //   swiperKegiatan.on("slideChange", function () {
  //     currentIndex = swiperKegiatan.realIndex;
  //     changeBackgroundImage(currentIndex);
  //   });
  // });

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
});

document.addEventListener('DOMContentLoaded', function () {
  const berandaModal = document.getElementById('berandaModal');

  berandaModal.addEventListener('show.bs.modal', function (event) {
    // Card (or button) that triggered the modal
    const card = event.relatedTarget;
    // Extract the uri, title, and description values from the card's data-* attributes
    const uriValue = card.getAttribute('data-uri');
    const titleValue = card.getAttribute('data-title');
    const descriptionValue = card.getAttribute('data-deskripsi');
    const waktuValue = formatDate(card.getAttribute('data-waktu'));

    // Update the modal's content with the extracted values
    const modalTitle = berandaModal.querySelector('#modalTitle');
    const modalImageContent = berandaModal.querySelector('#modalImageContent');
    const modalWaktuContent = berandaModal.querySelector('#modalWaktuContent');
    const modalDescriptionContent = berandaModal.querySelector('#modalDescriptionContent');

    modalTitle.textContent = titleValue; // Update the title
    modalImageContent.src = uriValue; // Update the uri content
    modalWaktuContent.textContent = waktuValue; // Update the uri content
    modalDescriptionContent.textContent = descriptionValue; // Update the description content
  });

  // Ensure the card itself is clickable to trigger the modal
  const cards = document.querySelectorAll('.card[data-mdb-target="#berandaModal"]');
  cards.forEach(function (card) {
    card.addEventListener('click', function () {
      const modal = new bootstrap.Modal(berandaModal);
      modal.show();
    });
  });
});
