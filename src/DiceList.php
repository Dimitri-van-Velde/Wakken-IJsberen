<?php
namespace WakkenEnIjsberen;
class DiceList
{
    private array $dices = [];

    public function addDice(Dice $dice)
    {
        $this->dices[] = $dice;
    }

    public function getDices():array
    {
        return $this->dices;
    }
}