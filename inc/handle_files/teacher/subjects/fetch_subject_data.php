<?php
    if($_SERVER['REQUEST_METHOD'] == "POST"){
        session_start() ; 
        include_once "../../../../config/Database.php" ; 
        $database = new Database() ; 
        $db = $database->connect() ;
        extract($_REQUEST) ; 

        $q = "SELECT * FROM subjects WHERE subject_id = ?" ; 
        $stmt = $db->prepare($q) ; 
        $stmt->execute(array($subject_id)) ; 
        $data = '' ; 
        if($stmt->rowCount()){
            $res = $stmt->fetch() ; 
            $data = array(
                'status' => 'found',
                'data'=>array(
                    'subject_id' => $res['subject_id'],
                    'subject_title' => $res['subject_title'],
                    'subject_code' => $res['subject_code'],
                    'subject_status' => $res['subject_status']
                )
            ) ; 
        }else{
            $data = array(
                'status' => 'notfound',
                'data'=>''
            ) ; 
        }
        echo json_encode($data) ; 
        
    }

?>