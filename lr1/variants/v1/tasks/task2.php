<?php
/**
 * Завдання 2: Виведення форматованого тексту
 *
 * Реалізуйте функцію, яка генерує HTML з віршем.
 *
 * Вірш:
 * Я люблю свій край, свій рідний дім,
 * Де сонце сходить золотим,
 * Де річка тихо так тече,
 *     І серце
 *         радісно
 *             б'ється…
 *
 * Вимоги:
 * - Слово "край" — жирним (<b>)
 * - Слово "золотим" — курсивом (<i>)
 * - Кожен рядок в окремому <p>
 * - Останні 3 рядки ("І серце", "радісно", "б'ється…") з прогресивними відступами
 *
 * @return string HTML-код вірша
 */
function generatePoem(): string
{
    // TODO: Реалізуйте цю функцію
    // Поверніть HTML-код з віршем та форматуванням
    return ""; // Замініть це на правильну реалізацію
}

/**
 * Перевіряє чи містить HTML жирний текст
 *
 * @param string $html HTML-код
 * @param string $text Текст що має бути жирним
 * @return bool
 */
function hasBoldText(string $html, string $text): bool
{
    return strpos($html, "<b>$text</b>") !== false;
}

/**
 * Перевіряє чи містить HTML курсивний текст
 *
 * @param string $html HTML-код
 * @param string $text Текст що має бути курсивом
 * @return bool
 */
function hasItalicText(string $html, string $text): bool
{
    return strpos($html, "<i>$text</i>") !== false;
}
