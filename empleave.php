<?php
require_once('process/dbh.php');

$sql = "SELECT employee.id, employee.firstName, employee.lastName, employee_leave.start, 
               employee_leave.end, employee_leave.reason, employee_leave.status, employee_leave.token 
        FROM employee, employee_leave 
        WHERE employee.id = employee_leave.id 
        ORDER BY employee_leave.token";

$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Leave | Admin Panel | Trippintown Tech</title>
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
            --approved: rgba(0, 255, 0, 0.2);
            --pending: rgba(255, 255, 0, 0.2);
            --cancelled: rgba(255, 0, 0, 0.2);
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
            flex-wrap: wrap;
        }
        
        #navli li a {
            color: var(--light);
            text-decoration: none;
            padding: 0.5rem 1rem;
            margin: 0 0.2rem;
            border-radius: 4px;
            position: relative;
            font-weight: 500;
            font-size: 0.9rem;
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
        }
        
        /* Table Styles */
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1rem;
            background: var(--card-bg);
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
        }
        
        .data-table th, .data-table td {
            padding: 1rem;
            text-align: left;
            border-bottom: 1px solid rgba(100, 255, 218, 0.1);
        }
        
        .data-table th {
            background: linear-gradient(90deg, var(--primary), var(--secondary));
            color: var(--dark);
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.8rem;
            letter-spacing: 1px;
        }
        
        .data-table tr:hover {
            background: rgba(100, 255, 218, 0.05);
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
            background: var(--approved);
            color: #00ff00;
            border: 1px solid rgba(0, 255, 0, 0.3);
        }
        
        .status-pending {
            background: var(--pending);
            color: #ffff00;
            border: 1px solid rgba(255, 255, 0, 0.3);
        }
        
        .status-cancelled {
            background: var(--cancelled);
            color: #ff0000;
            border: 1px solid rgba(255, 0, 0, 0.3);
        }
        
        /* Action Buttons */
        .action-btn {
            padding: 0.5rem 1rem;
            border-radius: 4px;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.8rem;
            margin: 0 0.2rem;
            transition: all 0.3s ease;
            display: inline-block;
        }
        
        .approve-btn {
            background: rgba(0, 255, 0, 0.1);
            color: #00ff00;
            border: 1px solid rgba(0, 255, 0, 0.3);
        }
        
        .approve-btn:hover {
            background: rgba(0, 255, 0, 0.2);
            transform: translateY(-2px);
        }
        
        .cancel-btn {
            background: rgba(255, 0, 0, 0.1);
            color: #ff0000;
            border: 1px solid rgba(255, 0, 0, 0.3);
        }
        
        .cancel-btn:hover {
            background: rgba(255, 0, 0, 0.2);
            transform: translateY(-2px);
        }
        
        /* Responsive Design */
        @media (max-width: 768px) {
            nav {
                flex-direction: column;
            }
            
            #navli {
                margin-top: 1rem;
                justify-content: center;
            }
            
            .data-table {
                display: block;
                overflow-x: auto;
            }
        }
        
        /* Floating Animation */
        @keyframes float {
            0%, 100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-5px);
            }
        }
        
        .floating {
            animation: float 6s ease-in-out infinite;
        }
    </style>
</head>
<body>
    <header>
        <nav>
            <h1><i class="fas fa-robot"></i> Trippintown Tech</h1>
            <ul id="navli">
                <li><a class="homeblack" href="aloginwel.php"><i class="fas fa-home"></i> HOME</a></li>
                <li><a class="homeblack" href="addemp.php"><i class="fas fa-user-plus"></i> Add Employee</a></li>
                <li><a class="homeblack" href="viewemp.php"><i class="fas fa-users"></i> View Employee</a></li>
                <li><a class="homeblack" href="assign.php"><i class="fas fa-tasks"></i> Assign Project</a></li>
                <li><a class="homeblack" href="assignproject.php"><i class="fas fa-project-diagram"></i> Project Status</a></li>
                <li><a class="homeblack" href="salaryemp.php"><i class="fas fa-money-bill-wave"></i> Salary Table</a></li>
                <li><a class="homered" href="empleave.php"><i class="fas fa-calendar-alt"></i> Employee Leave</a></li>
                <li><a class="homeblack" href="alogin.html"><i class="fas fa-sign-out-alt"></i> Log Out</a></li>
            </ul>
        </nav>
    </header>
    
    <div class="main-content">
        <h2 class="floating"><i class="fas fa-calendar-check"></i> Employee Leave Management</h2>
        <table class="data-table">
            <thead>
                <tr>
                    <th>Emp. ID</th>
                    <th>Token</th>
                    <th>Name</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Days</th>
                    <th>Reason</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    while ($employee = mysqli_fetch_assoc($result)) {
                        $date1 = new DateTime($employee['start']);
                        $date2 = new DateTime($employee['end']);
                        $interval = $date1->diff($date2);
                        
                        $statusClass = '';
                        if($employee['status'] == 'Approved') $statusClass = 'status-approved';
                        elseif($employee['status'] == 'Cancelled') $statusClass = 'status-cancelled';
                        else $statusClass = 'status-pending';
                        
                        echo "<tr>";
                        echo "<td>".$employee['id']."</td>";
                        echo "<td>".$employee['token']."</td>";
                        echo "<td>".$employee['firstName']." ".$employee['lastName']."</td>";
                        echo "<td>".date('M d, Y', strtotime($employee['start']))."</td>";
                        echo "<td>".date('M d, Y', strtotime($employee['end']))."</td>";
                        echo "<td>".$interval->days."</td>";
                        echo "<td>".$employee['reason']."</td>";
                        echo "<td><span class='status-badge $statusClass'>".$employee['status']."</span></td>";
                        echo "<td>
                                <a href=\"approve.php?id=$employee[id]&token=$employee[token]\" class=\"action-btn approve-btn\" onClick=\"return confirm('Approve this leave request?')\">
                                    <i class=\"fas fa-check\"></i> Approve
                                </a>
                                <a href=\"cancel.php?id=$employee[id]&token=$employee[token]\" class=\"action-btn cancel-btn\" onClick=\"return confirm('Cancel this leave request?')\">
                                    <i class=\"fas fa-times\"></i> Cancel
                                </a>
                              </td>";
                        echo "</tr>";
                    }
                ?>
            </tbody>
        </table>
    </div>

    <script>
        // Add interactive effects
        document.querySelectorAll('.action-btn').forEach(btn => {
            btn.addEventListener('mouseenter', () => {
                btn.style.transform = 'translateY(-3px)';
                btn.style.boxShadow = '0 5px 15px rgba(0, 247, 255, 0.3)';
            });
            
            btn.addEventListener('mouseleave', () => {
                btn.style.transform = '';
                btn.style.boxShadow = '';
            });
        });
        
        // Add glow effect to table rows on hover
        document.querySelectorAll('.data-table tr').forEach(row => {
            row.addEventListener('mouseenter', () => {
                row.style.boxShadow = 'inset 0 0 15px rgba(0, 247, 255, 0.1)';
            });
            
            row.addEventListener('mouseleave', () => {
                row.style.boxShadow = '';
            });
        });
    </script>
</body>
</html>