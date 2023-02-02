<?php
if (session_status() != PHP_SESSION_ACTIVE) session_start();

// Файл с функция
require_once('./insert-functions.php');

// Массивы для проверки соответствия атрибутов
$columns_users = explode(";", 'XML_ID;LAST_NAME;NAME;SECOND_NAME;DEPARTMENT;WORK_POSITION;EMAIL;MOBILE_PHONE;PHONE;LOGIN;PASSWORD');
$columns_department = explode(";", 'XML_ID;PARENT_XML_ID;NAME_DEPARTMENT');


// Разрешенные типы
$file_mimes = array(
   'text/x-comma-separated-values',
   'text/comma-separated-values',
   'application/octet-stream',
   'application/vnd.ms-excel',
   'application/x-csv',
   'text/x-csv',
   'text/csv',
   'application/csv',
   'application/excel',
   'application/vnd.msexcel',
   'text/plain'
);

// Проверяем, является ли выбранный файл CSV-файлом
if (!empty($_FILES['file']['name']) && in_array($_FILES['file']['type'], $file_mimes)) {

   // Открываем загруженный файл в режиме чтения
   $csv_file = fopen($_FILES['file']['tmp_name'], 'r');

   // Получаем первую строку с названиями и сверяем с таблицами
   $get_columns = fgetcsv($csv_file, 10000, ";");

   $is_department = array_diff_assoc($get_columns, $columns_department);
   $is_users = array_diff_assoc($get_columns, $columns_users);

   if (empty($is_department)) insert_department($csv_file);
   else if (empty($is_users)) insert_users($csv_file);
   else echo "Данные файла не соответствуют схеме";

   // Закрываем открытый CSV-файл
   fclose($csv_file);
} else {
   echo "Неверный тип файла или файл отсутствует";
}
