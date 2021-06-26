<?php require '../functions/init.php'; ?>
<?php 
	$teacher_name = $_GET['name'];
	$stmt = "SELECT * FROM teachers WHERE teacher_firstname='$teacher_name'";
	$teachers = query($stmt);
	$teachers->execute();
	$teacher = $teachers->fetch();
	if ($teachers->rowCount() < 1) {?>
		<style type="text/css">
			body {
				background-image: url(../uploads/pictures/logo.png);
	    		background-color: rgba(255,255,255,0.9);
	    		background-blend-mode: lighten;
			}
			#error{
				text-align: center;
				padding-top: 200px;
			}
		</style>
		<?php
		echo '<h1 id="error">Error loading; The teacher with name: <em>'.$teacher_name.'</em> does NOT exist.</h1>';
	}
	else{

	$stmt2 = "SELECT * FROM teachers INNER JOIN module_teacher ON teachers.teacher_id=module_teacher.teacher_id INNER JOIN modules ON module_teacher.module_id=modules.module_id WHERE teachers.teacher_firstname='$teacher_name'";
	$modules = query($stmt2);
	$modules->execute();
?>

<!DOCTYPE html>
<html>
<head>
	<title> Profile</title>
	<!-- <link rel="stylesheet" type="text/css" href="teacherstyle.css"> -->
	<style type="text/css">
		*{
			padding: 0%;
			margin-top: 0%;
		}
		body {
  			background-image: url(../uploads/pictures/logo.png);
    		background-color: rgba(255,255,255,0.9);
    		background-blend-mode: lighten;

  		}

		h1{
			padding: 3%;
			font-size: 40px;
		}
		img{
			float:left;
			width:250px;
			height:250px;
			margin: 1%;
		}
		.techer_info{
			margin-bottom: 49px;
			font-size: 20px;
			padding: 2%;
		}
		.teacher_artical{
			clear:both;
			margin-top: 0px;
			padding: 2%;
		}
		.para_title{
			text-align: left;
			margin-bottom: 0%;
			
		}
		p{
			padding: 1%;
		}
	</style>
</head>
<body>
	<h1><?php echo $teacher["teacher_firstname"].' '.$teacher["teacher_surname"]; ?></h1>
	<main>	
	<section class="techer_info"> 
	<?php
		if ($teacher['teacher_profile'] == '') {
			if ($teacher['teacher_gender'] == 'M') {
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
	<img src="../uploads/profiles/<?php echo($profile); ?>" alt="Profile image">
		<p><b>Name: </b><?php echo $teacher["teacher_firstname"].' '.$teacher["teacher_surname"]; ?></p>
		<p><b>Modules Affiliated: </b>
			<?php 
				if ($modules->rowCount() < 1) {
					echo "None.";
				}
				foreach ($modules as $module) {
					echo $module['module_name'].': <em>'.$module['module_description'].'. </em>';
				}
			?>
		</p>
		<p><b>Email: </b><?php echo $teacher["teacher_email"]; ?></p>
		<p><b>Eductiaon: </b><?php echo $teacher["teacher_qualification"]; ?></p>
	</section>
	</main>

</body>
</html>
<?php } ?>
