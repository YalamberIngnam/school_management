<form method="POST">
	<input type="checkbox" name="ck1" value="<?php if(isset($_POST['ck1'])){ echo(1);}else{echo(0);} ?>">
	<input type="checkbox" name="ck2" value="0">
	<input type="checkbox" name="ck3">
	<input type="checkbox" name="ck4">
	<input type="checkbox" name="ck5">
	<input type="checkbox" name="ck6">
	<input type="checkbox" name="ck7">
	<input type="checkbox" name="ck8">
	<input type="submit" name="Submit" value="Send">
</form>
<?php 
	if (isset($_POST['ck1'])) {
		echo "YESSSSSSSS";
	}
	else{
		echo "NO";
	}
 ?>
<?php print_r($_POST) ?>
<?php print_r($_POST['ck1']) ?>