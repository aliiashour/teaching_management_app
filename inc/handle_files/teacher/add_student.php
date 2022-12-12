<?php


    if($_SERVER['REQUEST_METHOD'] == "POST"){
        session_start() ; 
        include_once "../../../config/Database.php" ; 
        $database = new Database() ; 
        $db = $database->connect() ; 

        extract($_REQUEST) ; 
        if(strlen($user_password) > 0){
            $q = "INSERT INTO users SET 
                user_first_name = :user_first_name,
                user_last_name = :user_last_name,
                user_number = :user_number,
                user_status = :user_status,
                user_password = :user_password" ; 
            $stmt = $db->prepare($q) ; 
            $res = $stmt->execute(array(
                ':user_first_name' => $user_first_name,
                ':user_last_name' => $user_last_name,
                ':user_number' => $user_number,
                ':user_status' => $user_status,
                ':user_password' => sha1($user_password)
            ));
            $data = '' ; 
            if($res){
                // here i shoud insert student enrollment course
                $q = "INSERT INTO enrollments SET 
                    enrollment_student_id = :enrollment_student_id,
                    enrollment_subject_id = :enrollment_subject_id"; 
                $stmt = $db->prepare($q) ; 
                $res = $stmt->execute(array(
                    ':enrollment_student_id' => $db->lastInsertId(),
                    ':enrollment_subject_id' => $user_course
                ));
                if($res){
                    $data = array('status' => 'success', 'msg'=>'student successfully added') ; 
                }else{
                    $data = array('status' => 'failed', 'msg'=>'can not add student') ; 
                }
            }else{
                $data = array('status' => 'failed', 'msg'=>'can not add student') ; 
            }       
            echo json_encode($data) ; 
        }else{
            $data = array('status' => 'failed', 'msg'=>'fill all fieds') ; 
            
            echo json_encode($data) ; 
        }
    }