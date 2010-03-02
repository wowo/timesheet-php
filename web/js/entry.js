$('document').ready(function() {
  $('#entryAdd').submit(function () {
    $('.error').removeClass('error');
    $('.validation').remove();

    $.ajax({
      type: $(this).attr('method'),
      url: $(this).attr('action'),
      data: $(this).serialize(),
      dataType: 'json',
      success: function (data) {
        var row = $('#entries .day[innerHTML=' + data.entry.day +']').parents('tr');
        if (row.length > 0) {
          for (var key in data.entry) {
            row.find('.' + key).html(data.entry[key]).fadeOut(50).fadeIn(100);
          }
          if (data.entry.isDeltaNegative) {
            row.addClass('minus');
          } else {
            row.removeClass('minus');
          }
        } else {
          var maxDay = 0;
          $('#entries .day').each(function (k,v) {
             if (parseInt($(v).html()) < data.entry.day) {
                maxDay = $(v).html();
             }
          });
          var newRow = $('<tr />').attr('id', 'entry-' + data.entry.day);
          if (data.entry.isDeltaNegative) {
            newRow.addClass('minus');
          }
          for (var key in ['day', 'dayLiteral', 'workingTime', 'delta', 'occurences']) {
            newRow.append($('<td>').addClass(key).html(data.entry[key]).fadeOut(50).fadeIn(100));
          }
          if (maxDay > 0) {
            $('#entries .day[innerHTML=' + maxDay +']').parent('tr').after(newRow.fadeOut(50).fadeIn(100));
          } else {
            $('#entries tbody tr.empty').remove();
            $('#entries tbody').prepend(newRow.fadeOut(50).fadeIn(100));
          }

        }
        $('#entries tfoot .sum').html(data.summary.sum).fadeOut(50).fadeIn(100);
        $('#entries tfoot .delta').html(data.summary.delta).fadeOut(50).fadeIn(100);
        $('#entries tfoot .occurences').html(data.summary.occurences).fadeOut(50).fadeIn(100);
      },
      error: function (response) {
        if (response.status == 409) { //validation problems
          data = eval('(' + response.responseText + ')');
          for (var key in data.fields) {
            $('[name*=entry[' + key + ']]').after('<span class="validation">' + data.fields[key] + '</span>').parents('tr').addClass('error');
          }
          for (var key in data.global) {
            $('#entryAdd tr:last').before('<tr class="error validation"><td colspan="2" class="validation">' + data.global[key] + '</td></tr>');
          }
        } else {
          alert(response.responseText);
        }
      }
    });
    return false;
  });
});
