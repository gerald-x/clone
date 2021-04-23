<?php 
class DBConnection{

    private $hostName = "localhost";
    private $hostUserName = "root";
    private $hostPassword = "";
    private $hostDbName = "fast_earners";
    public $connection;


function connect(){
    $this->connection = mysqli_connect($this->hostName,$this->hostUserName,$this->hostPassword,$this->hostDbName)or die("Could not connect");
}


function selectData($data_array,$table,$condition,$orderCond,$order){
    $datastring = "";
    $count = 0;
    $returning_data = array();
    $num_rows = 0;
    //Check whether the argument is all
    if($data_array == "*"){
        $datastring = "*";
    }
    else{
    foreach($data_array as $data){
        if($count >=1 ){
            $datastring .=','.  $data;
        }
        else{
            $datastring .= $data;
        }
        $count+=1;
  
    }
}
    //Checks the conditional statements
    if(empty($condition)){
$condition = "";
    }
    else{
$condition = "WHERE ".$condition;
    }
    if($order == 0){
        $order = $orderCond ." ASC";
    }
    else{
        $order = $orderCond ." DESC";
    }
    //checks the order uses default if not found
$query = "SELECT $datastring FROM $table ".$condition." ORDER BY ".$order.";";
// echo $query;
//Executes Query
$result = mysqli_query($this->connection,$query);

//Fetches Data


echo mysqli_error($this->connection);

$results = array();
//$rows = mysqli_fetch_assoc($result);


//returns array of data
while($row = mysqli_fetch_assoc($result)){
array_push($results,$row);
}
return $results;

}


function updateData($data_update,$table,$condition){




    if(empty($condition)){
        $condition = "";
            }
            else{
        $condition = "WHERE ".$condition;
            }

            $query = "UPDATE $table SET ".$data_update." ".$condition.";";
    // echo $query;
   
            $result = mysqli_query($this->connection,$query);
            echo mysqli_error($this->connection);
            
            return $result;

}

function insertData($columns,$values,$table){
 $columnString = "";
 $insertString = "";
$columnCount = 0;
$insertCount = 0;

    foreach($columns as $data){
        if($columnCount >=1 ){
            $columnString .=','.  $data;
        }
        else{
            $columnString .= $data;
        }
        $columnCount+=1;
  
    }
    foreach($values as $data){
        $data = mysqli_real_escape_string($this->connection,$data);
        $data = "'".$data."'";
        if($insertCount >=1 ){
            $insertString .=','.  $data;
        }
        else{
            $insertString .= $data;
        }
        $insertCount+=1;
  
    }
   $query = "INSERT INTO $table(".$columnString.") VALUES(".$insertString.")";
   //echo $query;

   $result = mysqli_query($this->connection,$query);
      echo mysqli_error($this->connection);
   return $result;
}







}