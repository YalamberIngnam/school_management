<?php 

	/*****Helper functions*****/
	function redirect($location)
	{
		return header("Location: {$location}");
	}
	function removeSymbol($string)
	{
		return str_replace("'", "''", "{$string}");
	}
	function checkStudentEmail($student_email)
	{
		$stmt = "SELECT * FROM students WHERE student_email='{$student_email}'";
		$studentEmail = query($stmt);
		$studentEmail->execute();
		if ($studentEmail->rowCount() == 1) {
			return true;
		}
		else {
			return false;
		}

	}
	function checkTeacherEmail($teacher_email)
	{
		$stmt = "SELECT * FROM teachers WHERE teacher_email='{$teacher_email}'";
		$teacherEmail = query($stmt);
		$teacherEmail->execute();
		if ($teacherEmail->rowCount() == 1) {
			return true;
		}
		else {
			return false;
		}

	}
	function checkModuleName($module_name)
	{
		$stmt = "SELECT * FROM modules WHERE module_name='{$module_name}'";
		$module = query($stmt);
		$module->execute();
		if ($module->rowCount() == 1) {
			return true;
		}
		else {
			return false;
		}
	}

	/*****Register Student*****/
	function registerStudent()
	{
		$errors = [];
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$student_firstname = removeSymbol($_POST['student_firstname']);
			$student_surname = removeSymbol($_POST['student_surname']);
			$student_gender = $_POST['student_gender'];
			$student_email = $_POST['student_email'];
			$student_password = removeSymbol($_POST['student_password']);
			$student_c_password = removeSymbol($_POST['c_s_password']);
			$student_dateOfBirth = $_POST['student_dateOfBirth'];
			$student_contact = $_POST['student_contact'];
			$student_class = $_POST['student_class'];

			$today = date('Y/m/d', time());
			$diff = strtotime($student_dateOfBirth)-strtotime($today);
			if (checkStudentEmail($student_email)) {
				$errors[] = "Email already registered.";
			}
			if (strlen($student_password) < 4) {
				$errors[] = "Please input at least 4 characters.";
			}
			elseif ($student_password !== $student_c_password) {
				$errors[] = "Passwords do not match.";
			}
			if ($diff > 0) {
				$errors[] = "Invalid Date of Birth.";
			}
			if (strlen($student_contact) < 10) {
				$errors[] = "Please enter a valid contact number.";
			}
			if ($student_class == 0) {
				$errors[] = "Please select a class.";
			}
			if (!empty($errors)) {
				foreach ($errors as $error) {
					echo $error . "<br>";
				}
			}
			else {
				$student_h_password = password_hash($student_password, PASSWORD_DEFAULT);
				$stmt = "INSERT INTO students(student_id,student_firstname,student_surname,student_gender,student_email,student_password,student_dateOfBirth,student_contact,student_class)
						 VALUES('','$student_firstname','$student_surname','$student_gender','$student_email','$student_h_password','$student_dateOfBirth','$student_contact','$student_class')";
				$registerStudent = query($stmt);
				if ($registerStudent->execute()) {
					echo "Student successfully registered.";
				}
				else {
					echo "Registration failed.";
				}
			}
		}
	}

	/*****Register Teacher*****/
	function registerTeacher()
	{
		$errors = [];
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$teacher_firstname = removeSymbol($_POST['teacher_firstname']);
			$teacher_surname = removeSymbol($_POST['teacher_surname']);
			$teacher_gender = $_POST['teacher_gender'];
			$teacher_email = $_POST['teacher_email'];
			$teacher_password = removeSymbol($_POST['teacher_password']);
			$teacher_c_password = removeSymbol($_POST['c_t_password']);
			$teacher_dateOfBirth = $_POST['teacher_dateOfBirth'];
			$teacher_contact = $_POST['teacher_contact'];
			$teacher_qualification = $_POST['teacher_qualification'];

			$today = date('Y/m/d', time());
			$diff = strtotime($teacher_dateOfBirth)-strtotime($today);
			if (checkTeacherEmail($teacher_email)) {
				$errors[] = "Email already registered.";
			}
			if (strlen($teacher_password) < 4) {
				$errors[] = "Please input at least 4 characters.";
			}
			elseif ($teacher_password !== $teacher_c_password) {
				$errors[] = "Passwords do not match.";
			}
			if ($diff > 0) {
				$errors[] = "Invalid Date of Birth.";
			}
			if (strlen($teacher_contact) < 10) {
				$errors[] = "Please enter a valid contact number.";
			}
			if (!empty($errors)) {
				foreach ($errors as $error) {
					echo $error . "<br>";
				}
			}
			else {
				$teacher_h_password = password_hash($teacher_password, PASSWORD_DEFAULT);
				$stmt = "INSERT INTO teachers(teacher_id,teacher_firstname,teacher_surname,teacher_gender,teacher_email,teacher_password,teacher_dateOfBirth,teacher_contact,teacher_qualification)
						 VALUES('','$teacher_firstname','$teacher_surname','$teacher_gender','$teacher_email','$teacher_h_password','$teacher_dateOfBirth','$teacher_contact','$teacher_qualification')";
				$registerTeacher = query($stmt);
				if ($registerTeacher->execute()) {
					echo "Teacher successfully registered.";
				}
				else {
					echo "Registration failed.";
				}
			}
		}
	}

	/*****Login*****/
	function loginValidate()
	{
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$email = $_POST['email'];
			$password = removeSymbol($_POST['password']);
			if (checkStudentEmail($email) == false && checkTeacherEmail($email) == false) {
				echo "Email not registered.";
			}
			else {
				if (loginStudent($email,$password)) {
					redirect("student.php");
				}
				elseif (loginTeacher($email,$password)) {
					if ($_SESSION['user_type'] == 'admin') {
						redirect("admin.php");
					}
					else {
						redirect("teacher.php");
					}
				}

			}
		}
	}
	function loginStudent($student_email,$student_password)
	{
		$stmt = "SELECT * FROM students WHERE student_email='{$student_email}'";
		$login = query($stmt);
		$login->execute();
		if ($login->rowCount() == 1) {
			$student = $login->fetch();
			$password_in_db = $student['student_password'];
			if (password_verify("{$student_password}", $password_in_db)) {
				$_SESSION['student_id'] = $student['student_id'];
				$_SESSION['student_name'] = $student['student_firstname'] . ' ' . $student['student_surname'];
				$_SESSION['user_type'] = $student['user_type'];
				$_SESSION['student_gender'] = $student['student_gender'];
				return true;
			}
			else {
				echo "The credentials are incorrect.";
				return false;
			}	
		}
		else {
			return false;
		}
	}
	function loginTeacher($teacher_email,$teacher_password)
	{
		$stmt = "SELECT * FROM teachers WHERE teacher_email='{$teacher_email}'";
		$login = query($stmt);
		$login->execute();
		if ($login->rowCount() == 1) {
			$teacher = $login->fetch();
			$password_in_db = $teacher['teacher_password'];
			if (password_verify("{$teacher_password}", $password_in_db)) {
				$_SESSION['teacher_id'] = $teacher['teacher_id'];
				$_SESSION['user_type'] = $teacher['user_type'];
				$_SESSION['teacher_gender'] = $teacher['teacher_gender'];
				return true;
			}
			else {
				echo "The credentials are incorrect.";
				return false;
			}
		}
		else {
			return false;
		}
	}
	function loggedIn()
	{
		if (isset($_SESSION['teacher_id'])) {
			return true;
		}
		elseif (isset($_SESSION['student_id'])) {
			return true;
		}
		else {
			return false;
		}
	}

	/*****Add Class*****/
	function addClass()
	{
		try {
			if ($_SERVER['REQUEST_METHOD'] == 'POST') {
				$classname = removeSymbol($_POST['class_name']);
				if (empty($classname)) {
					echo "Please enter name of the Class.";
				}
				else {
					$stmt = "INSERT INTO classes(class_id,class_name)
						 VALUES('','$classname')";
					$addClass = query($stmt);
					if ($addClass->execute()) {
						echo "Class  successfully added.";
					}
					else {
						echo "Class Adding Process Failed.";
					}
				}
			}
		} catch (Exception $e) {
			echo "Class has already been added.";
		}
	}	

	/*****Add Module*****/
	function addModule()
	{
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$module_name = strtoupper(removeSymbol($_POST['module_name']));
			$module_description = removeSymbol($_POST['module_description']);

			if (checkModuleName($module_name)) {
				echo "This module already exists.";
			}
			else {
				$stmt = "INSERT INTO modules(module_id,module_name,module_description)
						 VALUES('','$module_name','$module_description')";
				$addModule = query($stmt);
				if ($addModule->execute()) {
					echo "Module successfully added.";
				}
				else {
					echo "Module Adding Process Failed.";
				}
			}
		}
	}

	/*****Add Content*****/
	function addContent()
	{
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			if (isset($_POST['addContent'])) {
				unset($_POST['addContent']);
				$content_name = removeSymbol($_POST['content_name']);
				$content_description = removeSymbol($_POST['content_description']);
				$content_addedOn = date('Y-m-d', time());
				$content_module = $_GET['module_id'];
				$content_teacher = $_SESSION['teacher_id'];

				$content_file = $_FILES['content_file']['name'];
				$temp_dir = $_FILES['content_file']['tmp_name'];
				// $fileSize = $_FILES['content_file']['size'];
				// $fileSeperate = explode('.', $fileName);
				// $fileExt = strtolower(end($fileSeperate));
				// $allowExt = array('txt','pdf','docx','pdf','doc');
				// $content_file = rand(1,1000000).".".$fileExt;

				$stmt = "INSERT INTO contents(content_id,content_name,content_description,content_file,content_addedOn,content_module,content_teacher)
						 VALUES('','$content_name','$content_description','$content_file','$content_addedOn','$content_module','$content_teacher')";
				$addContent = query($stmt);
				if ($addContent->execute()) {
					move_uploaded_file($temp_dir, 'uploads/'.$content_file);
					echo "Content successfully added.";
				}
				else {
					echo "Content NOT successfully added.";
				}
			}
		}
	}

	/*****Add Teacher To Class*****/
	function addteacherClass()
	{
		try {
			$errors = [];
			if ($_SERVER['REQUEST_METHOD'] == 'POST') {
				$teacher_id = $_POST['teacher_id'];
				$class_id = $_POST['class_id'];
				if ($teacher_id == 0) {
					$errors[] = "Please select a teacher.";
				}
				if ($class_id == 0) {
					$errors[] = "Please select a class.";
				}
				if (!empty($errors)) {
					foreach ($errors as $error) {
						echo $error."<br>";
					}
				}
				else {
					$stmt = "INSERT INTO teacher_class(teacher_id,class_id)
							 VALUES('$teacher_id','$class_id')";
					$addTeacherToClass = query($stmt);
					if ($addTeacherToClass->execute()) {
						echo "Teacher was successfully added to a class.";
					}
					else {
						echo "Teacher was NOT successfully added.";
					}
				}
			}
		} catch (Exception $e) {
			echo "Teacher has already been added to this class.";	
		}
	}

	/*****Add Module To a Teacher*****/
	function addModuleTeacher()
	{
		try {
			$errors = [];
			if ($_SERVER['REQUEST_METHOD'] == 'POST') {
				$module_id = $_POST['module_id'];
				$teacher_id = $_POST['teacher_id'];
				if ($module_id == 0) {
					$errors[] = "Please select a module.";
				}
				if ($teacher_id == 0) {
					$errors[] = "Please select a teacher.";
				}
				if (!empty($errors)) {
					foreach ($errors as $error) {
						echo $error."<br>";
					}
				}
				else {
					$stmt = "INSERT INTO module_teacher(module_id,teacher_id)
							 VALUES('$module_id','$teacher_id')";
					$addModuleToTeacher = query($stmt);
					if ($addModuleToTeacher->execute()) {
						echo "Module was successfully assigned to a teacher.";
					}
					else {
						echo "Module was NOT successfully assigned.";
					}
				}
			}	
		} catch (Exception $e) {
			echo "Module has already been assigned to this teacher.";
		}
	}

	/*****Add Module To a Class*****/
	function addModuleClass()
	{
		try {
			$errors = [];
			if ($_SERVER['REQUEST_METHOD'] == 'POST') {
				$module_id = $_POST['module_id'];
				$class_id = $_POST['class_id'];
				if ($module_id == 0) {
					$errors[] = "Please select a module.";
				}
				if ($class_id == 0) {
					$errors[] = "Please select a class.";
				}
				if (!empty($errors)) {
					foreach ($errors as $error) {
						echo $error."<br>";
					}
				}
				else {
					$stmt = "INSERT INTO module_class(module_id,class_id)
							 VALUES('$module_id','$class_id')";
					$addModuleToClass = query($stmt);
					if ($addModuleToClass->execute()) {
						echo "Module was successfully added to a class.";
					}
					else {
						echo "Module was NOT successfully added.";
					}
				}
			}
		} catch (Exception $e) {
			echo "This module has already been assigned to the same class.";	
		}
	}

	/*****Add Attendance*****/
	function addAttendance($module_id)
	{	
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			if (isset($_POST['addAttendance'])) {
				unset($_POST['addAttendance']);
				$stmt1 = "SELECT * FROM students INNER JOIN classes ON students.student_class=classes.class_id INNER JOIN module_class ON classes.class_id=module_class.class_id INNER JOIN modules ON module_class.module_id=modules.module_id WHERE modules.module_id='$module_id'";
				$students = query($stmt1);
				$students->execute();
				foreach ($students as $student) {
					$student_id = $student['student_id'];
					$attendance_date = $_POST['attendance_date'];
					$attendance_status = $_POST[$student_id.'_attendance_status'];
					$stmt = "INSERT INTO attendance(attendance_id,attendance_student_id,attendance_module_id,attendance_date,attendance_status)
						 VALUES('',$student_id,'{$module_id}','$attendance_date','$attendance_status')";
					$insertAttendance = query($stmt);
					$insertAttendance->execute();
				}
				echo "Attendance Added successfully";
			}
		}
	}

	////////////////////////////////////////////DELETE////////////////////////////////////////////
	/*****Delete Module*****/
	function deleteModule($module_id)
		{	
			if ($_SERVER['REQUEST_METHOD'] == 'GET') {
				$stmt = "DELETE FROM modules WHERE module_id='$module_id'";
				$deleteModule = query($stmt);
				if ($deleteModule->execute()) {
					return true;
				}
				else {
					return false;
				}
			}
		}

	/*****Delete Module*****/
	function deleteContent($content_id)
		{	
			if ($_SERVER['REQUEST_METHOD'] == 'GET') {
				$stmt = "DELETE FROM contents WHERE content_id='$content_id'";
				$deleteContent = query($stmt);
				if ($deleteContent->execute()) {
					return true;
				}
				else {
					return false;
				}
			}
		}

	/*****Delete Class*****/
	function deleteClass($class_id)
		{	
			if ($_SERVER['REQUEST_METHOD'] == 'GET') {
				$stmt = "DELETE FROM classes WHERE class_id='{$class_id}'";
				$deleteClass = query($stmt);
				if ($deleteClass->execute()) {
					return true;
				}
				else {
					return false;
				}
			}
		}

	/*****Delete Module Class*****/
	function deleteModuleClass($module_id,$class_id)
		{	
			if ($_SERVER['REQUEST_METHOD'] == 'GET') {
				$stmt = "DELETE FROM module_class WHERE module_id='{$module_id}' AND class_id='{$class_id}'";
				$deleteModuleClass = query($stmt);
				if ($deleteModuleClass->execute()) {
					return true;
				}
				else {
					return false;
				}
			}
		}

	/*****Delete Module Teacher*****/
	function deleteModuleTeacher($module_id,$teacher_id)
		{	
			if ($_SERVER['REQUEST_METHOD'] == 'GET') {
				$stmt = "DELETE FROM module_teacher WHERE module_id='{$module_id}' AND teacher_id='{$teacher_id}'";
				$deleteModuleTeacher = query($stmt);
				if ($deleteModuleTeacher->execute()) {
					return true;
				}
				else {
					return false;
				}
			}
		}

	/*****Delete Teacher Class*****/
	function deleteTeacherClass($teacher_id,$class_id)
		{	
			if ($_SERVER['REQUEST_METHOD'] == 'GET') {
				$stmt = "DELETE FROM teacher_class WHERE teacher_id='{$teacher_id}' AND class_id='{$class_id}'";
				$deleteTeacherClass = query($stmt);
				if ($deleteTeacherClass->execute()) {
					return true;
				}
				else {
					return false;
				}
			}
		}

	/*****Delete Teacher*****/
	function deleteTeacher($teacher_id)
	{	
		if ($_SERVER['REQUEST_METHOD'] == 'GET') {
			$stmt = "DELETE FROM teachers WHERE teacher_id='{$teacher_id}'";
			$deleteTeacher = query($stmt);
			if ($deleteTeacher->execute()) {
				return true;
			}
			else {
				return false;
			}
		}
	}

	/*****Delete Student*****/
	function deleteStudent($student_id)
	{	
		if ($_SERVER['REQUEST_METHOD'] == 'GET') {
			$stmt = "DELETE FROM students WHERE student_id='{$student_id}'";
			$deleteStudent = query($stmt);
			if ($deleteStudent->execute()) {
				return true;
			}
			else {
				return false;
			}
		}
	}

	////////////////////////////////////////////EDIT////////////////////////////////////////////
	/*****Edit Module*****/
	function editModule($module_id)
	{
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$module_name = removeSymbol($_POST['module_name']);
			$module_description = removeSymbol($_POST['module_description']);
			$stmt = "UPDATE modules
				 SET module_name='$module_name',
				 	 module_description='$module_description'
				 WHERE module_id='{$module_id}'";
			$editModule = query($stmt);
			if ($editModule->execute()) {
				echo "Module successfully edited.";
			}
			else {
				echo "Module edit failed.";;
			}
		}
	}

	/*****Edit Class*****/
	function editClass($class_id)
	{
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$class_name = removeSymbol($_POST['class_name']);
			$stmt = "UPDATE classes
				 SET class_name='$class_name'
				 WHERE class_id='{$class_id}'";
			$editClass = query($stmt);
			if ($editClass->execute()) {
				echo "Class successfully edited.";
			}
			else {
				echo "Class edit failed.";
			}
		}
	}

	/*****Edit Teacher*****/
	function editTeacher($teacher_id)
	{
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$teacher_firstname = removeSymbol($_POST['teacher_firstname']);
			$teacher_surname = removeSymbol($_POST['teacher_surname']);
			$teacher_gender = removeSymbol($_POST['teacher_gender']);
			$teacher_email = removeSymbol($_POST['teacher_email']);
			$teacher_dateOfBirth = removeSymbol($_POST['teacher_dateOfBirth']);
			$teacher_contact = removeSymbol($_POST['teacher_contact']);
			$teacher_qualification = removeSymbol($_POST['teacher_qualification']);
			$user_type = removeSymbol($_POST['user_type']);
			$stmt = "UPDATE teachers
				 SET teacher_firstname='$teacher_firstname',
				 	 teacher_surname='$teacher_surname',
				 	 teacher_gender='$teacher_gender',
				 	 teacher_email='$teacher_email',
				 	 teacher_dateOfBirth='$teacher_dateOfBirth',
				 	 teacher_contact='$teacher_contact',
				 	 teacher_qualification='$teacher_qualification',
				 	 user_type='$user_type'
				 WHERE teacher_id='{$teacher_id}'";
			$editTeacher = query($stmt);
			if ($editTeacher->execute()) {
				echo "Teacher successfully edited.";
			}
			else {
				echo "Teacher edit failed.";
			}
		}
	}

	/*****Edit Teacher Profile*****/
	function editTeacherProfile($teacher_id)
	{
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$errors = [];
			$teacher_firstname = removeSymbol($_POST['teacher_firstname']);
			$teacher_surname = removeSymbol($_POST['teacher_surname']);
			$teacher_gender = removeSymbol($_POST['teacher_gender']);
			$teacher_email = removeSymbol($_POST['teacher_email']);
			$teacher_dateOfBirth = removeSymbol($_POST['teacher_dateOfBirth']);
			$today = date('Y/m/d', time());
			$diff = strtotime($teacher_dateOfBirth)-strtotime($today);
			$teacher_contact = removeSymbol($_POST['teacher_contact']);
			$teacher_qualification = removeSymbol($_POST['teacher_qualification']);

			$fileName = $_FILES['teacher_profile']['name'];
			$temp_dir = $_FILES['teacher_profile']['tmp_name'];
			$fileSize = $_FILES['teacher_profile']['size'];
			$fileSeperate = explode('.', $fileName);
			$fileExt = strtolower(end($fileSeperate));
			$allowExt = array('img','jpg','jpeg','pdf','png');
			$teacher_profile = strtolower($teacher_firstname).".jpeg";
			if ($fileSize > 1000000) {
				$errors[] = "File is too big to upload.";
			}
			if (!$fileExt == $allowExt) {
				$teacher_profile = "";
				// $errors[] = "Invalid Image Type.";
			}
			if ($diff > 0) {
				$errors[] = "Invalid Date of Birth.";
			}
			if (!empty($errors)) {
				foreach ($errors as $error) {
					echo $error . "<br>";
				}
			}
			else {
				$stmt = "UPDATE teachers
					 SET teacher_firstname='$teacher_firstname',
					 	 teacher_surname='$teacher_surname',
					 	 teacher_gender='$teacher_gender',
					 	 teacher_email='$teacher_email',
					 	 teacher_dateOfBirth='$teacher_dateOfBirth',
					 	 teacher_contact='$teacher_contact',
					 	 teacher_qualification='$teacher_qualification',
					 	 teacher_profile='$teacher_profile'
					 WHERE teacher_id='{$teacher_id}'";
				$editTeacher = query($stmt);
				if ($editTeacher->execute()) {
					move_uploaded_file($temp_dir, 'uploads/profiles/'.$teacher_profile);
					echo "Profile successfully edited.";
				}
				else {
					echo "Profile edit failed.";
				}
			}
		}
	}
	/*****Edit Teacher Password*****/
	function editTeacherPassword($teacher_id)
	{
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$stmt1 = "SELECT * FROM teachers WHERE teacher_id='{$teacher_id}'";
			$teachers = query($stmt1);
			$teachers->execute();
			$teacher = $teachers->fetch();
			$password_in_db = $teacher['teacher_password'];
			$old_teacher_password = removeSymbol($_POST['teacher_password']);
			if (password_verify($old_teacher_password, $password_in_db)) {
				$c_new_teacher_password = removeSymbol($_POST['c_new_teacher_password']);
				$new_teacher_password = removeSymbol($_POST['new_teacher_password']);
				$new_h_teacher_password = password_hash($new_teacher_password, PASSWORD_DEFAULT);
				if ($c_new_teacher_password == $new_teacher_password) {
					$stmt2 = "UPDATE teachers
						 SET teacher_password='$new_h_teacher_password'
						 WHERE teacher_id='{$teacher_id}'";
					$editPassword = query($stmt2);
					if ($editPassword->execute()) {
						redirect('logout.php');
					}
					else {
						echo "Error while changing password.";
					}
				}
				else {
					echo '<em><b style="color: red; font-size: 20px;">New passwords donot match with each other.</b></em>';
				}
			}
			else {
				echo '<em><b style="color: red; font-size: 20px;">The old password is incorrect.</b></em>';
			}	
		}
	}

	/*****Edit Student*****/
	function editStudent($student_id)
	{
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$student_firstname = removeSymbol($_POST['student_firstname']);
			$student_surname = removeSymbol($_POST['student_surname']);
			$student_gender = removeSymbol($_POST['student_gender']);
			$student_email = removeSymbol($_POST['student_email']);
			$student_dateOfBirth = removeSymbol($_POST['student_dateOfBirth']);
			$student_contact = removeSymbol($_POST['student_contact']);
			$student_class = removeSymbol($_POST['student_class']);
			if ($student_class == 0) {
				echo "Please select a class.";
			}
			else{
				$stmt = "UPDATE students
					 SET student_firstname='$student_firstname',
					 	 student_surname='$student_surname',
					 	 student_gender='$student_gender',
					 	 student_email='$student_email',
					 	 student_dateOfBirth='$student_dateOfBirth',
					 	 student_contact='$student_contact',
					 	 student_class='$student_class'
					 WHERE student_id='{$student_id}'";
				$editStudent = query($stmt);
				if ($editStudent->execute()) {
					echo "Student successfully edited.";
				}
				else {
					echo "Student edit failed.";
				}
			}
		}
	}	

	/*****Edit Student Profile*****/
	function editStudentProfile($student_id)
	{
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$errors = [];

			$fileName = $_FILES['student_profile']['name'];
			$temp_dir = $_FILES['student_profile']['tmp_name'];
			$fileSize = $_FILES['student_profile']['size'];
			$fileSeperate = explode('.', $fileName);
			$fileExt = strtolower(end($fileSeperate));
			$allowExt = array('img','jpg','jpeg','pdf','png');
			$student_profile = $student_id.".jpeg";
			if ($fileSize > 10000000) {
				$errors[] = "File is too big to upload.";
			}
			if (!$fileExt == $allowExt) {
				$student_profile = "";
			}
			if (!empty($errors)) {
				foreach ($errors as $error) {
					echo $error . "<br>";
				}
			}
			else {
				$stmt = "UPDATE students
					 SET student_profile='$student_profile'
					 WHERE student_id='{$student_id}'";
				$editStudent = query($stmt);
				if ($editStudent->execute()) {
					move_uploaded_file($temp_dir, 'uploads/profiles/students/'.$student_profile);
					echo "Profile Image successfully edited.";
				}
				else {
					echo "Profile edit failed.";
				}
			}
		}
	}

	/*****Edit Student Password*****/
	function editStudentPassword($student_id)
	{
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$stmt1 = "SELECT * FROM students WHERE student_id='{$student_id}'";
			$students = query($stmt1);
			$students->execute();
			$student = $students->fetch();
			$password_in_db = $student['student_password'];
			$old_student_password = removeSymbol($_POST['student_password']);
			if (password_verify($old_student_password, $password_in_db)) {
				$c_new_student_password = removeSymbol($_POST['c_new_student_password']);
				$new_student_password = removeSymbol($_POST['new_student_password']);
				$new_h_student_password = password_hash($new_student_password, PASSWORD_DEFAULT);
				if ($c_new_student_password == $new_student_password) {
					$stmt2 = "UPDATE students
						 SET student_password='$new_h_student_password'
						 WHERE student_id='{$student_id}'";
					$editPassword = query($stmt2);
					if ($editPassword->execute()) {
						redirect('logout.php');
					}
					else {
						echo "Error while changing password.";
					}
				}
				else {
					echo '<em><b style="color: red; font-size: 20px;">New passwords donot match with each other.</b></em>';
				}
			}
			else {
				echo '<em><b style="color: red; font-size: 20px;">The old password is incorrect.</b></em>';
			}	
		}
	}

	/*****Edit Content*****/
	function editContent($content_id)
	{
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$content_name = removeSymbol($_POST['content_name']);
			$content_description = removeSymbol($_POST['content_description']);
			$content_addedOn = date('Y-m-d', time());
			$content_teacher = $_SESSION['teacher_id'];

			$content_file = $_FILES['content_file']['name'];
			$temp_dir = $_FILES['content_file']['tmp_name'];
			// $fileSize = $_FILES['content_file']['size'];
			// $fileSeperate = explode('.', $fileName);
			// $fileExt = strtolower(end($fileSeperate));
			// $allowExt = array('txt','pdf','docx','pdf','doc');
			// $content_file = rand(1,1000000).".".$fileExt;

			$stmt = "UPDATE contents
					 SET content_name='$content_name',
					 	 content_description='$content_description',
					 	 content_file='$content_file',
					 	 content_addedOn='$content_addedOn',
					 	 content_teacher='$content_teacher'
					 WHERE content_id='{$content_id}';
					 	 ";
			$editContent = query($stmt);
			if ($editContent->execute()) {
				move_uploaded_file($temp_dir, 'uploads/'.$content_file);
				echo "Content successfully edited.";
			}
			else {
				echo "Content NOT successfully edited.";
			}
		}
	}					
?>