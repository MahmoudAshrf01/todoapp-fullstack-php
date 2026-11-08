<?php 
session_start();

$conn = mysqli_connect("localhost", "root", "", "todoapp");

if(!$conn){
    echo "connect error: " . mysqli_connect_error($conn);
}


$get_tasks = "SELECT * FROM `tasks` ORDER BY `id` ASC";
$result = mysqli_query($conn, $get_tasks);

$edit_id = isset($_GET["edit"]) ? (int) $_GET["edit"] : 0;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <title>Document</title>
</head>

<body>

    <div class="container">
        <div class="row">
            <div class="col-8 mx-auto">
                <form action="handlers/store-task.php" method="POST" class="form border p-2 my-5">
                <?php if (isset($_SESSION["success"])): ?>
                    <div class="alert alert-success text-center">
                        <?php
                        echo htmlspecialchars($_SESSION["success"]);
                        unset($_SESSION["success"]);
                        ?>
                    </div>
                <?php elseif (isset($_SESSION["failed"])): ?>
                    <div class="alert alert-danger text-center">
                        <?php
                        echo htmlspecialchars($_SESSION["failed"]);
                        unset($_SESSION["failed"]);
                        ?>
                    </div>
                <?php endif; ?>
                    <input type="text" name="title" class="form-control my-3 border border-success" placeholder="add new todo">
                    <input type="submit" value="Add" class="form-control btn btn-primary my-3 " placeholder="add new todo">
                </form>
            </div>
            <div class="col-12">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Task</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (mysqli_num_rows($result) === 0): ?>
                            <tr>
                                <td colspan="3" class="text-center text-muted py-5">
                                    <i class="fa-solid fa-list-check fa-2x mb-3" aria-hidden="true"></i>
                                    <p class="h5 mb-2">No tasks yet</p>
                                    <p class="mb-0">Add your first todo using the form above.</p>
                                </td>
                            </tr>
                        <?php endif; ?>
                        <?php while ($row = mysqli_fetch_assoc($result)): ?>
                            <?php
                            $task_id = (int) $row["id"];
                            $is_editing = $edit_id === $task_id;
                            ?>

                            <tr>
                                <td><?php echo $task_id; ?></td>

                                <td>
                                    <?php if ($is_editing): ?>
                                        <form
                                            id="edit-task-<?php echo $task_id; ?>"
                                            action="handlers/update-task.php"
                                            method="POST"
                                        >
                                            <input
                                                type="hidden"
                                                name="id"
                                                value="<?php echo $task_id; ?>"
                                            >

                                            <input
                                                type="text"
                                                name="title"
                                                class="form-control"
                                                value="<?php echo htmlspecialchars(
                                                    $row["title"],
                                                    ENT_QUOTES,
                                                    "UTF-8"
                                                ); ?>"
                                                maxlength="200"
                                                required
                                                autofocus
                                            >
                                        </form>
                                    <?php else: ?>
                                        <?php echo htmlspecialchars(
                                            $row["title"],
                                            ENT_QUOTES,
                                            "UTF-8"
                                        ); ?>
                                    <?php endif; ?>
                                </td>

                                <td>
                                    <?php if ($is_editing): ?>
                                        <button
                                            type="submit"
                                            form="edit-task-<?php echo $task_id; ?>"
                                            class="btn btn-success"
                                        >
                                            Save
                                        </button>

                                        <a href="index.php" class="btn btn-secondary">
                                            Cancel
                                        </a>
                                    <?php else: ?>
                                        <a
                                            href="handlers/delete-task.php?id=<?php echo $task_id; ?>"
                                            class="btn btn-danger"
                                        >
                                            <i class="fa-solid fa-trash-can"></i>
                                        </a>

                                        <a
                                            href="index.php?edit=<?php echo $task_id; ?>"
                                            class="btn btn-info"
                                        >
                                            <i class="fa-solid fa-edit"></i>
                                        </a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="script.js"></script>
</body>

</html>
