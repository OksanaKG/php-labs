<?php
/**
 * Automated test for v3 Cinema RegformController validation.
 * Run: php test_validation.php
 */

require_once __DIR__ . '/config/init.php';

$controller = new RegformController();
$validate = new ReflectionMethod($controller, 'validate');
if (PHP_VERSION_ID < 80100) {
    $validate->setAccessible(true);
}

$tests = [
    ['name' => 'Empty name', 'data' => ['name' => '', 'gender' => 'male', 'day' => '15', 'month' => '6', 'year' => '2000'], 'expectKey' => 'name'],
    ['name' => 'Empty gender', 'data' => ['name' => 'Ivan', 'gender' => '', 'day' => '15', 'month' => '6', 'year' => '2000'], 'expectKey' => 'gender'],
    ['name' => 'Invalid gender', 'data' => ['name' => 'Ivan', 'gender' => 'other', 'day' => '15', 'month' => '6', 'year' => '2000'], 'expectKey' => 'gender'],
    ['name' => 'Invalid day (too high)', 'data' => ['name' => 'Ivan', 'gender' => 'male', 'day' => '32', 'month' => '6', 'year' => '2000'], 'expectKey' => 'birthdate'],
    ['name' => 'Invalid day (zero)', 'data' => ['name' => 'Ivan', 'gender' => 'male', 'day' => '0', 'month' => '6', 'year' => '2000'], 'expectKey' => 'birthdate'],
    ['name' => 'Invalid month (too high)', 'data' => ['name' => 'Ivan', 'gender' => 'male', 'day' => '15', 'month' => '13', 'year' => '2000'], 'expectKey' => 'birthdate'],
    ['name' => 'Invalid month (zero)', 'data' => ['name' => 'Ivan', 'gender' => 'male', 'day' => '15', 'month' => '0', 'year' => '2000'], 'expectKey' => 'birthdate'],
    ['name' => 'Male age too young (20)', 'data' => ['name' => 'Ivan', 'gender' => 'male', 'day' => '15', 'month' => '6', 'year' => intval(date('Y')) - 20], 'expectKey' => 'birthdate', 'expectContains' => 'вікове обмеження'],
    ['name' => 'Female age too young (17)', 'data' => ['name' => 'Nina', 'gender' => 'female', 'day' => '15', 'month' => '6', 'year' => intval(date('Y')) - 17], 'expectKey' => 'birthdate', 'expectContains' => 'вікове обмеження'],
    ['name' => 'All valid (male 21)', 'data' => ['name' => 'Ivan', 'gender' => 'male', 'day' => '15', 'month' => '6', 'year' => intval(date('Y')) - 21], 'expectEmpty' => true],
    ['name' => 'All valid (female 18)', 'data' => ['name' => 'Nina', 'gender' => 'female', 'day' => '15', 'month' => '6', 'year' => intval(date('Y')) - 18], 'expectEmpty' => true],
];

$passed = 0;
$failed = 0;

foreach ($tests as $test) {
    $errors = $validate->invoke($controller, $test['data']);

    if (!empty($test['expectEmpty'])) {
        if (empty($errors)) {
            echo "PASS: {$test['name']}\n";
            $passed++;
        } else {
            echo "FAIL: {$test['name']} — expected no errors, got: " . json_encode($errors, JSON_UNESCAPED_UNICODE) . "\n";
            $failed++;
        }
    } else {
        $key = $test['expectKey'];
        if (!isset($errors[$key])) {
            echo "FAIL: {$test['name']} — expected error for '{$key}', got: " . json_encode($errors, JSON_UNESCAPED_UNICODE) . "\n";
            $failed++;
        } elseif (!empty($test['expectContains']) && strpos($errors[$key], $test['expectContains']) === false) {
            echo "FAIL: {$test['name']} — expected '{$test['expectContains']}' in error, got: {$errors[$key]}\n";
            $failed++;
        } else {
            echo "PASS: {$test['name']}\n";
            $passed++;
        }
    }
}

$total = $passed + $failed;
echo "\n{$passed}/{$total} tests passed.\n";

if ($failed > 0) {
    exit(1);
}
