<?php
require_once ('process/dbh.php');
$sql = "SELECT * from `project` order by subdate desc";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Mission Control | Admin Panel | Trippintown Tech</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;500;700;900&family=Rajdhani:wght@300;400;500;600;700&display=swap">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link rel="stylesheet" href="vendor/font-awesome/css/all.min.css">
    <style>
        :root {
            --primary: #00f7ff;
            --secondary: #00ff9d;
            --accent: #ff00e4;
            --dark: #0a0a1a;
            --darker: #050510;
            --light: #e0e0ff;
            --warning: #ffcc00;
            --danger: #ff3860;
            --success: #00ff9d;
        }
        
        body {
            background-color: var(--darker);
            color: var(--light);
            font-family: 'Rajdhani', sans-serif;
            margin: 0;
            padding: 0;
            overflow-x: hidden;
        }
        
        .cyber-header {
            background: rgba(10, 10, 26, 0.8);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(0, 247, 255, 0.2);
            box-shadow: 0 0 20px rgba(0, 247, 255, 0.1);
            padding: 15px 0;
            position: sticky;
            top: 0;
            z-index: 100;
        }
        
        .cyber-header h1 {
            font-family: 'Orbitron', sans-serif;
            text-transform: uppercase;
            letter-spacing: 3px;
            background: linear-gradient(90deg, var(--primary), var(--accent));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            position: relative;
            text-shadow: 0 0 10px rgba(0, 247, 255, 0.3);
            margin: 0;
            padding: 0 20px;
            font-size: 1.8rem;
        }
        
        .cyber-nav ul {
            display: flex;
            list-style: none;
            margin: 0;
            padding: 0 20px;
            justify-content: flex-end;
        }
        
        .cyber-nav ul li {
            margin-left: 20px;
        }
        
        .cyber-nav ul li a {
            color: var(--light);
            text-decoration: none;
            font-family: 'Rajdhani', sans-serif;
            font-weight: 600;
            letter-spacing: 1px;
            text-transform: uppercase;
            font-size: 0.9rem;
            position: relative;
            transition: color 0.3s;
        }
        
        .cyber-nav ul li a::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 0;
            height: 2px;
            background: var(--primary);
            transition: width 0.3s ease;
        }
        
        .cyber-nav ul li a:hover {
            color: var(--primary);
        }
        
        .cyber-nav ul li a:hover::after {
            width: 100%;
        }
        
        .cyber-nav ul li a.homered {
            color: var(--primary);
        }
        
        .cyber-nav ul li a.homered::after {
            width: 100%;
        }
        
        .cyber-divider {
            height: 1px;
            background: linear-gradient(90deg, transparent, var(--primary), transparent);
            margin: 0;
            opacity: 0.3;
        }
        
        .cyber-container {
            max-width: 1200px;
            margin: 40px auto;
            padding: 0 20px;
        }
        
        .cyber-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            background: rgba(10, 10, 26, 0.5);
            border-radius: 10px;
            overflow: hidden;
            margin-top: 30px;
            box-shadow: 0 0 30px rgba(0, 247, 255, 0.1);
        }
        
        .cyber-table th {
            background: linear-gradient(90deg, var(--primary), var(--secondary));
            color: var(--darker);
            font-family: 'Orbitron', sans-serif;
            text-transform: uppercase;
            letter-spacing: 1px;
            padding: 15px;
            text-align: left;
            font-size: 0.9rem;
        }
        
        .cyber-table td {
            padding: 12px 15px;
            border-bottom: 1px solid rgba(0, 247, 255, 0.1);
            color: var(--light);
            font-size: 0.9rem;
        }
        
        .cyber-table tr:last-child td {
            border-bottom: none;
        }
        
        .cyber-table tr:hover td {
            background: rgba(0, 247, 255, 0.05);
            color: var(--primary);
        }
        
        .status-badge {
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: bold;
            font-family: 'Orbitron', sans-serif;
            letter-spacing: 1px;
            text-transform: uppercase;
            display: inline-block;
            min-width: 80px;
            text-align: center;
        }
        
        .status-pending {
            background-color: rgba(255, 204, 0, 0.2);
            color: var(--warning);
            box-shadow: 0 0 10px rgba(255, 204, 0, 0.2);
        }
        
        .status-completed {
            background-color: rgba(0, 255, 157, 0.2);
            color: var(--success);
            box-shadow: 0 0 10px rgba(0, 255, 157, 0.2);
        }
        
        .status-late {
            background-color: rgba(255, 56, 96, 0.2);
            color: var(--danger);
            box-shadow: 0 0 10px rgba(255, 56, 96, 0.2);
        }
        
        .cyber-btn {
            background: linear-gradient(90deg, var(--primary), var(--secondary));
            border: none;
            color: var(--darker);
            font-family: 'Orbitron', sans-serif;
            padding: 8px 15px;
            border-radius: 20px;
            cursor: pointer;
            position: relative;
            overflow: hidden;
            transition: all 0.3s;
            box-shadow: 0 0 10px rgba(0, 247, 255, 0.5);
            text-transform: uppercase;
            letter-spacing: 1px;
            font-weight: bold;
            font-size: 0.8rem;
            text-decoration: none;
            display: inline-block;
        }
        
        .cyber-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 0 20px rgba(0, 247, 255, 0.8);
        }
        
        .cyber-btn::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(
                to bottom right,
                transparent 45%,
                rgba(255, 255, 255, 0.5) 50%,
                transparent 55%
            );
            transform: rotate(30deg);
            animation: btn-shine 3s infinite;
        }
        
        @keyframes btn-shine {
            0% { transform: translateX(-100%) rotate(30deg); }
            100% { transform: translateX(100%) rotate(30deg); }
        }
        
        .cyber-floating {
            position: absolute;
            border-radius: 50%;
            filter: blur(60px);
            opacity: 0.2;
            z-index: -1;
        }
        
        .cyber-floating-1 {
            width: 300px;
            height: 300px;
            background: var(--primary);
            top: -100px;
            right: -100px;
            animation: float 15s ease-in-out infinite;
        }
        
        .cyber-floating-2 {
            width: 400px;
            height: 400px;
            background: var(--accent);
            bottom: -150px;
            left: -100px;
            animation: float 20s ease-in-out infinite reverse;
        }
        
        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
            100% { transform: translateY(0px); }
        }
        
        .cyber-title {
            font-family: 'Orbitron', sans-serif;
            text-transform: uppercase;
            letter-spacing: 2px;
            color: var(--primary);
            margin-bottom: 20px;
            font-size: 1.5rem;
            position: relative;
        }
        
        .cyber-title::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 0;
            width: 50px;
            height: 3px;
            background: linear-gradient(90deg, var(--primary), var(--secondary));
        }
        
        .progress-bar {
            height: 8px;
            background: rgba(0, 247, 255, 0.1);
            border-radius: 4px;
            overflow: hidden;
            margin-top: 5px;
        }
        
        .progress-fill {
            height: 100%;
            background: linear-gradient(90deg, var(--primary), var(--secondary));
            border-radius: 4px;
        }
        
        .mark-cell {
            font-family: 'Orbitron', sans-serif;
            font-weight: bold;
            color: var(--primary);
        }
    </style>
