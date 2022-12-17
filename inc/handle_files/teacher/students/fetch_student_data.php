<?php
    if($_SERVER['REQUEST_METHOD'] == "POST"){
        session_start() ; 
        include_once "../../../../config/Database.php" ; 
        $database = new Database() ; 
        $db = $database->connect() ;
        extract($_REQUEST) ; 

        $q = "SELECT * FROM users INNER JOIN enrollments ON  user_id = enrollment_student_id WHERE user_id = ?" ; 
        $stmt = $db->prepare($q) ; 
        $stmt->execute(array($user_id)) ; 
        $data = '' ; 
        if($stmt->rowCount()){
            $res = $stmt->fetch() ; 
            $data = array(
                'status' => 'found',
                'data'=>array(
                    'user_id' => $res['user_id'],
                    'user_first_name' => $res['user_first_name'],
                    'user_last_name' => $res['user_last_name'],
                    'user_number' => $res['user_number'],
                    'user_status' => $res['user_status'],
                    'user_course' => $res['enrollment_subject_id'],
                    'previous_course_date' => $res['enrollment_started_at'],
                    'user_password' => $res['user_password']
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