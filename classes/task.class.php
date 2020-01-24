<?php

class Task
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function create($title, $description, $expiration)
    {
        $user_id =  $_SESSION['user_session'];
        $stmt = $this->pdo->prepare("INSERT INTO task(title, description, expiration, user_id) VALUES(:title, :description, :expiration, :user_id )");
        $stmt->bindparam(":title", $title);
        $stmt->bindparam(":description", $description);
        $stmt->bindparam(":expiration", $expiration);
        $stmt->bindparam(":user_id", $user_id);
        $stmt->execute();
        return true;
    }

    public function read()
    {   
        $timeNow = strtotime("now");
        $complete = false;
        $user_id = $_SESSION['user_session'];
        $query = "SELECT * FROM task WHERE user_id=:user_id AND complete=:complete ORDER BY expiration ";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindparam(":user_id", $user_id);
        $stmt->bindparam(":complete", $complete);
        $stmt->execute();
        
        if($stmt->rowCount()>0)
        { 
            ?>
                <!--Heading-->
                <div>
                    <h4 class="text-center" style="padding: 39px;">Your to do list:</h4>
                </div>
                <!--Table-->
                <div>
                    <div class="table-responsive">
                        <table class="table">

                            <thead>
                                <tr>
                                    <th class="text-left"   style="width: 5%;font-size:  14px;">id</th>
                                    <th class="text-left"   style="width: 25%;font-size: 14px;">Title</th>
                                    <th class="text-left"   style="width: 50%;font-size: 14px;">Description</th>
                                    <th class="text-center" style="width: 5%;font-size:  14px;">Edit</th>
                                    <th class="text-center" style="width: 5%;font-size:  14px;">Delete</th>
                                    <th class="text-center" style="width: 5%;font-size:  14px;">Complete</th>
                                    <th class="text-center" style="width: 5%;font-size:  14px;">Expiration</th>
                                </tr>
                            </thead>


                            <tbody> 
                            <?php
                            while($row=$stmt->fetch(PDO::FETCH_ASSOC))
                            {
                                
                                ?>
                                <tr>
                                <td style="font-size: 13px;"><?php echo $row['id']; ?></td>
                                <td style="font-size: 13px;"><?php echo $row['title']; ?></td>
                                <td style="font-size: 13px;"><?php echo $row['description']; ?></td>
                                <td class="text-center"><a href="edit.php?id=<?php echo $row['id']; ?>&user_id=<?php echo $row['user_id']; ?>"><i class="material-icons" style="font-size: 18px;">mode_edit</i></a></td>
                                <td class="text-center"><a href="delete.php?id=<?php echo $row['id']; ?>&user_id=<?php echo $row['user_id']; ?>"><i class="material-icons" style="font-size: 18px;">delete</i></a></td>
                                <?php
                                $dateTable = $row['expiration'];
                                $timestamp = strtotime($dateTable);
                                if($timeNow > $timestamp)
                                {
                                    ?><td class="text-center"><i class="material-icons" style="font-size: 18px;">done_all</i></td> 
                                    <td class="text-center alert alert-danger" style="font-size: 13px;"><?php echo $row['expiration']; ?> <br> Expired</td> <?php
                                }else{
                                ?><td class="text-center"><a href="firstPage.php?complete=<?php echo ($row['complete'] == 0 ? 1 : 0 ); ?>&id=<?php echo $row['id']; ?>&user_id=<?php echo $row['user_id']; ?>"><i class="material-icons" style="font-size: 18px;">done_all</i></a></td>
                                <td class="text-center" style="font-size: 13px;"><?php echo $row['expiration']; ?></td> <?php
                                }
                                ?>
                                </tr>
                                <?php } ?>
                            </tbody>
                                

                        </table>
                    </div>
                </div> 
                
            <?php    
        }
        else
        {
            ?>
            <div class="alert alert-info text-center" role="alert">
                    You don't have any task for now!
            </div>
            <?php
        }
    }


    //Secure acces for each user id
    public function taskComplete()
    {
        // Get the authenticated user 

        // Check if task's user_id is equal with Authenticated user id

        // Redirect back with errors or 403 page Unauthorized.

        if(isset($_GET['complete']))
        {
            try {
                if(!($_SESSION['user_session'] === $_GET['user_id']))
                {
                    throw new Exception('ERROR 403');
                }
                else
                {
                    $stmt=$this->pdo->prepare("UPDATE task SET complete=:complete WHERE id=:id AND user_id=:user_id");
                    $stmt->bindparam(":complete",$_GET['complete']);
                    $stmt->bindparam(":id",$_GET['id']);
                    $stmt->bindparam(":user_id",$_GET['user_id']);
                    $stmt->execute();
                }
            } 
            catch (PDOException $e) 
            {
                echo $e->getMessage();
            }
            finally
            {
                header("Location: firstPage.php");
            }  
        }
    }
    

    public function viewCompletedTask()
    {
        $complete= true;
        $user_id = $_SESSION['user_session'];
        $query = "SELECT * FROM task WHERE user_id=:user_id AND complete=:complete";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindparam(":user_id", $user_id);
        $stmt->bindparam(":complete", $complete);
        $stmt->execute();
        if($stmt->rowCount()>0)
        { 
            ?>
                <!--Table with completed task-->
                <div>
                    <div class="table-responsive">
                        <table class="table">

                            <thead>
                                <tr>
                                    <th class="text-left"   style="width: 5%;font-size:  14px;">id</th>
                                    <th class="text-left"   style="width: 25%;font-size: 14px;">Title</th>
                                    <th class="text-left"   style="width: 50%;font-size: 14px;">Description</th>
                                    <th class="text-center" style="width: 5%;font-size:  14px;">Edit</th>
                                    <th class="text-center" style="width: 5%;font-size:  14px;">Delete</th>
                                    <th class="text-center" style="width: 5%;font-size:  14px;">Incomplete</th>
                                    <th class="text-center" style="width: 5%;font-size:  14px;">Expiration</th>
                                </tr>
                            </thead>


                            <tbody> 
                            <?php
                            while($row=$stmt->fetch(PDO::FETCH_ASSOC))
                            {
                                ?>
                                <tr>
                                <td style="font-size: 13px;"><?php echo $row['id']; ?></td>
                                <td style="font-size: 13px;"><?php echo $row['title']; ?></td>
                                <td style="font-size: 13px;"><?php echo $row['description']; ?></td>
                                <td class="text-center"><a href="edit.php?id=<?php echo $row['id']; ?>&user_id=<?php echo $row['user_id']; ?>"><i class="material-icons" style="font-size: 18px;">mode_edit</i></a></td>
                                <td class="text-center"><a href="delete.php?id=<?php echo $row['id']; ?>&user_id=<?php echo $row['user_id']; ?>"><i class="material-icons" style="font-size: 18px;">delete</i></a></td>
                                <td class="text-center"><a href="firstPage.php?complete=<?php echo ($row['complete'] == 0 ? 1 : 0 ); ?>&id=<?php echo $row['id']; ?>&user_id=<?php echo $row['user_id']; ?>"><i class="material-icons" style="font-size: 18px;">clear</i></a></td>
                                <td class="text-center" style="font-size: 13px;"><?php echo $row['expiration']; ?></td>
                                </tr>
                                <?php } ?>
                            </tbody>
                                

                        </table>
                    </div>
                </div> 
                
            <?php    
        }
        else
        {
            ?>
            <div class="alert alert-info text-center" role="alert">
                You haven't finished any tasks yet
            </div>
            <?php
        }
    }


