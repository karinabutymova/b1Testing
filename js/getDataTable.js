$(document).ready(function () {

   // Скрыть/отобразить кнопку сохранения данных
   if (!$('table').length) {
      $('.save-data').addClass('hide');
   } else {
      $('.save-data').addClass('show');
   }

   // Получение таблицы с данными
   $('form[name=data]').on('submit', function (e) {
      e.preventDefault();

      let fd = new FormData();

      fd.append('file', $('input[name="file"]')[0].files[0]);

      $.ajax({
         url: this.action,
         type: this.method,
         dataType: 'text',
         contentType: false,
         processData: false,
         data: fd,
         success: function (response) {
            $('.response').empty();

            response.split(';').forEach(element => {
               $('.response').append($('<p>', {
                  'class': 'response-line',
                  'text': element
               }));
            });
            $('.btn-refresh').addClass('show');
         }
      });
   });
});