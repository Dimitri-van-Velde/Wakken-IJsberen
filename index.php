<?php

require_once "vendor/autoload.php";

use WakkenEnIjsberen\Dice;
use WakkenEnIjsberen\Hint;
use WakkenEnIjsberen\Play;
use WakkenEnIjsberen\Game;
use WakkenEnIjsberen\Turn;
use WakkenEnIjsberen\TurnList;

session_start();

/*
 * scherm1 : form start game
 * scherm2 : form kies aantal dobbelstenen
 * scherm3 : gegooide dobbelstenen
 *           A) antwoordformulier
 *           B) knop resultaat weergeven
 *           resultaten vorige games
 * scherm4(A) : A) antwoord is goed => game eindigen, resultaat opslaan + melding
 *                  knop nieuw spel / formulier dobbelstenen kiezen
 *            : B) antwoord is fout => random hint geven
 *                  formulier om antwoord te geven
 * scherm4(B) : Antwoord laten zien
 *                  knop nieuw spel / formulier dobbelstenen kiezen
 */
?>

<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <title>Wakken & Ijsberen</title>
    <style>
        body {
            margin: 25px;
        }
    </style>
    <link rel="icon" href="bear.png" type="img/png">
</head>
<body>
<!-- Optional JavaScript; choose one of the two! -->
<!-- Option 1: Bootstrap Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
<!-- Option 2: Separate Popper and Bootstrap JS -->
<!--
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
-->
<?php

if(isset($_SESSION["play"]))
{
    $play = $_SESSION["play"];
}

if(isset($_POST["guess"]))
{
    $play->addGuess($_POST["iceHoles"], $_POST["penguins"], $_POST["polarBears"]);

    if($play->checkscore() === "Fout")
    {
        ?>
        <div class="alert alert-danger" role="alert">
            Helaas Fout
        </div>
        <?php
        
        if($play->getGameList()->getCurrentGame()->getWrongAnswers() > 2)
        {
           ?>
            <div class="alert alert-info" role="alert">
           <?php echo $play->getHint()->getHintString() ?>
            </div>
            <?php
        }

        $play->draw();
        ?>
        <form action="index.php" method="post">
            <div class="mb-3">
                <label for="IceHoles">IceHoles:</label>
                <input type="number" class="form-control" id="IceHoles" name="iceHoles" required>
                <label for="Penguins">Penguins:</label>
                <input type="number" class="form-control" id="Penguins" name="penguins" required>
                <label for="PolarBears">PolarBears:</label>
                <input type="number" class="form-control" id="PolarBears" name="polarBears" required>
            </div>
            <button name="guess" type="submit" class="btn btn-primary">Raad</button>
            <button name="solution" type="submit" class="btn btn-primary" formnovalidate>Geef oplossing</button>

        </form>

        <h4 style="margin-top: 20px">Huidige game</h4>
        <table class="table">
            <thead>
            <tr>
                <th scope="col">Fout geraden</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>
                    <?php
                    echo $play->getGameList()->getCurrentGame()->getWrongAnswers();
                    ?>
                </td>
            </tr>
            </tbody>
        </table>
        <h4 style="margin-top: 20px">Vorige games</h4>
        <table class="table">
            <thead>
            <tr>
                <th scope="col"></th>
                <th scope="col">Aantal beurten</th>
                <th scope="col">Fout geraden</th>
            </tr>
            </thead>
            <tbody>
            <?php
            for ($i = count($play->getPreviousGames())-2; $i >= 0; $i--){
                ?>
                <tr>
                    <td> <?php echo "Game" ;?> </td>
                    <td> <?php echo $play->getPreviousGames()[$i]->getGameTurns();?> </td>
                    <td> <?php echo $play->getPreviousGames()[$i]->getWrongAnswers() ;?> </td>
                </tr>
                <?php
            }
            ?>
            <tr>
                <td>Score: <?php echo $play->getScore(); ?></td>
                <td></td>
                <td></td>
            </tr>
            </tbody>
        </table>
        <?php

    }else {

        echo '<div class="alert alert-success" role="alert">
                Correct
              </div>';
        $play->setPlayerName($_SESSION["name"]);
        ?>
<form action="index.php" method="post">
    <div class="mb-3">
        <label for="amount" class="form-label">Amount</label>
        <input type="number" min="3" max="8" class="form-control" id="amount" name="amount" required>
    </div>
    <button name="drawCubes" type="submit" class="btn btn-primary">Gooi dobbelstenen</button>
</form>
        <h4 style="margin-top: 20px">Vorige games</h4>
        <table class="table">
            <thead>
            <tr>
                <th scope="col"></th>
                <th scope="col">Aantal beurten</th>
                <th scope="col">Fout geraden</th>
            </tr>
            </thead>
            <tbody>
            <?php
            for ($i = count($play->getPreviousGames())-1; $i >= 0; $i--){
                ?>
                <tr>
                    <td> <?php echo "Game" ;?> </td>
                    <td> <?php echo $play->getPreviousGames()[$i]->getGameTurns();?> </td>
                    <td> <?php echo $play->getPreviousGames()[$i]->getWrongAnswers() ;?> </td>
                </tr>
                <?php
            }
            ?>
            <tr>
                <td>Score: <?php echo $play->getScore(); ?></td>
                <td></td>
                <td></td>
            </tr>

            </tbody>
        </table>
<?php }

}

