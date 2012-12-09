<?php
class CellTest extends PHPUnit_Framework_TestCase
{
    public function testGeneratesTheFullNeighborhood()
    {
        $cell = new Cell(1, 8);
        $neighborhood = $cell->neighborhood();
        $this->assertEquals(8, $neighborhood->count());
        $this->assertEquals(new CellSet(array(
            new Cell(1, 9),
            new Cell(2, 9),
            new Cell(2, 8),
            new Cell(2, 7),
            new Cell(1, 7),
            new Cell(0, 7),
            new Cell(0, 8),
            new Cell(0, 9),
        )), $neighborhood);
    }
}
