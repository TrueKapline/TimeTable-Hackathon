<?php

/* Метод, который проверяет на наличие ошибок во время json_decode
  если ошибка произошла, то возвращает описание ошибки и выходит из программы */
function error_catcher($json_last_error) {
  /* Ловим возможные ошибки при json_decode */
  switch ($json_last_error) {
    case JSON_ERROR_NONE:
      $data_error = '';
      break;
    case JSON_ERROR_DEPTH:
      $data_error = 'Достигнута максимальная глубина стека';
      break;
    case JSON_ERROR_STATE_MISMATCH:
      $data_error = 'Неверный или не корректный JSON';
      break;
    case JSON_ERROR_CTRL_CHAR:
      $data_error = 'Ошибка управляющего символа, возможно неверная кодировка';
      break;
    case JSON_ERROR_SYNTAX:
      $data_error = 'Синтаксическая ошибка';
      break;
    case JSON_ERROR_UTF8:
      $data_error = 'Некорректные символы UTF-8, возможно неверная кодировка';
      break;
    default:
      $data_error = 'Неизвестная ошибка';
      break;
  }
  /* Если есть ошибка, то возвращаем её и выходим */
  if($data_error !='') {
    echo $data_error;
    exit;
  }
}