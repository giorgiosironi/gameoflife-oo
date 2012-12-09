<?php
class Game
{
    private $currentGeneration;

    public static function conwayRules()
    {
        return function($alive, CellSet $aliveNeighborhood) {
            if ($alive) {
                return 2 <= $aliveNeighborhood->count()
                    && $aliveNeighborhood->count() <= 3;
            } else {
                return 3 == $aliveNeighborhood->count();
            }
        };
    }

    public function __construct(Generation $generation)
    {
        $this->currentGeneration = $generation;
    }

    public function newGeneration($rule)
    {
        $nextGeneration = Generation::blank();
        foreach ($this->currentGeneration->toConsider() as $cell) {
            $alive = $this->currentGeneration->isAlive($cell);
            $aliveNeighborhood = $this->currentGeneration->aliveNeighborhood($cell);
            if ($rule($alive, $aliveNeighborhood)) {
                $nextGeneration = $nextGeneration->alive($cell);
            }
        }
        $this->currentGeneration = $nextGeneration;
    }

    public function currentlyAlive()
    {
        return $this->currentGeneration->aliveSet();
    }

    public function display(Canvas $canvas)
    {
        $canvas->printAlive($this->currentlyAlive());
    }
}
