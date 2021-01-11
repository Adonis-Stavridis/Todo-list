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
        'comment': $('#taskComment').val()
      }
		}).done(function (response) {
			console.log(response);
      addComment(response);
    });
  });

  function addComment(response) {
    $(response).insertBefore('#insertBefore:hidden');
  }

  $('#searchInput').on('input', function () {
    var $value = $('#searchInput').val();
    if ($value) {
      if ($value.startsWith('[c]')) {
        filterByCreator($value.replace('[c]',''));
      } else if ($value.startsWith('[a]')) {
        filterByAssignee($value.replace('[a]',''));
      } else {
        filterByKeyword($value);
      }
    } else {
      $('#tasksList > a').removeClass('d-none');
      $('#tasksList > a').addClass('d-flex');
    }
  });

  function filterByCreator(val) {
    $('span.taskCreatedBy:not(:contains("' + val + '"))').parent().removeClass('d-flex');
    $('span.taskCreatedBy:not(:contains("' + val + '"))').parent().addClass('d-none');
    $('span.taskCreatedBy:contains("' + val + '")').parent().removeClass('d-none');
    $('span.taskCreatedBy:contains("' + val + '")').parent().addClass('d-flex');
  }

  function filterByAssignee(val) {
    $('span.taskAssignedTo:not(:contains("' + val + '"))').parent().removeClass('d-flex');
    $('span.taskAssignedTo:not(:contains("' + val + '"))').parent().addClass('d-none');
    $('span.taskAssignedTo:contains("' + val + '")').parent().removeClass('d-none');
    $('span.taskAssignedTo:contains("' + val + '")').parent().addClass('d-flex');
  }

  function filterByKeyword(val) {
    $('#tasksList > a:not(:contains("' + val + '"))').removeClass('d-flex');
    $('#tasksList > a:not(:contains("' + val + '"))').addClass('d-none');
    $('#tasksList > a:contains("' + val + '")').removeClass('d-none');
    $('#tasksList > a:contains("' + val + '")').addClass('d-flex');
  }
});
