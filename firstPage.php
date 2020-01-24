<?php require 'includes/db.inc.php'; ?>
<?php require 'classes/authentication.class.php'; ?>
<?php require 'classes/task.class.php'; ?>

<?php

$user = new Authentication($pdo);


// Log Out

if(!$user->is_loggedin())
{
 $user->redirect('login.php');
}

if(isset($_POST['logout']))
{
    $user->logout();
    if(!$user->is_loggedin())
    {
        $user->redirect('login.php');
    }
}

//Create task
$crud = new Task($pdo);
if(isset($_POST['submitTask']))
{
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $expiration = trim($_POST['expiration']);
    
    $crud->create($title, $description, $expiration);
}

//Complete or not
$crud->taskComplete();

?>


<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>2Do</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/fonts/material-icons.min.css">
    <link rel="stylesheet" href="assets/css/Navigation-with-Button.css">
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="shortcut icon" type="image/png" href="2do.png">
</head>

<body>




<!--NavBar -->
    <div>
        <nav class="navbar navbar-light navbar-expand-md navigation-clean-button">
            <div class="container"><a class="navbar-brand" href="" style="font-size: 21px;"><i class="material-icons" style="font-size: 25px;">looks_two</i>Do</a><button data-toggle="collapse" class="navbar-toggler" data-target="#navcol-1"><span class="sr-only">Toggle navigation</span><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navcol-1">
                    <ul class="nav mr-auto"></ul>
                    <form action="" method="post">
                        <span class="navbar-text actions"> <a class="login" style="font-size: 15px;">Welcome, <?php $user->displayName(); ?> &nbsp;</a>
                            <button class="btn btn-dark shadow" name="logout" type="submit" style="font-size: 13px;">Log Out</button>
                        </span>
                    </form>
                </div>
            </div>
        </nav>
    </div>


    <!--Main-->
    <div class="card">
        <div class="card-body" style="background-color: rgba(7,94,132,0.05);">


        <!--Textarea & Expiration input -->
        <form action="" method="post">
            <div class="form-group">

                <!--Title -->
                <div class="row">
                    <div class="col d-flex d-sm-flex d-md-flex d-lg-flex d-xl-flex justify-content-end justify-content-sm-end justify-content-md-end justify-content-lg-end align-items-lg-end justify-content-xl-end" style="padding: 5px;font-size: 15px;">
                        <label class="col-form-label d-sm-flex d-xl-flex align-items-sm-center align-items-xl-center">Title: &nbsp;</label>
                    </div>
                    <div class="col"><input class="border rounded shadow" type="text" required="" name="title" placeholder="Write your title" style="font-size: 15px;"></div>
                </div>
                
                <!--Expiration -->
                <div class="row">
                    <div class="col text-center d-flex d-sm-flex d-md-flex d-lg-flex d-xl-flex justify-content-end justify-content-sm-end justify-content-md-end justify-content-lg-end justify-content-xl-end" style="padding: 5px;font-size: 15px;">
                        <label class="col-form-label d-sm-flex d-xl-flex align-items-sm-center align-items-xl-center">Due: &nbsp;</label>
                    </div>
                    <div class="col"><input class="border rounded shadow" type="date" id=theDate name="expiration" required="" style="font-size: 15px;"></div>
                </div>
                
                <!--Description -->
                <div class="row">
                    <div class="col text-center d-sm-flex d-md-flex d-lg-flex d-xl-flex justify-content-sm-end justify-content-md-end align-items-md-center justify-content-lg-end justify-content-xl-end" style="padding: 5px;"><label class="col-form-label d-flex d-lg-flex d-xl-flex justify-content-start align-items-sm-center align-items-lg-center align-items-xl-center">Description: &nbsp;</label></div>
                    <div class="col">
                    <textarea class="border rounded shadow d-lg-flex d-xl-flex justify-content-xl-center" name="description" placeholder="Write your description.." required="" style="width: 234px;height: 100px;"></textarea>
                    </div>
                </div>

                <!--Button -->
                <div class="row d-xl-flex">
                    <div class="col text-center d-lg-flex d-xl-flex justify-content-lg-center justify-content-xl-center" style="padding: 5px;">
                        <button class="btn btn-info text-left border rounded shadow d-xl-flex" name="submitTask" type="submit" style="margin: 11px;">Submit</button>
                    </div>
                </div>
                <hr>
            </div>
        </form>

            
            <!--Table & Read task -->
            <?php 
                $crud->read(); 
           ?>
            <!--End of Table-->

            <!--Not ready yet-->
            <div>
                <h5 style="padding: 7px;">Not ready yet: <?php $crud->numberTaskReady(false); ?></h5>
            </div>
            
            
            
            <!--Table with tasks completed-->
            <div>
                <a data-toggle="collapse" href="#collapseTaskDone" role="button" aria-expanded="false" aria-controls="collapseExample" style="text-decoration: none;">
                    <div >
                        <h5 style="padding: 7px; color: black;">Done: <?php $crud->numberTaskReady(true); ?></h5>
                    </div>
                </a>
                
                <div class="collapse" id="collapseTaskDone">
                    <div>
                        <?php
                            $crud->viewCompletedTask();
                        ?>
                    </div>
                </div>
            </div>

            
        
        <!--End of Card Body-->
        </div> 
     <!--End of Card-->
    </div>
    
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script> let date = new Date(); let day = date.getDate(); let month = date.getMonth() + 1; let year = date.getFullYear(); if (month < 10) month = "0" + month;if (day < 10) day = "0" + day; let today = year + "-" + month + "-" + day; document.getElementById('theDate').value = today; </script>
</body>

</html>