elseif(isset($_POST["drawCubes"]) && !empty($_POST["amount"] ))
{

    $_SESSION['amount'] =  $_POST["amount"];
    $game = new Game($_POST["amount"]);
    $play->addGame($game);

    $play->draw();
    
    ?>
   <form action="index.php" method="post">
       <div class="mb-3">
           <label for="IceHoles">IceHoles:</label>
           <input type="number" class="form-control" id="IceHoles" name="iceHoles" required>
           <label for="Penguins">Penguins:</label>
           <input type="number" class="form-control" id="Penguins" name="penguins" required>
           <label for="PolarBears">PolarBears:</label>
           <input type="number" class="form-control" id="PolarBears" name="polarBears" required>
       </div>
       <button name="guess" type="submit" class="btn btn-primary">Raad</button>
       <button name="solution" type="submit" class="btn btn-primary" formnovalidate>Geef oplossing</button>
   </form>

    <h4 style="margin-top: 20px">Huidige game</h4>
    <table class="table">
        <thead>
        <tr>
            <th scope="col">Fout geraden</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>
                <?php
                    echo $play->getGameList()->getCurrentGame()->getWrongAnswers();
                ?>
            </td>
        </tr>
        </tbody>
    </table>
    <h4 style="margin-top: 20px">Vorige games</h4>
    <table class="table">
        <thead>
        <tr>
            <th scope="col"></th>
            <th scope="col">Aantal beurten</th>
            <th scope="col">Fout geraden</th>
        </tr>
        </thead>
        <tbody>
        <?php
        for ($i = count($play->getPreviousGames())-2; $i >= 0; $i--){
            ?>
            <tr>
                <td> <?php echo "Game" ;?> </td>
                <td> <?php echo $play->getPreviousGames()[$i]->getGameTurns();?> </td>
                <td> <?php echo $play->getPreviousGames()[$i]->getWrongAnswers() ;?> </td>
            </tr>
            <?php
        }
        ?>
        <tr>
            <td>Score: <?php echo $play->getScore(); ?></td>
            <td></td>
            <td></td>
        </tr>
        </tbody>
    </table>
        <?php

}
elseif(isset($_POST["startGame"]) && isset($_POST["name"]) OR isset($_POST["startGameAgain"]))
{
    if(!isset($_POST["startGameAgain"])) {
        $_SESSION['name'] = $_POST["name"];

        $play->setPlayerName($_POST["name"]);
    }
    ?>
    <form action="index.php" method="post">
        <div class="mb-3">
            <label for="amount" class="form-label">Amount</label>
            <input type="number" min="3" max="8" class="form-control" id="amount" name="amount" required>
        </div>
        <button name="drawCubes" type="submit" class="btn btn-primary">Gooi dobbelstenen</button>

    </form>


    <?php

    if(isset($_POST["startGameAgain"])) {
    ?>
        <h4 style="margin-top: 20px">Vorige games</h4>
        <table class="table">
            <thead>
            <tr>
                <th scope="col"></th>
                <th scope="col">Aantal beurten</th>
                <th scope="col">Fout geraden</th>
            </tr>
            </thead>
            <tbody>
            <?php
            for ($i = count($play->getPreviousGames())-1; $i >= 0; $i--){
                ?>
                <tr>
                    <td> <?php echo "Game" ;?> </td>
                    <td> <?php echo $play->getPreviousGames()[$i]->getGameTurns();?> </td>
                    <td> <?php echo $play->getPreviousGames()[$i]->getWrongAnswers() ;?> </td>
                </tr>
                <?php
            }
            ?>
            <tr>
                <td>Score: <?php echo $play->getScore(); ?></td>
                <td></td>
                <td></td>
            </tr>

            </tbody>
        </table>
            <?php
    }
}else if (isset($_POST["solution"])) {
    ?>
        <h4>Oplossing</h4>
    <table class="table">
        <thead>
        <tr>
            <th scope="col">Iceholes</th>
            <th scope="col">Penguins</th>
            <th scope="col">Polarbears</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <?php foreach($play->getGamelist()->getCurrentGame()->getAnswer() as $value){
                ?>
            <td> <?php echo $value ;?> </td>
            <?php
            }

                ?>
        </tr>
        </tbody>
    </table>
    <h4 style="margin-top: 20px">Vorige games</h4>
    <table class="table">
        <thead>
        <tr>
            <th scope="col"></th>
            <th scope="col">Aantal beurten</th>
            <th scope="col">Fout geraden</th>
        </tr>
        </thead>
        <tbody>
        <?php
        for ($i = count($play->getPreviousGames())-1; $i >= 0; $i--){
            ?>
            <tr>
                <td> <?php echo "Game" ;?> </td>
                <td> <?php echo $play->getPreviousGames()[$i]->getGameTurns();?> </td>
                <td> <?php echo $play->getPreviousGames()[$i]->getWrongAnswers() ;?> </td>
            </tr>
            <?php
        }
        ?>
        <tr>
            <td>Score: <?php echo $play->getScore(); ?></td>
            <td></td>
            <td></td>
        </tr>

        </tbody>
    </table>
    <form action="index.php" method="post">
        <button name="startGameAgain" type="submit" class="btn btn-primary">Ga verder</button>
    </form>
    <?php
}else
{
   $_SESSION["play"] = new Play();
    ?>
    <form action="index.php" method="post">
        <div class="mb-3">
            <label for="name" class="form-label">Naam</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <button name="startGame" type="submit" class="btn btn-primary">Start spel</button>
    </form>
    <?php
}
?>

</body>
</html>