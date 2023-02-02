$(document).ready(function () {
   // Раскрываем список или закрываем
   let open = true;

   // Получение списка файлов
   $('form[name=list]').on('submit', function (e) {
      e.preventDefault();

      $.ajax({
         url: this.action,
         type: this.method,
         dataType: 'json',
         success: function (response) {
            if (open) {
               if (response) {
                  response.forEach((fileName, index) => {
                     $('.list-group').append($('<li>', {
                        'class': 'list-group-item',
                        'text': index + 1 + ". " + fileName
                     }));
                  });

               } else {
                  $('.list-group').append($('<li>', {
                     'class': 'list-group-item',
                     'text': 'Список пуст'
                  }));
               }

               open = false;
            } else {
               $('.list-group').empty();
               open = true;
            }

         }
      });
   });
});