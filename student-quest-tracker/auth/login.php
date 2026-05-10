<?php
session_start();
include "../config/database.php";

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);

    if (!empty($email) && !empty($password)) {
        $sql = "SELECT * FROM users WHERE email = ?";
        $stmt = mysqli_prepare($conn, $sql);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "s", $email);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            if (mysqli_num_rows($result) == 1) {
                $user = mysqli_fetch_assoc($result);

                if (password_verify($password, $user["password"])) {
                    $_SESSION["user_id"] = $user["id"];
                    $_SESSION["user_name"] = $user["name"];

                    header("Location: ../dashboard.php");
                    exit();
                } else {
                    $message = "Incorrect password.";
                }
            } else {
                $message = "Email not found.";
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
    <title>Login | Student Quest Task Tracker</title>
    <link rel="stylesheet" href="../assets/style.css">
    <script src="../assets/script.js"></script>
</head>
<body>

<div class="page-center">
    <div class="card">
        <div class="logo">📚</div>
        <h1>Login</h1>
        <p class="subtitle">Continue your student quest</p>

        <p class="message"><?php echo htmlspecialchars($message); ?></p>

        <form method="POST" onsubmit="return validateForm()">
            <label>Email Address</label>
            <input type="email" name="email" placeholder="Enter your email">

            <label>Password</label>
            <input type="password" name="password" placeholder="Enter your password">

            <button type="submit">Login</button>
        </form>

        <p class="link-text">
            No account yet?
            <a href="register.php">Register here</a>
        </p>
    </div>
</div>

</body>
</html>