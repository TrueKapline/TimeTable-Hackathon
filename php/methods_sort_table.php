<?php

/* Подключаемые файлы php */
require "real_time_schedule.php";
require "time.php";

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
      return create_table_3();
      break;
  }
}

/* Метод, который создаёт таблицу под номер 3, исходя из данных 1 и 2 таблиц и возвращает её в виде объекта  */
function create_table_3() {
  $table_1 = output_table(1);
  $table_2 = output_table(2);
  $table_3 = [];

  for ($i = 0; $i < count($table_1); $i++) {
    $table_3[$i] = new real_time_schedule(0,
                                          $table_1[$i]->type-1,
                                          $table_1[$i]->id,
                                          $table_1[$i]->pair,
                                          $table_1[$i]->day,
                                          -1,
                                          fulldate_in_table_1($table_1[$i]->week_beginning,$table_1[$i]->day),
                                          $table_1[$i]->groups,
                                          $table_1[$i]->subgroup_number,
                                          $table_1[$i]->discipline,
                                          $table_1[$i]->teachers,
                                          $table_1[$i]->auditoriums,
                                          false,
                                          null,
                                          null);
  }

  return $table_3;
}
