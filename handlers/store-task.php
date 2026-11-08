<?php

session_start();

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: ../index.php");
    exit;
}

$title = isset($_POST["title"]) && is_string($_POST["title"])
    ? trim($_POST["title"])
    : "";

if ($title === "") {
    $_SESSION["failed"] = "Please enter a valid task.";

    header("Location: ../index.php");
    exit;
}

$conn = mysqli_connect("localhost", "root", "", "todoapp");

if (!$conn) {
    $_SESSION["failed"] = "Database connection failed.";

    header("Location: ../index.php");
    exit;
}

$create_task = "INSERT INTO `tasks` (`title`) VALUES (?)";
$stmt = mysqli_prepare($conn, $create_task);

mysqli_stmt_bind_param($stmt, "s", $title);

if (mysqli_stmt_execute($stmt)) {
    $_SESSION["success"] = "Task created successfully.";
} else {
    $_SESSION["failed"] = "Task creation failed, try again later.";
}

mysqli_stmt_close($stmt);
mysqli_close($conn);

header("Location: ../index.php");
exit;
