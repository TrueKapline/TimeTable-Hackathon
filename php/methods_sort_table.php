<?php

/* Подключаемые файлы php */
require "real_time_schedule.php";
require "time.php";
require "alteration_table.php";

/*
  Атрибуты сортировки:
  * table: номер_сортируемой_таблицы
  * 

  Возможные значения атрибутов:
  * номер_сортируемой_таблицы:
  * * 1 - таблица расписания семестра
  * * 2 - таблица мероприятий, проектов и переносов
  * * 3 - таблица реального времени(1 таблица корректируется под данные второй таблицы)
*/

/* Главный метод сортировки, который определяет,
  как сортировать расписание по входным данным запроса */
function sort_schedule($data) {
  $sort_schedule = output_table($data->table);
  return $sort_schedule;
}

/* Метод, который принимает на вход номер таблицы и возвращает эту таблицу в виде объекта */
function output_table($table) {
  switch ($table) {
    case 1:
      return $GLOBALS["schedule"];
      break;
    case 2:
      return $GLOBALS["queries"];
      break;
    case 3:
      return $GLOBALS["real_time_table"];
      break;
  }
}

/* Метод, который добавляет элемент в массив */
function adder(&$table, $elem) {
  $table[count($table)] = $elem;
}

/* Метод, который ищет пару по заданному id и возвращает её индекс, если не находят, возвращает -1 */
function search_id($table, $id) {
  for($i = 0; $i < count($table); $i++) {
    if($table[$i]->id === $id)
      return $i;
  }
  return -1;
}