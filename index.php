<?php if (session_status() != PHP_SESSION_ACTIVE) session_start();
include_once('./modules/get-data.php'); ?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="stylesheet" href="./assets/bootstrap/bootstrap.min.css">
   <link rel="stylesheet" href="./css/style.css">
   <title>Тестовое задание</title>
</head>

<body>
   <div class="container">
      <div class="row">
         <div class="uplode-show-files">
            <div>
               <form action="./modules/uplode-data.php" method="post" name="data" enctype="multipart/form-data">
                  <div class="custom-file">
                     <input type="file" name="file">
                  </div>
                  <div class="btn-upload">
                     <input type="submit" name="submit" value="Загрузить" class="btn btn-primary">
                  </div>
               </form>
            </div>

            <div class="show-file-list">
               <form name='list' method='POST' action="./modules/get-files-list.php">
                  <button type="submit" name="get_list" class="btn btn-outline-secondary" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">Показать загруженные файлы</button>
               </form>
               <div class="collapse" id="collapseExample">
                  <ul class="list-group">
                  </ul>
               </div>
            </div>
         </div>
         <div class="comments">
            <div class="response"></div>
         </div>
         <div class="page-refresh">
            <button class="btn btn-info hide btn-refresh" onClick="window.location.reload();">Обновить</button>
         </div>

      </div>
   </div>
   <div class="table">
      <?php get_all_data(); ?>
   </div>
   <div class="container">
      <div class="row">
         <div class="save-data hide">
            <form action="./modules/export-data.php" method="post" name="export-form" enctype="multipart/form-data">
               <div class="export-form-group">
                  <input type="submit" name="export" class="btn btn-success" value="Сохранить данные в CSV" />
               </div>
            </form>
         </div>
      </div>
   </div>
</body>
<script type="text/javascript" src="./assets/bootstrap/bootstrap.min.js"></script>
<script type="text/javascript" src="./assets/jQuery/jquery-3.6.3.min.js"></script>
<script type="text/javascript" src="./js/getDataTable.js"></script>
<script type="text/javascript" src="./js/getFiles.js"></script>

</html>