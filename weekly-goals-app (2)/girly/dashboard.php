<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}
require 'includes/db.php';

$user_id = $_SESSION['user_id'];
$user_stmt = $pdo->prepare("SELECT fname, lname FROM users WHERE id = ?");
$user_stmt->execute([$user_id]);
$user = $user_stmt->fetch(PDO::FETCH_ASSOC);
$fname = $user['fname'];
$lname = $user['lname'];

$stmt = $pdo->prepare("SELECT * FROM goals WHERE user_id = ?");
$stmt->execute([$user_id]);
$goals = $stmt->fetchAll(PDO::FETCH_ASSOC);

$total_goals = count($goals);
$completed_goals = count(array_filter($goals, fn($g) => $g['completed']));
$completion_rate = $total_goals > 0 ? round(($completed_goals / $total_goals) * 100) : 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
    <style>
        .container {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #fff0f5;
    display: flex;
    justify-content: center;
    align-items: flex-start;
    padding: 40px 20px;
}

.dashboard-card {
    background-color: #fff;
    border-radius: 20px;
    box-shadow: 0 8px 25px rgba(0,0,0,0.08);
    padding: 30px;
    max-width: 900px;
    width: 100%;
    box-sizing: border-box;
}

.dashboard-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    margin-bottom: 30px;
}

.logout-btn {
    background-color: #f44336;
    color: white;
    padding: 8px 16px;
    border-radius: 8px;
    text-decoration: none;
}

.stats-section {
    text-align: center;
    margin-bottom: 40px;
}

.stats-grid {
    display: flex;
    justify-content: space-around;
    margin-top: 15px;
    margin-bottom: 25px;
}

.circular-progress svg {
    width: 120px;
    height: 120px;
}

.circular-progress .bg {
    fill: none;
    stroke: #eee;
    stroke-width: 3.8;
}

.circular-progress .progress {
    fill: none;
    stroke:rgb(255, 159, 191);
    stroke-width: 3.8;
    stroke-linecap: round;
    transition: stroke-dasharray 0.6s ease;
}

.circular-progress .percentage {
    fill: #333;
    font-size: 0.5em;
    text-anchor: middle;
}

.goals-section {
    margin-top: 20px;
}

.goals-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.goals-table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 15px;
}

.goals-table th, .goals-table td {
    padding: 12px;
    border-bottom: 1px solid #ddd;
    text-align: left;
}

.progress-bar {
    
   background-color:rgb(255, 159, 191);
    border-radius: 10px;
    overflow: hidden;
    height: 24px;
}

.bar {
    height: 100%;
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.85em;
    transition: width 0.4s ease;
}

.green {
    background-color: #4caf50;
}

.red {
    background-color: #f44336;
}

/* Mobile responsive */
@media (max-width: 768px) {
    .stats-grid {
        flex-direction: column;
        gap: 10px;
    }

    .dashboard-header, .goals-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 10px;
    }

    .circular-progress svg {
        width: 100px;
        height: 100px;
    }
}

    </style>
<div class="container">
    <div class="dashboard-card">
        <div class="dashboard-header">
            <h2>Welcome Queen 💗🎀</h2>
            <a href="logout.php" class="btn logout-btn">Logout</a>
        </div>

        <div class="stats-section">
            <h3>Weekly Stats</h3>
            <div class="stats-grid">
                <div><strong>Total Goals:</strong> <?= $total_goals ?></div>
                <div><strong>Completed:</strong> <?= $completed_goals ?></div>
                <div><strong>Remaining:</strong> <?= $total_goals - $completed_goals ?></div>
            </div>
            <div class="circular-progress">
                <svg viewBox="0 0 36 36">
                    <path class="bg" d="M18 2.0845
                      a 15.9155 15.9155 0 0 1 0 31.831
                      a 15.9155 15.9155 0 0 1 0 -31.831"/>
                    <path class="progress"
                      stroke-dasharray="<?= $completion_rate ?>, 100"
                      d="M18 2.0845
                        a 15.9155 15.9155 0 0 1 0 31.831
                        a 15.9155 15.9155 0 0 1 0 -31.831"/>
                    <text x="18" y="20.35" class="percentage"><?= $completion_rate ?>%</text>
                </svg>
            </div>
        </div>

        <div class="goals-section">
            <div class="goals-header">
                <h3>My Weekly Goals</h3>
                <a href="add_goal.php" class="btn">+ New Goal</a>
            </div>

            <table class="goals-table">
                <thead>
                <tr>
                    <th>Goal</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($goals as $goal): ?>
                    <tr>
                        <td><?= htmlspecialchars($goal['title']) ?></td>
                        <td>
                            <div class="progress-bar">
                                <div class="<?= $goal['completed'] ? 'bar green' : 'bar red' ?>"
                                     style="width: <?= $goal['completed'] ? '100%' : '0%' ?>;">
                                    <?= $goal['completed'] ? 'Completed' : 'Pending' ?>
                                </div>
                            </div>
                        </td>
                        <td>
                            <?php if (!$goal['completed']): ?>
                                <a href="mark_done.php?id=<?= $goal['id'] ?>">✅</a>
                            <?php endif; ?>
                            <a href="edit_goal.php?id=<?= $goal['id'] ?>">✏️</a>
                            <a href="delete_goal.php?id=<?= $goal['id'] ?>">❌</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html>
