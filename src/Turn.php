<?php
namespace WakkenEnIjsberen;
class Turn
{
    private int $guessIceHoles = 0;
    private int $guessPolarBears = 0;
    private int $guessPenguins = 0;

    public function __construct(int $iceHoles,int $penguins, int $polarBears,)
    {
        $this->guessIceHoles = $iceHoles;
        $this->guessPolarBears = $polarBears;
        $this->guessPenguins = $penguins;
    }

    public function getGuessIceHoles():int
    {
        return $this->guessIceHoles;
    }

    public function getGuessPolarBears():int
    {
        return $this->guessPolarBears;
    }

    public function getGuessPenguins():int
    {
        return $this->guessPenguins;
    }
}