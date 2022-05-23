<?php

/* Подключаемые файлы php */
require "real_time_schedule.php";
require "time.php";
require "alteration_table.php";

/*
  Атрибуты сортировки:
  * table: номер_сортируемой_таблицы
  * date: дата_начала
  * day_count: количество_дней
  * pair_number: номер_пары 
  * type_sort: тип_сортировки
  * output: заданный_атрибут_вывода
  * output_key: ключ_вывода
  * type: тип_пары
  * type_lessons: тип_занятия
  * subgroup_number: номер_подгруппы

  Возможные значения атрибутов:
  * {номер_сортируемой_таблицы}:
  - Тип таблицы, с которой вы хотим работать
  * * 1 - таблица расписания семестра
  * * 2 - таблица мероприятий, проектов и переносов
  * * 3 - таблица реального времени(1 таблица корректируется под данные 2 таблицы)
  * {дата_начала}:
  - Дата, начиная с которой будет возвращаться расписание
  * * "год-месяц-день" - формат входящего значения
  * {количество_дней}:
  - Количество дней, которое мы хотим вернуть, начиная с указанной даты
  * * количество - целочисленное число от 1
  * {номер_пары}:
  - Номер пары, которую мы хотим получить
  * * номер - целочисленное число от 0 до 8; 0 - если хотим вернуть все пары в дне
  * {тип_сортировки}:
  - Тип сортировки, которую мы хотим применить к запрашиваемым данным
  * * null - сортировка не нужна
  * * "date" - сортировать по дате
  * * "groups" - сортировать по группам
  * * "teachers" - сортировать по преподавателям
  * * "auditories" - сортировать по аудитории
  * {заданный_атрибут_вывода}:
  - Атрибут, который будет фильтровать данные(Например вывести пары только с заданным учителем или для данной группы)
  * * null - фильтра не будет, выведет всё
  * * "groups" - выведет только пары только для заданной группы
  * * "teachers" - выведет только пары только с заданным учителем
  * * "auditories" - выведет только пары с заданной аудиторией
  * {ключ_вывода}:
  - Ключевое слово для заданного фильтра(например если задали "teachers", то ключевое слово может быть "Иван Иванович")
  * * ключевое слово - слово, по которому будет происходить фильтр
  * {тип_пары}:
  - Тип пар, которые мы хотим получить
  * * null - все типы пар
  * * 0 - только занятия
  * * 1 - только мероприятия
  * * 2 - только проекты
  * {тип_занятия}:
  - Тип занятия, если задали тип пары занятие
  * * null - если тип пары не занятие или хотим вывести все типы занятий
  * * 0 - лекция
  * * 1 - практика
  * * 2 - лабораторная
  * {номер_подгруппы}:
  - Номер подгруппы, если задали тип занятия лабораторная
  * * null - если тип занятия не лаборатная
  * * 1 - первая подгруппа
  * * 2 - вторая подгруппа
*/

/* Главный метод сортировки, который определяет,
  как сортировать расписание по входным данным запроса */
function sort_schedule($data) {
  $sort_schedule = output_table($data->table);
  
  table_correct_date($sort_schedule, $data->date, $data->day_count);
  table_correct_pair($sort_schedule, $data->pair_number);
  table_correct_keys($sort_schedule, $data->output, $data->output_key);
  table_correct_type($sort_schedule, $data->type);
  table_correct_type_lessons($sort_schedule, $data->type_lessons);
  table_correct_subgroup_number($sort_schedule, $data->subgroup_number);
  table_sort($sort_schedule, $data->type_sort);

  return $sort_schedule;
}

/* Метод, который оставляет в таблице только даты начиная с заданной даты с заданным количеством дней */
function table_correct_date(&$table, $date, $day_count) {
  if ($date == null || $day_count == null) return $table;

  $date_end = fulldate_date_p_day($date, $day_count);
  $size_table = count($table);

  for($i = 0; $i < $size_table; $i++) {
    if(strcmp($table[$i]->date, $date) < 0 || strcmp($table[$i]->date, $date_end) > 0) {
      unset($table[$i]);
    }
  }

  $table = array_values($table);
}

