<?php
/* Тип возвращаемого контента(json) */
header("Content-type: json/application");
/* Запрос к файлу доступен с любого устройства */
//header("Access-Control-Allow-Origin:•*");

/* Подключаемые файлы php */
require "error_catcher.php";
require "methods_sort_table.php";

/* Подгружаемые данные при вызове файла */
$method = $_SERVER["REQUEST_METHOD"];                                     // Метод пришедшего запроса(GET, POST)
$data = json_decode(file_get_contents("php://input"));              // Данные с пришедшего запроса в виде json
$schedule = json_decode(file_get_contents("../schedule.json"));     // Расписание пар в json
$queries = json_decode(file_get_contents("../queries.json"));       // Расписание мероприятий, проектов, переносов в js>

/* Если произойдёт ошибка, то мы вернём описание ошибки и завершим программу */
error_catcher(json_last_error());

/* Проверка на метод запроса(GET, POST) */
switch ($method) {
  case "GET":
    echo json_encode("GET запрос не обрабатывается", JSON_UNESCAPED_UNICODE);
    break;
  case "POST":
    echo sort_schedule($data);
    break;
}

