<?php
class GenerationTest extends PHPUnit_Framework_TestCase
{
    public function testKnowsTheStateOfACell()
    {
        $generation = Generation::blank()
            ->alive(new Cell(1, 2));
        $this->assertTrue($generation->isAlive(new Cell(1, 2)));
        $this->assertFalse($generation->isAlive(new Cell(11, 12)));
    }

    public function testAliveCellsHaveToBeConsideredForTransition()
    {
        $generation = Generation::blank()
            ->alive(new Cell(1, 2));
        $cellSet = $generation->toConsider();
        $this->assertTrue($cellSet->contains(new Cell(1, 2)));
        $this->assertFalse($cellSet->contains(new Cell(11, 12)));
    }

    public function testDeadCellsNearToAliveCellsHaveToBeConsideredForTransition()
    {
        $generation = Generation::blank()
            ->alive(new Cell(1, 8));
        $cellSet = $generation->toConsider();
        $this->assertTrue($cellSet->contains(new Cell(1, 9)));
        $this->assertTrue($cellSet->contains(new Cell(2, 8)));
    }
}

