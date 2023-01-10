<?php
    session_start() ; 
    include_once "../../../../config/Database.php" ; 
    $database = new Database() ; 
    $db = $database->connect() ; 

    $q = "SELECT * FROM subjects WHERE subject_publisher = :teacher_id " ; 
    $stmt = $db->prepare($q) ; 
    $stmt->execute(array(
        ':teacher_id' => $_SESSION['user_id']
    )) ; 
    $count_all_rows = $stmt->rowCount() ; 

    if(isset($_POST['search']['value'])){
        $search_value = $_POST['search']['value'] ; 
        $q .= "AND (subjects.subject_title LIKE '%" . $search_value . "%'" ; 
        $q .= " OR subjects.subject_code LIKE '%" . $search_value . "%'" ; 
        $q .= " OR subjects.subject_status LIKE '%" . $search_value . "%')" ; 
         
    }

    if(isset($_POST['order'])){
        $column = $_POST['order'][0]['column'] ; 
        $order = $_POST['order'][0]['dir'] ; 
        $q .= " order by " . $column . " " . $order ; 
    }else{
        $q .= " order by subjects.subject_title ASC" ; 
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
            $sub_arr[] = '<a href ="./subject.php?subject_id=' . $row['subject_id'] . '">' . $row['subject_title'] . '</a>' ;
            $sub_arr[] = $row['subject_code'] ;
            if($row['subject_status'] == 'ACTIVE'){
                $sub_arr[] = '<span class="btn btn-sm bg-success text-light">'.ucfirst(strtolower($row['subject_status'])).'</span>' ; 
            }else{
                $sub_arr[] = '<span class="btn btn-sm bg-danger text-light">'.ucfirst($row['subject_status']).'</span>' ; 
            }
            $sub_arr[] = '
                <button data-title="Edit Subject" data-action="update" id="edit_button" class="btn btn-warning" data-subject_id="' . $row['subject_id'] . '"><i class="fa-solid fa-pen-to-square"></i></button>
                <button id="delete_button" class="btn btn-danger" data-subject_id="' . $row['subject_id'] . '"><i class="fa-sharp fa-solid fa-trash"></i></button>
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