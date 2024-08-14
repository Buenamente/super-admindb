<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<!-- Boxicons -->
	<link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
	<!-- My CSS -->
	<link rel="stylesheet" href="styleadmin.css">
    <link rel="stylesheet" href="dashboardadmin.css">

	<title>AdminHub</title>
</head>
<body>

	<!-- SIDEBAR -->
	<section id="sidebar">
		<a href="#" class="brand">
			<i class='bx bxs-lock'></i>
			<span class="text">Senti-Shield</span>
		</a>
		<ul class="side-menu top">
			<li>
				<a href="index.html">
					<i class='bx bxs-dashboard' ></i>
					<span class="text">Dashboard</span>
				</a>
			</li>
			<li>
				<a href="user.html">
					<i class='bx bxs-user' ></i>
					<span class="text">User Info</span>
				</a>
			</li>
			<li class="active">
				<a href="history.php">
					<i class='bx bxs-calendar-check' ></i>
					<span class="text">History Logs</span>
				</a>
			</li>
			<li>
				<a href="notification.html">
					<i class='bx bxs-notification' ></i>
					<span class="text">Alert/Notifications</span>
				</a>
			</li>
			<li>
				<a href="activities.html">
					<i class='bx bxs-group' ></i>
					<span class="text">History Logs</span>
				</a>
			</li>
            <li>
				<a href="registration.html">
					<i class='bx bxs-group' ></i>
					<span class="text">Registration</span>
				</a>
			</li>
		</ul>
		<ul class="side-menu">
			<li>
				<a href="index.html" class="logout">
					<i class='bx bxs-log-out-circle' ></i>
					<span class="text">Logout</span>
				</a>
			</li>
		</ul>
	</section>
	<!-- SIDEBAR -->

	<!-- CONTENT -->
	<section id="content">
		<!-- NAVBAR -->
		<nav>
			<i class='bx bx-menu' ></i>
			<a href="#" class="nav-link">Categories</a>
			<form action="#">
				<div class="form-input">
					<input type="search" placeholder="Search...">
					<button type="submit" class="search-btn"><i class='bx bx-search' ></i></button>
				</div>
			</form>
			<input type="checkbox" id="switch-mode" hidden>
			<label for="switch-mode" class="switch-mode"></label>
			<a href="#" class="notification">
				<i class='bx bxs-bell' ></i>
				<span class="num">8</span>
			</a>
			<a href="#" class="profile">
				<img src="img/jj.jpg">
			</a>
		</nav>
		<!-- NAVBAR -->

		<!-- MAIN -->
		<main>
			<div class="head-title">
				<div class="left">
					<h1>History Logs</h1>
					<ul class="breadcrumb">
						<li>
							<a href="#">History Logs</a>
						</li>
						<li><i class='bx bx-chevron-right' ></i></li>
						<li>
							<a class="active" href="dashboard.html">Home</a>
						</li>
					</ul>
				</div>
			</div>

			<div class="table-data">
				<div class="order">
					<div class="head">
						<h3>History Logs</h3>
						<i class='bx bx-search' ></i>
						<i class='bx bx-filter' ></i>
					</div>
					<table>
						<thead>
							<tr>
								<th>ID</th>
								<th>RFID Tag</th>
                                <th>Role</th>
								<th>Name</th>
								<th>Date</th>
								<th>Time</th>
							</tr>
						</thead>
						<tbody>
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
							?>
						</tbody>
					</table>
				</div>
			</div>
		</main>
		<!-- MAIN -->
	</section>
	<!-- CONTENT -->
	
	<script src="scriptadmin.js"></script>
</body>
</html>