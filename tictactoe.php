<?php
//game variables
$player = "X";
$current = "true";
$cur_human = "X";
$gamemode = "c";
$board = ["_","_","_","_","_","_","_","_","_"];

//game entry
function gameIntro(){
    global $gamemode;
    if ($gamemode == "c") {
        changePlayer();
    } else {
        startGame();
    }
}

//change player
function changePlayer() {
    global $player, $current;
    $n_player = strtoupper(readline("Please Select Player(X/O)"));
    if ($n_player == "X" ||  $n_player == "O") {
        $player = $n_player;
        $current = ($n_player == "X") ? true : false;
        startGame();
    } else {
        changePlayer();
    }
    
}

//start game
function startGame() {
    global $current, $gamemode;
    if ($current == false && $gamemode == "c") {
        computerPlay();
    } else {
        humanPlay();
    }
}

//computer play
function computerPlay(){
    global $board, $player, $current;
    //get available slots
    $available = [];
    for ($j = 0; $j < count($board); $j++) {
        if ($board[$j] == "_") {
            array_push($available, $j);
        }        
    }
    //get random slot from available
    $slot = $available[rand(0, count($available)-1)];
    $board[$slot] = ($player == "X") ? "O" : "X";
    $current = true;
    echo "It'z computer's turn...\r\n\r\n";
    checkWin();
}

//restart
function restartGame() {
    global $player, $current, $cur_human, $gamemode, $board;
    $res = readline("Restart Game?(y/n)");
    switch ($res) {
        case 'y':
            echo "Restarting game...\r\n\r\n";
            //reset variables
            $player = "X";
            $current = true;
            $cur_human = "X";
            $gamemode = "c";
            $board = ["_","_","_","_","_","_","_","_","_"];
            //restart game
            showInstructions();
            break;
        case 'n':
            //end game
            echo("Game ended!");
            break;    
        
        default:
            restartGame();
            break;
    }
}

//human play
function humanPlay(){
    global $gamemode, $board, $player, $cur_human, $current;
    $no = readline("Please enter a slot number from available slots");
    if ($gamemode == "c") {
        if ($board[$no - 1] !== "_") {
            humanPlay();
        } else {
            $board[$no - 1] = $player;
            $current = false;
            
        }
    }
    else{
        if ($board[$no - 1] !== "_") {
            humanPlay();
        } else {
            $board[$no - 1] = $cur_human;
            $cur_human = ($cur_human == "X") ? "O" : "X";
            echo "It'z ".$cur_human."'s turn...\r\n\r\n";
        }
    }  
    
    checkWin();
}

//checkwin
function checkWin(){
    global $board, $gamemode, $player;
    //draw board
    for ($i = 1; $i <= count($board); $i++) {
        //check board size
        if ($i % 3 == 0) {
            //draw board
            echo "\t".$board[$i-3]."\t".$board[$i-2]."\t".$board[$i-1]."\r\n\r\n" ;
        }
    }
    //check for win
    if ($board[0] == "O" && $board[1] == "O" && $board[2] == "O" || $board[3] == "O" && $board[4] == "O" && $board[5] == "O" ||  $board[6] == "O" && $board[7] == "O" && $board[8] == "O" ||  $board[0] == "O" && $board[3] == "O" && $board[6] == "O" ||  $board[1] == "O" && $board[4] == "O" && $board[7] == "O" ||  $board[2] == "O" && $board[5] == "O" && $board[8] == "O" || $board[2] == "O" && $board[4] == "O" && $board[6] == "O" ||  $board[0] == "O" && $board[4] == "O" && $board[8] == "O") {
        echo($gamemode == "c" && strtolower($player) == "o") ? "You win\r\n\r\n" : "Player O wins\r\n\r\n";
        //restart
        restartGame();
    }
    else if ($board[0] == "X" && $board[1] == "X" && $board[2] == "X" || $board[3] == "X" && $board[4] == "X" && $board[5] == "X" ||  $board[6] == "X" && $board[7] == "X" && $board[8] == "X" ||  $board[0] == "X" && $board[3] == "X" && $board[6] == "X" ||  $board[1] == "X" && $board[4] == "X" && $board[7] == "X" ||  $board[2] == "X" && $board[5] == "X" && $board[8] == "X" || $board[2] == "X" && $board[4] == "X" && $board[6] == "X" ||  $board[0] == "X" && $board[4] == "X" && $board[8] == "X") {
        echo($gamemode == "c" && strtolower($player) == "x") ? "You win\r\n\r\n" : "Player X wins\r\n\r\n";
        //restart
        restartGame();
    }
    elseif (!in_array("_", $board)) {
        echo "It's a draw!\r\n\r\n";
        //restart
        restartGame();
    }
    else{
        startGame();
    }
}


//draw board
function drawBoard() {
    global $board;
    for ($i = 1; $i <= count($board); $i++) {
        //check board size
        if ($i % 3 == 0) {
            //draw board
            echo "\t".$board[$i-3]."\t".$board[$i-2]."\t".$board[$i-1]."\r\n\r\n" ;
        }
        
                
    }
} 

//instructions
function showInstructions() {
    echo drawBoard();
    echo "To play, simply input the corresponding slot number.\r\n Slots are numbered 0-9 from left to right";
    selectMode();
}

//game mode
function selectMode() {
    global $gamemode;
    $mode = readline("Please select game mode(c for computer and h for human)");
    if ($mode == "c" || $mode == "h") {
        $gamemode = $mode;
        gameIntro();
        
    } else {
        selectMode();
    }
} 

//enter game
showInstructions();



?>