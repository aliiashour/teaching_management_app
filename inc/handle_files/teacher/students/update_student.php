
<?php

if($_SERVER['REQUEST_METHOD'] == "POST"){
    session_start() ; 
    include_once "../../../../config/Database.php" ; 
    $database = new Database() ; 
    $db = $database->connect() ;
    extract($_REQUEST) ; 
    $q = "UPDATE users SET 
        user_first_name = :user_first_name,
        user_last_name = :user_last_name,
        user_number = :user_number,
        user_status = :user_status";
       if(strlen($user_password) > 0 ) {
        $q .= ", user_password=:user_password" ; 
       }
        $q .= " WHERE user_id = :user_id" ; 
    $stmt = $db->prepare($q) ; 
    $res = false ; 
    if(strlen($user_password) > 0 ) {
        $res = $stmt->execute(array(
            ':user_first_name' => $user_first_name,
            ':user_last_name' => $user_last_name,
            ':user_number' => $user_number,
            ':user_status' => $user_status,
            ':user_password' => sha1($user_password),
            ':user_id' => $user_id
        ));
    }else{
        $res = $stmt->execute(array(
            ':user_first_name' => $user_first_name,
            ':user_last_name' => $user_last_name,
            ':user_number' => $user_number,
            ':user_status' => $user_status,
            ':user_id' => $user_id
        ));
    }
    if($res){
        // here i shoud update student enrollment course
        $q = "UPDATE enrollments SET 
            enrollment_subject_id = :enrollment_subject_id, 
            enrollment_started_at = :enrollment_current_date
            WHERE enrollment_student_id = :enrollment_student_id AND enrollment_started_at = :enrollment_started_at"; 
        $stmt = $db->prepare($q) ; 
        $res = $stmt->execute(array(
            ':enrollment_subject_id' => $user_course,
            ':enrollment_current_date' => date('Y-m-d', time()),
            ':enrollment_student_id' => $user_id,
            // how to get the previous course enrollment date for this spesific user 
            // i have the student id and next course id !!
            ':enrollment_started_at' => $previous_course_date
        ));
        if($res){
            $data = array('status' => 'success', 'msg'=>'student successfully edited') ; 
        }else{
            $data = array('status' => 'failed', 'msg'=>'can not edit student') ; 
        }
    }else{
        $data = array('status' => 'failed', 'msg'=>'can not edit student data') ; 
    }
    
    echo json_encode($data) ; 

    
}