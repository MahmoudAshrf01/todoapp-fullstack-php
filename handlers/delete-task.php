<?php 
session_start();


if(isset($_GET["id"])){
    $conn = mysqli_connect("localhost", "root", "", "todoapp");
    
    if(!$conn){
        echo "connect error: " . mysqli_connect_error($conn);
    };
    
    $task_id = $_GET["id"];
    $check_if_task_exists = mysqli_fetch_row(mysqli_query($conn, "SELECT * FROM `tasks` WHERE id = $task_id"));

    if($check_if_task_exists){
        $delete_task = "DELETE FROM `tasks` WHERE `id` = $task_id";
        $result = mysqli_query($conn, $delete_task);

        if(mysqli_affected_rows($conn) === 1){
            $_SESSION["success"] = "task deleted successfully";
        }else {
            $_SESSION["failed"] = "task delete failed, try again later";
        };
    }else {
            $_SESSION["failed"] = "task delete failed, try again later";
    }


    header("location:../index.php");
};