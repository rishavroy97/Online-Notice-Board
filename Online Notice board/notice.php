<!DOCTYPE html>
<html>
<head>
	<title>Notice Board</title>
	<link href="https://fonts.googleapis.com/css?family=Covered+By+Your+Grace|Permanent+Marker" rel="stylesheet">
	<link href="style.css" rel="stylesheet" type="text/css">

</head>
<body>
<div class = "heading">
<h1>Online Notice Board</h1>
</div>
<?php
	session_start();
	require_once('config.php'); 

	if(!isset($_POST['email']) || !isset($_POST['password'])){
		$_SESSION['reg-msg'] = "Valid email (or) password not received";
		sleep(1);
		header("Location: login_signup.php");
	}

	$link = mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);

	// Check connection
	if (mysqli_connect_errno()) {
	  echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}

	//to check the access status of the user
	$access_query = 'SELECT * FROM users WHERE users.email = "'.$_POST['email'].'" AND users.password = "' . $_POST['password'] . '"';
	$access = mysqli_query($link,$access_query);
	if (!$access) {
		echo "<br> Error :" . mysqli_error($link);
	}
	$access_result = mysqli_fetch_array($access);
	
	

	$email = $_POST['email'];
	$password = $_POST['password'];
	$name = $_POST['name'];

	

	//if access is teacher
	if ($access_result['Access'] == 'teacher') {
		
		echo '<form id="teacher_form" method="post" action="notice_teacher.php">
                  <input type="hidden" name="email" value="'.$_POST['email'] .'">
                  <input type="hidden" name="password" value="'.$_POST['password'].'">
                  <input type="hidden" name="name" value="'.$_POST['name'] .'">

                  </form>';
		echo '<script type="text/javascript">
  		document.getElementById("teacher_form").submit();
		</script>';
	}

	//if Access value is admin

	else if ($access_result['Access'] == 'admin') {

		echo '<form id="admin_form" method="post" action="notice_admin.php">
                  <input type="hidden" name="email" value="'.$_POST['email'] .'">
                  <input type="hidden" name="password" value="'.$_POST['password'].'">
                  <input type="hidden" name="name" value="'.$_POST['name'] .'">
                  </form>';
		echo '<script type="text/javascript">
  		document.getElementById("admin_form").submit();
		</script>';
	}
	
	//if Access value is student

	else if($access_result['Access'] == 'student'){
		
		$sql = "SELECT * FROM `notice` ORDER BY `notice`.`date` ASC";
		$query = mysqli_query($link,$sql);
		if (!$query) {
			echo "<br> Error :" . mysqli_error($link);
		}
		echo "<div class = 'greeting'>Hello ".$name."!</div>";
		echo "<style>
			#notice{
				top:140px;
			}
		</style>";
		echo "<div id = 'notice'><p>Notice Board</p>";
		$count = 0;
		while ($result = mysqli_fetch_array($query)) {
			$count +=1;
			echo "<div class='note'>";
			//echo "<p>ID : " . $result['id'] . "</p>";
			echo "<p>".$count." : <u>" . $result['Subject'] . "</u></p>";
			echo "<p><u>Note</u> : " . $result['Note'] . "</p>";
			echo "</div>";
		}

		echo "</div>";
	}

	

	
?>
</body>
</html>