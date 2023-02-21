<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/path.php";
require_once BASE_DIR . "/test/test.php";


/*
 * Страница для запуска тестов
 */


function printElement($value)
{
    echo '<pre>';
    print_r($value);
    echo '</pre>';
    echo '<br>';
}


function printArray($arr)
{
    foreach ($arr as $element) {
        printElement($element);
    }
}


function main() {
    $test = new Test();
    $resTest = $test->testAllCases();
    printElement($resTest);
}

main();