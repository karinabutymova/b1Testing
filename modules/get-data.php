<?php
if (session_status() != PHP_SESSION_ACTIVE) session_start();

function get_all_data()
{
   // подключаем файл конфигурации БД MySQL
   include(dirname(__FILE__) . '/../connect/db.php');

   // Проверяем наличие данных в таблице пользователей
   $query = "SELECT * FROM users";
   $check = mysqli_query($link, $query);

   if (mysqli_num_rows($check) > 0) {
      // Собираем информацию со всех таблиц
      $query = "SELECT * FROM `department` LEFT JOIN users ON department.xml_id = users.department
      INNER JOIN user_auth ON users.user_auth_id = user_auth.id";
      $result = mysqli_query($link, $query);

      // Вывод таблицы пользователей
      if (mysqli_num_rows($result) > 0) {
         echo "<div class='table-responsive'><table id='myTable' class='table table-striped table-bordered'>
            <thead><tr><th>XML_ID</th>
                         <th>LAST_NAME</th>
                         <th>NAME</th>
                         <th>SECOND_NAME</th>
                         <th>DEPARTMENT</th>
                         <th>WORK_POSITION</th>
                         <th>EMAIL</th>
                         <th>MOBILE_PHONE</th>
                         <th>PHONE</th>
                         <th>LOGIN</th>
                         <th>PASSWORD</th>
                       </tr></thead><tbody>";

         while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr><td>" . $row['xml_id'] . "</td>
                  <td>" . $row['last_name'] . "</td>
                  <td>" . $row['name'] . "</td>
                  <td>" . $row['second_name'] . "</td>
                  <td>" . $row['name_department'] . "</td>
                  <td>" . $row['work_position'] . "</td>
                  <td>" . $row['email'] . "</td>
                  <td>" . $row['mobile_phone'] . "</td>
                  <td>" . $row['phone'] . "</td>
                  <td>" . $row['login'] . "</td>
                  <td>" . $row['password'] . "</td>
                  </tr>";
         }
      }

      echo "</tbody></table></div>";
   } else {
      // Проверяем наличие данных в таблице department
      $query = "SELECT * FROM department";
      $result = mysqli_query($link, $query);

      // Вывод таблицы department
      if (mysqli_num_rows($result) > 0) {
         echo "<div class='container'><div class='table-responsive'><table id='myTable' class='table table-striped table-bordered'>
            <thead><tr><th>XML_ID</th>
                         <th>PARENT_XML_ID</th>
                         <th>NAME_DEPARTMENT</th>
                       </tr></thead><tbody>";

         while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr><td>" . $row['xml_id'] . "</td>
                  <td>" . $row['parent_xml_id'] . "</td>
                  <td>" . $row['name_department'] . "</td></tr>";
         }

         echo "</tbody></table></div></div>";
      } else {
         echo "<div class='container'><div class='row justify-content-center'>Пока таблицы не содержат данные</div></div>";
      }
   }
   // Закрываем соединение с БД
   mysqli_close($link);
}
