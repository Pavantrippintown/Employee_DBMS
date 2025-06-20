<?php 
require_once ('process/dbh.php');
$sql = "SELECT id, firstName, lastName,  points FROM employee, rank WHERE rank.eid = employee.id order by rank.points desc";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Admin Panel | Trippintown Tech</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Lobster&family=Montserrat:wght@400;500;700&family=Orbitron:wght@500;700&display=swap">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="vendor/font-awesome/css/all.min.css">
    <style>
        :root {
            --primary: #00f7ff;
            --secondary: #00ff9d;
            --accent: #ff00e4;
            --dark: #0a0a1a;
            --darker: #050510;
            --light: #e0e0ff;
        }
        
        .cyber-glitch {
            position: relative;
        }
        .cyber-glitch::before, .cyber-glitch::after {
            content: attr(data-text);
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            opacity: 0.8;
        }
        .cyber-glitch::before {
            color: var(--accent);
            z-index: -1;
            animation: glitch-effect 3s infinite;
        }
        .cyber-glitch::after {
            color: var(--primary);
            z-index: -2;
            animation: glitch-effect 2s infinite reverse;
        }
        
        @keyframes glitch-effect {
            0% { transform: translate(0); }
            20% { transform: translate(-3px, 3px); }
            40% { transform: translate(-3px, -3px); }
            60% { transform: translate(3px, 3px); }
            80% { transform: translate(3px, -3px); }
            100% { transform: translate(0); }
        }
        
        .holographic-card {
            background: linear-gradient(135deg, rgba(10,10,26,0.8) 0%, rgba(5,5,16,0.9) 100%);
            border: 1px solid rgba(0, 247, 255, 0.2);
            border-radius: 12px;
            box-shadow: 0 0 20px rgba(0, 247, 255, 0.1),
                        0 0 40px rgba(0, 255, 157, 0.1),
                        inset 0 0 15px rgba(0, 247, 255, 0.1);
            backdrop-filter: blur(10px);
            transition: all 0.3s ease;
        }
        .holographic-card:hover {
            box-shadow: 0 0 30px rgba(0, 247, 255, 0.2),
                        0 0 60px rgba(0, 255, 157, 0.2),
                        inset 0 0 20px rgba(0, 247, 255, 0.2);
            transform: translateY(-5px);
        }
        
        .cyber-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            background: rgba(10, 10, 26, 0.5);
            border-radius: 10px;
            overflow: hidden;
        }
        .cyber-table th {
            background: linear-gradient(90deg, var(--primary), var(--secondary));
            color: var(--darker);
            font-family: 'Orbitron', sans-serif;
            text-transform: uppercase;
            letter-spacing: 1px;
            padding: 15px;
            text-align: left;
        }
        .cyber-table td {
            padding: 12px 15px;
            border-bottom: 1px solid rgba(0, 247, 255, 0.1);
            color: var(--light);
        }
        .cyber-table tr:last-child td {
            border-bottom: none;
        }
        .cyber-table tr:hover td {
            background: rgba(0, 247, 255, 0.05);
            color: var(--primary);
        }
        
        .performance-bar {
            height: 8px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 4px;
            overflow: hidden;
            position: relative;
        }
        .performance-bar::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(90deg, 
                      transparent, 
                      rgba(255, 255, 255, 0.3), 
                      transparent);
            animation: shine 2s infinite;
        }
        .performance-fill {
            height: 100%;
            border-radius: 4px;
            position: relative;
            z-index: 2;
            transition: width 1s ease-out;
        }
        
        @keyframes shine {
            0% { transform: translateX(-100%); }
            100% { transform: translateX(100%); }
        }
        
        .cyber-btn {
            background: linear-gradient(90deg, var(--primary), var(--secondary));
            border: none;
            color: var(--darker);
            font-family: 'Orbitron', sans-serif;
            padding: 12px 24px;
            border-radius: 30px;
            cursor: pointer;
            position: relative;
            overflow: hidden;
            transition: all 0.3s;
            box-shadow: 0 0 15px rgba(0, 247, 255, 0.5);
            text-transform: uppercase;
            letter-spacing: 1px;
            font-weight: bold;
        }
        .cyber-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 0 25px rgba(0, 247, 255, 0.8);
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
        
        .cyber-nav {
            background: rgba(10, 10, 26, 0.8);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(0, 247, 255, 0.2);
        }
        .cyber-nav ul li a {
            position: relative;
            overflow: hidden;
        }
        .cyber-nav ul li a::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 2px;
            background: var(--primary);
            transform: scaleX(0);
            transform-origin: right;
            transition: transform 0.3s ease;
        }
        .cyber-nav ul li a:hover::after {
            transform: scaleX(1);
            transform-origin: left;
        }
        
        .pulse {
            animation: pulse 2s infinite;
        }
        @keyframes pulse {
            0% { box-shadow: 0 0 0 0 rgba(0, 247, 255, 0.7); }
            70% { box-shadow: 0 0 0 15px rgba(0, 247, 255, 0); }
            100% { box-shadow: 0 0 0 0 rgba(0, 247, 255, 0); }
        }
    </style>
