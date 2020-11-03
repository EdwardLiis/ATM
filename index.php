<?php 

//DIDN'T IMPLEMENT CHECKING IF INPUT IS NEGATIVE NUMBER OR RIGHT FORMAT, SINCE ATM KEYBOARD RESTRICS TO INPUT INT ONLY
//ALSO INPUTS LIKE YES OR NO TAKE ANY NON 0 VALUE AS YES, CHECK COULD BE IMPLEMENTED BUT DON'T SEE A REASON TO DO SO


//select operation menu
function askForActivity(){
    echo "Would you like to view your balance(1), withdraw(2), deposit(3), transfer funds to another account(4) or change your bound phone number(5)? To exit enter 0\n";
    $input = readline();
    if ($input){
        $GLOBALS["atm"]->action($GLOBALS["client"], $input);
        echo "Do you want to perform any other operation? Yes(1), No(0)\n";
        $input = readline();
        if ($input){
            askForActivity();
        }
    }
}

//register client working with ATM
function newClient(){
    $input = readline();
    $result = $GLOBALS["atm"]->validate($input);
    return $result;
}

//cycle of operation - greeting, register client, ask for activity, logout.
include 'ATM.php';
    $atm = new ATM;
    $powerON = true;
    while ($powerON){
        $atm->init();
        $client = newClient();
        if ($client){
            echo "Hello ".$client->getName()."\n";
            askForActivity();
        }
    }
    
    