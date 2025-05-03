<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

require 'includes/db.php';

$id = $_GET['id'] ?? null;

// Get the existing goal
$stmt = $pdo->prepare("SELECT * FROM goals WHERE id = ? AND user_id = ?");
$stmt->execute([$id, $_SESSION['user_id']]);
$goal = $stmt->fetch();

if (!$goal) {
    echo "Goal not found.";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    if (!empty($title)) {
        $update = $pdo->prepare("UPDATE goals SET title = ? WHERE id = ? AND user_id = ?");
        $update->execute([$title, $id, $_SESSION['user_id']]);
        header("Location: dashboard.php");
        exit();
    } else {
        $error = "Goal title cannot be empty.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Goal</title>
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
    background-color: #fff0f5;
}

.form-card {
    background-color: white;
    padding: 40px 30px;
    border-radius: 20px;
    box-shadow: 0 8px 25px rgba(0,0,0,0.08);
    width: 100%;
    max-width: 450px;
    box-sizing: border-box;
}

h2 {
    text-align: center;
    margin-bottom: 25px;
}

label {
    display: block;
    margin-bottom: 8px;
    font-weight: 600;
}

input[type="text"] {
    width: 100%;
    padding: 12px;
    border: 1px solid #ccc;
    border-radius: 10px;
    margin-bottom: 20px;
    font-size: 1rem;
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
    background-color: #62447E;
    color: white;
    cursor: pointer;
    font-size: 1rem;
    transition: background 0.3s ease;
    text-decoration: none;
    text-align: center;
}

.btn:hover {
    background-color: #50376a;
}

.cancel-btn {
    background-color: #bbb;
}

.cancel-btn:hover {
    background-color: #999;
}

.error-msg {
    background-color: #ffe0e0;
    color: #c00;
    padding: 10px;
    border-radius: 8px;
    margin-bottom: 20px;
    text-align: center;
}

    </style>
    <div class="form-container">
        <div class="form-card">
            <h2>Edit Goal 🎯</h2>
            <?php if (!empty($error)): ?>
                <p class="error-msg"><?= $error ?></p>
            <?php endif; ?>
            <form method="POST">
                <label for="title">Goal Title</label>
                <input type="text" name="title" id="title" value="<?= htmlspecialchars($goal['title']) ?>" required>

                <div class="btn-group">
                    <button type="submit" class="btn">Update</button>
                    <a href="dashboard.php" class="btn cancel-btn">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
