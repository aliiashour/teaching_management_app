<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?php echo $page_title ; ?></title>
        <!-- add resrt css file -->
        <link rel="stylesheet" href="<?php echo $css ?>reset.css">
        <!-- add css library -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
        <!-- fontawesome library -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
        <!-- add datatable css library -->
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/jq-3.6.0/dt-1.12.1/datatables.min.css"/>
        <!-- add main style css file -->
        <link rel="stylesheet" href="<?php echo $main_css ?>main_style.css">
        <!-- add my style css file -->
        <link rel="stylesheet" href="<?php echo $css ?>style.css">
    </head>
    <body onresize="re_size_page()">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <nav class="navbar navbar-expand-lg">
                        <div class="container-fluid">
                            <a class="navbar-brand" href="#">Teaching System</a>
                            
                            <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
                                <ul class="navbar-nav mb-2 mb-lg-0">
                                    <li class="nav-item">
                                        <a class="nav-link" href="../profile.php"><i title="profile" class="fa-solid fa-user fa-lg"></i></a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="../logout.php"><i title="logout" class="fa-solid fa-right-from-bracket fa-lg "></i></a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </nav>
                </div>