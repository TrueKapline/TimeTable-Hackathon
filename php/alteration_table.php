<?php

/* Метод, который принимает на вход номер таблицы и возвращает эту таблицу в виде объекта */
function output_table($table, $date, $day_count) {
  switch ($table) {
    case 1:
      return json_decode(file_get_contents("../semester_schedule.json"));   // Расписание пар
      break;
    case 2:
      return json_decode(file_get_contents("../queries.json"));             // Расписание мероприятий, проектов, переносов
      break;
    case 3:
      return create_real_time_table($date, $day_count);                     // Раписания реального времени
      break;
  }
}

/* Метод, который создаёт таблицу, исходя из данных 1 и 2 таблиц и возвращает её  */
function create_real_time_table($date, $day_count) {
  $table_1 = output_table(1, null, null);
  $table_2 = output_table(2, null, null);
  $table_3 = [];
  
  while($day_count > 0) {
    $day = day($date);
    $week = week($date)%2 + 1;

    /* Создаём расписание начиная с указаной даты и с указанным количеством дней, согласно 1 таблице */
    for ($i = 0; $i < count($table_1); $i++) {
      if($table_1[$i]->day === $day && $table_1[$i]->week === $week) {
        $real_time_schedule = new real_time_schedule($table_1[$i]->type,
                                          $table_1[$i]->type_lessons,
                                          generateID($date, $table_1[$i]->id),
                                          $table_1[$i]->pair,
                                          $day,
                                          $week,
                                          $date,
                                          $table_1[$i]->groups,
                                          $table_1[$i]->subgroup_number,
                                          $table_1[$i]->title,
                                          $table_1[$i]->teachers,
                                          $table_1[$i]->auditories,
                                          $table_1[$i]->transfer_type,
                                          $table_1[$i]->id_family,
                                          $table_1[$i]->comment);
        adder($table_3, $real_time_schedule);   
      }
    }

    /* Добавляем данные из 2 таблицы в 3, если соответсвует указанной дате и количеству дней*/
    for ($i = 0; $i < count($table_2); $i++) {
      /* Для мероприятий и проектов */
      if ($table_2[$i]->type < 3 && $table_2[$i]->dt === $date) {
        $real_time_schedule = new real_time_schedule($table_2[$i]->type+1,
                                            null,
                                            $table_2[$i]->id,
                                            $table_2[$i]->pair,
                                            day($table_2[$i]->dt),
                                            week($table_2[$i]->dt)%2 + 1,
                                            $table_2[$i]->dt,
                                            $table_2[$i]->groups,
                                            null,
                                            $table_2[$i]->description,
                                            $table_2[$i]->teachers,
                                            $table_2[$i]->auditories,
                                            0,
                                            null,
                                            null);
        adder($table_3, $real_time_schedule);
      }
      /* Для пары, которая переносится с данной даты */
      elseif($table_2[$i]->type === 3 && $table_2[$i]->dt === $date) {
        $s_id = search_id($table_3, $table_2[$i]->affected_schedule_id);

        if($s_id != -1) {
          $table_3[$s_id]->transfer_type = 1;
          $table_3[$s_id]->id_family[0] = $table_3[$s_id]->id;
          $table_3[$s_id]->id_family[1] = $table_2[search_id($table_2, $table_2[$i]->related_queries[1])]->affected_schedule_id;
          $table_3[$s_id]->comment = $table_2[$i]->description;
        }
      } 
      /* Для пары, которая переносится на данную дату */
      elseif($table_2[$i]->type === 4 && $table_2[$i]->dt === $date) {
        $s_id = search_id($table_3, $table_2[search_id($table_2, $table_2[$i]->related_queries[1])]->affected_schedule_id);
        $array = [];
        $array[0] = $table_2[$i]->affected_schedule_id;
        $array[1] = $table_2[search_id($table_2, $table_2[$i]->related_queries[1])]->affected_schedule_id;

        $real_time_schedule = new real_time_schedule($table_3[$s_id]->type,
                                          $table_3[$s_id]->type_lessons,
                                          $table_2[$i]->affected_schedule_id,
                                          $table_2[$i]->pair,
                                          day($table_2[$i]->dt),
                                          week($table_2[$i]->dt)%2 + 1,
                                          $table_2[$i]->dt,
                                          $table_2[$i]->groups,
                                          $table_3[$s_id]->subgroup_number,
                                          $table_3[$s_id]->title,
                                          $table_2[$i]->teachers,
                                          $table_2[$i]->auditories,
                                          2,
                                          $array,
                                          $table_2[$i]->description);
        adder($table_3, $real_time_schedule); 
      }
    }

    $date = fulldate_date_p_day($date, 2);
    $day_count--;
  }

  return $table_3;
}

/* Метод, который добавляет элемент в массив */
function adder(&$table, $elem) {
  $table[count($table)] = $elem;
}

/* Метод, который генерирует id пары согласно её дате и начального id*/
function generateID($date, $id) {
  $array = explode("-", $date);
  return (int)($array[0] . $array[1] . $array[2] . $id);
}