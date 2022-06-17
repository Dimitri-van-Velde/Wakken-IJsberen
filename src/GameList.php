<?php
namespace WakkenEnIjsberen;
class GameList
{
    private array $games = [];

    public function addGame(Game $game)
    {
        $this->games[] = $game;
    }

    public function getGames():array
    {
        return $this->games;
    }

    public function getCurrentGame():Game
    {
        return $this->getGames()[count($this->getGames()) - 1];
    }
}