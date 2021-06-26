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
								<h2 class="inner-tittle">Welcome, <?php echo $_SESSION['student_name']; ?></h2>
								<div class="graph">
									<nav>
										<?php 
											$student_id = $_SESSION['student_id'];
											editStudentPassword($student_id);
										?>
										<ul>
											<li><a href="#section-1" class="icon-shop"><i class="lnr lnr-question-circle"></i> <span>Information</span></a></li>
											<li><a href="#section-2" class="icon-cup"><i class="lnr lnr-cog"></i> <span>Change Password</span></a></li>
											<li><a href="#section-3" class="icon-food"><i class="lnr lnr-graduation-hat" aria-hidden="true"></i> <span>Module Teacher</span></a></li>
											<li><a href="#section-4" class="icon-lab"><i class="lnr lnr-calendar-full"></i> <span>Attendance Overview</span></a></li>
										</ul>
									</nav>
									<div class="content tab">
										<section id="section-1">
											<?php 
												$student_id = $_SESSION['student_id'];
												$stmt = "SELECT * FROM students INNER JOIN classes ON students.student_class=classes.class_id WHERE student_id='$student_id'";
												$students = query($stmt);
												$students->execute();
												foreach ($students as $student) {?>
											<div class="mediabox">
												<strong>Personal Information</strong>
												<p> <strong>WELCOME</strong>,
													<?php echo $_SESSION['student_name']; ?>
												</p>
												<p><strong>Standard: </strong>
													<?php echo $student['class_name']; ?>
												</p>
												<p><strong>Gender: </strong>
													<?php  
														if ($student['student_gender'] == "M") {
															echo "Male";
														}
														else {
															echo "Female";
														}
													?>
												</p>
												<p> <strong>Date of Birth:</strong>
													<?php echo $student['student_dateOfBirth']; ?>
												</p>

											</div>
											<div class="mediabox">
												<strong>Contact Details</strong>

												<p> <strong>Email:</strong>
													<?php echo $student['student_email']; ?>
												</p>
												<p> <strong>Phone Number:</strong>
													<?php echo $student['student_contact']; ?>
												</p>
											</div>
											<?php } ?>
										</section>
										<section id="section-2">
											
											<div class="col-md-12">
												
												<form method="POST">
												<div class="input-group input-icon">
													<span class="input-group-addon">
												<i class="fa fa-key"></i>	</span>
													<input type="text" class="form-control1 icon" name="student_password" placeholder="Old Password" required>
													
												</div>
												<div class="input-group input-icon">
													<span class="input-group-addon">
												<i class="fa fa-lock"></i>	</span>
													<input type="password" class="form-control1 icon" placeholder="New Password" name="new_student_password" required>
													
												</div>	
												<div class="input-group input-icon">
													<span class="input-group-addon">
												<i class="fa fa-lock"></i>	</span>
													<input type="password" class="form-control1 icon" placeholder="Confirm New Password" name="c_new_student_password" required>
													
												</div>	
										
													<input type="submit" name="submit" class="a_demo_four" value="Change Password & Log Out">
													</form>
											</div>
										</section>
										<section id="section-3">
											<div class="graph">
											<div class="tables">
															
																<table class="table table-hover"> 
																	<thead>
																		<tr> 
																			<th>#</th> 
																	 
																			<th>Teacher Name</th> 
																			<th>Teacher Email</th>
																			<th>Subject</th>
																			
																		</tr> 
																	</thead> 
																	<tbody>														
																		<?php 
																			$stmt = "SELECT * FROM students INNER JOIN classes ON students.student_class=classes.class_id INNER JOIN module_class ON classes.class_id=module_class.class_id INNER JOIN modules ON module_class.module_id=modules.module_id INNER JOIN module_teacher ON modules.module_id=module_teacher.module_id INNER JOIN teachers ON module_teacher.teacher_id=teachers.teacher_id WHERE students.student_id='$student_id'";
																			$modules = query($stmt);
																			$modules->execute();
																			$num = 1;
																			foreach ($modules as $module) {?>
																		<tr>
																			<td>
																				<?php
																					echo $num; 
																					$num = ++$num;
																				?>	
																			</td>
																			<td><?php echo $module['teacher_firstname']." ".$module['teacher_surname']; ?></td> 
																			<td><?php echo $module['teacher_email']; ?></td>
																			<td><?php echo $module['module_name'].': '.$module['module_description']; ?></td>
																			
																		</tr> 											<?php } ?>						
																	</tbody> 
																</table>
															</div>
											</div>
										</section>
										<section id="section-4">
												<div class="graph">
															<div class="tables">
															
																<table class="table table-hover"> 
																	<thead>
																		<tr> 
																			<th>#</th> 
																			<th>Subject Name</th> 
																			<th>Total Class Attended</th>
																			<th>Total Class Held</th>
																			<th>Attended Percent</th>
																		</tr> 
																	</thead> 
																	<tbody>
																		<?php 
																		$stmt = "SELECT * FROM attendance INNER JOIN students On attendance.attendance_student_id=students.student_id INNER JOIN modules ON attendance.attendance_module_id=modules.module_id WHERE students.student_id='$student_id' GROUP BY modules.module_name ASC";
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
																		<td><?php echo $attendance['module_name'].': '.$attendance['module_description']; ?></td> 
																		<td>
																			<?php 
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
																				if ($percentage < 80) {
																					echo '<p style="color: red;">'.$percentage.'%</p>';
																				}
																				else {
																					echo '<p style="color: navy;">'.$percentage.'%</p>';
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