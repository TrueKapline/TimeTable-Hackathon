<?php

/* Метод, который создаёт таблицу под номер 3, исходя из данных 1 и 2 таблиц и перезаписывает в файл real_time_table.json  */
function create_table_3() {
  $table_1 = output_table(1);
  $table_2 = output_table(2);
  $table_3 = [];

  /* Добавляем данные из 1 таблицы в 3 */
  for ($i = 0; $i < count($table_1); $i++) {
    $real_time_schedule = new real_time_schedule(0,
                                          $table_1[$i]->type-1,
                                          $table_1[$i]->id,
                                          $table_1[$i]->pair,
                                          $table_1[$i]->day,
                                          week($table_1[$i]->week_beginning),
                                          fulldate_in_table_1($table_1[$i]->week_beginning,$table_1[$i]->day),
                                          $table_1[$i]->groups,
                                          $table_1[$i]->subgroup_number,
                                          $table_1[$i]->discipline,
                                          $table_1[$i]->teachers,
                                          $table_1[$i]->auditoriums,
                                          false,
                                          null,
                                          null);
    adder($table_3, $real_time_schedule);
  }

  /* Добавляем данные из 2 таблицы в 3 */
  for ($i = 0; $i < count($table_2); $i++) {
    /* Для мероприятий и проектов */
    if ($table_2[$i]->type < 3) {
      $real_time_schedule = new real_time_schedule($table_2[$i]->type+1,
                                            null,
                                            $table_2[$i]->id,
                                            $table_2[$i]->pair,
                                            day($table_2[$i]->dt),
                                            week($table_2[$i]->dt),
                                            $table_2[$i]->dt,
                                            $table_2[$i]->groups,
                                            null,
                                            $table_2[$i]->description,
                                            $table_2[$i]->teachers,
                                            $table_2[$i]->auditoriums,
                                            false,
                                            null,
                                            null);
      adder($table_3, $real_time_schedule);
    }
    /* Для переносов пар */
    elseif(search_id($table_3, $table_2[$i]->affected_schedule_id) != -1 && $table_2[$i]->type === 4) {
      $s_id = search_id($table_3, $table_2[$i]->affected_schedule_id);

      $table_3[$s_id]->day = day($table_2[$i]->dt);
      $table_3[$s_id]->week = week($table_2[$i]->dt);
      $table_3[$s_id]->date = $table_2[$i]->dt;
      $table_3[$s_id]->pair = $table_2[$i]->pair;
      $table_3[$s_id]->groups = $table_2[$i]->groups;
      $table_3[$s_id]->teachers = $table_2[$i]->teachers;
      $table_3[$s_id]->auditories = $table_2[$i]->auditoriums;
      $table_3[$s_id]->related_queries = $table_2[$i]->related_queries;
      $table_3[$s_id]->transfer = true;
      $table_3[$s_id]->comment = $table_2[$i]->description;
    } 
  }

  file_put_contents("../real_time_table.json", json_encode($table_3, JSON_UNESCAPED_UNICODE));
}