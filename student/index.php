<?php
session_start();

if (!isset($_SESSION["user"])) {
	header("Location: login.php");
	exit();
}
?>

<html lang="en">

<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>Online Library Management System</title>
	<link rel="stylesheet" href="./css/style.css">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
	<style>
		body {
			background: url('https://images.unsplash.com/photo-1524995997946-a1c2e315a42f') no-repeat center center fixed;
			background-size: cover;
			color: #e0e0e0;
			font-family: 'Georgia', serif;
			position: relative;
			min-height: 100vh;
		}

		.overlay {
			background: rgba(0, 0, 0, 0.75);
			position: absolute;
			top: 0;
			left: 0;
			right: 0;
			bottom: 0;
			z-index: -1;
		}

		.box {
			background: rgba(0, 0, 0, 0.6);
			padding: 40px;
			border-radius: 12px;
			text-align: center;
			width: 50%;
			max-width: 500px;
			margin: auto;
			box-shadow: 0 8px 20px rgba(255, 255, 255, 0.1);
			backdrop-filter: blur(10px);
			transition: transform 0.3s ease-in-out;
		}

		.box:hover {
			transform: translateY(-5px);
			box-shadow: 0 10px 25px rgba(255, 255, 255, 0.2);
		}

		.box h1 {
			font-size: clamp(24px, 5vw, 28px);
			/* Responsive text */
			font-weight: bold;
			color: #d4af37;
			text-transform: uppercase;
			letter-spacing: 2px;
			margin-bottom: 10px;
		}

		.box p {
			font-size: clamp(16px, 3.5vw, 18px);
			/* Adjusts for mobile */
			font-weight: 500;
			color: #e0e0e0;
			margin-bottom: 8px;
		}

		.hours {
			font-size: clamp(18px, 4vw, 20px);
			font-weight: 600;
			color: #d4af37;
			background: rgba(255, 255, 255, 0.1);
			padding: 10px;
			border-radius: 8px;
			display: inline-block;
			margin-top: 10px;
		}

		.divider {
			width: 60%;
			height: 2px;
			background: rgba(255, 255, 255, 0.3);
			margin: 10px auto;
			border-radius: 5px;
		}

		/* Responsive Adjustments */
		@media (max-width: 768px) {
			.box {
				width: 80%;
				padding: 30px;
			}
		}

		@media (max-width: 480px) {
			.box {
				width: 90%;
				padding: 25px;
			}

			.box h1 {
				font-size: 22px;
			}

			.box p {
				font-size: 16px;
			}

			.hours {
				font-size: 18px;
				padding: 8px;
			}
		}
	</style>
</head>

<body>
	<div class="overlay"></div>

	<!-- Responsive Navbar -->
	<?php include "navbar.php" ?>

	<section>
		<div class="container d-flex align-items-center justify-content-center" style="height: 80vh;">
			<div class="box">
				<h1>Welcome to Our Library</h1>
				<p>Your gateway to knowledge, research, and discovery.</p>
				<div class="divider"></div>
				<p class="hours">📖 Operating Hours</p>
				<p><strong>Monday - Friday:</strong> 9:00 AM – 3:00 PM</p>
				<p><strong>Saturday & Sunday:</strong> Closed</p>
			</div>

	</section>
	

</body>

</html>