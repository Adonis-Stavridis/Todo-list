import 'bootstrap';

let $ = require('jquery');

$(function () {
  $('#createButton').on('click', function () {
    $.ajax({
      'url': 'create',
      'type': 'post'
    }).done(function (response) {
      updateUrl(response);
    });
  });

  function updateUrl(response) {
    window.history.replaceState(response.html, response.title);
  }
});
