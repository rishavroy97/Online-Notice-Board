<!DOCTYPE html>
<html>
<head>
	<title></title>
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

    $success = 0;
    $message = NULL;
    $email = NULL;
    $password = NULL;
    $name = NULL;

	$connection=mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);

	// Check connection
	if (mysqli_connect_errno()) {
	  echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}



    if(isset($_POST['action']))
    {          
        if($_POST['action']=="login")
        {
            $email = mysqli_real_escape_string($connection,$_POST['email']);
            $password = mysqli_real_escape_string($connection,$_POST['password']);
            $strSQL = mysqli_query($connection,"select name from users where email='".$email."' and password='".md5($password)."'");
            $Results = mysqli_fetch_array($strSQL);
            if(count($Results)>=1)
            {
                $name = $Results['name'];
                $message = $Results['name']." Login Sucessfully!!";
                $success = 1;
            }
            else
            {
                $message = "Invalid email or password!!";
                
            }        
        }
        elseif($_POST['action']=="signup")
        {
            $name = mysqli_real_escape_string($connection,$_POST['name']);
            $email = mysqli_real_escape_string($connection,$_POST['email']);
            $password = mysqli_real_escape_string($connection,$_POST['password']);
            $query = "SELECT email FROM users where email='".$email."'";
            $result = mysqli_query($connection,$query);
            $numResults = mysqli_num_rows($result);
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) // Validate email address
            {
                $message =  "Invalid email address please type a valid email!!";
            }
            elseif($numResults>=1)
            {
                $message = $email." Email already exist!!";
            }
            elseif($password == ""){
                $message = "Password field cannot be empty";
            }
            else
            {
                mysqli_query($connection,"insert into users(name,email,password) values('".$name."','".$email."','".md5($password)."')");
                $message = "Signup Sucessfully!!";
                $success = 1;
            }
        }
    }
	
    if ($success == 1) {
        echo "$message";
        echo '<form method="post" action="notice.php" id = "successform">
                  <input type="hidden" name="email" value="'.$email.'">
                  <input type="hidden" name="name" value="'.$name.'">
                  <input type="hidden" name="password" value="'.md5($password).'">
              </form>';
        echo '<script type="text/javascript">
        document.getElementById("successform").submit();
        </script>';
    }
    else{
        header("Location: login_signup.php");
    }
    $_SESSION['reg_msg'] = $message;
?>


</body>
</html>
