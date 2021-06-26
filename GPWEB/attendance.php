<?php require 'requires/header.php'; ?>
<?php 
	if (loggedIn()) {
		if ($_SESSION['user_type'] == 'teacher') {
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
	<title>Teacher</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="keywords" content="Augment Responsive web template, Bootstrap Web Templates, Flat Web Templates, Android Compatible web template, 
Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, SonyEricsson, Motorola web design" />
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
											<?php
												$module_id = $_GET['module_id'];
												$stmt = "SELECT * FROM modules WHERE module_id='$module_id'";
												$modules = query($stmt);
												$modules->execute();
												$module = $modules->fetch();
											?>
											<li><a href="#section-1" class="icon-shop"><i class="lnr lnr-select"></i> <span>Attendance: <?php echo $module['module_name']; ?></span></a></li>
											<li><a href="#section-2" class="icon-shop"><i class="lnr lnr-chart-bars"></i> <span>All Attendances</span></a></li>
											<li><a href="#section-3" class="icon-shop"><i class="lnr lnr-list"></i> <span>Details</span></a></li>
										</ul>
									</nav>
									<div class="content tab">
										<section id="section-1">
											<div class="graph">
												<?php 
													$module_id = $_GET['module_id'];
													addAttendance($module_id);
												?>
												<div class="tables">
													<table class="table table-hover"> 
														<form method="POST">
															<label>Date: </label><input type="date" name="attendance_date" value="<?php echo(date('Y-m-d')); ?>">

														<thead>
															<tr> 
																<th>#</th> 
														 		<th>Student Name</th>
																<th>Email</th>
																<th>Present</th>
																<th>Absent</th>
															</tr> 
														</thead> 
														<tbody>														
															<?php 
																$module_id = $_GET['module_id'];
																$stmt = "SELECT * FROM students INNER JOIN classes On students.student_class=classes.class_id INNER JOIN module_class ON classes.class_id=module_class.class_id INNER JOIN modules ON module_class.module_id=modules.module_id WHERE modules.module_id='$module_id'";
																$students = query($stmt);
																$students->execute();
																$num = 1;
																foreach ($students as $student) {?>
															<tr>
																<td>
																	<?php
																		echo $num; 
																		$num = ++$num;
																	?>	
																</td>
																<td><?php echo $student['student_firstname'].' '.$student['student_surname']; ?></td> 
																<td><?php echo $student['student_email']; ?></td> 
																<td><input type="radio" name="<?php echo($student['student_id']); ?>_attendance_status" value="1" checked></td>
																<td><input type="radio" name="<?php echo($student['student_id']); ?>_attendance_status" value="0"></td>
															</tr> 											
																<?php } ?>	
														</tbody>
													</table>
													<input type="submit" name="addAttendance" value="Submit">
													</form>
												</div>
											</div>
										</section>
										<section id="section-2">
											<div class="graph">
												<div class="tables">
													<table class="table table-hover"> 
														<thead>
															<tr> 
																<th>#</th> 
														 		<th>Student Name</th>
																<th>Total Present</th>
																<th>Total Class</th>
																<th>Attend Percentage</th>
															</tr> 
														</thead> 
														<tbody>														
															<?php 
																$module_id = $_GET['module_id'];
																$stmt = "SELECT * FROM attendance INNER JOIN students On attendance.attendance_student_id=students.student_id INNER JOIN modules ON attendance.attendance_module_id=modules.module_id WHERE modules.module_id='$module_id' GROUP BY students.student_firstname ASC";
																$attendances = query($stmt);
																$attendances->execute();
																$num = 1;
																foreach ($attendances as $attendance) {?>
															<tr>
																<td>
																	<?php
																		echo $num; 
																		$num = ++$num;
																	?>	
																</td>
																<td><?php echo $attendance['student_firstname'].' '.$attendance['student_surname']; ?></td> 
																<td>
																	<?php 
																		$student_id = $attendance['attendance_student_id'];
																		$module_id = $attendance['attendance_module_id'];
																		$stmt = "SELECT * FROM attendance WHERE attendance_student_id='$student_id' AND attendance_module_id='$module_id' AND attendance_status='1'";
																		$presents = query($stmt);
																		$presents->execute();
																		$present = $presents->rowCount();
																		echo $present;
																	?>
																</td>
																<td>
																	<?php 
																		$stmt = "SELECT * FROM attendance WHERE attendance_student_id='$student_id' AND attendance_module_id='$module_id'";
																		$totals = query($stmt);
																		$totals->execute();
																		$total = $totals->rowCount();
																		echo $total;
																	?>
																</td>
																<td>
																	<?php
																		$percentage = ($present/$total)*100;
																		echo $percentage.'%';
																	?>
																</td>
															</tr> 											
																<?php } ?>						
														</tbody> 
													</table>
												</div>
											</div>
										</section>
										<section id="section-2">
											<div class="graph">
												<div class="tables">
													<table class="table table-hover"> 
														<thead>
															<tr> 
																<th>#</th> 
														 		<th>Date</th>
																<th>Student Name</th>
																<th>Status</th>
															</tr> 
														</thead> 
														<tbody>														
															<?php 
																$module_id = $_GET['module_id'];
																$stmt = "SELECT * FROM attendance INNER JOIN students On attendance.attendance_student_id=students.student_id INNER JOIN modules ON attendance.attendance_module_id=modules.module_id WHERE modules.module_id='$module_id' ORDER BY attendance.attendance_date ASC";
																$attendances = query($stmt);
																$attendances->execute();
																$num = 1;
																foreach ($attendances as $attendance) {?>
															<tr>
																<td>
																	<?php
																		echo $num; 
																		$num = ++$num;
																	?>	
																</td>
																<td><?php echo $attendance['attendance_date']; ?></td>
																<td><?php echo $attendance['student_firstname'].' '.$attendance['student_surname']; ?></td>
																<td>
																	<?php 
																		if ($attendance['attendance_status'] == '1') {
																			echo '<b style="color:navy;">Present<b>';
																		}
																		else {
																			echo '<b style="color:red;">Absent<b>';
																		}
																	?>
																</td>
															</tr> 											
																<?php } ?>						
														</tbody> 
													</table>
												</div>
											</div>
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
				<a href="#" class="sidebar-icon"> <span class="fa fa-bars"></span> </a> <a href="teacher.php"> <span id="logo"> <h1>NAMI</h1></span> 
					<!--<img id="logo" src="" alt="Logo"/>--> 
				  </a>
			</header>
			<div style="border-top:1px solid rgba(69, 74, 84, 0.7)"></div>
			<!--/down-->
			<div class="down">
				<?php 
					$teacher_id = $_SESSION['teacher_id'];
					$stmt = "SELECT * FROM teachers WHERE teacher_id='$teacher_id'";
					$teachers = query($stmt);
					$teachers->execute();
					$teacher = $teachers->fetch();
					if ($teacher['teacher_profile'] == '') {
						if ($_SESSION['teacher_gender'] == 'M') {
							$profile = "male.jpg";
						}
						else {
							$profile = "female.jpg";
						}
					}
					else {
						$profile = $teacher['teacher_profile'];
					}
				?>
				<a href="teacher.php"><img src="uploads/profiles/<?php echo($profile); ?>" style="height: 50%;width: 50%;"></a>
				<a href="teacher.php"><span class=" name-caret"><?php echo $teacher['teacher_firstname'].' '.$teacher['teacher_surname']; ?></span></a>
				<p><?php echo strtoupper($_SESSION['user_type']); ?></p>
				<ul>
					<li><a class="tooltips" href="teacherProfile.php?teacher_id=<?php echo($_SESSION['teacher_id']); ?>"><span>Profile</span><i class="lnr lnr-user"></i></a></li>
					<li><a class="tooltips" href="logout.php"><span>Log out</span><i class="lnr lnr-power-switch"></i></a></li>
				</ul>
			</div>
			<!--//down-->
			<div class="menu">
				<ul id="menu">
					<li id="menu-academico"><a href="teacher.php"><i class="fa fa-home"></i> <span>Home</span></a>
					<?php 
						$teacher_id = $_SESSION['teacher_id'];
						$stmt = "SELECT * FROM teachers INNER JOIN module_teacher ON teachers.teacher_id=module_teacher.teacher_id INNER JOIN modules ON module_teacher.module_id=modules.module_id WHERE teachers.teacher_id='$teacher_id'";
						$modules = query($stmt);
						$modules->execute();
						foreach ($modules as $module) {?>
							<li id="menu-academico"><a><i class="fa fa-book"></i> <span><?php echo $module['module_name']; ?></span><span class="fa fa-angle-right" style="float: right"></span></a>
								<ul id="menu-academico-sub">
									<li id="menu-academico-avaliacoes"><a><i class="fa fa-info"></i> <?php echo $module['module_description']; ?></a></li>
									<li id="menu-academico-avaliacoes"><a href="addContent.php?module_id=<?php echo($module['module_id']); ?>"><i class="fa fa-star"></i> Add New Content</a></li>
									<li id="menu-academico-avaliacoes"><a href="editContent.php?module_id=<?php echo($module['module_id']); ?>"><i class="fa fa-list"></i> All Contents</a></li>
									<li id="menu-academico-avaliacoes"><a href="attendance.php?module_id=<?php echo($module['module_id']); ?>"><i class="fa fa-calendar"></i> Attendance</a></li>
								</ul>
							</li>
						<?php } ?>
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