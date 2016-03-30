$(function() {
  // select all like link
  $('.js_like').click(function(e){
    e.preventDefault();
    $url = $(e.currentTarget).attr("href");
    $nbLike = $(e.currentTarget).children('span');

    $.ajax($url)
        .done(function(data) {
          // check if data.valid is true
          if (data.valid) {
            // increase the number of like instead of reload the full page
            $nbLike.html(+$nbLike.html() + 1);
          }
        });
  });
});