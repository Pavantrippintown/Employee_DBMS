<?php
$id = isset($_GET['id']) ? $_GET['id'] : '';
require_once('process/dbh.php');

$sql = "SELECT * FROM `employee` WHERE id = '$id'";
$result = mysqli_query($conn, $sql);
$employee = mysqli_fetch_array($result);
$empName = $employee['firstName'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Apply Leave | Employee Panel | Trippintown Tech</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;500;700&family=Roboto:wght@300;400;500&display=swap" rel="stylesheet">
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
            font-family: 'Roboto', sans-serif;
            background-color: var(--dark);
            color: var(--light);
            background-image: 
                radial-gradient(circle at 25% 25%, rgba(0, 247, 255, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 75% 75%, rgba(0, 102, 255, 0.1) 0%, transparent 50%);
            min-height: 100vh;
            overflow-x: hidden;
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
        
        #navli li a.homered {
            color: var(--accent);
        }
        
        /* Main Content */
        .main-content {
            margin-top: 80px;
            padding: 2rem;
        }
        
        /* Card Styles */
        .card {
            background: var(--card-bg);
            border-radius: 16px;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(100, 255, 218, 0.1);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
            overflow: hidden;
            margin-bottom: 2rem;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 40px rgba(0, 247, 255, 0.2);
        }
        
        .card-heading {
            background: linear-gradient(90deg, var(--primary), var(--secondary));
            height: 10px;
        }
        
        .card-body {
            padding: 2rem;
        }
        
        .title {
            margin-bottom: 1.5rem;
            font-size: 1.8rem;
            position: relative;
            display: inline-block;
        }
        
        .title::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 0;
            width: 100%;
            height: 3px;
            background: linear-gradient(90deg, var(--primary), transparent);
        }
        
        /* Form Styles */
        .input-group {
            margin-bottom: 1.5rem;
            position: relative;
        }
        
        .input--style-1 {
            width: 100%;
            padding: 1rem;
            background: rgba(100, 255, 218, 0.1);
            border: 1px solid rgba(100, 255, 218, 0.3);
            border-radius: 8px;
            color: var(--light);
            font-size: 1rem;
        }
        
        .input--style-1:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 2px rgba(0, 247, 255, 0.3);
        }
        
        .input--style-1::placeholder {
            color: rgba(230, 241, 255, 0.6);
        }
        
        .row-space {
            display: flex;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }
        
        .col-2 {
            flex: 1;
        }
        
        p {
            margin-bottom: 0.5rem;
            color: var(--accent);
            font-weight: 500;
        }
        
        /* Button Styles */
        .btn {
            padding: 1rem 2rem;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            font-size: 1rem;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        
        .btn--radius {
            border-radius: 50px;
        }
        
        .btn--green {
            background: linear-gradient(90deg, var(--primary), var(--secondary));
            color: var(--dark);
        }
        
        .btn--green:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(0, 247, 255, 0.3);
        }
        
        .btn--green::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, rgba(255, 255, 255, 0.2), transparent);
            transform: translateX(-100%);
            transition: transform 0.3s ease;
        }
        
        .btn--green:hover::after {
            transform: translateX(100%);
        }
        
        /* Table Styles */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 2rem;
            background: var(--card-bg);
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
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
        
        /* Animations */
        @keyframes float {
            0%, 100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-10px);
            }
        }
        
        .floating {
            animation: float 6s ease-in-out infinite;
        }
        
        /* Responsive Design */
        @media (max-width: 768px) {
            .row-space {
                flex-direction: column;
            }
            
            nav {
                flex-direction: column;
            }
            
            #navli {
                margin-top: 1rem;
                flex-wrap: wrap;
                justify-content: center;
            }
            
            table {
                display: block;
                overflow-x: auto;
            }
        }
    </style>
</head>
<body>
    <header>
        <nav>
            <h1><i class="fas fa-robot"></i> Trippintown Tech</h1>
            <ul id="navli">
                <li><a class="homeblack" href="eloginwel.php?id=<?php echo $id?>"><i class="fas fa-home"></i> HOME</a></li>
                <li><a class="homeblack" href="myprofile.php?id=<?php echo $id?>"><i class="fas fa-user"></i> My Profile</a></li>
                <li><a class="homeblack" href="empproject.php?id=<?php echo $id?>"><i class="fas fa-project-diagram"></i> My Projects</a></li>
                <li><a class="homered" href="applyleave.php?id=<?php echo $id?>"><i class="fas fa-calendar-alt"></i> Apply Leave</a></li>
                <li><a class="homeblack" href="elogin.html"><i class="fas fa-sign-out-alt"></i> Log Out</a></li>
            </ul>
        </nav>
    </header>
    
    <div class="main-content">
        <div class="card floating">
            <div class="card-heading"></div>
            <div class="card-body">
                <h2 class="title"><i class="fas fa-paper-plane"></i> Apply Leave</h2>
                <form action="process/applyleaveprocess.php?id=<?php echo $id?>" method="POST">
                    <div class="input-group">
                        <input class="input--style-1" type="text" placeholder="Reason for leave" name="reason" required>
                    </div>
                    <div class="row row-space">
                        <div class="col-2">
                            <p><i class="fas fa-calendar-day"></i> Start Date</p>
                            <div class="input-group">
                                <input class="input--style-1" type="date" placeholder="start" name="start" required>
                            </div>
                        </div>
                        <div class="col-2">
                            <p><i class="fas fa-calendar-day"></i> End Date</p>
                            <div class="input-group">
                                <input class="input--style-1" type="date" placeholder="end" name="end" required>
                            </div>
                        </div>
                    </div>
                    <div class="p-t-20">
                        <button class="btn btn--radius btn--green" type="submit"><i class="fas fa-paper-plane"></i> Submit Request</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <h2 class="title"><i class="fas fa-history"></i> Leave History</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Emp. ID</th>
                            <th>Name</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Total Days</th>
                            <th>Reason</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $sql = "Select employee.id, employee.firstName, employee.lastName, employee_leave.start, employee_leave.end, employee_leave.reason, employee_leave.status From employee, employee_leave Where employee.id = $id and employee_leave.id = $id order by employee_leave.token";
                            $result = mysqli_query($conn, $sql);
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
                                echo "<td>".$employee['firstName']." ".$employee['lastName']."</td>";
                                echo "<td>".date('M d, Y', strtotime($employee['start']))."</td>";
                                echo "<td>".date('M d, Y', strtotime($employee['end']))."</td>";
                                echo "<td>".$interval->days." days</td>";
                                echo "<td>".$employee['reason']."</td>";
                                echo "<td><span class='status-badge $statusClass'>".$employee['status']."</span></td>";
                                echo "</tr>";
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        // Add futuristic hover effects
        document.querySelectorAll('.card, .btn, tr').forEach(element => {
            element.addEventListener('mouseenter', () => {
                element.style.transform = 'scale(1.02)';
                element.style.boxShadow = '0 10px 25px rgba(0, 247, 255, 0.3)';
            });
            
            element.addEventListener('mouseleave', () => {
                element.style.transform = '';
                element.style.boxShadow = '';
            });
        });
        
        // Add glow effect to form inputs on focus
        document.querySelectorAll('.input--style-1').forEach(input => {
            input.addEventListener('focus', () => {
                input.style.boxShadow = '0 0 15px rgba(0, 247, 255, 0.5)';
            });
            
            input.addEventListener('blur', () => {
                input.style.boxShadow = '';
            });
        });
    </script>
</body>
</html>