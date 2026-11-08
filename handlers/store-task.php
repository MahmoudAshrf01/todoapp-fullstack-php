<?php 
session_start();


$conn = mysqli_connect("localhost", "root", "", "todoapp");

if(!$conn){
    echo "connect error: " . mysqli_connect_error($conn);
}



if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['title'])) {

        $title = trim(htmlspecialchars(htmlentities($_POST["title"])));

        $create_task = "INSERT INTO `tasks`(`title`) VALUES('$title')";
        $result = mysqli_query($conn, $create_task);

        if(mysqli_affected_rows($conn) === 1){
                $_SESSION["success"] = "task created successfully";
        }else {
                $_SESSION["failed"] = "task created failed, try again later";
        };

        header("location:../index.php");
};



