<?php
session_start();
include "../config/database.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: ../auth/login.php");
    exit();
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION["user_id"];
    $title = trim($_POST["title"]);
    $subject = trim($_POST["subject"]);
    $description = trim($_POST["description"]);
    $status = trim($_POST["status"]);

    if (!empty($title) && !empty($subject) && !empty($description) && !empty($status)) {
        $sql = "INSERT INTO tasks (user_id, title, subject, description, status) VALUES (?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $sql);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "issss", $user_id, $title, $subject, $description, $status);

            if (mysqli_stmt_execute($stmt)) {
                header("Location: index.php");
                exit();
            } else {
                $message = "Error adding task.";
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
    <title>Add Task | Student Quest Task Tracker</title>
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
        <div class="logo">📝</div>
        <h1>Add Task</h1>
        <p class="subtitle">Create a new student task</p>

        <p class="message"><?php echo htmlspecialchars($message); ?></p>

        <form method="POST" onsubmit="return validateForm()">
            <label>Task Title</label>
            <input type="text" name="title" placeholder="Example: Finish PHP Project">

            <label>Subject</label>
            <input type="text" name="subject" placeholder="Example: Web Development">

            <label>Description</label>
            <textarea name="description" placeholder="Write task details here"></textarea>

            <label>Status</label>
            <select name="status">
                <option value="">Choose status</option>
                <option value="Pending">Pending</option>
                <option value="In Progress">In Progress</option>
                <option value="Done">Done</option>
            </select>

            <button type="submit">Save Task</button>
            <a class="btn btn-gray" href="index.php">Back</a>
        </form>
    </div>
</div>

</body>
</html>