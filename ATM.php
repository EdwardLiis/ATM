<?php

include 'Client.php';

class ATM {
    public function init(){
        echo "Welcome to SomeBankATM \nTo start, please enter your card number or phone number \n";
    }
    
    public function validate($input){
        $data = file_get_contents("Database.json");
        $json_a = json_decode($data);
        foreach ($json_a as $clientID => $client){
            if ($input == $client->cardNum || $input == $client->phoneNum){
                $curClient = new Client($client->name, $client->phoneNum, $client->balance, $clientID);
                return $curClient;
            }
        }
    } 
    
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
    
    private function deposit($client){
        echo "How much do you want to deposit?\n";
        $input = readline();
        echo "Please put the cash into the bill slot";
        echo "*You put ".$input." cash into the bill slot";
        $client->changeBalance($input);
        $client->submitChanges();
    }
    
    private function numChange($client){
       echo "Enter your new phone number\n";
       $input = readline();
       $client->changePhoneNum($input);
       $client->submitChanges();
    }
    
    private function transfer($client){
        echo "Enter recipient card number or phone number\n";
        $recipientNum = readline();
        echo "Enter how much do you want to transfer\n";
        $amount = readline();
        if ($client->getBalance() < $amount){
            echo "Insufficient funds\n";
            return;
        }
        $recipient = $this->validate($recipientNum);
        $recipient->changeBalance($amount);
        $recipient->submitChanges();
        $client->changeBalance($amount*-1);
        $client->submitChanges();
        
    }
    
    public function action($client, $input){
        //echo "Would you like to view your balance(1), withdraw(2), deposit(3) or change your bound phone number(4)?\n";
        //$input = readline();
        switch($input){
            case 1: 
                echo $client->getBalance()."\n";
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
        }
    }
}
