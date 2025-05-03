<?php
session_start();
require_once 'includes/db.php';

session_regenerate_id(true);

if (empty($_SESSION['token'])) {
    $_SESSION['token'] = bin2hex(random_bytes(32));
}

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!hash_equals($_SESSION['token'], $_POST['token'])) {
        $errors[] = "Invalid request. Please try again.";
    } else {
        $username = trim($_POST['username']);
        $password = $_POST['password'];

        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            header("Location: dashboard.php");
            exit;
        } else {
            $errors[] = "Invalid username or password.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
    :root {
        --bg-light: #e8edf1;         /* Light, clean slate gray */
        --primary: #a2b8c5;          /* Subtle steel */
        --accent: #355c7d;           /* Deep blue steel */
        --text-dark: #1c1c1c;
        --error: #e53935;
        --btn-color: #2a3f54;        /* Dark blue-gray */
        --btn-hover: #1a2733;
    }

    body {
        margin: 0;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background-color: var(--bg-light);
        color: var(--text-dark);
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
    }

    .form-container {
        background-color: #ffffff;
        padding: 40px 30px;
        border-radius: 20px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        width: 100%;
        max-width: 380px;
    }

    h2 {
        text-align: center;
        color: var(--accent);
        margin-bottom: 25px;
        font-size: 26px;
        font-weight: 600;
    }

    input[type="text"],
    input[type="password"] {
        width: 100%;
        padding: 14px 12px;
        margin: 12px 0;
        border: 1px solid #c5d1da;
        border-radius: 12px;
        background-color: #f4f6f8;
        font-size: 16px;
    }

    button {
        width: 100%;
        padding: 14px;
        background-color: var(--btn-color);
        border: none;
        border-radius: 12px;
        color: white;
        font-weight: bold;
        font-size: 16px;
        cursor: pointer;
        transition: 0.3s ease;
        margin-top: 10px;
    }

    button:hover {
        background-color: var(--btn-hover);
    }

    .error {
        background-color: var(--error);
        color: white;
        padding: 10px;
        margin-bottom: 15px;
        border-radius: 10px;
        text-align: center;
    }

    p {
        text-align: center;
        margin-top: 18px;
        font-size: 14px;
    }

    a {
        color: var(--accent);
        text-decoration: none;
        font-weight: 500;
    }

    a:hover {
        text-decoration: underline;
    }

    @media (max-width: 420px) {
        .form-container {
            padding: 30px 20px;
        }

        input[type="text"],
        input[type="password"] {
            font-size: 15px;
        }

        button {
            font-size: 15px;
        }
    }
</style>


</head>
<body>

<div class="form-container">
    
    <h2>Welcome Back ✨</h2>

    <?php if ($errors): ?>
        <div class="error"><?= implode('<br>', $errors) ?></div>
    <?php endif; ?>

    <form method="post">
        <input type="text" name="username" placeholder="Enter your username" required>
        <input type="password" name="password" placeholder="Enter your password" required>
        <input type="hidden" name="token" value="<?= $_SESSION['token'] ?>">
        <button type="submit">Login</button>
    </form>

    <p>Don't have an account? <a href="signup.php">Sign up here</a></p>
</div>

</body>
</html>
