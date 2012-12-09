<?php
require_once 'bootstrap.php';
define('GENERATIONS', 10);
$game = new Game(Generation::blank()
    ->alive(new Cell(0, 0))
    ->alive(new Cell(0, 1))
    ->alive(new Cell(0, 2))
);
$canvas = new CliCanvas(new StdoutPipe());
$game->display($canvas);
for ($i = 0; $i < GENERATIONS; $i++) {
    $game->newGeneration(Game::conwayRules());
    $game->display($canvas);
}
