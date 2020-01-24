<?php require 'includes/db.inc.php'; ?>
<?php require 'classes/authentication.class.php'; ?>

<?php

$user = new Authentication($pdo);

if($user->is_loggedin() === true)
{
 $user->redirect('firstPage.php');
}

    $errors= array(
        'username'=>[],
        'password'=>[],
        'email'=>[]
    );
    if(isset($_POST['register'])) 
    {
        $username = trim($_POST['username']);
        $email = trim($_POST['email']);
        $password = trim($_POST['password']);
        $checkpass = trim($_POST['checkpass']);

        if(empty($username))
        {
            array_push($errors['username'], 'Insert your username');
        }
        if(strlen($username) < 4)   
        {   
            array_push($errors['username'], 'Password must be atleast 4 characters ');
        }
        if($password == "")
        {
            array_push($errors['password'], 'Insert your password');
        }
        if(!($password == $checkpass))
        {
            array_push($errors['password'], 'Password do not match');
        }
        if( !(preg_match('@[A-Z]@', $password)) || !(preg_match('@[a-z]@', $password)) || !(preg_match('@[0-9]@', $password)) )
        {
            array_push($errors['password'], 'Password must contain 1 uppercase and small letter and 1 digit');
        }
        if(strlen($password) < 6){
            array_push($errors['password'], 'Password must be atleast 6 characters');
        }
        
        try 
        {
            $stmt = $pdo->prepare("SELECT email FROM users WHERE email=:email ");
            $stmt->bindparam(":email", $email);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if($row['email']===$email) 
            {
                throw new Exception("The e-mail is already taken");
            }
            
            if(count($errors, COUNT_RECURSIVE) === 3)
            {
                if($user->register($username, $email, $password))
                {
                    $_SESSION['user_session'] = $pdo->lastInsertId();
    
                    if(isset($_SESSION['user_session'])) {
                        $user->redirect('firstPage.php');
                    } 
                }
            }
        } 
        catch (Exception $e) 
        {
           // echo $e->getMessage();
            array_push($errors['email'], $e->getMessage());
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


    <!--Register -->
    <div class="contact-clean">
        
        <form action="register.php" method="post">
            <h2 class="text-center">Register</h2>
            <div class="form-group">
            <input class="form-control" type="text" name="username" placeholder="Username" required="">
            <!--Display error message -->
            <?php
            // verifici daca array-ul nu este empty 
                if(count($errors['username']) > 0) {
                    foreach($errors['username'] as $error) {
            ?>
                        <div style="font-size: 12px; margin-top: 10px;" class="alert alert-danger" role="alert">
                            <?php echo $error; ?>
                        </div> 
            <?php }
                }
            ?>
            
            </div>
            <div class="form-group">
                <input class="form-control" type="email" name="email" placeholder="Email" required="">
                <?php
            // verifici daca array-ul nu este empty 
                if(count($errors['email']) > 0) {
                    foreach($errors['email'] as $error) {
            ?>
                        <div style="font-size: 12px; margin-top: 10px;" class="alert alert-danger" role="alert">
                            <?php echo $error; ?>
                        </div> 
            <?php }
                }
            ?>
            </div>
            <div class="form-group">
            <input class="form-control" type="password" name="password" placeholder="Password" required="">
            <?php
            // verifici daca array-ul nu este empty 
                if(count($errors['password']) > 0) {
                    foreach($errors['password'] as $error) {
            ?>
                        <div style="font-size: 12px; margin-top: 10px;" class="alert alert-danger" role="alert">
                            <?php echo $error; ?>
                        </div> 
            <?php }
                }
            ?>
            </div>
            <input class="form-control" type="password" name="checkpass" placeholder="Check password" required="">
            <div class="form-group d-lg-flex justify-content-lg-start align-items-lg-end">
                <button class="btn btn-primary" type="submit" name="register" value="">Register</button>
            </div>
            <div>
                <a class ="text-center" href ="login.php"><p class="text-primary">Back to Login<br></p></a>
            </div>
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
