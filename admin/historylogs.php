<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Boxicons -->
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <!-- CSS -->
    <link rel="stylesheet" href="styleadmin.css">
    <link rel="stylesheet" href="dashboardadmin.css">
    <title>History Logs</title>
    <style>
        :root {
	--poppins: 'Poppins', sans-serif;
	--lato: 'Lato', sans-serif;

	--light: #F9F9F9;
	--blue: #3C91E6;
	--light-blue: #CFE8FF;
	--grey: #eee;
	--dark-grey: #AAAAAA;
	--dark: #342E37;
	--red: #DB504A;
	--yellow: #FFCE26;
	--light-yellow: #FFF2C6;
	--orange: #FD7238;
	--light-orange: #FFE0D3;
}

        p#total-records {
        color: var(--dark);
}
        /* Additional styles for dark mode and updated table */
        body.dark-mode #total-records {
            color: white;
        }

        /* Name link styles */
        .name-link {
            color: var(--dark); /* Default text color (light mode) */
            text-decoration: underline; /* Default underline (light mode) */
            text-decoration-color: blue; /* Default underline color (light mode) */
        }

        body.dark-mode .name-link {
            color: white; /* Text color in dark mode */
            text-decoration-color: white; /* Underline color in dark mode, e.g., blue */
        }

        .name-link:hover {
            color: #555; /* Hover color for better visibility in light mode */
            text-decoration-color: #555; /* Hover underline color in light mode */
        }

        body.dark-mode .name-link:hover {
            color: #0f0; /* Hover color for better visibility in dark mode */
            text-decoration-color: #0f0; /* Hover underline color in dark mode */
        }
    </style>
</head>
<body>
    <!-- SIDEBAR -->
    <section id="sidebar">
        <a href="#" class="brand">
            <img class="logo" src="pictures/horizontallogo.png" alt="logo">
        </a>
        <ul class="side-menu top">
            <li>
                <a href="index.html">
                    <i class='bx bxs-dashboard'></i>
                    <span class="text">Dashboard</span>
                </a>
            </li>
            <li>
                <a href="user.html">
                    <i class='bx bxs-user'></i>
                    <span class="text">User Info</span>
                </a>
            </li>
            <li class="active">
                <a href="historylogs.php">
                    <i class='bx bxs-calendar-check'></i>
                    <span class="text">History Logs</span>
                </a>
            </li>
            <li>
                <a href="userActivities.html">
                    <i class='bx bxs-notification'></i>
                    <span class="text">User Activities</span>
                </a>
            </li>
            <li>
                <a href="notification.html">
                    <i class='bx bxs-notification'></i>
                    <span class="text">Alert/Notifications</span>
                </a>
            </li>
            <li>
                <a href="registration.html">
                    <i class='bx bxs-user-plus'></i>
                    <span class="text">Registration</span>
                </a>
            </li>
        </ul>
        <ul class="side-menu">
            <li>
                <a href="../index.html" class="logout">
                    <i class='bx bxs-log-out-circle'></i>
                    <span class="text">Logout</span>
                </a>
            </li>
        </ul>
    </section>
    <!-- CONTENT -->
    <section id="content">
        <!--navbar-->
        <nav>
            <i class='bx bx-menu'></i>
            <form action="#">
                <div class="form-input">
                    <button class="search-btn"><i class='bx bx-search'></i></button>
                </div>
            </form>
            <input type="checkbox" id="switch-mode" hidden>
            <label for="switch-mode" class="switch-mode"></label>
            <div class="calendar">
                <div class="cd">
                    <i class='bx bx-calendar'></i>
                </div>
                <div id="calendar"></div>
            </div>
        
            <div id="profile" class="profile">
                <img src="assets/profile2.png" alt="Profile Picture" id="profile-picture" />
                <div id="profile-dropdown" class="profile-dropdown">
                    <a href="#">Change Profile Picture</a>
                    <a href="#">Logout</a>
                </div>
            </div>
        </nav>
        <!--navbar-->
         
        <main>
            <div class="head-title">
                <div class="left">
                    <h1>History Logs</h1>
                    <p id="total-records">Total Records: Loading...</p>
                </div>
            </div>
            <div class="table-data">
                <div class="order">
                    <div class="head">
                        <h3>History Logs</h3>
                    </div>
                    
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>RFID Tag/Passcode Key</th>
                                <th>Role</th>
                                <th>Name</th>
                                <th>Date</th>
                                <th>Time</th>
                                <th>Action</th>
                                <th>Export Data</th>
                            </tr>
                        </thead>
                        <tbody id="history-logs-table">
                            <?php
							$conn = new mysqli('localhost', 'root', '', 'senti-shield');
							if ($conn->connect_error) {
								die("Connection failed: " . $conn->connect_error);
							}

							$sql = "SELECT id, rfid, name, role, access_time FROM access_logs ORDER BY access_time DESC";
							$result = $conn->query($sql);

							if ($result->num_rows > 0) {
								while ($row = $result->fetch_assoc()) {
									// Split date and time
									$date_time = explode(' ', $row['access_time']);
									$date = $date_time[0];
									$time = $date_time[1];
									
									echo "<tr>
											<td>{$row['id']}</td>
											<td>{$row['rfid']}</td>
                                            <td>{$row['role']}</td>
											<td>{$row['name']}</td>
											<td>{$date}</td>
											<td>{$time}</td>
										  </tr>";
								}
							} else {
								echo "<tr><td colspan='5'>No logs found</td></tr>";
							}

							$conn->close();
							?>>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </section>

    <script src="scriptadmin.js"></script>
    <script src="calendar.js"></script>
    <script>
        function downloadFile(rowId) {
            console.log("Downloading file for row: " + rowId);
        }

        document.addEventListener('DOMContentLoaded', function() {
            // Count total records
            const totalRecords = document.querySelectorAll('#history-logs-table tr').length;
            document.getElementById('total-records').textContent = `Total Records: ${totalRecords}`;
        });

        // Toggle dark mode
        document.getElementById('switch-mode').addEventListener('change', function() {
            document.body.classList.toggle('dark-mode');
        });
    </script>
</body>
</html>
