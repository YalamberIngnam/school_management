<?php require 'functions/init.php'; ?>
<?php 
	if (loggedIn()) {
		if ($_SESSION['user_type'] == 'student') {
		}
		else {
			redirect('logout.php');
		}
	}
	else {
		redirect('login.php');
	}
?>
<!--
Author: W3layouts
Author URL: http://w3layouts.com
License: Creative Commons Attribution 3.0 Unported
License URL: http://creativecommons.org/licenses/by/3.0/
-->
<!DOCTYPE HTML>
<html>

<head>
	<title>Students</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<script type="application/x-javascript">
		addEventListener("load", function() {
			setTimeout(hideURLbar, 0);
		}, false);

		function hideURLbar() {
			window.scrollTo(0, 1);
		}
	</script>
	<!-- Bootstrap Core CSS -->
	<link href="css/bootstrap.min.css" rel='stylesheet' type='text/css' />
	<!-- Custom CSS -->
	<link href="css/style.css" rel='stylesheet' type='text/css' />
	<!-- Graph CSS -->
	<link href="css/font-awesome.css" rel="stylesheet">
	<!-- jQuery -->
	<link href='//fonts.googleapis.com/css?family=Roboto:700,500,300,100italic,100,400' rel='stylesheet' type='text/css'>
	<!-- lined-icons -->
	<link rel="stylesheet" href="css/icon-font.min.css" type='text/css' />
	<!-- //lined-icons -->
	<script src="js/jquery-1.10.2.min.js"></script>
	<script src="js/amcharts.js"></script>
	<script src="js/serial.js"></script>
	<script src="js/light.js"></script>
	<script src="js/radar.js"></script>
	<link href="css/barChart.css" rel='stylesheet' type='text/css' />
	<link href="css/fabochart.css" rel='stylesheet' type='text/css' />
	<!--clock init-->
	<script src="js/css3clock.js"></script>
	<!--Easy Pie Chart-->
	<!--skycons-icons-->
	<script src="js/skycons.js"></script>

	<script src="js/jquery.easydropdown.js"></script>

	<!--//skycons-icons-->
</head>

