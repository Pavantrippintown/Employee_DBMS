<?php
require_once ('process/dbh.php');
$sql = "SELECT * from `employee`, `rank` WHERE employee.id = rank.eid";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Agent Network | Admin Panel | Trippintown Tech</title>
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
            flex-wrap: wrap;
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
            max-width: 1800px;
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
            position: sticky;
            top: 0;
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
        
        .agent-avatar {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid var(--primary);
            box-shadow: 0 0 10px rgba(0, 247, 255, 0.5);
        }
        
        .cyber-btn {
            background: transparent;
            border: 1px solid var(--primary);
            color: var(--primary);
            font-family: 'Orbitron', sans-serif;
            padding: 5px 10px;
            border-radius: 4px;
            cursor: pointer;
            transition: all 0.3s;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-size: 0.8rem;
            margin: 0 5px;
            text-decoration: none;
        }
        
        .cyber-btn:hover {
            background: var(--primary);
            color: var(--darker);
            box-shadow: 0 0 10px rgba(0, 247, 255, 0.5);
        }
        
        .cyber-btn-danger {
            border-color: var(--danger);
            color: var(--danger);
        }
        
        .cyber-btn-danger:hover {
            background: var(--danger);
            color: var(--light);
            box-shadow: 0 0 10px rgba(255, 56, 96, 0.5);
        }
        
        .points-cell {
            font-family: 'Orbitron', sans-serif;
            font-weight: bold;
            color: var(--secondary);
        }
        
        .search-container {
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
        }
        
        .cyber-search {
            background: rgba(10, 10, 26, 0.5);
            border: 1px solid rgba(0, 247, 255, 0.2);
            color: var(--light);
            padding: 10px 15px;
            border-radius: 6px;
            font-family: 'Rajdhani', sans-serif;
            min-width: 300px;
            margin-bottom: 10px;
        }
        
        .cyber-search:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 10px rgba(0, 247, 255, 0.3);
        }
        
        .dept-badge {
            padding: 3px 8px;
            border-radius: 4px;
            font-size: 0.8rem;
            font-weight: bold;
            text-transform: uppercase;
        }
        
        .dept-tech {
            background-color: rgba(0, 247, 255, 0.2);
            color: var(--primary);
        }
        
        .dept-hr {
            background-color: rgba(255, 0, 228, 0.2);
            color: var(--accent);
        }
        
        .dept-finance {
            background-color: rgba(0, 255, 157, 0.2);
            color: var(--secondary);
        }
        
        .dept-ops {
            background-color: rgba(255, 204, 0, 0.2);
            color: var(--warning);
        }
        
        @media (max-width: 1600px) {
            .cyber-table {
                display: block;
                overflow-x: auto;
                white-space: nowrap;
            }
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
                <li><a class="homered" href="viewemp.php"><i class="fas fa-users"></i> AGENT NETWORK</a></li>
                <li><a class="homeblack" href="assign.php"><i class="fas fa-tasks"></i> ASSIGN MISSION</a></li>
                <li><a class="homeblack" href="assignproject.php"><i class="fas fa-project-diagram"></i> MISSION CONTROL</a></li>
                <li><a class="homeblack" href="salaryemp.php"><i class="fas fa-credit-card"></i> FINANCIAL HUB</a></li>
                <li><a class="homeblack" href="empleave.php"><i class="fas fa-calendar-alt"></i> LEAVE CONSOLE</a></li>
                <li><a class="homeblack" href="alogin.html"><i class="fas fa-power-off"></i> LOGOUT</a></li>
            </ul>
        </nav>
    </header>
    
    <div class="cyber-divider"></div>
    
    <div class="cyber-container">
        <h2 class="cyber-title">Agent Network</h2>
        
        <div class="search-container">
            <input type="text" class="cyber-search" placeholder="Search agents..." id="searchInput">
            <div>
                <span style="color: var(--primary); margin-right: 10px;">
                    <i class="fas fa-users"></i> Total Agents: 
                    <?php 
                        $countSql = "SELECT COUNT(*) as total FROM employee";
                        $countResult = mysqli_query($conn, $countSql);
                        $count = mysqli_fetch_assoc($countResult);
                        echo $count['total'];
                    ?>
                </span>
                <span style="color: var(--secondary);">
                    <i class="fas fa-star"></i> Top Performer: 
                    <?php 
                        $topSql = "SELECT employee.firstName, employee.lastName FROM employee, rank 
                                   WHERE employee.id = rank.eid ORDER BY rank.points DESC LIMIT 1";
                        $topResult = mysqli_query($conn, $topSql);
                        $top = mysqli_fetch_assoc($topResult);
                        echo $top['firstName']." ".$top['lastName'];
                    ?>
                </span>
            </div>
        </div>
        
        <table class="cyber-table" id="agentTable">
            <thead>
                <tr>
                    <th>Agent ID</th>
                    <th>Avatar</th>
                    <th>Agent Name</th>
                    <th>Email</th>
                    <th>Birth Date</th>
                    <th>Gender</th>
                    <th>Contact</th>
                    <th>NID</th>
                    <th>Address</th>
                    <th>Department</th>
                    <th>Degree</th>
                    <th>Points</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    while ($employee = mysqli_fetch_assoc($result)) {
                        $deptClass = 'dept-tech';
                        if (strpos($employee['dept'], 'HR') !== false) $deptClass = 'dept-hr';
                        elseif (strpos($employee['dept'], 'Finance') !== false) $deptClass = 'dept-finance';
                        elseif (strpos($employee['dept'], 'Operations') !== false) $deptClass = 'dept-ops';
                        
                        echo "<tr>";
                        echo "<td>#".str_pad($employee['id'], 4, '0', STR_PAD_LEFT)."</td>";
                        echo "<td><img src='process/".$employee['pic']."' class='agent-avatar'></td>";
                        echo "<td>".$employee['firstName']." ".$employee['lastName']."</td>";
                        echo "<td>".$employee['email']."</td>";
                        echo "<td>".date('M d, Y', strtotime($employee['birthday']))."</td>";
                        echo "<td>".$employee['gender']."</td>";
                        echo "<td>".$employee['contact']."</td>";
                        echo "<td>".$employee['nid']."</td>";
                        echo "<td>".$employee['address']."</td>";
                        echo "<td><span class='dept-badge $deptClass'>".$employee['dept']."</span></td>";
                        echo "<td>".$employee['degree']."</td>";
                        echo "<td class='points-cell'>".$employee['points']."</td>";
                        echo "<td>
                                <a href=\"edit.php?id=$employee[id]\" class=\"cyber-btn\"><i class=\"fas fa-edit\"></i> EDIT</a>
                                <a href=\"delete.php?id=$employee[id]\" class=\"cyber-btn cyber-btn-danger\" onClick=\"return confirm('Are you sure you want to deactivate this agent?')\"><i class=\"fas fa-trash\"></i> DELETE</a>
                              </td>";
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
            
            // Search functionality
            $("#searchInput").on("keyup", function() {
                var value = $(this).val().toLowerCase();
                $("#agentTable tbody tr").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });
        });
        
        function confirmDelete() {
            return confirm("Are you sure you want to deactivate this agent?");
        }
    </script>
</body>
</html>