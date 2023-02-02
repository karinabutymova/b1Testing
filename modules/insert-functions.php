<?php
if (session_status() != PHP_SESSION_ACTIVE) session_start();

// Добавление данных в таблицу департаментов
function insert_department($csv_file)
{
   // Кол-во добавленных строк и общее кол-во
   $success = 0;
   $all_data = 0;

   // подключаем файл конфигурации БД MySQL
   include(dirname(__FILE__) . '/../connect/db.php');

   // Построчно разбиваем данные из файла 
   while (($get_data = fgetcsv($csv_file, 10000, ";")) !== FALSE) {
      $all_data++;

      // Получаем данные строки
      $xml_id = $get_data[0];
      $parent_xml_id = $get_data[1];
      $name_department = $get_data[2];

      // Есть ли департамент уже в БД, если нет - записываем
      $query = "SELECT `name_department` FROM department WHERE `name_department` = '$name_department'";
      $check = mysqli_query($link, $query);

      if ($check->num_rows == 0) {
         $query = "INSERT INTO department (`xml_id`, `parent_xml_id`, `name_department`) VALUES
                ('$xml_id','$parent_xml_id','$name_department')";
         $result = mysqli_query($link, $query);

         if ($result) $success++;
      }
   }

   add_to_files_list($success);
   echo "Добавлено " . $success . " из " . $all_data . " строк документа;";

   // Закрываем соединение с БД
   mysqli_close($link);
}

// Добавление данных в таблицы пользователей
function insert_users($csv_file)
{
   // Кол-во добавленных строк и общее кол-во
   $success = 0;
   $all_data = 0;

   // подключаем файл конфигурации БД MySQL
   include(dirname(__FILE__) . '/../connect/db.php');

   // Построчно разбиваем данные из файла 
   while (($get_data = fgetcsv($csv_file, 10000, ";")) !== FALSE) {
      $all_data++;

      // Получаем данные строки
      $department = $get_data[4];
      $login = $get_data[9];
      $password = $get_data[10];

      // Есть ли пользователь уже в БД, если нет - записываем
      $query = "SELECT `id` FROM user_auth WHERE `login` = '$login'";
      $check_users = mysqli_query($link, $query);

      // Проверяем есть ли записm в таблице department
      $query = "SELECT `xml_id` FROM department WHERE `xml_id` = '$department'";
      $check_department = mysqli_query($link, $query);

      if ($check_users->num_rows) {
         echo "Пользователь с таким логином уже сущетвует;";
      } else if (!$check_department->num_rows) {
         echo "Невозможно добавить пользователя: нет соответствия с департаментом;";
      } else {
         $query = "INSERT INTO user_auth (`login`, `password`) VALUES
         ('$login','$password')";
         mysqli_query($link, $query);

         $lastId = $link->insert_id;

         $query = "INSERT INTO users (`xml_id`, `last_name`,`name`,`second_name`, `department`, `work_position`, `email`, `mobile_phone`,`phone`,`user_auth_id`) VALUES
            ('$get_data[0]',
            '$get_data[1]',
            '$get_data[2]',
            '$get_data[3]',
            '$department',
            '$get_data[5]', 
            '$get_data[6]',
            '$get_data[7]',
            '$get_data[8]',
            '$lastId')";
         $result = mysqli_query($link, $query);

         if ($result) $success++;
      }
   }

   add_to_files_list($success);
   echo "Добавлено " . $success . " из " . $all_data . " строк документа;";

   // Закрываем соединение с БД
   mysqli_close($link);
}

// Добавляем в сессию название загруженных файлов

function add_to_files_list($success_count)
{
   if ($success_count > 0) $_SESSION['files_list'][] = $_FILES['file']['name'];
}
