<?php
namespace WakkenEnIjsberen;
class Game
{
    private int $wrong = 0;
    private int $correct = 0;
    private int $resultIceHoles = 0;
    private int $resultPenguins = 0;
    private int $resultPolarBears = 0;
    private TurnList $turnList;
    private DiceList $diceList;

    public function __construct(int $amount)
    {
        $this->diceList = new DiceList();

        for ($i = 0; $i < $amount; $i++)
        {
            $dice = new Dice(random_int(1, 6));
            $this->diceList->addDice($dice);

            $this->resultIceHoles += $dice->getIceholes();
            $this->resultPolarBears += $dice->getPolarbears();
            $this->resultPenguins += $dice->getPenguins();
        }

        $this->turnList = new TurnList();
    }

    public function drawCubes():string
    {
        $html = "";
        foreach ($this->diceList->getDices() as $dice)
        {
            $html .= $dice->draw();
        }

        return $html;
    }

    public function result()
    {
       return $this->checkGuess();
    }

    public function getTurnList():TurnList
    {
        return $this->turnList;
    }

    public function addGuess($iceHoles, $penguins, $polarBears)
    {
        $this->getTurnList()->addturn(new Turn($iceHoles,$penguins, $polarBears));
    }

    public function checkGuess():string
    {

        if ($this->getTurnList()->getCurrentTurn()->getGuessIceHoles() == $this->resultIceHoles &&
            $this->getTurnList()->getCurrentTurn()->getGuessPenguins() == $this->resultPenguins &&
            $this->getTurnList()->getCurrentTurn()->getGuessPolarBears() == $this->resultPolarBears)
        {
            if ($this->correct < 1)
            {
                $this->correct++;
            }else {
                $this->correct = 1;
            }
            return "Correct";
        }else
        {
            $this->wrong++;
            return "Fout";

        }

    }

    public function getGameTurns():int
    {
       return $this->turnList->getAmountTurns();
    }


    public function getWrongAnswers():int
    {
            return $this->wrong;
    }

    public function getAnswer():array
    {
        return  [$this->resultIceHoles, $this->resultPenguins, $this->resultPolarBears];
    }


    public function getScore():int
    {
       return $this->correct;
    }
}