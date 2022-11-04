<?php
declare(strict_types=1);
//Variable declaration
$board = [
    [" ", " ", " ", " ", " "],
    [" ", " ", " ", " ", " "],
    [" ", " ", " ", " ", " "]
];
$symbols = ["A", "B", "C", "D", "E"];
//Deposit/BANK$$$
(float) $bank = readline("Enter deposit -> ");
//Wining combinations
$combinations = [
    [
        [0, 0], [0, 1], [0, 2], [0, 3], [0, 4]
    ],
    [
        [1, 0], [1, 1], [1, 2], [1, 3], [1, 4]
    ],
    [
        [2, 0], [2, 1], [2, 2], [2, 3], [2, 4]
    ],
    [
        [2, 0], [2, 1], [1, 2], [0, 3], [0, 4]
    ],
    [
        [0, 0], [0, 1], [1, 2], [2, 3], [2, 4]
    ],
    [
        [0, 0], [1, 1], [0, 2], [1, 3], [0, 4]
    ],
    [
        [2, 0], [1, 1], [2, 2], [1, 3], [2, 4]
    ]
];
//Game mechanic
while ($bank > 0) {
    //Choose difficulty (number of sine)
    $difficulty = readline("Choose difficulty from 1 to 4 -> ");
    $intDifficulty = intval($difficulty);
    if ($difficulty > 4 || $difficulty < 1) {
        echo "Wrong difficulty\n";
        continue;
    }
    //Player choose combinations to win
    echo "Choose combination from 1 to 7 ore multiple combinations with join number\n"; // 123 ore 3
    echo "***** |       |       |    ** | **    | * * * |       |\n";
    echo "      | ***** |       |   *   |   *   |  * *  |  * *  |\n";
    echo "      |       | ***** | **    |    ** |       | * * * |\n";
    $combinationChoice = str_split(readline("-> "));
    //Transform user choice
    if (count($combinationChoice) > 7) {
        continue;
    }
    $combinationChoiceInt = [];
    foreach ($combinationChoice as &$item) {
        $combinationChoiceInt[] = intval($item) - 1;
    }
    $combinationsPlayer = [];
    for ($i=0; $i < count($combinationChoiceInt); $i++) {
        $combinationsPlayer[] = $combinations[$combinationChoiceInt[$i]];
    }
    //Filling board / spin
    foreach ($board as &$line) {
        foreach ($line as &$slot) {
            $slot = $symbols[rand(0, $intDifficulty)];
        }
    }
    $bet = intval(readline("Enter your bet(int) -> "));
    //Display board
    echo "{$board[0][0]} | {$board[0][1]} | {$board[0][2]} | {$board[0][3]} | {$board[0][4]} \n";
    echo "--+---+---+---+---\n";
    echo "{$board[1][0]} | {$board[1][1]} | {$board[1][2]} | {$board[1][3]} | {$board[1][4]} \n";
    echo "--+---+---+---+---\n";
    echo "{$board[2][0]} | {$board[2][1]} | {$board[2][2]} | {$board[2][3]} | {$board[2][4]} \n";
    //Check for wining combination
    $conditionCounterCount = 0;
    foreach ($combinationsPlayer as $combination) {
        $conditionCounterA = 0;
        $conditionCounterB = 0;
        $conditionCounterC = 0;
        $conditionCounterD = 0;
        $conditionCounterE = 0;
        foreach ($combination as $position) {
            [$x, $y] = $position;
            switch ($board[$x][$y]) {
                case "A":
                    $conditionCounterA++;
                    break;
                case "B":
                    $conditionCounterB++;
                    break;
                case "C":
                    $conditionCounterC++;
                    break;
                case "D":
                    $conditionCounterD++;
                    break;
                case "E":
                    $conditionCounterE++;
                    break;
            }
        }

        if ($conditionCounterA == 5) {
            $conditionCounterCount++;
            echo "WIN combination for A" . PHP_EOL;
        } elseif ($conditionCounterB == 5) {
            $conditionCounterCount++;
            echo "WIN combination for B" . PHP_EOL;
        } elseif ($conditionCounterC == 5) {
            $conditionCounterCount++;
            echo "WIN combination for C" . PHP_EOL;
        } elseif ($conditionCounterD == 5) {
            $conditionCounterCount++;
            echo "WIN combination for D" . PHP_EOL;
        } elseif ($conditionCounterE == 5) {
            $conditionCounterCount++;
            echo "WIN combination for E" . PHP_EOL;
        }

    }
    //Counting multiplayer for win bet
    $combinationMultiply = 0;
    switch (count($combinationsPlayer)) {
        case 1:
            $combinationMultiply = 3;
            break;
        case 2:
        case 3:
        case 4:
            $combinationMultiply = 1.4;
            break;
        case 6:
        case 5:
            $combinationMultiply = 1.2;
            break;
        case 7:
            $combinationMultiply = 1.05;
            break;
    }
    //Wining bet counting
    if ($conditionCounterCount > 0) {
        $bank += $bet * $intDifficulty * $combinationMultiply;
        echo "Your deposit is -> " . $bank . PHP_EOL;
    } else {
        $bank -= $bet;
        echo "No wining combination, your deposit -> " . $bank . PHP_EOL;
    }

}

echo "You are out of credits\n";
