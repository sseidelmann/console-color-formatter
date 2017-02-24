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
    const TAG_REGEX = '[a-z][a-z0-9,_=;-]*+';

    const STYLE_REGEX = '/([^=]+)=([^;]+)(;|$)/';

    /**
     * Saves the styles.
     * @var Style[]
     */
    private $styles = [];

    /**
     * Style stack.
     * @var array
     */
    private $styleStack = [];

    /**
     * Saves the style stack instance.
     * @var Stack
     */
    private $stack;

    /**
     * Constructor for the formatter.
     * Sets some default styles.
     */
    public function __construct()
    {
        $this->addStyle('info', new Style('yellow'));
        $this->addStyle('error', new Style('white', 'red'));

        $this->stack = new Stack();
        $this->stack->setEmptyStyle(new Style());
    }

    /**
     * Adds a style
     * @param $name
     * @param Style $style
     * @return Formatter
     */
    public function addStyle($name, Style $style)
    {
        $this->styles[$name] = $style;

        return $this;
    }

    public function format($message)
    {
        // reset the stack
        $this->stack->reset();

        $matches = [];
        $regex   = self::TAG_REGEX;
        $offset  = 0;
        $output  = '';

        preg_match_all("#<(($regex) | /($regex)?)>#ix", $message, $matches, PREG_OFFSET_CAPTURE);

        foreach ($matches[0] as $i => $match) {
            $pos  = $match[1];
            $text = $match[0];

            if (0 != $pos && '\\' == $message[$pos - 1]) {
                continue;
            }

            $output .= $this->apply(substr($message, $offset, $pos - $offset));
            $offset  = $pos + strlen($text);

            // opening tag?
            if ($open = '/' != $text[1]) {
                $tag = $matches[1][$i][0];
            } else {
                $tag = isset($matches[3][$i][0]) ? $matches[3][$i][0] : '';
            }

            if (!$open && !$tag) {
                // </>
                $this->stack->pop();
            } elseif (false === $style = $this->createStyleFromTag(strtolower($tag))) {
                $output .= $this->apply($text);
            } elseif ($open) {
                $this->stack->push($style);
            } else {
                $this->stack->pop();
            }
        }

        $output .= $this->apply(substr($message, $offset));

        return $output;
    }

    /**
     * Creates the style for the current tag
     * @param string $tag
     * @return Style|boolean
     */
    private function createStyleFromTag($tag)
    {
        if (isset($this->styles[$tag])) {
            return $this->styles[$tag];
        }

        $matches = [];
        $style   = new Style();

        if (!preg_match_all(self::STYLE_REGEX, $tag, $matches, PREG_SET_ORDER)) {
            return false;
        }

        foreach ($matches as $match) {
            array_shift($match);
            if ('fg' == $match[0]) {
                $style->setForeground($match[1]);
            } elseif ('bg' == $match[0]) {
                $style->setBackground($match[1]);
            } elseif ('options' === $match[0]) {

            }
        }

        return $style;
    }

    /**
     * Applies the style to the current $message.
     * @param string $message
     * @return string
     */
    private function apply($message)
    {
        return strlen($message) > 0 ? $this->stack->current()->apply($message) : $message;
    }
}
