<?php
/**
 * Завдання 6: Операції з чотиризначним числом
 *
 * Реалізуйте функції для роботи з чотиризначним числом (1000-9999).
 */

/**
 * Обчислює суму цифр числа
 *
 * @param int $number Чотиризначне число (1000-9999)
 * @return int Сума всіх цифр
 */
function sumOfDigits(int $number): int
{
    $sum = 0;
    while ($number > 0) {
        $sum += $number % 10;
        $number = (int)($number / 10);
    }
    return $sum;
}

/**
 * Обчислює добуток цифр числа
 *
 * @param int $number Чотиризначне число (1000-9999)
 * @return int Добуток всіх цифр
 */
function productOfDigits(int $number): int
{
    $product = 1;
    while ($number > 0) {
        $digit = $number % 10;
        $product *= $digit;
        $number = (int)($number / 10);
    }
    return $product;
}

/**
 * Повертає число в зворотному порядку
 *
 * @param int $number Чотиризначне число (1000-9999)
 * @return int Число з цифрами у зворотному порядку
 */
function reverseNumber(int $number): int
{
    $reversed = 0;
    while ($number > 0) {
        $reversed = $reversed * 10 + ($number % 10);
        $number = (int)($number / 10);
    }
    return $reversed;
}

/**
 * Повертає найбільше можливе число з цифр даного числа
 *
 * @param int $number Чотиризначне число (1000-9999)
 * @return int Найбільше число з тих самих цифр
 */
function maxFromDigits(int $number): int
{
    $digits = [];
    while ($number > 0) {
        $digits[] = $number % 10;
        $number = (int)($number / 10);
    }
    rsort($digits);
    $result = 0;
    foreach ($digits as $digit) {
        $result = $result * 10 + $digit;
    }
    return $result;
}
