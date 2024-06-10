$(document).ready(function () {
  let menuShown = false; // Menu shown state
  let navbarScrolled = false; // Navbar scrolled state

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
            menuShown = true;
            activateNavbar();
          } else {
            menuShown = false;
            if (!navbarScrolled) {
              deactivateNavbar();
            }
          }
        }
      }
    });

    // Start observing changes in #menu
    menuObserver.observe(document.getElementById("menu"), { attributes: true });

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
  }

  //////////////////
});

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
