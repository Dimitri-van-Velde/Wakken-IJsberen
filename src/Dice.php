<?php
namespace WakkenEnIjsberen;
class Dice
{
    private int $iceHoles = 0;
    private int $polarBears = 0;
    private int $penguins = 0;
    private int $dice;

    public function __construct($dice)
    {
        $this->dice = $dice;
        $this->dice();
    }

    public function dice()
    {
        if($this->dice % 2 == 1 )
        {
            $this->iceHoles = 1;
            $this->polarBears = $this->dice - $this->iceHoles;
            $this->penguins = 7 - $this->dice;
        }else
        {
            $this->penguins = 0;
            $this->iceHoles = 0;
            $this->polarBears = 0;
        }
    }

    public function draw(){

            $dice = $this->getDice();

            $html = '<svg width="150" height="150">' .
                '<rect x="10" y="10" width="130" height="130" rx="25" style="fill:white;stroke:black;stroke-width:5;fill-opacity:0.1;stroke-opacity:0.9" />';

            switch ($dice)
            {
                case 5:
                    $html .= '<circle cx="40" cy="110" r="10" style="fill:black"/>';
                    $html .= '<circle cx="110" cy="40" r="10" style="fill:black"/>';
                case 3:
                    $html .= '<circle cx="40" cy="40" r="10" style="fill:black"/>';
                    $html .= '<circle cx="110" cy="110" r="10" style="fill:black"/>';
                case 1:
                    $html .= '<circle cx="75" cy="75" r="10" style="fill:blue"/>';
                    break;
                case 6:
                    $html .= '<circle cx="40" cy="75" r="10" style="fill:black"/>';
                    $html .= '<circle cx="110" cy="75" r="10" style="fill:black"/>';
                case 4:
                    $html .= '<circle cx="40" cy="110" r="10" style="fill:black"/>';
                    $html .= '<circle cx="110" cy="40" r="10" style="fill:black"/>';
                case 2:
                    $html .= '<circle cx="40" cy="40" r="10" style="fill:black"/>';
                    $html .= '<circle cx="110" cy="110" r="10" style="fill:black"/>';
                    break;
            }

            $html .= '</svg>';

            echo $html;
        }


    public function getIceholes(): int
    {
        return $this->iceHoles;
    }

    public function getPenguins(): int
    {
        return $this->penguins;
    }

    public function getPolarbears(): int
    {
        return $this->polarBears;
    }

    public function getDice(): int
    {
        return $this->dice;
    }
}