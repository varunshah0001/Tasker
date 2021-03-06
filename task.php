<?php
    session_start();
    if(!(isset($_SESSION['logged-in']))){
        header('Location: login.php');
        exit();
    }
    if(!(isset($_GET['sn']))){
        header('Location: index.php');
        exit();
    }

    require_once "connect.php";

    $connection = new mysqli($host, $db_user, $db_password, $db_name);

    if($connection->connect_errno!=0){
        echo "Error: ".$connection->connect_errno . "<br>";
        echo "Description: " . $connection->connect_error;
        exit();
    }
    $shortName = $_GET['sn'];
    $taskNum = $_GET['tn'];
?>

<?php include 'header.php';?>

<?php
    $sql = "SELECT * FROM `tasks` WHERE `project_short_name` = '$shortName' AND `project_task_num` = $taskNum";
     if($result = $connection->query($sql)){
        $rowsCount = $result->num_rows;
        if($rowsCount>0){
            $row = $result->fetch_assoc();
            $result->free_result();
        }
        else{
            echo '<span class="error-msg">sql error</span>';
            exit();
        } 
    }
?>
<nav class="navbar fixed-top navbar-light justify-content-center nav-color">
    <div class="container">
        <div class="col ">
            <span>
                <h3>Task </h3>        
            </span>            
            
        </div>
        <div class="col">
            <a class="nav-link ml-2" href="newTask.php?sn=<?php echo $shortName ?>" class="btn">Create task</a>
            <a class="nav-link ml-2" href="index.php"></a>      
        </div>
            
    </div>
</nav>


<div class="container margin">
    <div class="card">
        <div class="card-header">
            <?php echo $row['task_name']; ?>
        </div>
        <div class="card-body">
            <h5 class="card-title"><?php echo $row['date']; ?></h5>
            <p class="card-text"><?php echo $row['task_desc']; ?></p>
            <a href="board.php?sn=<?php echo $shortName ?>" class="btn btn-primary">Back</a>
            <a href="taskdelete.php?sn=<?php echo $shortName ?>&tn=<?php echo $taskNum ?>" class="btn btn-danger">Delete</a>
        </div>
    </div>

</div>
<?php $connection->close(); ?>
<?php include 'footer.php';?>
