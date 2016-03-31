$(function() {
  // select all star img
  $('.js_score').click(function(e) {
    e.preventDefault();
    $url = $(e.currentTarget).attr("href");

    $.ajax($url)
        .done(function(data) {
          // check if data.valid is true
          if (data.valid) {

          }
        });
  });
});