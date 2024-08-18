// Light mode/dark mode
$(document).ready(function () {
  const htmlElement = $("html");
  const currentTheme = localStorage.getItem("mdb-theme") || "light";

  // Set the initial theme
  htmlElement.attr("data-mdb-theme", currentTheme);

  // Toggle theme on button click
  $("#themeToggle").click(function () {
    console.log("Switched theme");
    const newTheme =
      htmlElement.attr("data-mdb-theme") === "light" ? "dark" : "light";
    htmlElement.attr("data-mdb-theme", newTheme);
    localStorage.setItem("mdb-theme", newTheme);
  });

  // Toggle navbar brand
  $(".navbar-toggler").on("click", function () {
    if ($("#navbarSupportedContent").hasClass("show")) {
      $("#navbarBrandWrapper").fadeIn(); // Show navbar brand
    } else {
      $("#navbarBrandWrapper").fadeOut(); // Hide navbar brand
    }
  });

  // Listen for the collapse 'shown' and 'hidden' events
  $("#navbarSupportedContent").on("shown.bs.collapse", function () {
    $("#navbarBrandWrapper").fadeOut(); // Hide navbar brand when fully expanded
  });

  $("#navbarSupportedContent").on("hidden.bs.collapse", function () {
    $("#navbarBrandWrapper").fadeIn(); // Show navbar brand when fully collapsed
  });
});
