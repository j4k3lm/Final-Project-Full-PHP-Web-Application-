<?php
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: auth/login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard | Student Quest Task Tracker</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>

<div class="navbar">
    <h3>🎓 Student Quest Task Tracker</h3>
    <div>
        <a href="dashboard.php">Dashboard</a>
        <a href="crud/index.php">My Tasks</a>
        <a href="auth/logout.php">Logout</a>
    </div>
</div>

<div class="page-center">
    <div class="card welcome-box">
        <div class="logo">⭐</div>
        <h1>Welcome, <?php echo htmlspecialchars($_SESSION["user_name"]); ?>!</h1>
        <p>
            This is your student dashboard. You can add your school tasks,
            track your subjects, update your progress, and delete completed tasks.
        </p>

        <a class="btn" href="crud/index.php">Open My Task Quest</a>
    </div>
</div>

</body>
</html>