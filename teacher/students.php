<?php
    /////////////////////////////////////////////////////////////////////////////
    //Student page///////////////////////////////

    $page_title = "students" ; 
    include_once "./init.php" ; 

    $res = $teacher->fetch_data($_SESSION['user_id']) ; 
    if($res->rowCount()){
        // teacher is found
        // get teacher data
        while ($row = $res->fetch(PDO::FETCH_ASSOC)) {
            extract($row) ; 
            $teacher->set_user_first_name($user_first_name) ; 
            $teacher->set_user_last_name($user_last_name) ; 
            $teacher->set_user_number($user_number) ; 
            $teacher->set_user_image($user_image) ; 
            $teacher->set_user_status($user_status) ; 
            $teacher->set_user_password($user_password) ;
        }

        ?>
            <!-- complete main page design -->
                    <!-- after nav design -->
                    <div class="menu col-3 text-light">
                        <!-- menu -->
                        <!-- title -->
                        <p class="main-category col-12 text-gray text-uppercase fw-semibold text-muted">main category</p>

                        <!-- get all teacher category -->
                        <div class="categoreys col-12">
                            <ul>
                                <div class="container-fluid">
                                    <?php
                                        $data = $teacher->get_main_category() ; 
                                        $item = '' ; 
                                        $i = 0 ; 
                                        foreach ($data['categores'] as $category) {
                                            $item .='
                                                    <div class="row">
                                                            <div class="col-6 text-start">
                                                                <li class="';
                                                                if($page_title == $category || ($page_title =='dashboard' && $category =='home')){
                                                                    $item .='active' ; 
                                                                }
                                                                $item .= '">
                                                                    '.$data['icons'][$i].' <a class="text-capitalize';
                                                                
                                                                if($page_title == $category || ($page_title =='dashboard' && $category =='home')){
                                                                    $item .=' active' ; 
                                                                }   
                                                                $item .= '" ';
                                                                if($category == 'home'){
                                                                    $item .= 'href="./"' ; 
                                                                }elseif($category == "change password"){
                                                                    $item .= 'id="change_password_button"' ; 
                                                                }else{
                                                                    $item .= 'href="./'.$category.'.php"' ;
                                                                }
                                                                $item .='>'.$category.'</a>
                                                                </li>
                                                            </div>
                                                    </div>' ; 
                                                            // on line -2
                                                            // <div class="col-6 text-end">
                                                            //     <span class="text-end"><i data-target="'.$category.'_'.$i.'" class="category-dropdown-icon fa-solid fa-angle-right fs-5"></i></span>
                                                            // </div>
                                                            // <div id="'.$category.'_'.$i.'" class="category col-12">
                                                            //     '.$category.' Actions
                                                            // </div>
                                                            
                                            $i = $i +1 ; 
                                        }
                                        echo $item ; 
                                    ?>
                                </div>
                            </ul>
                        </div>
                    </div>
                    <div class="data col-9">
                        <!-- tables data -->
                        <h1 class="text-capitalize">
                            student management page
                        </h1>
                        <div class="row">
                            <div class="col-12 bg-dark text-light">just links</div>
                        </div>
                        <div class="row">
                            <div class="col-12 text-end">
                                <button data-title='Add Student' data-action='add' id="add_user_button" class="btn btn-md btn-primary">add</button>
                            </div>
                        </div>
                        <div class="students">
                            <div id="response"></div>
                            <table id="datatable" class="table hover">
                                <thead>
                                    <th>S.N</th>
                                    <th>First name</th>
                                    <th>Second name</th>
                                    <th>Number</th>
                                    <!-- <th>Subject count</th> -->
                                    <th>Status</th>
                                    <th>Action</th>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        <?php
        // now echo data
        echo '<h1>'.$teacher->get_user_first_name().'</h1>' ; 
        echo '<h2>'.$teacher->get_user_last_name().'</h2>' ; 
        echo '<h3>'.$teacher->get_user_number().'</h3>' ; 
        echo '<h4>'.$teacher->get_user_image().'</h4>' ; 
        echo '<h5>'.$teacher->get_user_status().'</h5>' ;  
    }else{
        echo "there are no user with id = 3" ; 
    }
    echo '<a href="../logout.php">out</a>' ; 

