<?php

include 'Client.php';

class ATM {
    
    public function init(){
        echo "Welcome to SomeBankATM \nTo start, please enter your card number or phone number \n";
    }
    
    //search for account in database, and if found return Client object.
    public function validate($input){
        $data = file_get_contents("Database.json");
        $json_a = json_decode($data);
        foreach ($json_a as $clientID => $client){
            if ($input == $client->cardNum || $input == $client->phoneNum){
                $curClient = new Client($client->name, $client->phoneNum, $client->cardNum, $client->balance, $clientID);
                return $curClient;
            }
        }
        
        //failsafe if no matches were found
        echo "No account matched. Do you want to try again? Yes(1), No(0)\n";
        $retry = readline();
        if ($retry){
            echo "Enter card number or phone number\n";
            $input = readline();
            return $this->validate($input);
        }
    } 
    //withdraw money from account
    private function withdraw($client){
        echo "How much do you want to withdraw?\n";
        $input = readline();
        if ($client->getBalance() < $input){
            echo "Insufficient funds\n";
            return;
        }
        echo "*ATM emits ".$input." cash*\n";
        $client->changeBalance($input*-1);
        $client->submitChanges();
    }
    
    
    //deposit money to account
    private function deposit($client){
        echo "How much do you want to deposit?\n";
        $input = readline();
        echo "Please put the cash into the bill slot\n";
        echo "*You put ".$input." cash into the bill slot\n";
        $client->changeBalance($input);
        $client->submitChanges();
    }
    
    //change client phone number
    private function numChange($client){
       echo "Enter your new phone number\n";
       $input = readline();
       $client->changePhoneNum($input);
       $client->submitChanges();
    }
    
    //transfer money from 1 recipient to another
    private function transfer($client){
        echo "Enter recipient card number or phone number\n";
        $recipientNum = readline();
       
        //failsafe if client enters his own number, useless now but may be good idea if transfers have a commission 
        if ($recipientNum == $client->getCardNum() || $recipientNum == $client->getPhoneNum()){
            echo "You have entered your own account info!\n";
            return;
        }
        
        $recipient = $this->validate($recipientNum);
        if ($recipient){
        echo "Enter how much do you want to transfer\n";
        $amount = readline();
        if ($client->getBalance() < $amount){
            echo "Insufficient funds\n";
            return;
        }
        $recipient->changeBalance($amount);
        $recipient->submitChanges();
        $client->changeBalance($amount*-1);
        $client->submitChanges();
        }
        
    }
    
    //operation menu controller. 
    public function action($client, $input){
        switch($input){
            case 1: 
                echo "Your balance is ".$client->getBalance()."\n";
                break;
            case 2:
                $this->withdraw($client);
                break;
            case 3: 
                $this->deposit($client);
                break;
            case 4:
                $this->transfer($client);
                break;
            case 5: 
               $this->numChange($client);
                break;
            default:
                echo "Invalid input\n";
                break;
        }
    }
}
