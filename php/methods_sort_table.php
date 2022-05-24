<?php

/* Подключаемые файлы php */
require "real_time_schedule.php";
require "time.php";
require "alteration_table.php";

/*
  Атрибуты сортировки:
  * table: номер_сортируемой_таблицы
  ---Только для 3 таблицы---
  * date: дата_начала
  * day_count: количество_дней
  * pair_number: номер_пары 
  * type_sort: тип_сортировки
  * output: [заданный_атрибут_вывода_1, заданный_атрибут_вывода_2, ...]
  * output_key: [ключ_вывода_1, ключ_вывода_2, ...]
  * type: тип_пары
  * type_lessons: тип_занятия
  * subgroup_number: номер_подгруппы
  * delete_pair: выводить_ли_удалённые_пары(null - true)
  * search: текст_поиска
  * search_type: тип_поиска
  ---Только для 3 таблицы---

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
  * * "groups" - сортировать по группам по названиям (!!! разработаю по надобности, не работает)
  * * "teachers" - сортировать по преподавателям по именам (!!! разработаю по надобности, не работает)
  * * "auditories" - сортировать по аудитории по названиям (!!! разработаю по надобности, не работает)
  * * "events" - сортировать по мероприятиям по названиям (!!! разработаю по надобности, не работает)
  * * "project" - сортировать по проектам по названиям (!!! разработаю по надобности, не работает)
  * {заданный_атрибут_вывода}:
  - Атрибут, который будет фильтровать данные(Например вывести пары только с заданным учителем или для данной группы)
  * * null - фильтра не будет, выведет всё
  * * "groups" - выведет только пары только для заданной группы
  * * "teachers" - выведет только пары только с заданным учителем
  * * "auditories" - выведет только пары с заданной аудиторией
  * * "events" - выведет только пары с заданным мероприятием
  * * "projects" - выведет только пары с заданным проектом
  * * "title" - выведет только пары с заданным названием
  * * "lesson" - выведет только пары с заданным занятием
  * * "lecture" - выведет только пары с заданной лекцией
  * * "practice" - выведет только пары с заданной практикой
  * * "laboratory" - выведет только пары с заданной лабораторной
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
  * {выводить_ли_удалённые_пары}:
  - Нужно ли выводить удалённые или перенесённые пары
  * * true - да
  * * false - нет
  * {текст_поиска}:
  - По этому тексту поиска сортируется расписание
  * * строка - обычная стрик строка с буковками
  * {тип_поиска}:
  - Какие параметры мы будем подвергать поиску
  * * null - поиск по всему
  * * title - поиск по названию
*/

/* Главный метод сортировки, который определяет,
  как сортировать расписание по входным данным запроса */
function sort_schedule($data) {
  $sort_schedule = output_table($data->table, $data->date, $data->day_count);
  
  table_correct_date($sort_schedule, $data->date, $data->day_count);
  table_correct_pair($sort_schedule, $data->pair_number);
  for($i = 0; $i < count($data->output); $i++)
    table_correct_keys($sort_schedule, $data->output[$i], $data->output_key[$i]);
  table_correct_type($sort_schedule, $data->type);
  table_correct_type_lessons($sort_schedule, $data->type_lessons);
  table_correct_subgroup_number($sort_schedule, $data->subgroup_number);
  table_correct_delete_pair($sort_schedule, $data->delete_pair);
  table_search($sort_schedule, $data->search, $data->search_type);
  table_sort($sort_schedule, $data->type_sort);

  return $sort_schedule;
}

/* Метод, который оставляет в таблице только даты начиная с заданной даты с заданным количеством дней */
function table_correct_date(&$table, $date, $day_count) {
  if ($date === null || $day_count === null) return $table;

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
  if ($pair_number === null || $pair_number === 0) return $table;

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
  if ($output === null || $output_key === null) return $table;
  
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
  } elseif ($output === "events") {
    for($i = 0; $i < $size_table; $i++) {
      if($table[$i]->title != $output_key || $table[$i]->type != 1) {
        unset($table[$i]);
      }
    }
  } elseif ($output === "projects") {
    for($i = 0; $i < $size_table; $i++) {
      if($table[$i]->title != $output_key || $table[$i]->type != 2) {
        unset($table[$i]);
      }
    }
  } elseif ($output === "title") {
    for($i = 0; $i < $size_table; $i++) {
      if($table[$i]->title != $output_key) {
        unset($table[$i]);
      }
    }
  } elseif ($output === "lesson") {
    for($i = 0; $i < $size_table; $i++) {
      if($table[$i]->title != $output_key || $table[$i]->type != 0) {
        unset($table[$i]);
      }
    }
  } elseif ($output === "lecture") {
    for($i = 0; $i < $size_table; $i++) {
      if($table[$i]->title != $output_key || $table[$i]->type != 0 || $table[$i]->type_lesson != 0) {
        unset($table[$i]);
      }
    }
  } elseif ($output === "practice") {
    for($i = 0; $i < $size_table; $i++) {
      if($table[$i]->title != $output_key || $table[$i]->type != 0 || $table[$i]->type_lesson != 1) {
        unset($table[$i]);
      }
    }
  } elseif ($output === "laboratory") {
    for($i = 0; $i < $size_table; $i++) {
      if($table[$i]->title != $output_key || $table[$i]->type != 0 || $table[$i]->type_lesson != 2) {
        unset($table[$i]);
      }
    }
  }

  $table = array_values($table);
}

/* Метод, который оставляет в таблице пары только с заданным типом */
function table_correct_type(&$table, $type) {
  if ($type === null) return $table;

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
  if ($type_lessons === null) return $table;

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
  if ($subgroup_number === null) return $table;

  $size_table = count($table);

  for($i = 0; $i < $size_table; $i++) {
    if($table[$i]->subgroup_number != $subgroup_number) {
      unset($table[$i]);
    }
  }

  $table = array_values($table);
}

function table_correct_delete_pair(&$table, $delete_pair) {
  if ($delete_pair === null) return $table;

  $size_table = count($table);

  for($i = 0; $i < $size_table; $i++) {
    if($table[$i]->transfer_type === 1 || $table[$i]->transfer_type === 3) {
      unset($table[$i]);
    }
  }

  $table = array_values($table);
}

/* Метод, который делает поиск по входящей строке в таблице и возвращает таблицу с подходящим условием */
function table_search(&$table, $search, $search_type) {
  if ($search === null) return $table;

  $size_table = count($table);

  if ($search_type === "title") {
    for($i = 0; $i < $size_table; $i++) {
      if(mb_stripos($table[$i]->title, $search) === false) {
        unset($table[$i]);
      }
    }
  } elseif ($search_type === null) {
    for($i = 0; $i < $size_table; $i++) {
      
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