</head>
<body>
    <!-- Floating background elements -->
    <div class="cyber-floating cyber-floating-1"></div>
    <div class="cyber-floating cyber-floating-2"></div>
    
    <header class="cyber-header">
        <nav class="cyber-nav">
            <h1>TRIPPINTOWN TECH</h1>
            <ul id="navli">
                <li><a class="homeblack" href="aloginwel.php"><i class="fas fa-terminal"></i> DASHBOARD</a></li>
                <li><a class="homeblack" href="addemp.php"><i class="fas fa-user-plus"></i> ADD AGENT</a></li>
                <li><a class="homeblack" href="viewemp.php"><i class="fas fa-users"></i> AGENT NETWORK</a></li>
                <li><a class="homeblack" href="assign.php"><i class="fas fa-tasks"></i> ASSIGN MISSION</a></li>
                <li><a class="homered" href="assignproject.php"><i class="fas fa-project-diagram"></i> MISSION CONTROL</a></li>
                <li><a class="homeblack" href="salaryemp.php"><i class="fas fa-credit-card"></i> FINANCE SYSTEM</a></li>
                <li><a class="homeblack" href="empleave.php"><i class="fas fa-calendar-alt"></i> LEAVE CONSOLE</a></li>
                <li><a class="homeblack" href="alogin.html"><i class="fas fa-power-off"></i> LOGOUT</a></li>
            </ul>
        </nav>
    </header>
    
    <div class="cyber-divider"></div>
    
    <div class="cyber-container">
        <h2 class="cyber-title">Mission Status Dashboard</h2>
        
        <table class="cyber-table">
            <thead>
                <tr>
                    <th>Mission ID</th>
                    <th>Agent ID</th>
                    <th>Mission Name</th>
                    <th>Due Date</th>
                    <th>Completion Date</th>
                    <th>Progress</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    while ($project = mysqli_fetch_assoc($result)) {
                        $statusClass = '';
                        if ($project['status'] == 'Completed') {
                            $statusClass = 'status-completed';
                        } elseif (strtotime($project['subdate']) > strtotime($project['duedate'])) {
                            $statusClass = 'status-late';
                        } else {
                            $statusClass = 'status-pending';
                        }
                        
                        $progress = min(100, ($project['mark'] / 100) * 100);
                        
                        echo "<tr>";
                        echo "<td>".$project['pid']."</td>";
                        echo "<td>#".str_pad($project['eid'], 4, '0', STR_PAD_LEFT)."</td>";
                        echo "<td>".$project['pname']."</td>";
                        echo "<td>".date('M d, Y', strtotime($project['duedate']))."</td>";
                        echo "<td>".($project['subdate'] ? date('M d, Y', strtotime($project['subdate'])) : 'N/A')."</td>";
                        echo "<td>
                                <div class='mark-cell'>".$project['mark']."%</div>
                                <div class='progress-bar'>
                                    <div class='progress-fill' style='width: ".$progress."%;'></div>
                                </div>
                              </td>";
                        echo "<td><span class='status-badge $statusClass'>".$project['status']."</span></td>";
                        echo "<td><a href=\"mark.php?id=$project[eid]&pid=$project[pid]\" class=\"cyber-btn\"><i class=\"fas fa-edit\"></i> UPDATE</a></td>";
                        echo "</tr>";
                    }
                ?>
            </tbody>
        </table>
    </div>

    <script src="vendor/jquery/jquery.min.js"></script>
    <script>
        // Add animation to table rows on load
        $(document).ready(function() {
            $('.cyber-table tbody tr').each(function(i) {
                $(this).delay(100 * i).queue(function() {
                    $(this).css('opacity', '1');
                    $(this).dequeue();
                });
            });
        });
    </script>
</body>
</html>