<?php
session_start() ; 
include_once "../config/Database.php" ; 
include_once "../modules/Student.php";
$database = new Database() ; 
$db = $database->connect() ; 


$student = new Student($db) ; 

$res = $student->fetch_data($_SESSION['user_id']) ; 
if($res->rowCount()){
    while ($row = $res->fetch(PDO::FETCH_ASSOC)) {
        extract($row) ; 
        $student->set_user_first_name($user_first_name) ; 
        $student->set_user_last_name($user_last_name) ; 
        $student->set_user_number($user_number) ; 
        $student->set_user_image($user_image) ; 
        $student->set_user_status($user_status) ; 
        $student->set_user_password($user_password) ;
    }
    // now echo data
    echo '<h1>'.$student->get_user_first_name().'</h1>' ; 
    echo '<h2>'.$student->get_user_last_name().'</h2>' ; 
    echo '<h3>'.$student->get_user_number().'</h3>' ; 
    echo '<h4>'.$student->get_user_image().'</h4>' ; 
    echo '<h5>'.$student->get_user_status().'</h5>' ;  
}else{
    echo "there are no user with id = 3" ; 
}
echo '<a href="../logout.php">out</a>' ; 
