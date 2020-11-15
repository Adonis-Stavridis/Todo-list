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

  $('#searchButton').on('click', function () {
    var $value = $('#searchInput').val();
    if ($value) {
      $('#tasksList > a:not(:contains("' + $value + '"))').removeClass('d-flex');
      $('#tasksList > a:not(:contains("' + $value + '"))').addClass('d-none');
      $('#tasksList > a:contains("' + $value + '")').removeClass('d-none');
      $('#tasksList > a:contains("' + $value + '")').addClass('d-flex');
    } else {
      $('#tasksList > a').removeClass('d-none');
      $('#tasksList > a').addClass('d-flex');
    }
  });
});
