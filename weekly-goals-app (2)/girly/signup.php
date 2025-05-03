<?php
session_start();
require_once 'includes/db.php';

session_regenerate_id(true);

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fname = trim($_POST['fname']);
    $lname = trim($_POST['lname']);
    $username = trim($_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    if (empty($username) || empty($_POST['password']) || empty($fname) || empty($lname)) {
        $errors[] = 'Please fill in all fields.';
    } else {
        $stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
        if ($stmt->execute([$username, $password])) {
            header("Location: login.php");
            exit;
        } else {
            $errors[] = 'Username might already exist.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign Up</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        :root {
            --bg-light: #fff0f5;
            --primary: #e6d9f3;
            --accent: #b99cc8;
            --text-dark: #333;
            --error: #ff6b6b;
            --btn-color: #d9a5b3;
            --btn-hover: #c7899f;
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
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 420px;
        }

        h2 {
            text-align: center;
            color: var(--accent);
            margin-bottom: 25px;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 14px 12px;
            margin: 12px 0;
            border: 1px solid #ddd;
            border-radius: 12px;
            background-color: #fafafa;
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
    <h2>Join the Club 💕</h2>

    <?php if ($errors): ?>
        <div class="error"><?= implode('<br>', $errors) ?></div>
    <?php endif; ?>

    <form method="post">
        <input type="text" name="fname" placeholder="First Name" required>
        <input type="text" name="lname" placeholder="Last Name" required>
        <input type="text" name="username" placeholder="Choose a Username" required>
        <input type="password" name="password" placeholder="Create a Password" required>
        <button type="submit">Sign Up</button>
    </form>

    <p>Already part of the fam? <a href="login.php">Log in here</a></p>
</div>

</body>
</html>