<body>
	<div class="page-container">
		<!--/content-inner-->
		<div class="left-content">
			<div class="inner-content">
				<!-- header-starts -->
				<div class="header-section">

					<div class="clearfix"></div>
				</div>
				<!-- //header-ends -->
				<div class="outter-wp">
					<!--/tabs-->
					<div class="tab-main">
						<!--/tabs-inner-->
						<div class="tab-inner">
							<div id="tabs" class="tabs">
								<section class="panel">
											<div class="user-heading alt clock-row terques-bg">
											</div>
											<ul id="clock">
												<li id="sec"></li>
												<li id="hour"></li>
												<li id="min"></li>
											</ul>


										</section>
								<div class="graph">
									<nav>
										<ul>
											<li><a href="#section-1" class="icon-shop"><i class="lnr lnr-picture"></i> <span>Add Photo</span></a></li>
										</ul>
									</nav>
									<div class="content tab">
										<section id="section-1">
											<?php 
												$student_id = $_SESSION['student_id'];
												editStudentProfile($student_id);
											?>
											<form method="POST" enctype="multipart/form-data">
												<label>Browse your device:</label><input type="file" name="student_profile">
												<input type="submit" name="submit" value="Submit">
											</form>
										</section>
									</div>
									<!-- /content -->
								</div>
								<!-- /tabs -->

							</div>
							<script src="js/cbpFWTabs.js"></script>
							<script>
								new CBPFWTabs(document.getElementById('tabs'));
							</script>
							<div class="clearfix"> </div>
						</div>
					</div>
					<!--//tabs-inner-->

				</div>
				<!--footer section start-->
				<footer>
					<p>&copy 2018 Augment . All Rights Reserved | Design by <a href="https://w3layouts.com/" target="_blank">W3layouts.</a> and Developed By "The UnderDogs"</p>
				</footer>
				<!--footer section end-->
			</div>
		</div>
		<!--//content-inner-->
		<!--/sidebar-menu-->
		<div class="sidebar-menu">
			<header class="logo">
				<a href="#" class="sidebar-icon"> <span class="fa fa-bars"></span> </a> <a href="student.php"> <span id="logo"> <h1>NAMI <i class="fa fa-"></i></h1></span> 
					<!--<img id="logo" src="" alt="Logo"/>--> 
				  </a>
			</header>
			<div style="border-top:1px solid rgba(69, 74, 84, 0.7)"></div>
			<!--/down-->
			<div class="down">
				<?php 
					$stmt = "SELECT * FROM students WHERE student_id='$student_id'";
					$students = query($stmt);
					$students->execute();
					$student = $students->fetch();
					if ($student['student_profile'] == '') {
						if ($_SESSION['student_gender'] == 'M') {
							$profile = "male.jpg";
						}
						else {
							$profile = "female.jpg";
						}
					}
					else {
						$profile = $student['student_profile'];
					}
				?>
				<a href="studentProfile.php"><img src="uploads/profiles/students/<?php echo($profile); ?>" style="height: 50%;width: 50%;" alt="student_profile"></a>
				<a href="student.php"><span class=" name-caret"><?php echo $_SESSION['student_name']; ?></span></a>
				<p>Student</p>
				<ul>
					<li><a class="tooltips" href="logout.php"><span>Log out</span><i class="lnr lnr-power-switch"></i></a></li>
				</ul>
			</div>
			<!--//down-->
			<div class="menu">
				<ul id="menu">
					<li id="menu-academico"><a href="student.php"><i class="fa fa-home"></i> <span>Home</span></a>
					<li id="menu-academico"><a><i class="fa fa-archive"></i> <span>My Modules</span><span class="fa fa-angle-right" style="float: right"></span></a>
						<ul id="menu-academico-sub">
							<?php 
								$stmt = "SELECT * FROM students INNER JOIN classes ON students.student_class=classes.class_id INNER JOIN module_class ON classes.class_id=module_class.class_id INNER JOIN modules ON module_class.module_id=modules.module_id WHERE students.student_id='$student_id'";
								$sideModule = query($stmt);
								$sideModule->execute();
								foreach ($sideModule as $module) {?>
							<li id="menu-academico-avaliacoes"><a href="contents.php?module_id=<?php echo $module['module_id']; ?>&module_name=<?php echo $module['module_name'].': '.$module['module_description'] ?>"><i class="fa fa-book"></i><?php echo $module['module_name'].': '.$module['module_description']; ?></a></li>
						<?php } ?>
						</ul>
					</li>
				</ul>
			</div>
		</div>
		<div class="clearfix"></div>
	</div>
	<script>
		var toggle = true;

		$(".sidebar-icon").click(function() {
			if (toggle) {
				$(".page-container").addClass("sidebar-collapsed").removeClass("sidebar-collapsed-back");
				$("#menu span").css({
					"position": "absolute"
				});
			} else {
				$(".page-container").removeClass("sidebar-collapsed").addClass("sidebar-collapsed-back");
				setTimeout(function() {
					$("#menu span").css({
						"position": "relative"
					});
				}, 400);
			}

			toggle = !toggle;
		});
	</script>
	<!--js -->
	<link rel="stylesheet" href="css/vroom.css">
	<script type="text/javascript" src="js/vroom.js"></script>
	<script type="text/javascript" src="js/TweenLite.min.js"></script>
	<script type="text/javascript" src="js/CSSPlugin.min.js"></script>
	<script src="js/jquery.nicescroll.js"></script>
	<script src="js/scripts.js"></script>

	<!-- Bootstrap Core JavaScript -->
	<script src="js/bootstrap.min.js"></script>
</body>

</html>