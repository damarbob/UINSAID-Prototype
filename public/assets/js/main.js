$(document).ready(function () {
  let menuShown = false; // Menu shown state
  let navbarScrolled = false; // Navbar scrolled state

  /* Navbar */

  /**
   * Toggle .header-scrolled class to #header when page is scrolled
   */
  let selectHeader = $("#frontend-navbar");
  if (selectHeader.length) {
    const headerScrolled = () => {
      if ($(window).scrollTop() > 100) {
        navbarScrolled = true;
        activateNavbar();
      } else {
        navbarScrolled = false;
        if (!menuShown) {
          deactivateNavbar();
        }
      }
    };
    $(window).on("load", headerScrolled);
    $(document).on("scroll", headerScrolled);

    // Create a MutationObserver to listen for changes in #menu
    const menuObserver = new MutationObserver((mutationsList, observer) => {
      for (let mutation of mutationsList) {
        if (
          mutation.type === "attributes" &&
          mutation.attributeName === "class" &&
          mutation.target.id === "menu"
        ) {
          // Check if the class .show is added to #menu
          if ($(mutation.target).hasClass("show")) {
            // The menu is shown

            menuShown = true; // Set menu shown to true
            activateBodyScrollbar();
            activateNavbar();

            let $icon = $("#menuIcon");
            if ($icon.hasClass("bi-list")) {
              $icon.removeClass("bi-list").addClass("bi-x");
            }
          } else {
            // The menu is hidden

            menuShown = false; // Set menu shown to false
            deactivateBodyScrollbar();
            if (!navbarScrolled) {
              deactivateNavbar();
            }

            let $icon = $("#menuIcon");
            if (!$icon.hasClass("bi-list")) {
              $icon.removeClass("bi-x").addClass("bi-list");
            }
          }
        }
      }
    });

    // Start observing changes in #menu
    menuObserver.observe(document.getElementById("menu"), {
      attributes: true,
    });

    // Create a MutationObserver to listen for changes in #search
    const searchObserver = new MutationObserver((mutationsList, observer) => {
      for (let mutation of mutationsList) {
        if (
          mutation.type === "attributes" &&
          mutation.attributeName === "class" &&
          mutation.target.id === "search"
        ) {
          // Check if the class .show is added to #menu
          if ($(mutation.target).hasClass("show")) {
            // The search is shown
            activateBodyScrollbar();
          } else {
            // The search is hidden
            deactivateBodyScrollbar();
          }
        }
      }
    });

    // Start observing changes in #search
    searchObserver.observe(document.getElementById("search"), {
      attributes: true,
    });

    function activateNavbar() {
      if (!selectHeader.hasClass("header-scrolled")) {
        selectHeader.addClass("header-scrolled");
      }

      if (!selectHeader.hasClass("navbar-light")) {
        selectHeader.addClass("navbar-light");
      }

      if (selectHeader.hasClass("navbar-dark")) {
        selectHeader.removeClass("navbar-dark");
      }
    }

    function deactivateNavbar() {
      if (selectHeader.hasClass("header-scrolled")) {
        selectHeader.removeClass("header-scrolled");
      }

      if (!selectHeader.hasClass("navbar-dark")) {
        selectHeader.addClass("navbar-dark");
      }

      if (selectHeader.hasClass("navbar-light")) {
        selectHeader.removeClass("navbar-light");
      }
    }

    // Activate body scrollbar
    function activateBodyScrollbar() {
      if (!$("body").hasClass("overflow-hidden")) {
        $("body").addClass("overflow-hidden");
      }
    }

    // Deactivate body scrollbar
    function deactivateBodyScrollbar() {
      if ($("body").hasClass("overflow-hidden")) {
        $("body").removeClass("overflow-hidden");
      }
    }

    // Show close button (second menuButton) and hide others
    function hideCloseMenuButton() {
      // Show the first #menuButton
      $("#menuButton").show();

      // Show the first #menuSearch
      $("#menuSearch").show();

      // Show the first #menuLanguage
      $("#menuLanguage").show();

      // Hide the second #menuButton
      $("#menuButton").eq(1).hide();
    }

    // Hide close button (second menuButton) and show others
    function showCloseMenuButton() {
      // Hide the first #menuButton
      $("#menuButton").hide();

      // Hide the first #menuSearch
      $("#menuSearch").hide();

      // Hide the first #menuLanguage
      $("#menuLanguage").hide();

      // Hide the second #menuButton
      $("#menuButton").eq(1).show();
    }
  }

  /* Main menu dropdown */

  // Function to collapse other dropdowns
  function collapseOthers(notThis) {
    $(".collapse").not(notThis).not("#menu").collapse("hide");
  }

  // Attach event handlers
  $("#menuAkademik").on("click", function () {
    collapseOthers("#dropdownAkademik");
  });

  $("#menuRisetDanPublikasi").on("click", function () {
    collapseOthers("#dropdownRisetDanPublikasi");
  });

  $("#menuTentangKami").on("click", function () {
    collapseOthers("#dropdownTentangKami");
  });

  /* Triple click default action prevention */

  // Function to clear text selection
  function clearTextSelection() {
    if (window.getSelection) {
      var selection = window.getSelection();
      if (selection.empty) {
        // Chrome
        selection.empty();
      } else if (selection.removeAllRanges) {
        // Firefox
        selection.removeAllRanges();
      } else if (selection.collapse) {
        // IE
        selection.collapse(null);
      }
    } else if (document.selection) {
      // Older IE
      document.selection.empty();
    }
  }

  // Function to handle clicks
  function handleClick(event) {
    clearTextSelection();
    // Prevent default triple-click behavior
    event.preventDefault();
    event.stopPropagation();
  }

  // Target buttons, links, and .btn elements
  $("button, .btn, a").on("click", function (event) {
    handleClick(event);
  });

  // Prevent triple-click selection
  $(document).on("mousedown", function (event) {
    if (event.originalEvent.detail > 2) {
      // This indicates a triple click
      event.preventDefault();
    }
  });
});

