<?php
    /////////////////////////////////////////////////////////////////////////////
    //Main page -dashboard///////////////////////////////

    $page_title = "dashboard" ; 
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
                            teacher dashboard
                        </h1>
                        <!-- statistics -->
                        <div class="statistics">
                            <div class="row justify-content-space-between">
                                <div class="col-10 col-sm-10 col-md-5 col-lg-2">
                                    <i class="fa-solid fa-users fs-4"></i>
                                    <p class="text-capitalize text-primary">
                                        <a href="./students.php">
                                            <span><?php echo $teacher->fetch_student_count(2)?></span>
                                            students
                                        </a>
                                    </p>
                                </div>
                                <div class="col-10 col-sm-10 col-md-5 col-lg-2">
                                    <i class="fa-solid fa-list fs-4"></i>
                                    <p class="text-capitalize text-primary">
                                        <a href="./subjects.php">
                                            <span><?php echo $teacher->fetch_subject_count($_SESSION['user_id'])?></span>
                                            subjects
                                        </a>
                                    </p>
                                </div>
                                <div class="col-10 col-sm-10 col-md-5 col-lg-2">
                                    <i class="fa-solid fa-list fs-4"></i>
                                    <p class="text-capitalize text-primary">test</p>
                                </div>
                                <div class="col-10 col-sm-10 col-md-5 col-lg-2">
                                    <i class="fa-solid fa-list fs-4"></i>
                                    <p class="text-capitalize text-primary">test</p>
                                </div>
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
    
</body>
</html>

