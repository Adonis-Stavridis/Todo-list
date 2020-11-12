import 'bootstrap';

let $ = require('jquery');

$(function () {
  $('.task-el').on('click', function () {
    $.ajax({
      'url': 'task',
      'type': 'post',
      'data': {
        'taskId': this.id
      },
      'success': function (response) {
        updateElement($('#taskPage'), response);
      }
    });
  });

  $('#addButton').on('click', function () {
    $.ajax({
      'url': 'add',
      'type': 'post',
      'success': function (response) {
        updateElement($('#taskPage'), response);
      }
    });
  });

  function updateElement(element, response) {
    element.html(response);
  }
});
