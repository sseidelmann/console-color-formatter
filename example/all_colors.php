<?php

require_once realpath(dirname(__FILE__) . '/../vendor') . DIRECTORY_SEPARATOR . 'autoload.php';

if (PHP_SAPI !== 'cli') {
    die('only in cli');
}

$formatter = new \ConsoleColorFormatter\Formatter();

foreach (\ConsoleColorFormatter\Style::getAvailableBackgroundColors() as $bg) {
    foreach (\ConsoleColorFormatter\Style::getAvailableForegroundColors() as $fg) {
        echo str_pad(sprintf('<fg=%s;bg=%s>', $fg, $bg), 30, ' ', STR_PAD_RIGHT) . $formatter->format(sprintf('<fg=%s;bg=%s>  abcdefghijklmnopqrstuvwxyz  </>', $fg, $bg)) . PHP_EOL;
    }
}