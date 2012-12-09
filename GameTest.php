<?php
class GameTest extends PHPUnit_Framework_TestCase
{
    public function testMakesACellAliveInTheNextGenerationAccordingToARule()
    {
        $game = new Game(Generation::blank()->alive(new Cell(0, 0)));
        $rule = function($alive, CellSet $aliveNeighborhood) {
            return true;
        };
        $game->newGeneration($rule);
        $this->assertEquals(9, count($game->currentlyAlive()));
    }

    public function testDisplaysTheCurrentGeneration()
    {
        $game = new Game(Generation::blank()->alive(new Cell(0, 0)));
        $canvas = $this->getMock('Canvas');
        $canvas->expects($this->once())
               ->method('printAlive')
               ->with(new CellSet(array(new Cell(0, 0))));
        $game->display($canvas);
    }
}
