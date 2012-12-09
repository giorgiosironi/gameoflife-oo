<?php
class CellSet implements Countable, IteratorAggregate
{
    private $cells;

    /**
     * @internal
     */
    public function __construct(array $cells = array())
    {
        $this->cells = array();
        foreach ($cells as $cell) {
            if (!$this->contains($cell)) {
                $this->cells[] = $cell;
            };
        }
    }

    public function contains(Cell $cell)
    {
        return in_array($cell, $this->cells);
    }

    public function mapToMany($callback)
    {
        $cells = new CellSet();
        foreach ($this->cells as $cell) {
            $cells = $cells->union($callback($cell));
        }
        return $cells;
    }

    public function union(CellSet $another)
    {
        return new self(array_merge($this->cells, $another->cells));
    }

    public function intersect(CellSet $another)
    {
        $candidates = $this->cells;
        $result = array();
        foreach ($this->cells as $c) {
            if ($another->contains($c)) {
                $result[] = $c;
            }
        }
        return new self($result);
    }

    public function getIterator()
    {
        return new ArrayIterator($this->cells);
    }

    public function count()
    {
        return count($this->cells);
    }
}
