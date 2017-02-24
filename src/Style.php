<?php
/**
 * Class Style
 * @package ConsoleColorFormatter
 * @author Sebastian Seidelmann <sebastian.seidelmann@wfp2.com>, wfp:2 GmbH & Co. KG
 */

namespace ConsoleColorFormatter;

/**
 * Class Style
 * @package ConsoleColorFormatter
 * @author Sebastian Seidelmann <sebastian.seidelmann@wfp2.com>, wfp:2 GmbH & Co. KG
 */
class Style
{
    private static $availableForegroundColors = [
        'black' => ['set' => 30, 'unset' => 39],
        'red' => ['set' => 31, 'unset' => 39],
        'green' => ['set' => 32, 'unset' => 39],
        'yellow' => ['set' => 33, 'unset' => 39],
        'blue' => ['set' => 34, 'unset' => 39],
        'magenta' => ['set' => 35, 'unset' => 39],
        'cyan' => ['set' => 36, 'unset' => 39],
        'white' => ['set' => 37, 'unset' => 39],
        'default' => ['set' => 39, 'unset' => 39],
    ];
    private static $availableBackgroundColors = [
        'black' => ['set' => 40, 'unset' => 49],
        'red' => ['set' => 41, 'unset' => 49],
        'green' => ['set' => 42, 'unset' => 49],
        'yellow' => ['set' => 43, 'unset' => 49],
        'blue' => ['set' => 44, 'unset' => 49],
        'magenta' => ['set' => 45, 'unset' => 49],
        'cyan' => ['set' => 46, 'unset' => 49],
        'white' => ['set' => 47, 'unset' => 49],
        'default' => ['set' => 49, 'unset' => 49],
    ];
    private static $availableOptions = [
        'bold' => ['set' => 1, 'unset' => 22],
        'underscore' => ['set' => 4, 'unset' => 24],
        'blink' => ['set' => 5, 'unset' => 25],
        'reverse' => ['set' => 7, 'unset' => 27],
        'conceal' => ['set' => 8, 'unset' => 28],
    ];

    /**
     * Saves the foreground.
     * @var string
     */
    private $foreground = null;

    /**
     * Saves the background.
     * @var string
     */
    private $background = null;

    /**
     * Saves the options.
     * @var array
     */
    private $options = [];

    /**
     * Style constructor.
     * @param string $foreground
     * @param string $background
     * @param array  $options
     */
    public function __construct($foreground = null, $background = null, array $options = [])
    {
        if (null !== $foreground) {
            $this->setForeground($foreground);
        }

        if (null !== $background) {
            $this->setBackground($background);
        }

        if (count($options)) {
            $this->setOptions($options);
        }
    }

    /**
     * Sets the Foreground color.
     * @param string $foreground
     * @return Style
     * @throws \Exception If the color was not found
     */
    public function setForeground($foreground = null)
    {
        if (null === $foreground) {
            return $this;
        }

        if (isset(self::$availableForegroundColors[$foreground])) {
            $this->foreground = self::$availableForegroundColors[$foreground];
        } else {
            throw new \Exception(sprintf('foreground color "%s" not found', $foreground));
        }

        return $this;
    }

    /**
     * Sets the Background color.
     * @param string $background
     * @return Style
     * @throws \Exception
     */
    public function setBackground($background = null)
    {
        if (null === $background) {
            return $this;
        }

        if (isset(self::$availableBackgroundColors[$background])) {
            $this->background = self::$availableBackgroundColors[$background];
        } else {
            throw new \Exception(sprintf('background color "%s" not found', $background));
        }

        return $this;
    }

    /**
     * Sets a options.
     * @param string $option
     * @return Style
     * @throws \Exception
     */
    public function setOption($option)
    {

        if (isset(self::$availableOptions[$option])) {
            $this->options[] = self::$availableOptions[$option];
        } else {
            throw new \Exception(sprintf('option "%s" not found', $option));
        }

        return $this;
    }

    /**
     * Sets the options.
     * @param array $options
     * @return Style
     */
    public function setOptions(array $options = [])
    {
        $this->options = [];

        foreach ($options as $option) {
            $this->setOption($option);
        }

        return $this;
    }

    /**
     * Applies the given $message with the configured style.
     * @param string $message
     * @return string
     */
    public function apply($message)
    {
        $codes['set']   = [];
        $codes['unset'] = [];

        if (null !== $this->foreground) {
            $codes['set'][]   = $this->foreground['set'];
            $codes['unset'][] = $this->foreground['unset'];
        }

        if (null !== $this->background) {
            $codes['set'][]   = $this->background['set'];
            $codes['unset'][] = $this->background['unset'];
        }

        foreach ($this->options as $option) {
            $codes['set'][]   = $option['set'];
            $codes['unset'][] = $option['unset'];
        }

        if (0 === count($codes['set'])) {
            return $message;
        }

        return sprintf("\033[%sm%s\033[%sm", implode(';', $codes['set']), $message, implode(';', $codes['unset']));
    }

    /**
     * Returns the available foreground colors.
     * @return array
     */
    public static function getAvailableForegroundColors()
    {
        return array_keys(self::$availableForegroundColors);
    }

    /**
     * Returns the available background colors.
     * @return array
     */
    public static function getAvailableBackgroundColors()
    {
        return array_keys(self::$availableBackgroundColors);
    }

    /**
     * Returns the available options.
     * @return array
     */
    public static function getAvailableOptions()
    {
        return array_keys(self::$availableOptions);
    }





}