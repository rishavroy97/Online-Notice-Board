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

	$email = $_POST['email'];
	$password = $_POST['password'];
	$name = $_POST['name'];
	//variables for sql statement and query
	$sql = '';
	$query = '';

	echo "<div class = 'greeting'>
			<p> Hello ".$name."!</p>
		</div>";


	//opening the container div
	//echo "<div class = 'container' id = 'display'>";

	echo '<div class = "container" id = "list">
	<ul class = "adminList">';



	//view the notes
		echo '<li>
				<p class = "Topic">View Notice Board</p>';
			
			echo "<div id = 'notice' class = 'View'><p>Notice Board</p>";

			$sql = "SELECT * FROM `notice` ORDER BY `notice`.`date` ASC";
			$query = mysqli_query($link,$sql);
			if (!$query) {
				echo "<br> Error :" . mysqli_error($link);
			}
			
			$count = 0;
			while ($result = mysqli_fetch_array($query)) {
				echo "<div class='note'>";
				$count += 1;
				echo "<p>".$count." : <u>" . $result['Subject'] . "</u></p>";
				echo "<p><u>Note</u> : " . $result['Note'] . "</p>";
				echo "</div>";
			}
			echo "</div></li>";

		



	//add note

		echo '<li>
			<p class = "Topic">Add Notes</p>';
			echo "<div id = 'add_note' class = 'View'><p>Add New Note</p>";
			echo "<div class='note'>";
			echo "<form id = 'add' method='post' action = ''>
					<p><input type = 'text' name = 'Subject' placeholder = 'Subject'></p>
					<p><textarea name = 'Note' placeholder = 'Note'></textarea></p>
					<input type = 'hidden' name = 'action' value = 'Add Note'>
					<input type = 'hidden' name = 'email' value = '". $email ."'>
					<input type = 'hidden' name = 'password' value = '". $password ."'>
					<input type = 'hidden' name = 'name' value='".$name ."'>
					<input type = 'submit' value = 'Add New Note'>
			</form>";
			if (isset($_POST['action'])) {
				if($_POST['action']=="Add Note")
		        {
		            $subject = mysqli_real_escape_string($link,$_POST['Subject']);
		            $note = mysqli_real_escape_string($link,$_POST['Note']);
		            if ($subject != '' && $note != '') {
		            	$sql = "INSERT into notice (Subject,Note) values ('".$subject."','".$note . "')";
			            $query = mysqli_query($link,$sql);
			            if (!$query) {
							echo "<br> Error :" . mysqli_error($link);
						}
        				echo 'New Note Added Successfully';
						//after adding the note..you have to display it as well	
						//hence refresh the page
						echo '<script type="text/javascript">
        					document.getElementById("add").submit();
        				</script></div>';
		            }
		        }
			}
			echo "</div></li>";








	//delete note
		echo '<li>
			<p class="Topic">Delete Notes</p>';
			echo "<div id = 'delete_note' class = 'View'><p>Delete Note<br>";
			echo "Click on the Note to Delete it.</p>";

			$sql = "SELECT * FROM `notice` ORDER BY `notice`.`date` ASC";
			$query = mysqli_query($link,$sql);
			if (!$query) {
				echo "<br> Error :" . mysqli_error($link);
			}
			
			while ($result = mysqli_fetch_array($query)) {
				echo "<div class='deleteNote'>";
				echo "<p>" . $result['Subject'] . "</p>";
				echo "<p>" . $result['Note'] . "</p>";
				echo "<form id= 'del' method='post' action = ''>";
				echo "<input type = 'hidden' name = 'action' value = 'Delete Note'>";
				echo "<input type = 'hidden' name = 'email' value = '". $email ."'>
					<input type = 'hidden' name = 'password' value = '". $password ."'>
					<input type = 'hidden' name = 'name' value='".$name ."'>
					<input type = 'hidden' name = 'subject' value ='".$result['Subject']."'>
					<input type = 'hidden' name = 'note' value = '".$result['Note'] ."'>
					<input class='delSub' type = 'submit' value = 'Delete Note'>";
				echo "</form>";

				echo "</div>";
			}

			if (isset($_POST['action'])) {
				if($_POST['action']=="Delete Note")
		        {
		        	//echo "Success";
		        	$sql = "DELETE FROM `notice` WHERE `notice`.`Subject` ='".$_POST['subject']."' AND `notice`.`Note` ='".$_POST['note']."'" ;
					$query = mysqli_query($link,$sql);
					if (!$query) {
						echo "<br> Error :" . mysqli_error($link);
					}
					//after deleting the note..you have to display it as well	
					//hence refresh the page
					echo '<script type="text/javascript">
	        			document.getElementById("add").submit();
	        		</script></div>';
		        }

		    }

			echo "</div></li>";

		




	//access modification
		echo '<li>
		<p class = "Topic">Access Modification</p>';
		echo "<div id = 'access_mod' class = 'View'><p>Access Modification</p>";
		echo"<form method='post' action=''>
				<p><input type = 'text' name= 'a_name' placeholder = 'Enter the Name'></p>
				<p><input type = 'text' name= 'a_email' placeholder = 'Enter the email-id(required)'></p>
				<p id = 'accesslist'>Access Level : <select name='access' placeholder = 'Access Level'>
          				<option value='student'>Student</option>
          				<option value='teacher'>Teacher</option>
        			</select></p>
				<input type = 'hidden' name = 'action' value = 'access_mod'>
				<input type = 'hidden' name = 'email' value = '". $email ."'>
				<input type = 'hidden' name = 'password' value = '". $password ."'>
				<input type = 'hidden' name = 'name' value='".$name ."'>
				<input type = 'submit' value = 'Change Access'>
				</form>";

		if(isset($_POST['action']))
	    {          
	        if($_POST['action']=="access_mod")
	        {
	            $a_email = mysqli_real_escape_string($link,$_POST['a_email']);
	            $a_name = mysqli_real_escape_string($link,$_POST['a_name']);
	            $a_access = mysqli_real_escape_string($link,$_POST['access']);
	            $strSQL = mysqli_query($link,"select * from users where email='".$a_email."'");
	            $Results = mysqli_fetch_array($strSQL);
	            if(count($Results)>=1)
	            {
	                if ($Results['Access'] == 'admin' || $Results['Access'] == 'teacher') {
	            		echo "You do not have that permission";
	            	}
	            	else{
	            		$sql = "UPDATE `users` SET `Access` = '".$a_access."' WHERE `users`.`email` = '".$a_email."'";
		                $query = mysqli_query($link,$sql);
						if (!$query) {
							echo "<br> Error :" . mysqli_error($link);
						}
						else{
							echo "Updated sucessfully!!";
						}	
	            	}
	                
	            }
	            else{
	            	echo "Email-id not found!";
	            }

	        }
	        else{
	        	echo "";
	        }

		}
		 /*echo "<script type='text/javascript'>
	        		document.getElementById('access_mod').style.display = 'block';
	        </script>";*/
		echo "</div></li></ul>";
	

	

	



	
	

	


	echo "</div>";
?>
<script type="text/javascript" src="script.js"></script>
</body>
</html>