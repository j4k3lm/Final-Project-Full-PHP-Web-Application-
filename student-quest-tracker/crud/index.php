<?php
session_start();
include "../config/database.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: ../auth/login.php");
    exit();
}

$user_id = $_SESSION["user_id"];

$sql = "SELECT * FROM tasks WHERE user_id = ? ORDER BY id DESC";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Tasks | Student Quest Task Tracker</title>
    <link rel="stylesheet" href="../assets/style.css">
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

<div class="big-card">
    <h1>My Task Quest</h1>
    <p class="subtitle">Create, view, update, and delete your school tasks.</p>

    <a class="btn btn-green" href="create.php">+ Add New Task</a>

    <table>
        <tr>
            <th>Title</th>
            <th>Subject</th>
            <th>Description</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>

        <?php if (mysqli_num_rows($result) > 0) { ?>
            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                <?php
                $statusClass = "pending";

                if ($row["status"] == "In Progress") {
                    $statusClass = "progress";
                }

                if ($row["status"] == "Done") {
                    $statusClass = "done";
                }
                ?>

                <tr>
                    <td><?php echo htmlspecialchars($row["title"]); ?></td>
                    <td><?php echo htmlspecialchars($row["subject"]); ?></td>
                    <td><?php echo htmlspecialchars($row["description"]); ?></td>
                    <td>
                        <span class="status <?php echo $statusClass; ?>">
                            <?php echo htmlspecialchars($row["status"]); ?>
                        </span>
                    </td>
                    <td class="actions">
                        <a class="btn" href="edit.php?id=<?php echo $row["id"]; ?>">Edit</a>
                        <a class="btn btn-red" href="delete.php?id=<?php echo $row["id"]; ?>" onclick="return confirm('Are you sure you want to delete this task?')">Delete</a>
                    </td>
                </tr>
            <?php } ?>
        <?php } else { ?>
            <tr>
                <td colspan="5" class="empty">No tasks yet. Click Add New Task to begin.</td>
            </tr>
        <?php } ?>
    </table>
</div>

</body>
</html>