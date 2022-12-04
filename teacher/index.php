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
                                        $categores = $teacher->get_main_category() ; 
                                        $item = '' ; 
                                        $i = 0 ; 
                                        foreach ($categores as $category) {
                                            $i = $i +1 ; 
                                            $item .='
                                                    <div class="row">
                                                            <div class="col-6 text-start">
                                                                <li>
                                                                    <a class="" href="#">'.$category.'</a>
                                                                </li>
                                                            </div>
                                                            <div class="col-6 text-end">
                                                                <span class="text-end"><i data-target="'.$category.'_'.$i.'" class="category-dropdown-icon fa-solid fa-angle-down fs-5"></i></span>
                                                            </div>
                                                            <div id="'.$category.'_'.$i.'" class="category col-12">'.$category.' Actions</div>
                                                    </div>' ; 
                                        }
                                        echo $item ; 
                                    ?>
                                </div>
                            </ul>
                        </div>
                    </div>
                    <div class="data col-9">
                        <!-- tables data -->
                        data
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

