<?php
require_once("combinations.php");

class Element
{
    private string $symbol;
    private int $price;

    public function __construct(string $symbol, int $price)
    {
        $this->symbol = $symbol;
        $this->price = $price;
    }

    public function getSymbol(): string
    {
        return $this->symbol;
    }

    public function getPrice(): int
    {
        return $this->price;
    }
}

$elements = [
    new Element("A", 10),
    new Element("K", 8),
    new Element("K", 8),
    new Element("Q", 6),
    new Element("Q", 6),
    new Element("Q", 6),
    new Element("J", 4),
    new Element("J", 4),
    new Element("J", 4),
    new Element("J", 4),
    new Element("10", 2),
    new Element("10", 2),
    new Element("10", 2),
    new Element("10", 2),
    new Element("10", 2),
];

class Board
{
    private array $board = [];
    private int $row = 3;
    private int $column = 4;

    public function setBoard($elements)
    {
        for ($i = 0; $i < $this->row; $i++) {
            for ($j = 0; $j < $this->column; $j++) {
                $this->board[$i][$j] = $elements[array_rand($elements)]->getSymbol();
            }
        }
        foreach ($this->board as $element) {
            echo "\t";
            foreach ($element as $value) {
                echo $value . " ";
            }
            echo "\n";
        }
    }

    public function getBoard()
    {
        return $this->board;
    }
}

class Player
{

    private int $wallet;

    public function __construct(int $wallet = 0)
    {

        $this->wallet = $wallet;
    }

    public function setWallet(int $newWalletValue): int
    {
        return $this->wallet = $newWalletValue;
    }

    public function getWallet(): int
    {
        return $this->wallet;
    }

    public function addToWallet(int $valueToAdd): int
    {
        return $this->wallet += $valueToAdd;
    }

    public function subtractFromWallet(int $valueToSubtract): int
    {
        return $this->wallet -= $valueToSubtract;
    }
}


class Game
{
    private bool $keepPlaying = true;
    private array $elements;
    private array $combinations;
    private Player $player;

    public function __construct($elements, $combinations, Player $player)
    {
        $this->elements = $elements;
        $this->combinations = $combinations;
        $this->player = $player;

    }

    public function play(): void
    {

        echo "Welcome to the SLOT MACHINE\n";
        $credits = readline("Enter amount of money to deposit: ");
        $this->player->setWallet($credits);
        $baseBet = readline("Enter amount to bet: ");
        $betAmount = $baseBet;


        while ($this->keepPlaying == true) {

            if ($this->player->getWallet() <= 0) {
                echo "You have run out of money\n";
                echo "Thank you for playing\n";
                $this->keepPlaying = false;
                break;
            }
            if ($betAmount > $this->player->getWallet()) {
                $inEqualSum = true;
                while ($inEqualSum) {
                    echo "Bet amount cannot exceed your available money : $ {$this->player->getWallet()}\n";
                    $baseBet = readline("Enter valid bet amount: \n");
                    $betAmount = $baseBet;
                    if ($betAmount <= $this->player->getWallet()) {
                        $inEqualSum = false;
                    }
                }
            }

            echo "You have $" . $this->player->getWallet() . " to play with\n";
            echo 'Base bet: $' . $baseBet . ' | ';
            echo 'Bet amount $' . $betAmount . PHP_EOL;

            echo("1. Spin\n2. Increase bet by 1x\n3. Edit base bet\n4. Reset bet\n5 .Quit\n\n");
            $choice = (int)readline("Select a choice: \n");

            switch ($choice) {
                case 1:
                    $board = new Board();
                    $board->setBoard($this->elements);
                    $this->player->subtractFromWallet($betAmount);

                    $organizedLineValues = [];
                    foreach ($this->combinations as $combination) {
                        $tempLineValues = [];
                        foreach ($combination as $position) {
                            $tempLineValues[] = $board->getBoard()[$position->getPosition()[0]][$position->getPosition()[1]];
                        }
                        if (count(array_unique($tempLineValues)) === 1) {
                            echo 'You got a line! ' . PHP_EOL;
                            $organizedLineValues[] = $tempLineValues[0];

                        }
                    }

                    foreach ($organizedLineValues as &$lineValues) {
                        foreach ($this->elements as $value) {
                            if ($value->getSymbol() == $lineValues) {
                                $lineValues = [
                                    'symbol' => $value->getSymbol(),
                                    'price' => $value->getPrice()
                                ];
                            }

                        }
                    }

                    if (!count($organizedLineValues) == 0) {
                        $totalPayout = 0;
                        foreach ($organizedLineValues as $matchPrice) {
                            $totalPayout += $matchPrice['price'] * $betAmount;
                        }
                        $this->player->addToWallet($totalPayout);
                        echo 'Total Payout: $' . $totalPayout . PHP_EOL;
                    }
                    break;
                case 2:
                    $betAmount = $betAmount + $baseBet;
                    break;
                case 3:
                    $newBetAmount = (int)readline('Enter new bet amount: ');
                    $baseBet = $newBetAmount;
                    $betAmount = $baseBet;
                    echo $baseBet . PHP_EOL;
                    break;
                case 4:
                    $betAmount = $baseBet;
                    echo "Bet amount is reset!";
                    break;
                case 5:
                    $this->keepPlaying = false;
                    break;
                default:
                    echo 'Select valid choice 1-5!' . PHP_EOL;
                    break;
            }
        }
    }
}

$player = new Player();
$game = new Game($elements, $combinations, $player);
$game->play();
