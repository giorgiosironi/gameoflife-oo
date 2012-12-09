<?php
class StdoutPipe implements Pipe
{
    public function printLine($text)
    {
        echo $text . "\n";
    }
}
