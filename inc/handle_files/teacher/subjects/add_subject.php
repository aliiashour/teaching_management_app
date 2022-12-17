<?php


    if($_SERVER['REQUEST_METHOD'] == "POST"){
        session_start() ; 
        include_once "../../../../config/Database.php" ; 
        $database = new Database() ; 
        $db = $database->connect() ; 

        extract($_REQUEST) ; 
        $q = "INSERT INTO subjects SET 
                subject_title = :subject_title,
                subject_code = :subject_code,
                subject_status = :subject_status,
                subject_publisher = :subject_publisher" ; 
        $stmt = $db->prepare($q) ; 
        $res = $stmt->execute(array(
            ':subject_title' => $subject_title,
            ':subject_code' => $subject_code,
            ':subject_status' => $subject_status,
            ':subject_publisher' => $_SESSION['user_id']
        ));
        $data = '' ; 
        if($res){
            $data = array('status' => 'success', 'msg'=>'subject successfully added') ; 
        }else{
            $data = array('status' => 'failed', 'msg'=>'can not add subject') ; 
        }       
        echo json_encode($data) ; 
    }