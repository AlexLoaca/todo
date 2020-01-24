<?php

class Authentication
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }


    public function register($username,$email,$password)
    {
        try {

            $stmt = $this->pdo->prepare("INSERT INTO users(username, email, password) VALUES(:username, :email, :password)");
            $stmt->bindparam(":username", $username);
            $stmt->bindparam(":email", $email);
            $new_password = md5($password); //hash function 
            $stmt->bindparam(":password", $new_password);

            $stmt->execute();
            
            return $stmt;
        } catch (PDOException $e)
         {
            echo $e->getMessage();
        }
    }

    public function login($email, $password)
    {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email=:email");
            $stmt->bindparam(":email", $email);
            $stmt->execute();
            $userRow = $stmt->fetch(PDO::FETCH_ASSOC);
            if($stmt->rowCount() > 0)
            {
                if(md5($password) === $userRow['password'])
                {
                    $_SESSION['user_session'] = $userRow['user_id'];
                    return TRUE;
                }
                else
                {
                    return FALSE;
                }
            }
        }
        catch(PDOException $e)
        {
            echo $e->getMessage();
        }
        
    }

    public function is_loggedin()
    {
        if(isset($_SESSION['user_session']))
        {
            return true;
        }
    }
    

    public function redirect($url)
   {
       header("Location:" . $url);
   }


   public function logout()
   {
        session_destroy();
        unset($_SESSION['user_session']);
        return true;
   }

   public function displayName()
   {
        $user_id = $_SESSION['user_session'];
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE user_id = :user_id ");
        $stmt->bindparam(":user_id", $user_id);
        $stmt->execute();
        $userRow=$stmt->fetch(PDO::FETCH_ASSOC);
        echo $userRow['username'];
   }


}





// DE FACUT!!!! ---->>>> daca greseste 10 X ori o parola sa-i blocheze ip-ul pentru 5 minute. (metoda=bruteforce)