//Number of rows for "Done" & "Not ready yet"
    public function numberTaskReady($complete)
    {
        
        switch($complete)
        {
            //Not ready yet
            case false:
                $complete= false;
                $user_id = $_SESSION['user_session'];
                $query = "SELECT * FROM task WHERE user_id=:user_id AND complete=:complete";
                $stmt = $this->pdo->prepare($query);
                $stmt->bindparam(":user_id", $user_id);
                $stmt->bindparam(":complete", $complete);
                $stmt->execute();
                echo $stmt->rowCount();
            break;

            //Done:
            case true:
                $complete= true;
                $user_id = $_SESSION['user_session'];
                $query = "SELECT * FROM task WHERE user_id=:user_id AND complete=:complete";
                $stmt = $this->pdo->prepare($query);
                $stmt->bindparam(":user_id", $user_id);
                $stmt->bindparam(":complete", $complete);
                $stmt->execute();
                echo $stmt->rowCount();
            break;
        }
    } 
    
    
    public function edit()
    {
        if(($_SESSION['user_session'] == $_GET['user_id']))
        {
        $user_id = $_SESSION['user_session'];
        $query = "SELECT * FROM task WHERE user_id=:user_id AND id=:id ";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindparam(":id",$_GET['id']);
        $stmt->bindparam(":user_id",$_GET['user_id']);
        $stmt->execute();
        $row=$stmt->fetch(PDO::FETCH_ASSOC);
        ?>
        <!--Title -->
        <div class="row">
            <div class="col d-flex d-sm-flex d-md-flex d-lg-flex d-xl-flex justify-content-end justify-content-sm-end justify-content-md-end justify-content-lg-end align-items-lg-end justify-content-xl-end" style="padding: 5px;font-size: 15px;">
                <label class="col-form-label d-sm-flex d-xl-flex align-items-sm-center align-items-xl-center">Title: &nbsp;</label>
            </div>
            <div class="col"><input class="border rounded shadow" type="text" required="" name="title" value="<?php echo $row["title"]; ?>" style="font-size: 15px;"></div>
        </div>
        
        <!--Expiration -->
        <div class="row">
            <div class="col text-center d-flex d-sm-flex d-md-flex d-lg-flex d-xl-flex justify-content-end justify-content-sm-end justify-content-md-end justify-content-lg-end justify-content-xl-end" style="padding: 5px;font-size: 15px;">
                <label class="col-form-label d-sm-flex d-xl-flex align-items-sm-center align-items-xl-center">Due: &nbsp;</label>
            </div>
            <div class="col"><input class="border rounded shadow" type="date" name="expiration" value="<?php echo $row["expiration"]; ?>" required="" style="font-size: 15px;"></div>
        </div>
        
        <!--Description -->
        <div class="row">
            <div class="col text-center d-sm-flex d-md-flex d-lg-flex d-xl-flex justify-content-sm-end justify-content-md-end align-items-md-center justify-content-lg-end justify-content-xl-end" style="padding: 5px;"><label class="col-form-label d-flex d-lg-flex d-xl-flex justify-content-start align-items-sm-center align-items-lg-center align-items-xl-center">Description: &nbsp;</label></div>
            <div class="col">
            <textarea class="border rounded shadow d-lg-flex d-xl-flex justify-content-xl-center" name="description" placeholder="Write your description.." required="" style="width: 234px;height: 100px;"><?php echo $row['description']; ?></textarea>
            </div>
        </div>

        <?php 
        }else{
            header("Location: firstpage.php");
        }


   
     }

     public function update($title, $description, $expiration)
     {
        if(($_SESSION['user_session'] === $_GET['user_id']))
        {
            $user_id =  $_SESSION['user_session'];
            $stmt = $this->pdo->prepare("UPDATE task SET title=:title, description=:description, expiration=:expiration WHERE user_id=:user_id AND id=:id ");
            $stmt->bindparam(":title", $title);
            $stmt->bindparam(":description", $description);
            $stmt->bindparam(":expiration", $expiration);
            $stmt->bindparam(":user_id", $user_id);
            $stmt->bindparam(":id",$_GET['id']);
            $stmt->execute();
            return true;
        }else{
            header("Location: firstpage.php");
        }
     }


     public function SelectedForDelete()
     {
        if(($_SESSION['user_session'] == $_GET['user_id']))
        {
            $user_id = $_SESSION['user_session'];
            $query = "SELECT * FROM task WHERE user_id=:user_id AND id=:id ";
            $stmt = $this->pdo->prepare($query);
            $stmt->bindparam(":id",$_GET['id']);
            $stmt->bindparam(":user_id",$_GET['user_id']);
            $stmt->execute();
            $row=$stmt->fetch(PDO::FETCH_ASSOC);

            echo " <strong>Title:</strong> <br> $row[title] <br> 
            <strong> Description:</strong> <br> $row[description] <br> 
            <strong>Expiration:</strong> <br> $row[expiration]";
        }
     }
    

     public function delete()
     {
        if(($_SESSION['user_session'] === $_GET['user_id']))
        {
            $user_id =  $_SESSION['user_session'];
            $stmt = $this->pdo->prepare("DELETE FROM task WHERE user_id=:user_id AND id=:id ");
            $stmt->bindparam(":user_id", $user_id);
            $stmt->bindparam(":id",$_GET['id']);
            $stmt->execute();
            return true;
        }else{
            header("Location: firstpage.php");
        }
     }
}