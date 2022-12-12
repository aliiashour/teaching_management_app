<?php

    if($_SERVER['REQUEST_METHOD'] == "POST"){
        session_start() ; 
        include_once "../../../config/Database.php" ; 
        $database = new Database() ; 
        $db = $database->connect() ; 
        extract($_REQUEST) ; 
        $q = "DELETE FROM users WHERE user_id = :user_id" ; 
        $stmt = $db->prepare($q) ; 
        $res = $stmt->execute(array(':user_id' => $user_id));
        $data = '' ; 
        if($res){
            $data = array('status' => 'success') ; 
        }else{
            $data = array('status' => 'failed') ; 
        }
        
        echo json_encode($data) ; 

        
    }