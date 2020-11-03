<?php 

function askForActivity(){
    echo "Would you like to view your balance(1), withdraw(2), deposit(3), transfer funds to another account(4) or change your bound phone number(5)? To exit enter 0\n";
    $input = readline();
    if ($input == 0){
        return;
    }
    else{
        $GLOBALS["atm"]->action($GLOBALS["client"], $input);
        echo "Do you want to perform any other operation? Yes(1), No(0)\n";
        $input = readline();
        if ($input == 0){
            return;
        }
        else
            askForActivity();
    }
}

function newClient(){
    $input = readline();
    $result = $GLOBALS["atm"]->validate($input);
    if ($result){
        return $result;
    }
    else {
        $retry = 1;
        while ($retry){
            echo "No account matched. Do you want to try again? Yes(1), No(0)\n";
            $retry = readline();
            if ($retry == 1){
                echo "Enter your card number or phone number\n";
                $input = readline();
                $result = $GLOBALS["atm"]->validate($input);
                if ($result)
                    return $result;
            }
        }
    }
}

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
    
    