</head>
<body class="futuristic-body">
    <!-- Futuristic Loader -->
    <div class="futuristic-loader">
        <div class="loader-content">
            <div class="loader-circle pulse" style="border-color: var(--primary);"></div>
            <div class="loader-text" style="color: var(--primary); font-family: 'Orbitron', sans-serif;">SYSTEM INITIALIZING...</div>
            <div class="loader-progress">
                <div class="progress-bar" style="background: linear-gradient(90deg, var(--primary), var(--secondary));"></div>
            </div>
        </div>
    </div>
    
    <!-- Particles Background -->
    <div id="particles-js"></div>
    
    <!-- Floating Holograms -->
    <div class="hologram-1"></div>
    <div class="hologram-2"></div>
    
    <header class="cyber-nav">
        <nav>
            <h1 class="cyber-glitch" data-text="TRIPPINTOWN TECH">TRIPPINTOWN TECH</h1>
            <ul id="navli">
                <li><a class="homered" href="aloginwel.php"><i class="fas fa-chart-network"></i> DASHBOARD</a></li>
                <li><a class="homeblack" href="addemp.php"><i class="fas fa-user-plus"></i> ADD AGENT</a></li>
                <li><a class="homeblack" href="viewemp.php"><i class="fas fa-users"></i> TEAM NETWORK</a></li>
                <li><a class="homeblack" href="assign.php"><i class="fas fa-tasks"></i> ASSIGN MISSION</a></li>
                <li><a class="homeblack" href="assignproject.php"><i class="fas fa-project-diagram"></i> ACTIVE MISSIONS</a></li>
                <li><a class="homeblack" href="salaryemp.php"><i class="fas fa-credit-card"></i> FINANCE SYSTEM</a></li>
                <li><a class="homeblack" href="empleave.php"><i class="fas fa-calendar-alt"></i> LEAVE CONSOLE</a></li>
                <li><a class="homeblack" href="alogin.html"><i class="fas fa-power-off"></i> LOGOUT</a></li>
            </ul>
        </nav>
    </header>
     
    <div class="divider" style="border-bottom: 1px solid rgba(0, 247, 255, 0.2);"></div>
    
    <div class="page-wrapper">
        <div class="wrapper wrapper--w900">
            <div class="card card-1 holographic-card animate__animated animate__fadeIn">
                <div class="card-heading" style="background: linear-gradient(90deg, var(--primary), var(--secondary));"></div>
                <div class="card-body">
                    <h2 class="title text-gradient" style="background: linear-gradient(90deg, var(--primary), var(--accent)); -webkit-background-clip: text; -webkit-text-fill-color: transparent; font-family: 'Orbitron', sans-serif;">
                        AGENT PERFORMANCE BOARD
                    </h2>
                    <p class="subtitle" style="color: var(--primary); font-family: 'Montserrat', sans-serif;">
                        TOP PERFORMERS BASED ON MISSION ACHIEVEMENT POINTS
                    </p>
                    
                    <div class="table-responsive">
                        <table class="cyber-table">
                            <thead>
                                <tr>
                                    <th>RANK</th>
                                    <th>AGENT ID</th>
                                    <th>CODENAME</th>
                                    <th>POINTS</th>
                                    <th>PERFORMANCE METRICS</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $seq = 1;
                                    while ($employee = mysqli_fetch_assoc($result)) {
                                        $percentage = min(100, ($employee['points'] / 100) * 100);
                                        $glowClass = $seq <= 3 ? "top-performer" : "";
                                        echo "<tr class='$glowClass'>";
                                        echo "<td>".$seq."</td>";
                                        echo "<td>#".str_pad($employee['id'], 4, '0', STR_PAD_LEFT)."</td>";
                                        echo "<td>".$employee['firstName']." ".$employee['lastName']."</td>";
                                        echo "<td>".$employee['points']."</td>";
                                        echo "<td>
                                                <div class='performance-bar'>
                                                    <div class='performance-fill' style='width: ".$percentage."%; background: ".getPerformanceColor($percentage).";'></div>
                                                    <span style='margin-left: 10px; font-size: 12px; color: ".getPerformanceColor($percentage).";'>".round($percentage)."%</span>
                                                </div>
                                              </td>";
                                        echo "</tr>";
                                        $seq+=1;
                                    }
                                    
                                    function getPerformanceColor($percentage) {
                                        if ($percentage >= 80) return '#00ff9d';
                                        if ($percentage >= 50) return '#ffcc00';
                                        return '#ff3860';
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="action-buttons" style="margin-top: 30px;">
                        <button class="cyber-btn animate__animated animate__pulse animate__infinite" type="submit" style="float: right;">
                            <a href="reset.php" style="text-decoration: none; color: inherit;">
                                <i class="fas fa-sync-alt"></i> RESET POINTS MATRIX
                            </a>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Floating Elements -->
    <div class="floating-elements">
        <div class="floating-element element-1"></div>
        <div class="floating-element element-2"></div>
        <div class="floating-element element-3"></div>
    </div>

    <!-- Vendor JS-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/select2/select2.min.js"></script>
    <script src="vendor/datepicker/moment.min.js"></script>
    <script src="vendor/datepicker/daterangepicker.js"></script>
    
    <!-- Particles.js for background -->
    <script src="vendor/particles/particles.min.js"></script>
    
    <!-- Main JS-->
    <script src="js/global.js"></script>
    
    <script>
        // Enhanced loader animation
        $(window).on('load', function() {
            setTimeout(function() {
                $('.futuristic-loader').fadeOut(500);
                
                // Animate table rows sequentially
                $('.cyber-table tbody tr').each(function(i) {
                    $(this).delay(100 * i).animate({
                        opacity: 1,
                        left: '0'
                    }, 200);
                });
            }, 1500);
        });
        
        // Particles.js configuration
        document.addEventListener('DOMContentLoaded', function() {
            if (document.getElementById('particles-js')) {
                particlesJS('particles-js', {
                    "particles": {
                        "number": {
                            "value": 80,
                            "density": {
                                "enable": true,
                                "value_area": 800
                            }
                        },
                        "color": {
                            "value": ["#00f7ff", "#00ff9d", "#ff00e4"]
                        },
                        "shape": {
                            "type": "circle",
                            "stroke": {
                                "width": 0,
                                "color": "#000000"
                            },
                            "polygon": {
                                "nb_sides": 5
                            }
                        },
                        "opacity": {
                            "value": 0.5,
                            "random": true,
                            "anim": {
                                "enable": true,
                                "speed": 1,
                                "opacity_min": 0.1,
                                "sync": false
                            }
                        },
                        "size": {
                            "value": 3,
                            "random": true,
                            "anim": {
                                "enable": true,
                                "speed": 2,
                                "size_min": 0.1,
                                "sync": false
                            }
                        },
                        "line_linked": {
                            "enable": true,
                            "distance": 150,
                            "color": "#00f7ff",
                            "opacity": 0.2,
                            "width": 1
                        },
                        "move": {
                            "enable": true,
                            "speed": 1,
                            "direction": "none",
                            "random": true,
                            "straight": false,
                            "out_mode": "out",
                            "bounce": false,
                            "attract": {
                                "enable": true,
                                "rotateX": 600,
                                "rotateY": 1200
                            }
                        }
                    },
                    "interactivity": {
                        "detect_on": "canvas",
                        "events": {
                            "onhover": {
                                "enable": true,
                                "mode": "grab"
                            },
                            "onclick": {
                                "enable": true,
                                "mode": "push"
                            },
                            "resize": true
                        },
                        "modes": {
                            "grab": {
                                "distance": 140,
                                "line_linked": {
                                    "opacity": 1
                                }
                            },
                            "bubble": {
                                "distance": 400,
                                "size": 40,
                                "duration": 2,
                                "opacity": 8,
                                "speed": 3
                            },
                            "repulse": {
                                "distance": 200,
                                "duration": 0.4
                            },
                            "push": {
                                "particles_nb": 4
                            },
                            "remove": {
                                "particles_nb": 2
                            }
                        }
                    },
                    "retina_detect": true
                });
            }
            
            // Add hover effect to table rows
            $('.cyber-table tbody tr').hover(
                function() {
                    $(this).css('transform', 'scale(1.02)');
                    $(this).find('td').css('color', 'var(--primary)');
                },
                function() {
                    $(this).css('transform', 'scale(1)');
                    $(this).find('td').css('color', 'var(--light)');
                }
            );
            
            // Add animation to top performers
            $('.top-performer').each(function() {
                $(this).css({
                    'background': 'rgba(0, 255, 157, 0.05)',
                    'box-shadow': '0 0 15px rgba(0, 255, 157, 0.2)'
                });
            });
        });
    </script>
</body>
</html>