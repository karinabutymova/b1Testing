<?php
if (isset($_POST["export"])) {
   // подключаем файл конфигурации БД MySQL
   include(dirname(__FILE__) . '/../connect/db.php');

   // Определяем заголовки и открываем файл для записи 
   header('Content-Type: text/csv; charset=utf-8');
   header('Content-Disposition: attachment; filename=export-data.csv');

   $output = fopen("php://output", "w");

   // Проверяем наличие данных в таблице пользователей
   $query = "SELECT * FROM users";
   $check = mysqli_query($link, $query);

   if (mysqli_num_rows($check) > 0) {

      // Первая строка название атрибутов
      fputcsv($output, array('XML_ID', 'LAST_NAME', 'NAME', 'SECOND_NAME', 'DEPARTMENT', 'WORK_POSITION', 'EMAIL', 'MOBILE_PHONE', 'PHONE', 'LOGIN', 'PASSWORD'));

      $query = "SELECT * FROM `department` LEFT JOIN users ON department.xml_id = users.department
      INNER JOIN user_auth ON users.user_auth_id = user_auth.id";
      $result = mysqli_query($link, $query);

      while ($row = mysqli_fetch_assoc($result)) {
         fputcsv($output, $row);
      }
   } else {
      // Первая строка название атрибутов
      fputcsv($output, array('XML_ID', 'PARENT_XML_ID', 'NAME_DEPARTMENT'));

      $query = "SELECT * FROM `department`";
      $result = mysqli_query($link, $query);

      while ($row = mysqli_fetch_assoc($result)) {
         fputcsv($output, $row);
      }
   }

   fclose($output);

   // Закрываем соединение с БД
   mysqli_close($link);
}
