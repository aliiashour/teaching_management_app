<?php

    if($_SERVER['REQUEST_METHOD'] == "POST"){
        session_start() ; 
        include_once "../../../../config/Database.php" ; 
        $database = new Database() ; 
        $db = $database->connect() ; 
        extract($_REQUEST) ; 
        $q = "DELETE FROM subjects WHERE subject_id = :subject_id" ; 
        $stmt = $db->prepare($q) ; 
        $res = $stmt->execute(array(':subject_id' => $subject_id));
        $data = '' ; 
        if($res){
            $data = array('status' => 'success') ; 
        }else{
            $data = array('status' => 'failed') ; 
        }
        
        echo json_encode($data) ; 

        
    }