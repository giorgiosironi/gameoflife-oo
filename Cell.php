<?php
class Cell
{
    private $x;
    private $y;

    public function __construct($x, $y)
    {
        $this->x = $x;
        $this->y = $y;
    }

    public static function fromKey($key)
    {
        list ($x, $y) = explode(':', $key);
        return new self($x, $y);
    }

    public function key()
    {
        return "{$this->x}:{$this->y}";
    }

    public function x()
    {
        return $this->x;
    }

    public function y()
    {
        return $this->y;
    }

    /**
     * @return array  of Cell
     */
    public function neighborhood()
    {
        $right = $this->x + 1;
        $left = $this->x - 1;
        $top = $this->y + 1;
        $bottom = $this->y - 1;
        return new CellSet(array(
            new Cell($this->x, $top),
            new Cell($right, $top),
            new Cell($right, $this->y),
            new Cell($right, $bottom),
            new Cell($this->x, $bottom),
            new Cell($left, $bottom),
            new Cell($left, $this->y),
            new Cell($left, $top),
        ));
    }
}
