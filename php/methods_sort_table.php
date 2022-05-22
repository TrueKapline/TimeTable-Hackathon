<?php

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
  return create_table_3();
  return json_encode($sort_schedule, JSON_UNESCAPED_UNICODE);
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
      return "Таблица номер 3 ещё не создана";
      break;
  }
}

/* Метод, который создаёт таблицу под номер 3, исходя из данных 1 и 2 таблиц и возвращает её в виде объекта  */
function create_table_3() {
  $table_1 = output_table(1);
  $table_2 = output_table(2);
  return $table_1[0];
}