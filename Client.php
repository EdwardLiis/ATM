<?php

class Client {
    private $clientID;
    private $name;
    private $phoneNum;
    private $cardNum;
    private $balance;
    
    function Client($name, $phoneNum, $cardNum, $balance, $clientID){
        $this->name = $name;
        $this->phoneNum = $phoneNum;
        $this->cardNum = $cardNum;
        $this->balance = $balance;
        $this->clientID = $clientID;
    }
    
    public function getBalance(){
        return $this->balance;
    }

    public function changeBalance($amount){
        $this->balance += $amount;
    }
    
    public function getCardNum(){
        return $this->cardNum;
    }
    
    public function getName(){
        return $this->name;
    }
    
    public function getPhoneNum(){
        return $this->phoneNum;
    }
    
    public function changePhoneNum($newNum){
        $this->phoneNum = $newNum;
        echo "You successfully changed your phone number\n";
    }    
    
    //push changes in balance of phone number into database
    public function submitChanges(){
        $data = file_get_contents("Database.json");
        $json_a = json_decode($data);
        foreach ($json_a as $clientID => $client){
            if ($this->clientID == $clientID){
                $client->phoneNum = $this->phoneNum;
                $client->balance = $this->balance;
            }
            $data = json_encode($json_a);
            file_put_contents("Database.json", $data);
        }
    }
}
