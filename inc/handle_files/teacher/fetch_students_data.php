<?php
    session_start() ; 
    include_once "../../../config/Database.php" ; 
    $database = new Database() ; 
    $db = $database->connect() ; 

    $q = "SELECT * FROM users INNER JOIN enrollments ON 
        users.user_id = enrollments.enrollment_student_id 
        WHERE enrollments.enrollment_subject_id IN (SELECT subject_id FROM subjects WHERE subject_publisher = :teacher_id)" ; 
    $stmt = $db->prepare($q) ; 
    $stmt->execute(array(
        ':teacher_id' => $_SESSION['user_id']
    )) ; 
    $count_all_rows = $stmt->rowCount() ; 

    if(isset($_POST['search']['value'])){
        $search_value = $_POST['search']['value'] ; 
        $q .= "AND (users.user_first_name LIKE '%" . $search_value . "%'" ; 
        $q .= " OR users.user_last_name LIKE '%" . $search_value . "%'" ; 
        $q .= " OR users.user_number LIKE '%" . $search_value . "%'" ; 
        $q .= " OR users.user_status LIKE '%" . $search_value . "%')" ; 
         
    }

    if(isset($_POST['order'])){
        $column = $_POST['order'][0]['column'] ; 
        $order = $_POST['order'][0]['dir'] ; 
        $q .= " order by " . $column . " " . $order ; 
    }else{
        $q .= " order by users.user_first_name ASC" ; 
    }

    if(isset($_POST['length']) && $_POST['length'] != -1){
        $start = $_POST['start'] ; 
        $length = $_POST['length'];
        $q .= ' LIMIT ' . $start . ', ' . $length ; 
    }

    $data =array() ; 
    $stmt = $db->prepare($q) ; 
    $stmt->execute(array(
        ':teacher_id' => $_SESSION['user_id']
    )) ; 
    $filtered_rows = $stmt->rowCount() ; 
    $counter= 1 ; 
    if($stmt->rowCount()){
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $sub_arr = array() ; 
            $sub_arr[] = $counter; 
            $sub_arr[] = $row['user_first_name'] ;
            $sub_arr[] = $row['user_last_name'] ; 
            $sub_arr[] = $row['user_number'] ; 
            // count
            $sub_arr[] = '<span class="btn btn-sm bg-danger text-light">'.$row['user_status'].'</span>' ; 
            // if($row['status'] != 'closed'){
            //     $sub_arr[] = '<a class="btn btn-md btn-info" href="../takeSurvey/index.php?survey_id='.$row['survey_id'].'" target="_blank"><i class="fa-solid fa-list"></i></a>' ; 
            // }
            // $sub_arr[] = '' ; 
            
            // $data[] = $sub_arr ; 
            $sub_arr[] = 'edit' ; 
            $counter +=1 ; 
        }
    }
   

    $output = array(
        'data'=>$data,
        'draw'=>intval($_POST['draw']),
        'recordsTotal'=>$filtered_rows, // 10
        'recordsFiltered'=>$count_all_rows, //14
    ) ; 
    echo json_encode($output) ; 