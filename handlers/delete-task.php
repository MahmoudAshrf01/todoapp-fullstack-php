<?php

session_start();

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: ../index.php");
    exit;
}

$task_id = filter_input(INPUT_POST, "id", FILTER_VALIDATE_INT);

if (!$task_id || $task_id < 1) {
    $_SESSION["failed"] = "Please select a valid task.";

    header("Location: ../index.php");
    exit;
}

$conn = mysqli_connect("localhost", "root", "", "todoapp");

if (!$conn) {
    $_SESSION["failed"] = "Database connection failed.";

    header("Location: ../index.php");
    exit;
}

$delete_task = "DELETE FROM `tasks` WHERE `id` = ?";
$stmt = mysqli_prepare($conn, $delete_task);

mysqli_stmt_bind_param($stmt, "i", $task_id);

if (mysqli_stmt_execute($stmt) && mysqli_stmt_affected_rows($stmt) === 1) {
    $_SESSION["success"] = "Task deleted successfully.";
} else {
    $_SESSION["failed"] = "Task deletion failed, try again later.";
}

mysqli_stmt_close($stmt);
mysqli_close($conn);

header("Location: ../index.php");
exit;
