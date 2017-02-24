<?php

require_once realpath(dirname(__FILE__) . '/../vendor') . DIRECTORY_SEPARATOR . 'autoload.php';

if (PHP_SAPI !== 'cli') {
    die('only in cli');
}

$formatter = new \ConsoleColorFormatter\Formatter();

foreach (\ConsoleColorFormatter\Style::getAvailableBackgroundColors() as $bg) {
    foreach (\ConsoleColorFormatter\Style::getAvailableForegroundColors() as $fg) {
        echo str_pad(sprintf('<fg=%s;bg=%s>', $fg, $bg), 40, ' ', STR_PAD_RIGHT) . $formatter->format(sprintf('<fg=%s;bg=%s>  abcdefghijklmnopqrstuvwxyz  </>', $fg, $bg)) . PHP_EOL;
    }
    echo PHP_EOL;
}

foreach (\ConsoleColorFormatter\Style::getAvailableOptions() as $option) {
    echo str_pad(sprintf('<options=%s>', $option), 40, ' ', STR_PAD_RIGHT);

    foreach (\ConsoleColorFormatter\Style::getAvailableForegroundColors() as $fg) {
        echo $formatter->format(sprintf('  <fg=%s;options=%s>%s</>', $fg, $option, $fg));
    }

    echo PHP_EOL;
}

echo PHP_EOL;
$availableOptions = \ConsoleColorFormatter\Style::getAvailableOptions();
foreach ($availableOptions as $option) {

    do {
        $secondOption = $availableOptions[rand(0, count($availableOptions) - 1)];
    } while ($secondOption == $option);

    echo str_pad(sprintf('<options=%s,%s>', $option, $secondOption), 40, ' ', STR_PAD_RIGHT);

    foreach (\ConsoleColorFormatter\Style::getAvailableForegroundColors() as $fg) {
        echo $formatter->format(sprintf('  <fg=%s;options=%s,%s>%s</>', $fg, $option, $secondOption, $fg));
    }

    echo PHP_EOL;
}