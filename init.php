<?php
    session_start() ; 
    ini_set('display_errors', 'On') ;
    error_reporting(E_ALL) ; 
    include_once "./config/Database.php" ; 
    $database = new Database() ; 
    $db = $database->connect() ; 
    $css = "./layout/css/" ; 
    $js = "./layout/js/" ; 
    $images = "./layout/images/" ; 

    
    $templates = "./inc/templates/" ; 


    // if(!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])){
    //     header('location:login.php') ; 
    // }else{
    //     header('location:index.php') ; 
    // }


    include_once $templates . 'header.php' ; 