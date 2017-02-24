<?php
/**
 * Class Stack
 * @package ConsoleColorFormatter
 * @author Sebastian Seidelmann <sebastian.seidelmann@wfp2.com>, wfp:2 GmbH & Co. KG
 */

namespace ConsoleColorFormatter;

/**
 * Class Stack
 * @package ConsoleColorFormatter
 * @author Sebastian Seidelmann <sebastian.seidelmann@wfp2.com>, wfp:2 GmbH & Co. KG
 */
class Stack
{
    /**
     * Saves the empty style.
     * @var Style
     */
    private $emptyStyle;

    /**
     * Saves the styles.
     * @var Style[]
     */
    private $stack = [];

    /**
     * Resets the stack.
     * @return void
     */
    public function reset()
    {
        $this->stack = [];
    }

    /**
     * Push a style.
     * @param Style $style
     * @return void
     */
    public function push(Style $style)
    {
        $this->stack[] = $style;
    }

    /**
     * Pops a element from the stack.
     * @return Style
     */
    public function pop()
    {
        if (empty($this->stack)) {
            return $this->emptyStyle;
        }

        return array_pop($this->stack);
    }

    /**
     * Returns the current style.
     * @return Style
     */
    public function current()
    {
        if (empty($this->stack)) {
            return $this->emptyStyle;
        }

        return $this->stack[count($this->stack) - 1];
    }

    /**
     * Sets the empty style.
     * @param Style $emptyStyle
     * @return void
     */
    public function setEmptyStyle($emptyStyle)
    {
        $this->emptyStyle = $emptyStyle;
    }
}