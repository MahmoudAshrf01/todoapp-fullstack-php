<?php

session_start();

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: ../index.php");
    exit;
}

$task_id = filter_input(INPUT_POST, "id", FILTER_VALIDATE_INT);

$title = isset($_POST["title"]) && is_string($_POST["title"])
    ? trim($_POST["title"])
    : "";

if (!$task_id || $task_id < 1 || $title === "") {
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

$update_task = "UPDATE `tasks` SET `title` = ? WHERE `id` = ?";
$stmt = mysqli_prepare($conn, $update_task);

mysqli_stmt_bind_param($stmt, "si", $title, $task_id);

if (mysqli_stmt_execute($stmt)) {
    $_SESSION["success"] = "Task saved successfully.";
} else {
    $_SESSION["failed"] = "Task update failed, try again later.";
}

mysqli_stmt_close($stmt);
mysqli_close($conn);

header("Location: ../index.php");
exit;