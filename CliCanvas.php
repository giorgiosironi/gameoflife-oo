<?php
class CliCanvas implements Canvas
{
    private $pipe;
    private $lastPrintout;

    public function __construct(Pipe $pipe)
    {
        $this->pipe = $pipe;
    }

    public function printAlive(CellSet $alive)
    {
        $printout = new Printout();
        foreach ($alive as $cell) {
            $printout->line($cell->y())->addChar($cell->x(), 'X');
        }
        foreach ($printout->lines($this->lastPrintout) as $line) {
            $this->pipe->printLine($line->__toString());
        }
        $this->lastPrintout = $printout;
        $this->pipe->printLine('-----');
    }
}

class Line
{
    private $chars = array();
    private $min = 100;
    private $max = -100;

    public function addChar($x, $char)
    {
        $this->chars[$x] = $char;
        $positions = array_keys($this->chars);
        $this->min = min($positions);
        $this->max = max($positions);
    }

    public function __toString()
    {
        if (!$this->chars) {
            return '';
        }
        for ($i = $this->min; $i <= $this->max; $i++) {
            if (!isset($this->chars[$i])) {
                $this->chars[$i] = ' ';
            }
        }
        ksort($this->chars);
        return implode('', $this->chars);
    }

    public function min()
    {
        return $this->min;
    }

    public function max()
    {
        return $this->max;
    }

    public function spanOn($min, $max)
    {
        $this->min = $min;
        $this->max = $max;
    }
}

class Printout
{
    private $lines = array();

    public function line($y)
    {
        if (!isset($this->lines[$y])) {
            $this->lines[$y] = new Line();
        }
        return $this->lines[$y];
    }

    public function lines($last = null)
    {
        $this->fillInMissingLines($last);
        $this->fillInMissingChars($last);
        krsort($this->lines);
        return $this->lines;
    }

    private function fillInMissingLines($last = null)
    {
        $min = $this->minimumY();
        $max = $this->maximumY();
        if ($last and $last->minimumY() < $min) {
            $min = $last->minimumY();
        }
        if ($last and $last->maximumY() > $max) {
            $max = $last->maximumY();
        }
        for ($i = $min; $i <= $max; $i++) {
            if (!isset($this->lines[$i])) {
                $this->lines[$i] = new Line();
            }
        }
    }

    private function fillInMissingChars($last = null)
    {
        $min = $this->minimumX();
        $max = $this->maximumX();
        if ($last and $last->minimumX() < $min) {
            $min = $last->minimumX();
        }
        if ($last and $last->maximumX() > $max) {
            $max = $last->maximumX();
        }
        foreach ($this->lines as $y => $line) {
            $line->spanOn($min, $max);
        }
    }

    private function minimumY()
    {
        $positions = array_keys($this->lines);
        return min($positions);
    }

    private function maximumY()
    {
        $positions = array_keys($this->lines);
        return max($positions);
    }

    private function minimumX()
    {
        reset($this->lines);
        $min = current($this->lines)->min();
        foreach ($this->lines as $y => $line) {
            if ($line->min() < $min) {
                $min = $line->min();
            }
        }
        return $min;
    }

    private function maximumX()
    {
        reset($this->lines);
        $max = current($this->lines)->max();
        foreach ($this->lines as $y => $line) {
            if ($line->max() > $max) {
                $max = $line->max();
            }
        }
        return $max;
    }
}
