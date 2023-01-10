<?php
    session_start() ; 
    include_once "../../../../config/Database.php" ; 
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
            $sub_arr[] = '<a href="../student/profile.php?student_id=' . $row['user_id'] . '">'.$counter.'</a>'; 
            $sub_arr[] = $row['user_first_name'] ;
            $sub_arr[] = $row['user_last_name'] ; 
            $sub_arr[] = $row['user_number'] ; 
            if($row['user_status'] == 'ACTIVE'){
                $sub_arr[] = '<span class="btn btn-sm bg-success text-light">'.ucfirst(strtolower($row['user_status'])).'</span>' ; 
            }else{
                $sub_arr[] = '<span class="btn btn-sm bg-danger text-light">'.ucfirst($row['user_status']).'</span>' ; 
            }
            $sub_arr[] = '
                <button data-title="Edit User" data-action="update" id="edit_button" class="btn btn-warning" data-user_id="' . $row['user_id'] . '"><i class="fa-solid fa-pen-to-square"></i></button>
                <button id="delete_button" class="btn btn-danger" data-user_id="' . $row['user_id'] . '"><i class="fa-sharp fa-solid fa-trash"></i></button>
            ' ; 
            $data[] = $sub_arr ; 
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