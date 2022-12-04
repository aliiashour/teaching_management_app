<?php
    $page_title = "Admin" ; 
    include_once "./init.php" ; 
    $res = $admin->fetch_data($_SESSION['user_id']) ; 
    if($res->rowCount()){
        while ($row = $res->fetch(PDO::FETCH_ASSOC)) {
            extract($row) ; 
            $admin->set_user_first_name($user_first_name) ; 
            $admin->set_user_last_name($user_last_name) ; 
            $admin->set_user_number($user_number) ; 
            $admin->set_user_image($user_image) ; 
            $admin->set_user_status($user_status) ; 
            $admin->set_user_password($user_password) ;
        }
        // now echo data
        echo '<h1>'.$admin->get_user_first_name().'</h1>' ; 
        echo '<h2>'.$admin->get_user_last_name().'</h2>' ; 
        echo '<h3>'.$admin->get_user_number().'</h3>' ; 
        echo '<h4>'.$admin->get_user_image().'</h4>' ; 
        echo '<h5>'.$admin->get_user_status().'</h5>' ;  
    }else{
        echo "there are no user with id = 3" ; 
    }
    echo '<a href="../logout.php">out</a>' ; 

    ?>

    <?php include_once $templates. "footer.php" ?>
        
</body>
</html>
    
    
