<?php

/* PHP работа со строками(помощь)
  mb_strlen($text); - возвращает количество символов
  mb_strpos($text, искомая_строка); - возвращает индекс первого символа искомой строки
  mb_substr($text, индекс_первого_символа(i), количество_возвращаемых_символов(k)); - возвращает строку символов с индексами от i до k-1
  explode(разделитель, входящая_строка); - возвращает массив строк, разделённых разделителем
*/

/* Метод, который принимает в качестве аргумента дату год-месяц-день_начала и количество дней, 
  а возращает полную дату год-месяц-день */
function fulldate_date_p_day($date, $day) {
  $array = explode("-", $date);
  $array[0] = (int)$array[0];
  $array[1] = (int)$array[1];
  $sum_day = (int)$array[2] + (int)$day - 1;
  return date("Y-m-d", mktime(0, 0, 0, $array[1], $sum_day, $array[0]));
}

/* Метод, который принимает в качестве аргумента дату год-месяц-день,
  а возвращает номер недели с 1970 года(12 января - понедельник) по входящую дату */
function week($date) {
  $array = explode("-", $date);
  $array[0] = (int)$array[0];
  $array[1] = (int)$array[1];
  $array[2] = (int)$array[2];
  return (int)((mktime(0, 0, 0, $array[1], $array[2], $array[0]) - mktime(0, 0, 0, 1, 12, 1970))/604800);
}

/* Метод, который возвращает день недели по входящей дате */
function day($date) {
  $array = explode("-", $date);
  $array[0] = (int)$array[0];
  $array[1] = (int)$array[1];
  $array[2] = (int)$array[2];
  $array1 = explode("-", date("Y-m-d",week($date)*604800+11*86400));
  $array1[0] = (int)$array1[0];
  $array1[1] = (int)$array1[1];
  $array1[2] = (int)$array1[2];
  return (int)((mktime(0, 0, 0, $array[1], $array[2], $array[0]) - mktime(0, 0, 0, $array1[1], $array1[2], $array1[0]))/86400) + 1;
}
