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
								<h2 class="inner-tittle">Welcome, 
									<?php
										$teacher_id = $_SESSION['teacher_id'];
										$stmt = "SELECT * FROM teachers WHERE teacher_id='$teacher_id'";
										$teachers = query($stmt);
										$teachers->execute();
										$teacher = $teachers->fetch();
										echo $teacher['teacher_firstname'].' '.$teacher['teacher_surname']; 
									?>
								</h2>
								<div class="graph">
									<nav>
										<?php 
											$teacher_id = $_SESSION['teacher_id'];
											editTeacherPassword($teacher_id);
										?>
										<ul>
											<li><a href="#section-1" class="icon-shop"><i class="lnr lnr-question-circle"></i> <span>Information</span></a></li>
											<li><a href="#section-2" class="icon-cup"><i class="lnr lnr-cog"></i> <span>Change Password</span></a></li>
											<li><a href="#section-3" class="icon-lab"><i class="lnr lnr-tag"></i> <span>Assigned Modules and Classes</span></a></li>
										</ul>
									</nav>
									<div class="content tab">
										<section id="section-1">
											<?php 
												$teacher_id = $_SESSION['teacher_id'];
												$stmt = "SELECT * FROM teachers WHERE teacher_id='$teacher_id'";
												$teachers = query($stmt);
												$teachers->execute();
												foreach ($teachers as $teacher) {?>
											<div class="mediabox">
												<strong>Personal Information</strong>
												<p> <strong>WELCOME</strong>,
													<?php echo $teacher['teacher_firstname'].' '.$teacher['teacher_surname']; ?>
												</p>
												<p><strong>Qualification: </strong>
													<?php echo $teacher['teacher_qualification']; ?>
												</p>
												<p><strong>Gender: </strong>
													<?php 
														if ($teacher['teacher_gender'] == "M") {
															echo "Male";
														}
														else {
															echo "Female";
														}
													?>
												</p>
												<p> <strong>Date of Birth:</strong>
													<?php echo $teacher['teacher_dateOfBirth']; ?>
												</p>

											</div>
											<div class="mediabox">
												<strong>Contact Details</strong>

												<p> <strong>Email:</strong>
													<?php echo $teacher['teacher_email']; ?>
												</p>
												<p> <strong>Phone Number:</strong>
													<?php echo $teacher['teacher_contact']; ?>
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
													<input type="text" class="form-control1 icon" name="teacher_password" placeholder="Old Password" required>
													
												</div>
												<div class="input-group input-icon">
													<span class="input-group-addon">
												<i class="fa fa-lock"></i>	</span>
													<input type="password" class="form-control1 icon" placeholder="New Password" name="new_teacher_password" required>
													
												</div>	
												<div class="input-group input-icon">
													<span class="input-group-addon">
												<i class="fa fa-lock"></i>	</span>
													<input type="password" class="form-control1 icon" placeholder="Confirm New Password" name="c_new_teacher_password" required>
													
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
														 		<th>Module Name</th>
																<th>Description</th>
																<th>Class</th>
																
															</tr> 
														</thead> 
														<tbody>														
															<?php 
																$stmt = "SELECT * FROM teachers INNER JOIN module_teacher ON teachers.teacher_id=module_teacher.teacher_id INNER JOIN modules ON module_teacher.module_id=modules.module_id INNER JOIN module_class ON modules.module_id=module_class.module_id INNER JOIN classes ON module_class.class_id=classes.class_id WHERE teachers.teacher_id='$teacher_id'";
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
																<td><?php echo $module['module_name']; ?></td>
																<td><?php echo $module['module_description']; ?></td> 
																<td><?php echo $module['class_name']; ?></td> 
																
																
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