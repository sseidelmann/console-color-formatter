<?php
/**
 * Class Console
 * @package ConsoleColorFormatter
 * @author Sebastian Seidelmann <sebastian.seidelmann@wfp2.com>, wfp:2 GmbH & Co. KG
 */

namespace ConsoleColorFormatter;

/**
 * Class Console
 * @package ConsoleColorFormatter
 * @author Sebastian Seidelmann <sebastian.seidelmann@wfp2.com>, wfp:2 GmbH & Co. KG
 */
class Formatter
{
    /**
     * Save the styles.
     * @var array
     */
    private $styles = [
        'black'     => '0;30m',
        'red'       => '0;31m',
        'green'     => '0;32m',
        'yellow'    => '0;33m',
        'blue'      => '0;34m',
        'purple'    => '0;35m',
        'cyan'      => '0;36m',
        'white'     => '0;37m',

        'blackB'    => '1;30m',
        'redB'      => '1;31m',
        'greenB'    => '1;32m',
        'yellowB'   => '1;33m',
        'blueB'     => '1;34m',
        'purpleB'   => '1;35m',
        'cyanB'     => '1;36m',
        'whiteB'    => '1;37m',

        'blackU'    => '4;30m',
        'redU'      => '4;31m',
        'greenU'    => '4;32m',
        'yellowU'   => '4;33m',
        'blueU'     => '4;34m',
        'purpleU'   => '4;35m',
        'cyanU'     => '4;36m',
        'whiteU'    => '4;37m',
    ];

    /**
     * Formats the string
     * @param string $string
     * @return string
     */
    public function format($string)
    {
        preg_match_all('/<(\/?\w+)>/i', $string, $matches);
        if (empty($matches[1])) {
            return $string;
        }

        foreach ($matches[1] as $k => $match) {
            if (strpos($match, '/') === 0) {
                $string = str_replace($matches[0][$k], "\033[0m", $string);
                continue;
            }

            if (!empty($this->styles[$match])) {
                $string = str_replace($matches[0][$k], "\033[" . $this->styles[$match], $string);
            }
        }

        return $string;
    }
}
