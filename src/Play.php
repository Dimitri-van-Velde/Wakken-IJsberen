<?php


namespace WakkenEnIjsberen;

class Play
{
    private string $name;
    private GameList $gameList;
    private HintList $hintList;
    private int $score;

    public function __construct()
    {
        $this->hintList = new HintList();
        $this->setHints();
        $this->gameList = new GameList();
    }

    public function setHints()
    {
        $hints = ['Je kan het!', 'Beter nadenken, dan heb je het vanzelf :)!', 'Really?','Not even close man.','(╯°□°）╯︵ ┻━┻'];
        foreach ($hints as $hint) {
            $hint = new Hint($hint);
            $this->hintList->addHint($hint);
        }
    }


    public function setPlayerName(string $name)
    {
        $this->name = $name;
    }


    public function getPlayerName(): string
    {
        return $this->name;
    }

    public function addGame($game)
    {
        $this->gameList->addGame($game);
    }

    public function addGuess($iceHoles, $penguins, $polarBears)
    {
        $this->gameList->getCurrentGame()->addGuess($iceHoles, $penguins, $polarBears);
    }

    public function checkScore(): string
    {
       return $this->gameList->getCurrentGame()->checkGuess();
    }

    public function draw():string
    {
        return $this->gameList->getCurrentGame()->drawCubes();
    }

    public function getHint() :Hint
    {
        return $this->hintList->getRandomHint();
    }

    public function getPreviousGames() :array
    {
        return $this->gameList->getGames();
    }

    public function getScore(): int
    {
        $score = 0;

        foreach ($this->getPreviousGames() as $game)
        {
                $score = $score + $game->getScore();
        }
        return $score;
    }
    public function getGameList() :GameList {
            return $this->gameList;
    }
}