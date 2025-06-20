<!DOCTYPE html>
<html>
<head>
    <title>Add Employee | Admin Panel | Trippintown Tech</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="vendor/mdi-font/css/material-design-iconic-font.min.css" rel="stylesheet" media="all">
    <link href="vendor/font-awesome/css/all.min.css" rel="stylesheet" media="all">
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,100i,300,300i,400,400i,500,500i,700,700i,900,900i" rel="stylesheet">
    <link href="vendor/select2/select2.min.css" rel="stylesheet" media="all">
    <link href="vendor/datepicker/daterangepicker.css" rel="stylesheet" media="all">
    <link href="css/main.css" rel="stylesheet" media="all">
    <style>
        .file-upload {
            position: relative;
            overflow: hidden;
            margin: 10px 0;
        }
        .file-upload input.upload {
            position: absolute;
            top: 0;
            right: 0;
            margin: 0;
            padding: 0;
            font-size: 20px;
            cursor: pointer;
            opacity: 0;
            filter: alpha(opacity=0);
        }
        .file-upload-label {
            display: block;
            padding: 12px;
            background: rgba(123, 45, 255, 0.1);
            border: 2px dashed rgba(123, 45, 255, 0.3);
            border-radius: 6px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .file-upload-label:hover {
            background: rgba(123, 45, 255, 0.2);
            border-color: var(--primary);
        }
        .file-upload-icon {
            font-size: 24px;
            margin-bottom: 10px;
            color: var(--primary);
        }
    </style>
</head>
<body>
    <header>
        <nav>
            <h1 class="glow-text">Trippintown Tech</h1>
            <ul id="navli">
                <li><a class="homeblack" href="aloginwel.php"><i class="fas fa-home"></i> Dashboard</a></li>
                <li><a class="homered" href="addemp.php"><i class="fas fa-user-plus"></i> Add Employee</a></li>
                <li><a class="homeblack" href="viewemp.php"><i class="fas fa-users"></i> View Team</a></li>
                <li><a class="homeblack" href="assign.php"><i class="fas fa-tasks"></i> Assign Project</a></li>
                <li><a class="homeblack" href="assignproject.php"><i class="fas fa-project-diagram"></i> Projects</a></li>
                <li><a class="homeblack" href="salaryemp.php"><i class="fas fa-money-bill-wave"></i> Finance</a></li> 
                <li><a class="homeblack" href="empleave.php"><i class="fas fa-calendar-alt"></i> Leave Management</a></li>
                <li><a class="homeblack" href="alogin.html"><i class="fas fa-sign-out-alt"></i> Log Out</a></li>
            </ul>
        </nav>
    </header>
    
    <div class="divider"></div>

    <div class="page-wrapper p-t-100 p-b-100 font-robo">
        <div class="wrapper wrapper--w680">
            <div class="card card-1">
                <div class="card-heading"></div>
                <div class="card-body">
                    <h2 class="title text-gradient">Employee Registration</h2>
                    <p class="subtitle">Fill in the details to add a new team member</p>
                    
                    <form action="process/addempprocess.php" method="POST" enctype="multipart/form-data">
                        <div class="row row-space">
                            <div class="col-2">
                                <div class="input-group">
                                    <label for="firstName">First Name</label>
                                    <input class="input--style-1" type="text" placeholder="First Name" name="firstName" required>
                                </div>
                            </div>
                            <div class="col-2">
                                <div class="input-group">
                                    <label for="lastName">Last Name</label>
                                    <input class="input--style-1" type="text" placeholder="Last Name" name="lastName" required>
                                </div>
                            </div>
                        </div>

                        <div class="input-group">
                            <label for="email">Email Address</label>
                            <input class="input--style-1" type="email" placeholder="Email" name="email" required>
                        </div>
                        
                        <div class="row row-space">
                            <div class="col-2">
                                <div class="input-group">
                                    <label>Birthday</label>
                                    <input class="input--style-1" type="date" name="birthday" required>
                                </div>
                            </div>
                            <div class="col-2">
                                <div class="input-group">
                                    <label>Gender</label>
                                    <div class="rs-select2 js-select-simple select--no-search">
                                        <select name="gender" required>
                                            <option disabled="disabled" selected="selected">Select Gender</option>
                                            <option value="Male">Male</option>
                                            <option value="Female">Female</option>
                                            <option value="Other">Other</option>
                                        </select>
                                        <div class="select-dropdown"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="input-group">
                            <label for="contact">Contact Number</label>
                            <input class="input--style-1" type="number" placeholder="Contact Number" name="contact" required>
                        </div>

                        <div class="input-group">
                            <label for="nid">National ID</label>
                            <input class="input--style-1" type="number" placeholder="NID" name="nid" required>
                        </div>

                        <div class="input-group">
                            <label for="address">Address</label>
                            <input class="input--style-1" type="text" placeholder="Address" name="address" required>
                        </div>

                        <div class="row row-space">
                            <div class="col-2">
                                <div class="input-group">
                                    <label for="dept">Department</label>
                                    <input class="input--style-1" type="text" placeholder="Department" name="dept" required>
                                </div>
                            </div>
                            <div class="col-2">
                                <div class="input-group">
                                    <label for="degree">Degree</label>
                                    <input class="input--style-1" type="text" placeholder="Degree" name="degree" required>
                                </div>
                            </div>
                        </div>

                        <div class="input-group">
                            <label for="salary">Base Salary</label>
                            <input class="input--style-1" type="number" placeholder="Salary" name="salary">
                        </div>

                        <div class="input-group">
                            <label>Profile Picture</label>
                            <div class="file-upload">
                                <label class="file-upload-label">
                                    <div class="file-upload-icon">
                                        <i class="fas fa-cloud-upload-alt"></i>
                                    </div>
                                    <span>Click to upload photo</span>
                                    <input type="file" class="upload" name="file" accept="image/*">
                                </label>
                            </div>
                        </div>

                        <div class="p-t-20">
                            <button class="btn btn--radius btn--green" type="submit">
                                <i class="fas fa-user-plus"></i> Register Employee
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/select2/select2.min.js"></script>
    <script src="vendor/datepicker/moment.min.js"></script>
    <script src="vendor/datepicker/daterangepicker.js"></script>
    <script src="js/global.js"></script>
    <script>
        $(document).ready(function() {
            // File upload preview
            $('input[type="file"]').change(function(e) {
                var fileName = e.target.files[0].name;
                $(this).siblings('span').text(fileName);
            });
        });
    </script>
</body>
</html>