<?php
class CliCanvasTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->dummyPipe = new DummyPipe();
        $this->canvas = new CliCanvas($this->dummyPipe);
    }

    public function testDisplaysAllAliveCells()
    {
        $this->canvas->printAlive(new CellSet(array(new Cell(1, 1))));
        $this->assertEquals(array(
            'X',
            '-----'
        ), $this->dummyPipe->outputLines);
    }

    public function testDisplaysCellsInTheirPositions()
    {
        $this->canvas->printAlive(new CellSet(array(
            new Cell(2, 1),
            new Cell(1, 1),
            new Cell(1, 2),
        )));
        $this->assertEquals(array(
            'X ',
            'XX',
            '-----'
        ), $this->dummyPipe->outputLines);
    }

    public function testDisplaysDeadCellsAsBlankCharactersInALine()
    {
        $this->canvas->printAlive(new CellSet(array(
            new Cell(1, 1),
            new Cell(3, 1),
        )));
        $this->assertEquals(array(
            'X X',
            '-----'
        ), $this->dummyPipe->outputLines);
    }

    public function testDisplaysDeadCellsAsBlankCharactersInColumns()
    {
        $this->canvas->printAlive(new CellSet(array(
            new Cell(1, 1),
            new Cell(1, 3),
        )));
        $this->assertEquals(array(
            'X',
            '',
            'X',
            '-----'
        ), $this->dummyPipe->outputLines);
    }

    public function testDisplaysAlignedLines()
    {
        $this->canvas->printAlive(new CellSet(array(
            new Cell(2, 1),
            new Cell(3, 1),
            new Cell(4, 2),
            new Cell(5, 2),
        )));
        $this->assertEquals(array(
            '  XX',
            'XX  ',
            '-----'
        ), $this->dummyPipe->outputLines);
    }

    public function testRemembersThePreviousBoundariesToShowMovement()
    {
        $this->canvas->printAlive(new CellSet(array(
            new Cell(1, 1),
        )));

        $this->canvas->printAlive(new CellSet(array(
            new Cell(2, 2),
        )));
        $this->assertEquals(array(
            'X',
            '-----',
            ' X',
            '',
            '-----',
        ), $this->dummyPipe->outputLines);
    }
}

class DummyPipe implements Pipe
{
    public $outputLines;

    public function printLine($text)
    {
        $this->outputLines[] = $text;
    }
}
