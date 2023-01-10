<?php
    /////////////////////////////////////////////////////////////////////////////
    //student profile ///////////////////////////////
    session_start() ; 
    $page_title = "student profile" ; 
    if(isset($_SESSION['user_type']) && $_SESSION['user_type'] =='STUDENT'){
        echo "welcome student" ; 
    }elseif(isset($_SESSION['user_type']) && $_SESSION['user_type'] =='TEACHER'){
        // here is teacher
        include_once "../teacher/init.php" ; 

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
                            <!-- in depend on user_type sessioned i will -->
                        <!-- if student show some thing -->
                        <!-- if teacher show else  -->
                        <div class="container-fluid">
                                <div class="row justify-content-space-between">
                                    <div class="col-12 col-sm-2 col-md-4">
                                        <!-- image here and student data -->
                                        imag and name and data
                                        status
                                    </div>
                                    <!-- statistics here -->
                                    <div class="col-12 col-sm-10 col-md-8">
                                        <div class="row">
                                            <div class="col-4">
                                                <!-- here all student subjects -->
                                                subjects
                                            </div>
                                            <div class="col-8">
                                                <!-- here quizes data -->
                                                quizes
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        </div>
                        <?php

                        ?>
                        </div>
                    </div>
                </div>
            <?php
        }else{
            echo "there are no user with id = 3" ; 
        }
    }else{
        // here is admin
        echo "admin" ; 
    }

?>
    <?php include_once $templates. "footer.php" ?>
    
</body>
</html>

