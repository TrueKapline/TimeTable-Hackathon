<?php

/* Класс, от которого образуются экземпляры таблицы номер 3 */
class real_time_schedule {
  public $type;                 // Тип пары: 0 - занятие, 1 - мероприятие, 2 - проект
  public $type_lessons;         // Тип занятия: null - если это не занятие, 0 - лекция, 1 - практика, 2 - лаба
  public $id;                   // ID пары
  public $pair;                 // Номер пары по счёту: от 1 до 8
  public $day;                  // День пары: от 1 до 7
  public $week;                 // Неделя: считается от начала учебного года(1 сентября)
  public $date;                 // Полная дата пары: вид "год-месяц-день"
  public $groups = [];          // Группы, которые должны присутствовать на паре
  public $subgroup_number;      // Номер группы(если type 0 и type_lessons 2): 1 - первая подгруппа, 2 - вторая подгруппа
  public $title;                // Название пары
  public $teachers = [];        // Учителя, которые будут вести пару
  public $auditories = [];      // Аудитории, которые задействованы для занятия
  public $transfer_type;        // Тип переноса пары: 0 - статическая пар, 1 - пару перенесли с этой даты, 2 - пару перенесли на эту дату, 3 - пару удалили, 4 - пару добавили
  public $id_family = [];       // ID пары, которая была перенесена
  public $comment;              // Комментарий к паре

  /* Конструктор со всеми параметрами */
  public function __construct($type, $type_lessons, $id, $pair, $day, $week, $date, $groups, $subgroup_number,
                              $title, $teachers, $auditories, $transfer_type, $id_family, $comment) {
    $this->type = $type;
    $this->type_lessons = $type_lessons;
    $this->id = $id;
    $this->pair = $pair;
    $this->day = $day;
    $this->week = $week;
    $this->date = $date;
    $this->groups = $groups;
    $this->subgroup_number = $subgroup_number;
    $this->title = $title;
    $this->teachers = $teachers;
    $this->auditories = $auditories;
    $this->transfer_type = $transfer_type;
    $this->id_family = $id_family;
    $this->comment = $comment;
  }
}