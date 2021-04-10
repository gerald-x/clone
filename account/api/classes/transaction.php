<?php
class Transaction{
public $id;
public $userId;
public $amount;
public $status;
public $date;
public $type;


function addTransaction(){
  global $conn;
    $result = 0;
    $this->date = date("Y-m-d");


    $result = $conn->insertData(array("userId","amount","status","type","date"),array("$this->userId","$this->amount","$this->status","$this->type","$this->date"),"transactions");

//Registers a new Transaction;

return $result;
}


function getTransactions(){
  global $conn;
  //gets all transactions
  $result = $conn->selectData("*","transactions","userId = $this->userId","id",1);
//Returns an array of all the users transactions
  return $result;
}

}