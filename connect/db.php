<?php
$host =  "localhost";
$username = "root";
$password = "";
$dbname = "b1_testing";

// Открываем соединение с БД
$link = mysqli_connect($host, $username, $password, $dbname) or die('Невозможно поключиться к MySql Server:' . mysqli_error($link));
