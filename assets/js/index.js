import 'bootstrap';

let $ = require('jquery');

$(function () {
  $('#addButton').on('click', function () {
    $.ajax({
      'url': 'add',
      'type': 'post'
    }).done(function (response) {
      updateElement($('#taskPage'), response);
    });
  });

  $('#addComment').on('click', function () {
    $.ajax({
      'url': 'comment',
      'type': 'post'
    });
  });

  function updateElement(element, response) {
    element.html(response);
  }
});
