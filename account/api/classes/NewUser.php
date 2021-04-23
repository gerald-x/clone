<?php 
class NewUser extends User{



function signupUser($first_name,$last_name,$username,$email,$referrer,$password){
global $conn;
$details_result;
$date = date("Y-m-d");
$result = $conn->insertData(array("first_name","last_name","username","email","password","date_joined","profile_image"),array($first_name,$last_name,$username,$email,$password,$date,"".BASE_URL."/account/uploads/blank.jpg"),"users");
if($result == true){
    $newId = $conn->selectData(array("id"),"users","email = '$email'","email",0);
    foreach($newId as $id){
       
        $details_result = $conn->insertData(array("owner_id","referrer"),array($id['id'],$referrer),"user_details");
        if($details_result == true){
            $this->addReferral($referrer);
        }
    }

    return $details_result;
}
else{
    return $result;
}




}

function addReferral($id){
    global $conn;
    $result = $conn->updateData("current_referrals = current_referrals + 1,total_referrals = total_referrals + 1","user_details","owner_id = $id");

}

}