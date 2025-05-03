<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}
require 'includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    if (!empty($title)) {
        $stmt = $pdo->prepare("INSERT INTO goals (user_id, title) VALUES (?, ?)");
        $stmt->execute([$_SESSION['user_id'], $title]);
        header('Location: dashboard.php');
        exit();
    } else {
        $error = "Please enter a goal title.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Goal</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/app.css">
</head>
<body>
<style>
    .form-container {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        padding: 20px;
        background-color: #f2f5f7; /* neutral background */
    }

    .form-card {
        background-color: #ffffff;
        padding: 40px 30px;
        border-radius: 20px;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
        width: 100%;
        max-width: 450px;
        box-sizing: border-box;
    }

    .form-card h2 {
        margin-bottom: 25px;
        text-align: center;
        color: #1e1e1e;
    }

    label {
        display: block;
        margin-bottom: 8px;
        font-weight: 600;
        color: #333;
    }

    input[type="text"] {
        width: 100%;
        padding: 12px;
        border: 1px solid #bbb;
        border-radius: 10px;
        margin-bottom: 20px;
        font-size: 1rem;
        background-color: #f9f9f9;
    }

    .btn-group {
        display: flex;
        justify-content: space-between;
        gap: 10px;
    }

    .btn {
        padding: 10px 18px;
        border: none;
        border-radius: 10px;
        background-color: #2a3f54; /* strong blue */
        color: white;
        cursor: pointer;
        font-size: 1rem;
        transition: background 0.3s ease;
        text-decoration: none;
        text-align: center;
    }

    .btn:hover {
        background-color: #1a2733;
    }

    .cancel-btn {
        background-color: #999;
    }

    .cancel-btn:hover {
        background-color: #777;
    }

    .error-msg {
        background-color: #ffdddd;
        color: #c00;
        padding: 10px;
        border-radius: 8px;
        margin-bottom: 20px;
        text-align: center;
    }
</style>

    <div class="form-container">
        <div class="form-card">
            <h2>Add a New Goal 🎯</h2>
            <?php if (!empty($error)): ?>
                <p class="error-msg"><?= $error ?></p>
            <?php endif; ?>
            <form method="POST">
                <label for="title">Goal Title</label>
                <input type="text" name="title" id="title" placeholder="Type your goal here..." required>

                <div class="btn-group">
                    <button type="submit" class="btn">Add Goal</button>
                    <a href="dashboard.php" class="btn cancel-btn">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
