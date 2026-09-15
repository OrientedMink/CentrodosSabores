<?php
	/* This page is an example of a resource that is only available for authenticated users. As such, the first thing is to verify that 
	 * it is so. If not, the user should be redirected to the login page. This can later on be added to a header page that may be
	 * included in all resources that are for authenticated users only.
	 */
	session_start();
	if ( !empty($_POST) && array_key_exists('logout', $_POST) ){
		/* the user if trying to perform a logout. This field should later be included in, for example, a header file. That way it will be
		 * persistent throughout all the web application.
		 */ 
		 
		 session_unset();
		 session_destroy();
		 $_SESSION = array();
		 
		 // After the logout, send the user back to the login form.
		 header('Location:loginForm.php?code=39');
		 die();
	}
	elseif ( empty($_SESSION) || !isset($_SESSION['username']) ){
		//the user is not authenticated. This can be an error or a direct access. Send it back to the login page.
		header('Location:loginForm.php?error=1');
		die();
	}
?>
<!DOCTYPE html>
<html>
<body>
<?php
	// print a hello message to the authenticated user using its username
	echo "Hello " . $_SESSION['username'] . ". Welcome back!";
?>

<!-- Logout form -->
<form name="logout" action="" method="POST">
	<input type="submit" name="logout" value="Logout"/>
</form>
</body>
</html>