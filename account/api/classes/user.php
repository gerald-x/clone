<?php
class User{

public $id;
public $first_name;
public $last_name;
public $username;
public $email;
public $date_joined;
public $phone_number;
public $profile_image;
public $referrer;
public $is_verified;


function setDetails(){
    global $conn;
    $all_details = $conn->selectData("*","users","id = $this->id","id",0);
    
    foreach($all_details as $details){
       // print_r($details);

    $this->email = $details['email'];
    $this->phone_number = $details['phone_number'];
    $this->profile_image = $details['profile_image'];
    $this->date_joined = $details['date_joined'];
    
    $this->is_verified = $details['is_verified'];
    }

}

function updateUserDetail($detail,$value){
global $conn;
$result = $conn->updateData($detail." = '".$value."'","users","id = '$this->id'");
return $detail;

}


function loginUser($email,$password){
    global $conn;
        //Algorithm checks for errors during Login
    $error;
    $reason;
    
    
    $nameResult = $conn->selectData("*","users","email = '$email'","email",0);
    $isContained = array_sum($nameResult);
    foreach($nameResult as $row){
        $isContained =1;
    }
  
    
    $passresult =$conn->selectData("*","users","email = '$email'","email",0);
    $isPasswordContained = 0;
  foreach($passresult as $row){
       $isPasswordContained = password_verify($password,$row['password']); 
      }
    
    
    if($isContained < 1  AND $isPasswordContained != 1 ){
    $reason = "your credentials does not match our records";
    $error = true;
    }
    
    
    elseif($isContained == 1  AND $isPasswordContained != 1 ){
    $reason = "user found please type in your password correctly";
    $error = true;
    }
    
    
    elseif($isContained == 1  AND $isPasswordContained == 1 ){
    $reason = "Login Success";
    $error = false;
    foreach($passresult as $row){
        $this->id = $row['id'];
       }
  ;
    
    
    }
    else{
    $reason = "An Unknown reason occured please try again later";
    $error = true; 
    }
    
    
    
    return array("error"=>$error,"reason"=>$reason,"userId" => $this->id);
    
    
    
    
    }
    
  function changePassword($oldPassword,$newPassword,$confirmNewPassword){
    global $conn;
    if($newPassword != $confirmNewPassword){
        //return error if confirmation isn't correct
    return array("error"=>true,"reason"=>"Password Confirmation Not Correct");
    
    }
    else{
    $passwords = $conn->selectData(array("password"),"users","id = $this->id","password",1);
    $previousPassword = "";
    foreach($passwords as $pass){
        $previousPassword = $pass['password'];
    }
    
    if(password_verify($oldPassword,$previousPassword) != 1 && $oldPassword != "RECOVERED"){
        //return error if old password isn't correct
        return array("error"=>true,"reason"=>"Old Password not correct");
    }
    else{

      $newPassword = password_hash($newPassword,PASSWORD_DEFAULT);
        //if no more errors update the database
        $result = $conn->updateData("password = '$newPassword'","users","id = $this->id");
 
    if($result == true){
        return array("error"=>false,"reason"=>"Password Changed Successfully");
    }
    else{
        return array("error"=>true,"reason"=>"An error occured please try again later");
    }
      
    }
    
    
    }
    
    }
}
