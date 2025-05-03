<?php
session_start();


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $gender = $_POST['gender'] ?? '';

    if ($gender === 'female') {
        header("Location: girly/login.php");
        exit();
    } elseif ($gender === 'male') {
        header("Location: male/login.php");
        exit();
    } else {
        $error = "Please select a valid gender.";
    }
}
?>


    
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Choose Gender</title>
    
</head>
<body>
<style>
        /* Gender selection CSS */
body {
    margin: 0;
    padding: 0;
    font-family: 'Poppins', sans-serif;
    background: linear-gradient(135deg, #fce4ec, #e3f2fd);
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
}

.gender-container {
    background: #ffffff;
    border-radius: 20px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    padding: 50px 30px;
    text-align: center;
    max-width: 400px;
    width: 90%;
    transition: all 0.3s ease-in-out;
}

.gender-container:hover {
    transform: translateY(-5px);
}

.gender-container h2 {
    font-size: 26px;
    margin-bottom: 30px;
    color: #333;
}

.gender-buttons {
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.gender-buttons a {
    text-decoration: none;
    padding: 15px;
    border-radius: 12px;
    font-size: 16px;
    font-weight: bold;
    transition: all 0.3s;
    color: #fff;
}

.gender-buttons a.female {
    background: linear-gradient(90deg, #f48fb1, #ce93d8);
}

.gender-buttons a.female:hover {
    background: linear-gradient(90deg, #ec407a, #ba68c8);
}

.gender-buttons a.male {
    background: linear-gradient(90deg, #64b5f6, #81d4fa);
}

.gender-buttons a.male:hover {
    background: linear-gradient(90deg, #42a5f5, #4dd0e1);
}

.gender-icon {
    font-size: 40px;
    margin-bottom: 10px;
}

@media (min-width: 600px) {
    .gender-buttons {
        flex-direction: row;
        justify-content: space-between;
    }

    .gender-buttons a {
        flex: 1;
    }
}

    </style>
    <div class="gender-container">
        <h2>Choose Your Gender 🎯</h2>
        <div class="gender-buttons">
            <a href="girly/login.php" class="female">
                <div class="gender-icon">💅</div>
                I'm Female
            </a>
            <a href="male/login.php" class="male">
                <div class="gender-icon">💪</div>
                I'm Male
            </a>
        </div>
    </div>
</body>
</html>

