<?php require 'includes/db.inc.php'; ?>
<?php require 'classes/authentication.class.php'; ?>

<?php
$email = null;
$password = null;
$user = new Authentication($pdo);

if($user->is_loggedin() === true)
{
 $user->redirect('firstPage.php');
}


if(isset($_POST['login']))
{
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if($user->login($email, $password))
    {
        $user->redirect('firstPage.php');
    }
    else
    {
        $error = "Wrong details!";
    }
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
    <link rel="stylesheet" href="assets/css/Contact-Form-Clean.css">
    <link rel="stylesheet" href="assets/css/Navigation-with-Search.css">
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="assets/modal.php">
</head>

<body>

    <!--NavBar -->
    <nav class="navbar navbar-light navbar-expand-md">
        <div class="container-fluid">
            <a class="navbar-brand" href="#"><i class="material-icons">looks_two</i><strong>Do</strong></a>
            <button data-toggle="collapse" class="navbar-toggler" data-target="#navcol-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="navbar-toggler-icon"></span>
            </button>
            <div
                class="collapse navbar-collapse" id="navcol-1">
                <ul class="nav navbar-nav"></ul>
            </div>
        </div>
    </nav>


    <!--Login In -->
    <div class="contact-clean">
        
        <form action="login.php" method="post">
            <h2 class="text-center">Log in</h2>
            <div class="form-group">
                <input class="form-control" type="email" name="email" placeholder="Email" required="">
            </div>
            <input class="form-control" type="password" name="password" placeholder="Password" required="">
            <div class="form-group d-lg-flex justify-content-lg-start align-items-lg-end">
                <button class="btn btn-primary" type="submit" name="login">log in</button>
            </div>
            <div>
                <a class ="text-center" href ="register.php"><p class="text-primary">Do not have an account yet? Register here<br></p></a>
            </div>
            <?php
            if(isset($error))
            {
                  ?>
                  <div class="alert alert-danger">
                      <i class="glyphicon glyphicon-warning-sign"></i> &nbsp; <?php echo $error; ?> !
                  </div>
                  <?php
            }
            ?>
        </form>

    </div>








<footer>
    <script src="assets/js/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <script src="assets/js/smart-forms.min.js"></script>
</footer>

</body>
</html>