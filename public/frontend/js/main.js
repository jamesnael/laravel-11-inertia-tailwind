$("#upload").change(function () {
  var fileName = $(this).val().split("\\").pop(); // Dapatkan nama file dari path
  $("#fileName").text("Nama File: " + fileName);
});

$(window).scroll(function () {
  var sticky = $(".header"),
    scroll = $(window).scrollTop();

  if (scroll >= 30) sticky.addClass("scroller");
  else sticky.removeClass("scroller");
});

$('.menu-mobile').click(function(e){
  e.preventDefault();
  $('.icon-humnurger').toggleClass('ico-menu ico-close');
  $('.menu-popup').toggleClass('show')
  $('body').toggleClass('no-scroll')
});