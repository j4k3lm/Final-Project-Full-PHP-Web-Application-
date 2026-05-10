<?php
session_start();
include "../config/database.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: ../auth/login.php");
    exit();
}

if (!isset($_GET["id"])) {
    header("Location: index.php");
    exit();
}

$user_id = $_SESSION["user_id"];
$id = $_GET["id"];

$sql = "SELECT * FROM tasks WHERE id = ? AND user_id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "ii", $id, $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) == 0) {
    header("Location: index.php");
    exit();
}

$task = mysqli_fetch_assoc($result);
$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = trim($_POST["title"]);
    $subject = trim($_POST["subject"]);
    $description = trim($_POST["description"]);
    $status = trim($_POST["status"]);

    if (!empty($title) && !empty($subject) && !empty($description) && !empty($status)) {
        $sql = "UPDATE tasks SET title = ?, subject = ?, description = ?, status = ? WHERE id = ? AND user_id = ?";
        $stmt = mysqli_prepare($conn, $sql);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "ssssii", $title, $subject, $description, $status, $id, $user_id);

            if (mysqli_stmt_execute($stmt)) {
                header("Location: index.php");
                exit();
            } else {
                $message = "Error updating task.";
            }
        } else {
            $message = "Something went wrong.";
        }
    } else {
        $message = "All fields are required.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Task | Student Quest Task Tracker</title>
    <link rel="stylesheet" href="../assets/style.css">
    <script src="../assets/script.js"></script>
</head>
<body>

<div class="navbar">
    <h3>🎓 Student Quest Task Tracker</h3>
    <div>
        <a href="../dashboard.php">Dashboard</a>
        <a href="index.php">My Tasks</a>
        <a href="../auth/logout.php">Logout</a>
    </div>
</div>

<div class="page-center">
    <div class="card">
        <div class="logo">✏️</div>
        <h1>Edit Task</h1>
        <p class="subtitle">Update your student task</p>

        <p class="message"><?php echo htmlspecialchars($message); ?></p>

        <form method="POST" onsubmit="return validateForm()">
            <label>Task Title</label>
            <input type="text" name="title" value="<?php echo htmlspecialchars($task["title"]); ?>">

            <label>Subject</label>
            <input type="text" name="subject" value="<?php echo htmlspecialchars($task["subject"]); ?>">

            <label>Description</label>
            <textarea name="description"><?php echo htmlspecialchars($task["description"]); ?></textarea>

            <label>Status</label>
            <select name="status">
                <option value="Pending" <?php if ($task["status"] == "Pending") echo "selected"; ?>>Pending</option>
                <option value="In Progress" <?php if ($task["status"] == "In Progress") echo "selected"; ?>>In Progress</option>
                <option value="Done" <?php if ($task["status"] == "Done") echo "selected"; ?>>Done</option>
            </select>

            <button type="submit">Update Task</button>
            <a class="btn btn-gray" href="index.php">Back</a>
        </form>
    </div>
</div>

</body>
</html>