<?php
namespace WakkenEnIjsberen;
class TurnList
{
    private array $turns = [];

    public function addTurn(Turn $turn)
    {
        $this->turns[] = $turn;
    }

    public function getTurns():array
    {
        return $this->turns;
    }

    public function getAmountTurns():int
    {
        return count($this->turns);
    }

    public function getCurrentTurn():Turn
    {
        return $this->getTurns()[$this->getAmountTurns() - 1];
    }
}