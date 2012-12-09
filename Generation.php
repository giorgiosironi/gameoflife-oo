<?php
class Generation
{
    private $cells;
    private $positions = array();

    public static function blank()
    {
        return new self();
    }

    private function __construct(array $cells = array())
    {
        $this->cells = $cells;
        foreach ($cells as $c) {
            $this->positions[$c->key()] = true;
        }
    }

    public function alive(Cell $cell)
    {
        $cells = $this->cells;
        $cells[] = $cell;
        return new self($cells);
    }

    public function isAlive(Cell $cell)
    {
        return isset($this->positions[$cell->key()]);
    }

    public function aliveNeighborhood(Cell $cell)
    {
        return $this->aliveSet()->intersect($cell->neighborhood());
    }

    public function toConsider()
    {
        $aliveSet = $this->aliveSet();
        $deadSet = $aliveSet->mapToMany(function(Cell $cell) {
            return $cell->neighborhood();
        });
        $totalSet = $aliveSet->union($deadSet);
        return $totalSet;
    }

    public function aliveSet()
    {
        return new CellSet($this->cells);
    }
}
