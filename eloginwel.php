<?php 
$id = isset($_GET['id']) ? $_GET['id'] : '';
require_once('process/dbh.php');

// Fetch employee data
$sql1 = "SELECT * FROM `employee` WHERE id = '$id'";
$result1 = mysqli_query($conn, $sql1);
$employeen = mysqli_fetch_array($result1);
$empName = $employeen['firstName'];

// Other queries
$sql = "SELECT id, firstName, lastName, points FROM employee, rank WHERE rank.eid = employee.id ORDER BY rank.points DESC";
$sql1 = "SELECT `pname`, `duedate` FROM `project` WHERE eid = $id AND status = 'Due'";
$sql2 = "SELECT * FROM employee, employee_leave WHERE employee.id = $id AND employee_leave.id = $id ORDER BY employee_leave.token";
$sql3 = "SELECT * FROM `salary` WHERE id = $id";

$result = mysqli_query($conn, $sql);
$result1 = mysqli_query($conn, $sql1);
$result2 = mysqli_query($conn, $sql2);
$result3 = mysqli_query($conn, $sql3);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Panel | Trippintown Tech</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;500;700&family=Montserrat:wght@300;400;500&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #00f7ff;
            --secondary: #0066ff;
            --dark: #0a192f;
            --light: #e6f1ff;
            --accent: #64ffda;
            --card-bg: rgba(10, 25, 47, 0.8);
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            transition: all 0.3s ease;
        }
        
        body {
            font-family: 'Montserrat', sans-serif;
            background-color: var(--dark);
            color: var(--light);
            background-image: 
                radial-gradient(circle at 25% 25%, rgba(0, 247, 255, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 75% 75%, rgba(0, 102, 255, 0.1) 0%, transparent 50%);
            min-height: 100vh;
        }
        
        h1, h2, h3, h4 {
            font-family: 'Orbitron', sans-serif;
            color: var(--primary);
            text-shadow: 0 0 10px rgba(0, 247, 255, 0.5);
        }
        
        /* Header Styles */
        header {
            background-color: rgba(10, 25, 47, 0.9);
            backdrop-filter: blur(10px);
            padding: 1rem 2rem;
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.3);
            border-bottom: 1px solid rgba(100, 255, 218, 0.2);
        }
        
        nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        #navli {
            display: flex;
            list-style: none;
        }
        
        #navli li a {
            color: var(--light);
            text-decoration: none;
            padding: 0.5rem 1rem;
            margin: 0 0.5rem;
            border-radius: 4px;
            position: relative;
            font-weight: 500;
        }
        
        #navli li a.homered {
            color: var(--accent);
        }
        
        #navli li a::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 0;
            height: 2px;
            background: var(--accent);
            transition: width 0.3s ease;
        }
        
        #navli li a:hover::after {
            width: 70%;
        }
        
        /* Main Content */
        .main-content {
            margin-top: 80px;
            padding: 2rem;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
        }
        
        .dashboard-card {
            background: var(--card-bg);
            border-radius: 16px;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(100, 255, 218, 0.1);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
            padding: 1.5rem;
            transition: transform 0.3s ease;
        }
        
        .dashboard-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 40px rgba(0, 247, 255, 0.2);
        }
        
        .card-title {
            margin-bottom: 1.5rem;
            font-size: 1.5rem;
            position: relative;
            display: inline-block;
        }
        
        .card-title::after {
            content: '';
            position: absolute;
            bottom: -8px;
            left: 0;
            width: 100%;
            height: 3px;
            background: linear-gradient(90deg, var(--primary), transparent);
        }
        
        /* Table Styles */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1rem;
            background: rgba(100, 255, 218, 0.05);
            border-radius: 8px;
            overflow: hidden;
        }
        
        th, td {
            padding: 1rem;
            text-align: left;
            border-bottom: 1px solid rgba(100, 255, 218, 0.1);
        }
        
        th {
            background: linear-gradient(90deg, var(--primary), var(--secondary));
            color: var(--dark);
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.8rem;
            letter-spacing: 1px;
        }
        
        tr:hover {
            background: rgba(100, 255, 218, 0.1);
        }
        
        /* Status Badges */
        .status-badge {
            padding: 0.5rem 1rem;
            border-radius: 50px;
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            display: inline-block;
        }
        
        .status-approved {
            background: rgba(0, 255, 0, 0.1);
            color: #00ff00;
            border: 1px solid rgba(0, 255, 0, 0.3);
        }
        
        .status-pending {
            background: rgba(255, 255, 0, 0.1);
            color: #ffff00;
            border: 1px solid rgba(255, 255, 0, 0.3);
        }
        
        .status-cancelled {
            background: rgba(255, 0, 0, 0.1);
            color: #ff0000;
            border: 1px solid rgba(255, 0, 0, 0.3);
        }
        
        /* Responsive Design */
        @media (max-width: 768px) {
            nav {
                flex-direction: column;
            }
            
            #navli {
                margin-top: 1rem;
                flex-wrap: wrap;
                justify-content: center;
            }
            
            .main-content {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <header>
        <nav>
            <h1><i class="fas fa-robot"></i> Trippintown Tech</h1>
            <ul id="navli">
                <li><a class="homered" href="eloginwel.php?id=<?php echo $id?>"><i class="fas fa-home"></i> HOME</a></li>
                <li><a class="homeblack" href="myprofile.php?id=<?php echo $id?>"><i class="fas fa-user"></i> My Profile</a></li>
                <li><a class="homeblack" href="empproject.php?id=<?php echo $id?>"><i class="fas fa-project-diagram"></i> My Projects</a></li>
                <li><a class="homeblack" href="applyleave.php?id=<?php echo $id?>"><i class="fas fa-calendar-alt"></i> Apply Leave</a></li>
                <li><a class="homeblack" href="elogin.html"><i class="fas fa-sign-out-alt"></i> Log Out</a></li>
            </ul>
        </nav>
    </header>
    
    <div class="main-content">
        <!-- Leaderboard Card -->
        <div class="dashboard-card">
            <h2 class="card-title"><i class="fas fa-trophy"></i> Employee Leaderboard</h2>
            <table>
                <thead>
                    <tr>
                        <th>Rank</th>
                        <th>Emp. ID</th>
                        <th>Name</th>
                        <th>Points</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $seq = 1;
                        while ($employee = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                            echo "<td>".$seq."</td>";
                            echo "<td>".$employee['id']."</td>";
                            echo "<td>".$employee['firstName']." ".$employee['lastName']."</td>";
                            echo "<td>".$employee['points']."</td>";
                            echo "</tr>";
                            $seq++;
                        }
                    ?>
                </tbody>
            </table>
        </div>
        
        <!-- Due Projects Card -->
        <div class="dashboard-card">
            <h2 class="card-title"><i class="fas fa-exclamation-circle"></i> Due Projects</h2>
            <table>
                <thead>
                    <tr>
                        <th>Project Name</th>
                        <th>Due Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        while ($employee1 = mysqli_fetch_assoc($result1)) {
                            echo "<tr>";
                            echo "<td>".$employee1['pname']."</td>";
                            echo "<td>".$employee1['duedate']."</td>";
                            echo "</tr>";
                        }
                    ?>
                </tbody>
            </table>
        </div>
        
        <!-- Salary Status Card -->
        <div class="dashboard-card">
            <h2 class="card-title"><i class="fas fa-money-bill-wave"></i> Salary Status</h2>
            <table>
                <thead>
                    <tr>
                        <th>Base Salary</th>
                        <th>Bonus</th>
                        <th>Total Salary</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        while ($employee = mysqli_fetch_assoc($result3)) {
                            echo "<tr>";
                            echo "<td>".$employee['base']."</td>";
                            echo "<td>".$employee['bonus']."%</td>";
                            echo "<td>".$employee['total']."</td>";
                            echo "</tr>";
                        }
                    ?>
                </tbody>
            </table>
        </div>
        
        <!-- Leave Status Card -->
        <div class="dashboard-card">
            <h2 class="card-title"><i class="fas fa-calendar-check"></i> Leave Status</h2>
            <table>
                <thead>
                    <tr>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Days</th>
                        <th>Reason</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        while ($employee = mysqli_fetch_assoc($result2)) {
                            $date1 = new DateTime($employee['start']);
                            $date2 = new DateTime($employee['end']);
                            $interval = $date1->diff($date2);
                            
                            $statusClass = '';
                            if($employee['status'] == 'Approved') $statusClass = 'status-approved';
                            elseif($employee['status'] == 'Cancelled') $statusClass = 'status-cancelled';
                            else $statusClass = 'status-pending';
                            
                            echo "<tr>";
                            echo "<td>".date('M d, Y', strtotime($employee['start']))."</td>";
                            echo "<td>".date('M d, Y', strtotime($employee['end']))."</td>";
                            echo "<td>".$interval->days."</td>";
                            echo "<td>".$employee['reason']."</td>";
                            echo "<td><span class='status-badge $statusClass'>".$employee['status']."</span></td>";
                            echo "</tr>";
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        // Add interactive effects
        document.querySelectorAll('.dashboard-card').forEach(card => {
            card.addEventListener('mouseenter', () => {
                card.style.transform = 'translateY(-10px)';
                card.style.boxShadow = '0 15px 30px rgba(0, 247, 255, 0.3)';
            });
            
            card.addEventListener('mouseleave', () => {
                card.style.transform = 'translateY(-5px)';
                card.style.boxShadow = '0 12px 40px rgba(0, 247, 255, 0.2)';
            });
        });
    </script>
</body>
</html>