/* Youtube */

$(document).ready(function () {
  // Youtube video player
  function togglePlayerVisibility() {
    if ($(window).width() < 576) {
      $("#player").hide();
    } else {
      $("#player").show();
    }
  }

  // Initial check on document ready
  togglePlayerVisibility();

  // Show the video player
  $("#btnSimakVideo").click(function () {
    $("#player").show();
  });
});

// Load YouTube iframe API asynchronously
(function () {
  var script = document.createElement("script");
  script.src = "https://www.youtube.com/iframe_api";
  var firstScriptTag = document.getElementsByTagName("script")[0];
  firstScriptTag.parentNode.insertBefore(script, firstScriptTag);
})();

var player;

function onYouTubeIframeAPIReady() {
  player = new YT.Player("player", {
    events: {
      onReady: onPlayerReady,
      // onStateChange: onPlayerStateChange,
    },
  });
}

function onPlayerReady(event) {
  $("#btnSimakVideo").click(function () {
    if (player.isMuted()) {
      player.unMute();
    } else {
      player.mute();
    }
  });
}

function onPlayerStateChange(event) {
  if (event.data == YT.PlayerState.PAUSED) {
    player.playVideo();
  }
}

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

$(document).ready(function () {
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
});

// Light mode/dark mode
$(document).ready(function () {
  const htmlElement = $("html");
  const currentTheme = localStorage.getItem("mdb-theme") || "light";

  // Set the initial theme
  htmlElement.attr("data-mdb-theme", currentTheme);

  // Toggle theme on button click
  $("#themeToggle").click(function () {
    const newTheme =
      htmlElement.attr("data-mdb-theme") === "light" ? "dark" : "light";
    htmlElement.attr("data-mdb-theme", newTheme);
    localStorage.setItem("mdb-theme", newTheme);
  });
});

/* RTL */
$(document).ready(function () {});
