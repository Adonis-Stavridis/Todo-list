import 'bootstrap';

let $ = require('jquery');

$(function () {
  $('#createButton').on('click', function () {
    $.ajax({
      'url': 'create',
      'type': 'post'
    });
  });

  $('#commentButton').on('click', function () {
    $.ajax({
      'url': '/comment',
      'type': 'post',
      'data': {
        'taskId': $('#taskId').val(),
        'taskComment': $('#taskComment').val()
      }
    }).done(function (response) {
      addComment(response);
    });
  });

  function addComment(response) {
    $(response).insertAfter('#addComment');
  }
});
