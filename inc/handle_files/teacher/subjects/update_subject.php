
<?php

if($_SERVER['REQUEST_METHOD'] == "POST"){
    session_start() ; 
    include_once "../../../../config/Database.php" ; 
    $database = new Database() ; 
    $db = $database->connect() ;
    extract($_REQUEST) ; 
    $q = "UPDATE subjects SET 
            subject_title = :subject_title,
            subject_code = :subject_code,
            subject_status = :subject_status WHERE subject_id = :subject_id" ; 
    $stmt = $db->prepare($q) ; 
    $res = $stmt->execute(array(
        ':subject_title' => $subject_title,
        ':subject_code' => $subject_code,
        ':subject_status' => $subject_status,
        ':subject_id' => $subject_id
    ));
    if($res){
        $data = array('status' => 'success', 'msg'=>'subject successfully edited') ; 
    }else{
        $data = array('status' => 'failed', 'msg'=>'can not edit subject data') ; 
    }
    
    echo json_encode($data) ; 

    
}