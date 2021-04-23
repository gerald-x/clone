<?php 
define('BASE_URL',"http://".$_SERVER['SERVER_NAME'].'/smartearners');

$conn = new DBConnection;
$conn->connect();

$site_status = 0;

$siteResult = $conn->selectData("*","siteinfo","accessor = 'site_status'","accessor",1);
foreach($siteResult as $result){
    $site_status =  $result['value'];
};

if($site_status == false){
exit("Website is not active");
}
else{
  
}