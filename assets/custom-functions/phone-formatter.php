<?php

function format_phone_number($number)
{
  // Смотрим, что номер содержит только цифры
  $number = preg_replace('/[^\d]/', '', $number);

  // Форматируем номер
  if (strlen($number) == 11) {
    return '+7 (' . substr($number, 1, 3) . ') ' . substr($number, 4, 3) . '-' . substr($number, 7, 2) . '-' . substr($number, 9, 2);
  }

  // Возвращаем исходный номер, если он не соответствует ожидаемой длине
  return $number;
}

?>