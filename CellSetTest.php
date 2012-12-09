<?php
class CellSetTest extends PHPUnit_Framework_TestCase
{
    public function testDoesNotAllowDuplicates()
    {
        $set = new CellSet(array(new Cell(0, 0), new Cell(0, 0)));
        $this->assertEquals(1, $set->count());
    }
}
