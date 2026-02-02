<?php
/**
 * Завдання 5: Парне/Непарне число (switch)
 *
 * Реалізуйте функцію, яка визначає чи є цифра (0-9) парною чи непарною.
 *
 * Парні цифри: 0, 2, 4, 6, 8
 * Непарні цифри: 1, 3, 5, 7, 9
 *
 * @param int $digit Цифра (0-9)
 * @return string "парна" або "непарна"
 */
function isEvenOrOdd(int $digit): string
{
    switch ($digit) {
        case 0:
        case 2:
        case 4:
        case 6:
        case 8:
            return "парна";
        case 1:
        case 3:
        case 5:
        case 7:
        case 9:
            return "непарна";
        default:
            return "";
    }
}
