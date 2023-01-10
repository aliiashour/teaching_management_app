<?php
    /////////////////////////////////////////////////////////////////////////////
    //Subject page///////////////////////////////

    $page_title = "subject management page" ; 
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

                    <?php 
                        // check for subject id if exist
                        if(isset($_GET['subject_id']) && $_GET['subject_id'] !='' && is_numeric($_GET['subject_id'])){
                        $subject_id = $_GET['subject_id']  ;
                        $res = $teacher->get_subject_details($subject_id, $_SESSION['user_id']) ; 
                        if($res->rowCount()){
                                $row = $res->fetch() ; 
                        }else{
                                echo "there is no subject with this id" ; 
                        }
                        }else{
                            // direct user to error page
                        }
                    ?>
                    
                    <div class="data col-9">
                        <!-- tables data -->
                        <h1 class="text-capitalize">
                            subject management page
                        </h1>
                        <div class="row">
                            <div class="col-12 bg-dark text-light">just links</div>
                        </div>
                        <div class="row">
                            <div class="col-6 text-start fs-4 subject_title"><?php echo $row['subject_title'] ; ?></div>
                            <div class="col-6 text-end subject_status">
                                <?php 
                                    if($row['subject_status'] == 'ACTIVE'){?>
                                        <span class="btn btn-md btn-success">
                                            <?php echo $row['subject_status'] ; ?>
                                        </span>
                                    <?php }else{?>
                                        <span class="btn btn-md btn-danger">
                                            <?php echo $row['subject_status'] ; ?>
                                        </span>
                                    <?php
                                    }
                                ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-2 subject_info">
                                <p>date</p>
                                <p><?php echo $row['subject_code'] ; ?></p>
                                <p><?php echo $row['students_num'] ; ?></p>
                            </div>
                            <div class="col-10 subject_tutorials">
                                <p>subject tutorials</p>
                                
                            </div>
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
                "url":"../inc/handle_files/teacher/subjects/fetch_subjects_data.php",
                "type":"post",
            },
            "fnCreateRow":function(nRow, aData, iDataIndex){
                $(nRow).attr('id', aData[0]) ; 
            },
            "columnDefs":[{
                // addong addition column
                "target":[0,4],
                "orderable":false,
            }]
        }) ; 
        
        $(document).on('click', '#add_subject_button', function(){
            $("#subject_title").val('') ;
            $("#subject_code").val('') ;
            $("#subject_status").val('') ; 
            $modal_title = $(this).data("title") ; 
            $modal_action = $(this).data("action") ; 
            $("#title").html($modal_title) ;
            $("#action").html($modal_action) ;
            $("#subject_modal").modal('show') ; 
        }) ; 
        // click to edit button
        $(document).on('click', '#edit_button', function(){
            var subject_id = $(this).data('subject_id') ; 
            $modal_title = $(this).data("title") ; 
            $modal_action = $(this).data("action") ; 
            $("#title").html($modal_title) ;
            $("#action").html($modal_action) ;
            if(subject_id != ''){
                // now fetch user data
                $.ajax({
                    url:"../inc/handle_files/teacher/subjects/fetch_subject_data.php",
                    method:"POST",
                    data:{subject_id:subject_id},
                    success:function(data){
                        var json = JSON.parse(data) ;
                        if(json.status =='found'){
                            // exist user
                            $("#subject_id").val(json['data']['subject_id']) ; 
                            $("#subject_title").val(json['data']['subject_title']) ; 
                            $("#subject_code").val(json['data']['subject_code']) ;  
                            $("#subject_status").val(json['data']['subject_status']) ;
                            $("#subject_modal").modal('show') ; 
                        }
                    }
                }) ; 
            }
        }) ;

        // delete user
        $(document).on('click', '#delete_button', function(){
            var subject_id = $(this).data("subject_id") ; 
            // now delete user directly
            if(confirm('are you sure?')){
                $.ajax({
                    url:"../inc/handle_files/teacher/subjects/delete_subject.php",
                    method:"POST",
                    data:{subject_id:subject_id},
                    success:function(data){
                        json = JSON.parse(data) ; 
                        if(json['status'] == 'success'){
                            $("#datatable").DataTable().draw() ; 
                            $("#response").html('<div class="alert alert-success text-start">subject deleted</div>') ; 
                            setTimeout(function(){
                                $("#response").html('') ; 
                            }, 2000) ; 
                        }
                    }
                });
            }
        }) ; 

        
        // submit the modal 
        $(document).on("submit", "#subject_modal", function(event){
            event.preventDefault() ;
            var subject_id = $("#subject_id").val() ; 
            var subject_title = $("#subject_title").val() ; 
            var subject_code = $("#subject_code").val() ; 
            var subject_status = $("#subject_status").val() ; 
            var url = "../inc/handle_files/teacher/subjects/" + $("#action").html() + "_subject.php" ; 
            if(subject_title != ''  && subject_code != '' && subject_status != ''){
                $.ajax({
                    url:url,
                    method:"post",
                    data:{subject_id:subject_id, subject_title:subject_title, subject_code:subject_code, subject_status:subject_status},
                    success:function(data){
                        var json = JSON.parse(data) ; 
                        if(json.status == "success"){
                            $("#datatable").DataTable().draw() ; 
                            $("#response").html('<div class="alert alert-success">' + json.msg + '</div>') ; 
                            $("#subject_title").val('') ;
                            $("#subject_code").val('') ; 
                            $("#subject_status").val('') ; 
                            $("#Subject_modal").modal('hide') ; 
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
                    $("#subject_modal").modal('hide') ; 
                }, 2000) ; 
            
            } 
        }) ;
    </script> 
    
    <!-- main user modal -->
    <div id="subject_modal" class="modal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="title"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="row g-3" method="POST">
                    <input type="hidden" id="subject_id">
                    <div id="response-form"></div>
                    <div class="col-md-6">
                        <label for="subject_title" class="form-label">subject title</label>
                        <input type="text" class="form-control" id="subject_title" name="subject_title">
                    </div>
                    <div class="col-md-6">
                        <label for="subject_code" class="form-label">subject code</label>
                        <input type="text" class="form-control" id="subject_code" name="subject_code">
                    </div>
                    <div class="col-md-4">
                        <label for="subject_status" class="form-label">subject Status</label>
                        <select name="subject_status" id="subject_status" class="form-select">
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