?>
    <?php include_once $templates. "footer.php" ?>
    <script>
        
        // setting datatable
        $("#datatable").DataTable({
            "pagingType": 'full_numbers',
            // "processing":true,
            "reponsive":true,
            "language":{
                "search":"_INPUT_",
                "searchPlaceholder":"Search..."
            },
            "serverSide" : true,
            "select" : true,
            "lengthChange":true,
            "paging":true,
            "order":[],
            "ajax":{
                "url":"../inc/handle_files/teacher/students/fetch_students_data.php",
                "type":"post",
            },
            "fnCreateRow":function(nRow, aData, iDataIndex){
                $(nRow).attr('id', aData[0]) ; 
            },
            "columnDefs":[{
                "target":[0,5],
                "orderable":false,
            }]
        }) ; 
        
        $(document).on('click', '#add_user_button', function(){
            $("#user_first_name").val('') ;
            $("#user_last_name").val('') ; 
            $("#user_number").val('') ; 
            $("#user_password").val('') ; 
            $("#user_status").val('') ; 
            $("#user_course").val('') ; 
            $modal_title = $(this).data("title") ; 
            $modal_action = $(this).data("action") ; 
            $("#title").html($modal_title) ;
            $("#action").html($modal_action) ;
            $("#user_modal").modal('show') ; 
        }) ; 
        // click to edit button
        $(document).on('click', '#edit_button', function(){
            var user_id = $(this).data('user_id') ; 
            $modal_title = $(this).data("title") ; 
            $modal_action = $(this).data("action") ; 
            $("#title").html($modal_title) ;
            $("#action").html($modal_action) ;
            if(user_id != ''){
                // now fetch user data
                $.ajax({
                    url:"../inc/handle_files/teacher/students/fetch_student_data.php",
                    method:"POST",
                    data:{user_id:user_id},
                    success:function(data){
                        var json = JSON.parse(data) ;
                        if(json.status =='found'){
                            // exist user
                            $("#user_id").val(json['data']['user_id']) ; 
                            $("#user_first_name").val(json['data']['user_first_name']) ; 
                            $("#user_last_name").val(json['data']['user_last_name']) ;  
                            $("#user_number").val(json['data']['user_number']); 
                            $("#user_status").val(json['data']['user_status']) ;
                            $("#user_course").val(json['data']['user_course']) ;
                            $("#previous_course_date").val(json['data']['previous_course_date']) ;
                            $("#user_password").val('') ;
                            $("#user_modal").modal('show') ; 
                        }
                    }
                }) ; 
            }
        }) ;

        // delete user
        $(document).on('click', '#delete_button', function(){
            var user_id = $(this).data("user_id") ; 
            // now delete user directly
            if(confirm('are you sure?')){
                $.ajax({
                    url:"../inc/handle_files/teacher/students/delete_student.php",
                    method:"POST",
                    data:{user_id:user_id},
                    success:function(data){
                        json = JSON.parse(data) ; 
                        if(json['status'] == 'success'){
                            $("#datatable").DataTable().draw() ; 
                            $("#response").html('<div class="alert alert-success text-start">user deleted</div>') ; 
                            setTimeout(function(){
                                $("#response").html('') ; 
                            }, 2000) ; 
                        }
                    }
                });
            }
        }) ; 

        
        // submit the modal 
        $(document).on("submit", "#user_modal", function(event){
            event.preventDefault() ;
            var user_id = $("#user_id").val() ; 
            var user_first_name = $("#user_first_name").val() ; 
            var user_last_name = $("#user_last_name").val() ; 
            var user_number = $("#user_number").val() ; 
            var user_password = $("#user_password").val() ; 
            var user_status = $("#user_status").val();
            var user_course = $("#user_course").val();
            var previous_course_date = $("#previous_course_date").val();
            var url = "../inc/handle_files/teacher/students/" + $("#action").html() + "_student.php" ; 
            if(user_first_name != ''  && user_last_name != ''  && user_number != ''  && user_status != '' && user_course != 0){
                $.ajax({
                    url:url,
                    method:"post",
                    data:{user_id:user_id, user_first_name:user_first_name, user_last_name:user_last_name, user_number:user_number, user_password:user_password, user_status:user_status, user_course:user_course, previous_course_date:previous_course_date},
                    success:function(data){
                        var json = JSON.parse(data) ; 
                        if(json.status == "success"){
                            $("#datatable").DataTable().draw() ; 
                            $("#response").html('<div class="alert alert-success">' + json.msg + '</div>') ; 
                            $("#user_first_name").val('') ;
                            $("#user_last_name").val('') ; 
                            $("#user_number").val('') ; 
                            $("#user_password").val('') ; 
                            $("#user_status").val('') ; 
                            $("#user_course").val('') ; 
                            $("#user_modal").modal('hide') ; 
                        }else{
                            $("#response-form").html('<div class="alert alert-danger">' +json.msg + '</div>') ; 
                        }
                        setTimeout(function(){
                            $("#response").html('');
                            $("#response-form").html('');

                        }, 2000);
                    }
                }) ; 
            }else{
                $("#response-form").html('<div class="alert alert-danger">fill all fieds</div>') ; 
                setTimeout(function(){
                    $("#response-form").html('') ; 
                    $("#user_modal").modal('hide') ; 
                }, 2000) ; 
            
            } 
        }) ;
    </script> 
    
    <!-- main user modal -->
    <div id="user_modal" class="modal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="title"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="row g-3" method="POST">
                    <input type="hidden" id="user_id">
                    <input type="hidden" id="previous_course_date">
                    <div id="response-form"></div>
                    <div class="col-md-6">
                        <label for="input_first_name" class="form-label">first name</label>
                        <input type="text" class="form-control" id="user_first_name" name="user_first_name">
                    </div>
                    <div class="col-md-6">
                        <label for="input_last_name" class="form-label">last name</label>
                        <input type="text" class="form-control" id="user_last_name" name="user_last_name">
                    </div>
                    <div class="col-md-6">
                        <label for="input_number" class="form-label">number</label>
                        <input type="text" class="form-control" id="user_number" name="user_number">
                    </div>
                    <div class="col-md-6">
                        <label for="inputPassword4" class="form-label">Password</label>
                        <input type="password" class="form-control" id="user_password" name="user_password">
                    </div>
                    <div class="col-md-8">
                        <label for="inputState" class="form-label">Course</label>
                        <select name="user_course" id="user_course" class="form-select">
                            <option selected>Choose...</option>
                            <!-- <option value="pended">PENDED</option> -->
                            <!-- here get all courses of this teacher -->
                            <?php
                                // $courses_count = $teacher->fetch_subject_count($_SESSION['user_id']) ; 
                                $res = $teacher->get_subject_title($_SESSION['user_id']) ; 
                                if($res->rowCount()){
                                    while($course = $res->fetch(PDO::FETCH_ASSOC)){
                                        extract($course) ; 
                                        echo '<option value="'. $subject_id .'">'. $subject_title .'</option>' ; 
                                    }
                                }else{
                                    echo '<option value="0">there are no courses yet</option>' ; 
                                }
                            ?>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="inputState" class="form-label">Status</label>
                        <select name="user_status" id="user_status" class="form-select">
                            <option selected>Choose...</option>
                            <option value="PENDED">PENDED</option>
                            <option value="ACTIVE">ACTIVE</option>
                        </select>
                    </div>
            </div>
            <div class="modal-footer">
                    <div class="col-12 text-end">
                        <button type="submit" class="btn btn-primary" id="action"></button>
                    </div>
                </form>
            </div>
            </div>
        </div>
    </div>   
</body>
</html>
