<?php require 'includes/db.inc.php'; ?>
<?php require 'classes/authentication.class.php'; ?>
<?php require 'classes/task.class.php'; ?>

<?php  $user = new Authentication($pdo);?>
<?php  $edit = new Task($pdo);?>

<?php 
if(isset($_POST['update']))
{
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $expiration = trim($_POST['expiration']);
    
    $edit->update($title, $description, $expiration);
  
}
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
</head>

<body>



<!--NavBar -->
    <div>
        <nav class="navbar navbar-light navbar-expand-md navigation-clean-button">
            <div class="container"><a class="navbar-brand" href="firstpage.php" style="font-size: 21px;"><i class="material-icons" style="font-size: 25px;">looks_two</i>Do</a><button data-toggle="collapse" class="navbar-toggler" data-target="#navcol-1"><span class="sr-only">Toggle navigation</span><span class="navbar-toggler-icon"></span></button>
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
            <h3 class="text-center" style="margin-bottom: 30px;">Edit the following task:</h3>
             <hr>
            <form action="" method="post">
                <div class="form-group">

                     <?php $edit->edit(); ?>
            <hr>
                     <!--Button -->
                    <div class="row d-xl-flex">
                        <div class="col text-center d-lg-flex d-xl-flex justify-content-lg-center justify-content-xl-center" style="padding: 5px;">
                            <button class="btn btn-info text-left border rounded shadow d-xl-flex" name="update" type="submit" style="margin: 11px;">Update</button>
                            <a href="firstpage.php" class="btn btn-dark text-left border rounded shadow d-xl-flex" style="margin: 11px;">Cancel</a>
                        </div>
                    </div>
                   <?php if(isset($_POST['update']))
                    {?>
                    <div class="alert alert-success text-center" role="alert">Data updated! <a href="firstpage.php">Back to task</a></div>
                    <?php } ?>
                </div>
            </form>
        <!--End of Card Body-->
        </div> 
     <!--End of Card-->
    </div>
    
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>

</body>

</html>