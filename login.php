<?php 
    $page_title = "login" ; 
    include_once "./init.php" ; 
    $response = '' ;  
    if(isset($_SESSION['user_id']) && isset($_SESSION['user_type']) && $_SESSION['user_type'] == 'STUDENT'){
        header('location:student/') ; 
    }  
    if(isset($_SESSION['user_id']) && isset($_SESSION['user_type']) && $_SESSION['user_type'] == 'TEACHER'){
        header('location:teacher/') ; 
    }  
    if(isset($_SESSION['user_id']) && isset($_SESSION['user_type']) && $_SESSION['user_type'] == 'ADMIN'){
        header('location:admin/') ; 
    }
    if(isset($_POST['login']) && $_POST['login']='login'){
        if($_POST['user_number']){
            $q = 'SELECT * FROM users WHERE user_number = :user_number' ; 
            $stmt = $db->prepare($q) ; 
            $stmt->execute(array(
                ':user_number' => $_POST['user_number']
            )) ; 
            $count = $stmt->rowCount() ; 
            if($count){
                $res = $stmt->fetch();
                if(sha1($_POST["user_password"])==$res['user_password']){
                    $_SESSION['user_id'] = $res['user_id'] ; 
                    $_SESSION['user_type'] = $res['user_type'] ; 
                    if($res['user_type'] == 'STUDENT'){
                        header('location:student/') ; 
                    }elseif($res['user_type'] == 'TEACHER'){
                        header('location:teacher/') ; 
                    }else{
                        header('location:admin/') ; 
                    }
                }else{
                    $response = '<div class="alert alert-danger">wrong password</div>' ;     
                }
            }else{
                $response = '<div class="alert alert-danger">this number not found</div>' ; 
            }

        }else{
            $response = '<div class="alert alert-danger">Enter your number</div>' ; 
        }
    }



?>


<div class="container">
    <div class="row justify-content-center mt-5">
        <div class="col-12 col-sm-10 col-md-8 mt-5">
            <div id="response"><?php echo $response ; ?></div>
            <form method="POST">

                <div class="mb-3">
                    <label for="user_number" class="form-label">Enter your Number</label>
                    <input type="text" class="form-control" name="user_number" required>
                </div>
                <div class="mb-3">
                    <label for="user_password" class="form-label">Enter you password</label>
                    <input type="password" class="form-control" name="user_password">
                </div>
                
                <div class="mb-3">
                    <input type="submit" class="btn btn-primary" name="login" value="login">
                </div>
                
            </form>
        </div>
    </div>
</div>


<?php include_once $templates. "footer.php" ?>
    
</body>
</html>

