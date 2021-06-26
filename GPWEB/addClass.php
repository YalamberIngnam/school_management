<?php require 'requires/header.php'; ?>
<?php 
	if (loggedIn()) {
		if ($_SESSION['user_type'] == 'admin') {
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
	<title>Admin</title>
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
									<div class="user-heading alt clock-row terques-bg"></div>
									<ul id="clock">
										<li id="sec"></li>
										<li id="hour"></li>
										<li id="min"></li>
									</ul>
								</section>
								<div class="graph">
									<nav>
										<ul>
											<li><a href="#section-1" class="icon-shop"><i class="lnr lnr-upload"></i> <span>Add Class</span></a></li>
											<li><a href="#section-2" class="icon-shop"><i class="lnr lnr-apartment"></i> <span>All Classes</span></a></li>
										</ul>
									</nav>
									<div class="content tab">
										<section id="section-1">
										<?php addClass(); ?>
										<form method="POST">
											<label>Class name: </label><input type="text" name="class_name" placeholder="Name of the grade"><br>
											<input type="submit" name="submit" value="Add">
										</form>
										</section>
										<section id="section-2">
											<div class="graph">
												<div class="tables">
													<table class="table table-hover"> 
														<thead>
															<tr> 
																<th>#</th> 
														 		<th>Class Name</th>
																
															</tr> 
														</thead> 
														<tbody>														
															<?php 
																$stmt = "SELECT * FROM classes GROUP BY class_name DESC";
																$classes = query($stmt);
																$classes->execute();
																$num = 1;
																foreach ($classes as $class) {?>
															<tr>
																<td>
																	<?php
																		echo $num; 
																		$num = ++$num;
																	?>	
																</td>
																<td><?php echo $class['class_name']; ?></td>
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
				<a href="#" class="sidebar-icon"> <span class="fa fa-bars"></span> </a> <a href="admin.php"> <span id="logo"> <h1>NAMI</h1></span> 
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
				<a href="admin.php"><img src="uploads/profiles/<?php echo($profile); ?>" style="height: 50%;width: 50%;"></a>
				<a href="admin.php"><span class=" name-caret"><?php echo $teacher['teacher_firstname'].' '.$teacher['teacher_surname']; ?></span></a>
				<p>Admin</p>				<ul>
					<li><a class="tooltips" href="#"><span>Profile</span><i class="lnr lnr-user"></i></a></li>
					<li><a class="tooltips" href="logout.php"><span>Log out</span><i class="lnr lnr-power-switch"></i></a></li>
				</ul>
			</div>
			<!--//down-->
			<div class="menu">
				<ul id="menu">
					<li id="menu-academico"><a href="admin.php"><i class="fa fa-home"></i> <span>Home</span></a>
						<li id="menu-academico"><a><i class="fa fa-archive"></i> <span>My Modules</span><span class="fa fa-angle-right" style="float: right"></span></a>
						<ul id="menu-academico-sub">
							<?php 
							$teacher_id = $_SESSION['teacher_id'];
							$stmt = "SELECT * FROM teachers INNER JOIN module_teacher ON teachers.teacher_id=module_teacher.teacher_id INNER JOIN modules ON module_teacher.module_id=modules.module_id WHERE teachers.teacher_id='$teacher_id'";
							$modules = query($stmt);
							$modules->execute();
							foreach ($modules as $module) {?>
								<li id="menu-academico-avaliacoes"><a href="adminModule.php?module_id=<?php echo($module['module_id']); ?>"><i class="fa fa-book"></i><?php echo $module['module_name'].': '.$module['module_description']; ?></a>
								</li>
							<?php } ?>
						</ul>
					</li>
					<li id="menu-academico"><a><i class="fa fa-book"></i> <span>Modules</span><span class="fa fa-angle-right" style="float: right"></span></a>
						<ul id="menu-academico-sub">
							<li id="menu-academico-avaliacoes"><a href="addModule.php"><i class="fa fa-star"></i> Add New Module</a></li>
							<li id="menu-academico-avaliacoes"><a href="editModule.php"><i class="fa fa-pencil"></i> Edit Module</a></li>
							<li id="menu-academico-avaliacoes"><a href="moduleClass.php"><i class="fa fa-plus"></i></i> Add Module to a Class</a></li>
							<li id="menu-academico-avaliacoes"><a href="moduleTeacher.php"><i class="fa fa-check"></i></i> Assign Module to a Teacher</a></li>
						</ul>
					</li>
					<li id="menu-academico"><a><i class="fa fa-calendar"></i> <span>Class</span><span class="fa fa-angle-right" style="float: right"></span></a>
						<ul id="menu-academico-sub">
							<li id="menu-academico-avaliacoes"><a href="addClass.php"><i class="fa fa-star"></i> Add New Class</a></li>
							<li id="menu-academico-avaliacoes"><a href="editClass.php"><i class="fa fa-pencil"></i> Edit Class</a></li>
						</ul>
					</li>
					<li id="menu-academico"><a><i class="fa fa-briefcase"></i> <span>Teacher</span><span class="fa fa-angle-right" style="float: right"></span></a>
						<ul id="menu-academico-sub">
							<li id="menu-academico-avaliacoes"><a href="addTeacher.php"><i class="fa fa-star"></i> Add New Teacher</a></li>
							<li id="menu-academico-avaliacoes"><a href="editTeacher.php"><i class="fa fa-pencil"></i> Edit Teacher</a></li>
							<li id="menu-academico-avaliacoes"><a href="teacherClass.php"><i class="fa fa-plus"></i> Add Teacher to a Class </a></li>
						</ul>
					</li>
					<li id="menu-academico"><a><i class="fa fa-user"></i> <span>Student</span><span class="fa fa-angle-right" style="float: right"></span></a>
						<ul id="menu-academico-sub">
							<li id="menu-academico-avaliacoes"><a href="addStudent.php"><i class="fa fa-star"></i> Add New Student</a></li>
							<li id="menu-academico-avaliacoes"><a href="editStudent.php"><i class="fa fa-pencil"></i> Edit Student</a></li>
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