/* Метод, который оставляет в таблице дни только с заданным номером пар  */
function table_correct_pair(&$table, $pair_number) {
  if ($pair_number == null || $pair_number === 0) return $table;

  $size_table = count($table);

  for($i = 0; $i < $size_table; $i++) {
    if($table[$i]->pair != $pair_number) {
      unset($table[$i]);
    }
  }

  $table = array_values($table);
}

/* Метод, который сортирует таблицу с заданным типом сортировки */
function table_sort(&$table, $type_sort) {
  if ($type_sort == null) return $table;

  switch ($type_sort) {
    case "date":
      date_sort($table);
      break;
    case "groups":
      break;
    case "teachers":
      break;
    case "auditories":
      break;
  }
}

/* Метод, который оставляет в таблице пары только с заданными ключами */
function table_correct_keys(&$table, $output, $output_key) {
  if ($output == null || $output_key == null) return $table;
  
  $size_table = count($table);
  $search = false;

  if ($output === "groups") {
    for($i = 0; $i < $size_table; $i++) {
      for($j = 0; $j < count($table[$i]->groups); $j++) {
        if($table[$i]->groups[$j] === $output_key) $search = true;
      }
      if($search === false) unset($table[$i]);
      $search = false;
    }
  } elseif ($output === "teachers") {
    for($i = 0; $i < $size_table; $i++) {
      for($j = 0; $j < count($table[$i]->teachers); $j++) {
        if($table[$i]->teachers[$j] === $output_key) $search = true;
      }
      if($search === false) unset($table[$i]);
      $search = false;
    }
  } elseif ($output === "auditories") {
    for($i = 0; $i < $size_table; $i++) {
      for($j = 0; $j < count($table[$i]->auditories); $j++) {
        if($table[$i]->auditories[$j] === $output_key) $search = true;
      }
      if($search === false) unset($table[$i]);
      $search = false;
    }
  }

  $table = array_values($table);
}

/* Метод, который оставляет в таблице пары только с заданным типом */
function table_correct_type(&$table, $type) {
  if ($type == null) return $table;

  $size_table = count($table);

  for($i = 0; $i < $size_table; $i++) {
    if($table[$i]->type != $type) {
      unset($table[$i]);
    }
  }

  $table = array_values($table);
}

/* Метод, который оставляет в таблице пары только с заданным типом занятия */
function table_correct_type_lessons(&$table, $type_lessons) {
  if ($type_lessons == null) return $table;

  $size_table = count($table);

  for($i = 0; $i < $size_table; $i++) {
    if($table[$i]->type_lessons != $type_lessons) {
      unset($table[$i]);
    }
  }

  $table = array_values($table);
}

/* Метод, который оставляет в таблице занятия лабораторные только с заданным номером группы*/
function table_correct_subgroup_number(&$table, $subgroup_number) {
  if ($subgroup_number == null) return $table;

  $size_table = count($table);

  for($i = 0; $i < $size_table; $i++) {
    if($table[$i]->subgroup_number != $subgroup_number) {
      unset($table[$i]);
    }
  }

  $table = array_values($table);
}

/* Метод, который сортирует таблицу по дате */
function date_sort(&$table) {
  $count = 0;
  
  while($count < count($table)-1) {
    if( strcmp($table[$count]->date, $table[$count+1]->date) > 0 ||
        strcmp($table[$count]->date, $table[$count+1]->date) === 0 && $table[$count]->pair > $table[$count+1]->pair) {
      $swap = $table[$count];
      $table[$count] = $table[$count+1];
      $table[$count+1] = $swap;

      $count = -1;
    }

    $count++;
  }
}

/* Метод, который сортирует таблицу по группам */
function groups_sort(&$table) {
  $count = 0;
  
}

/* Метод, который ищет пару по заданному id и возвращает её индекс, если не находят, возвращает -1 */
function search_id($table, $id) {
  for($i = 0; $i < count($table); $i++) {
    if($table[$i]->id === $id)
      return $i;
  }
  return -1;
}