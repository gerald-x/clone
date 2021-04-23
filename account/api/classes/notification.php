<?php
class Notification{
    public $id;
    public $ownerId;
    public $date;
    public $content;
    public $isRead;
    public $type;



    function addNotification(){
        global $conn;
        $this->date = date("Y-m-d");

//$quer = "INSERT INTO notifications() VALUES();";

$result = $conn->insertData(array("ownerId","date","content","isRead","type"),array("$this->ownerId","$this->date","$this->content",false,"$this->type"),"notifications");

return $result;
    }

    function getNotification(){
        global $conn;
        $quer = "SELECT * from notifications WHERE id = $this->id ORDER BY date DESC;";
        $result = $conn->selectData("*","notifications","id = $this->id","id",1);

return $result;


    }
    function registerRead(){
        global $conn;
     
        $result = $conn->updateData("isRead = true","notifications","id = $this->id");
        return $result;
    }
    
    function getNotifications(){
        global $conn;
        $result =  $result = $conn->selectData("*","notifications","ownerId = $this->ownerId","id",1);
      //  print_r($result);
      return $result;


        }


    


}