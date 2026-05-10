<?php
session_start();
include "../config/database.php";

$message = "";
$messageClass = "message";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);

    if (!empty($name) && !empty($email) && !empty($password)) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO users (name, email, password) VALUES (?, ?, ?)";
        $stmt = mysqli_prepare($conn, $sql);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "sss", $name, $email, $hashedPassword);

            if (mysqli_stmt_execute($stmt)) {
                $message = "Account created successfully. You can now login.";
                $messageClass = "message success";
            } else {
                $message = "Email already exists. Try another email.";
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
    <title>Register | Student Quest Task Tracker</title>
    <link rel="stylesheet" href="../assets/style.css">
    <script src="../assets/script.js"></script>
</head>
<body>

<div class="page-center">
    <div class="card">
        <div class="logo">🎓</div>
        <h1>Create Account</h1>
        <p class="subtitle">Join Student Quest Task Tracker</p>

        <p class="<?php echo $messageClass; ?>"><?php echo htmlspecialchars($message); ?></p>

        <form method="POST" onsubmit="return validateForm()">
            <label>Full Name</label>
            <input type="text" name="name" placeholder="Enter your name">

            <label>Email Address</label>
            <input type="email" name="email" placeholder="Enter your email">

            <label>Password</label>
            <input type="password" name="password" placeholder="Enter your password">

            <button type="submit">Register</button>
        </form>

        <p class="link-text">
            Already have an account?
            <a href="login.php">Login here</a>
        </p>
    </div>
</div>

</body>
</html>