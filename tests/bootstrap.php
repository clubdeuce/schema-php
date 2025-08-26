<?php
// PHPUnit bootstrap for this project
// Loads Composer autoloader and the custom base test class

$composerAutoload = __DIR__ . '/../vendor/autoload.php';
if (file_exists($composerAutoload)) {
    require $composerAutoload;
}

$testCasePath = __DIR__ . '/includes/testCase.php';
if (file_exists($testCasePath)) {
    require $testCasePath;
}
