<?php
namespace WakkenEnIjsberen;
class HintList
{
    private array $hints = [];

    public function addHint(Hint $hint)
    {
        $this->hints[] = $hint;
    }

    public function getHints(): array
    {
        return $this->hints;
    }

    public function getRandomHint() : Hint
    {
        return $this->hints[random_int(0,4)];
    }
}