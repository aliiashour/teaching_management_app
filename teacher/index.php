<?php
session_start() ; 
include_once "../config/Database.php" ; 
include_once "../modules/Teacher.php";
$database = new Database() ; 
$db = $database->connect() ; 


$teacher = new Teacher($db) ; 

$res = $teacher->fetch_data($_SESSION['user_id']) ; 
if($res->rowCount()){
    while ($row = $res->fetch(PDO::FETCH_ASSOC)) {
        extract($row) ; 
        $teacher->set_user_first_name($user_first_name) ; 
        $teacher->set_user_last_name($user_last_name) ; 
        $teacher->set_user_number($user_number) ; 
        $teacher->set_user_image($user_image) ; 
        $teacher->set_user_status($user_status) ; 
        $teacher->set_user_password($user_password) ;
    }
    // now echo data
    echo '<h1>'.$teacher->get_user_first_name().'</h1>' ; 
    echo '<h2>'.$teacher->get_user_last_name().'</h2>' ; 
    echo '<h3>'.$teacher->get_user_number().'</h3>' ; 
    echo '<h4>'.$teacher->get_user_image().'</h4>' ; 
    echo '<h5>'.$teacher->get_user_status().'</h5>' ;  
}else{
    echo "there are no user with id = 3" ; 
}
echo '<a href="../logout.php">out</a>' ; 
