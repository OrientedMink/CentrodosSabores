<?php
	/* This page is to be included in all pages. It may contain a navigation menu. The user must be checked to be authenticated or not and proceed accordingly.
	 */
	echo '<link rel="stylesheet" type="text/css" href="css/styles.css">';
	echo '<meta name="viewport" content="width=device-width, initial-scale=1"></head>';

	//check if a session is already started to avoid warnings.
	if (session_status() === PHP_SESSION_NONE) {
    session_start();
   }
	
	if ( empty($_SESSION) || !array_key_exists('username', $_SESSION) || !isset($_SESSION['username']) ){
		//the user is not authenticated. This can be an error or a direct access. Send it back to the login page or see if this page can be seen without authorization.
		
		$path = 'goodies/ConfigApp.php';		
		if (  file_exists($path) ){
		   require_once($path);				
		}
		else{
		   echo 'Internal server error: please try again later (Code: 8).';
		   die();		
		}
		
		//which is the script where the header is being included? Get the last position of the URL, remove the "." and the "php".
	   $scriptName = explode('/', $_SERVER['PHP_SELF']);
	   $scriptName = (explode('.', $scriptName[sizeof($scriptName)-1]))[0];
	   
	   // is it on the no authentication required list available on ConfigApp.php?
	   if( in_array( $scriptName, $pages ) ){
	   	//allow the user to navigate here - present the simple menu
	   	echo
		'<nav class="navbar" style="background-color:rgba(255, 250, 250, 0.8);">
            <div class="nav-left">
                <a href="index.php"><img src="images/Logo-Site-02.png" alt="Logo" class="logo"></a>
            </div>
            <div class="nav-center">
                <a href="index.php">Home</a>
                <a href="loginForm.php">Login</a>
                <a href="registerForm.php">Register</a>
            </div>
            <div class="nav-right">
                <form action="search.php" method="POST" class="search-form">
                    <input type="text" name="searchTerm" id="searchTerm" placeholder="Search..." class="search-input">
                    <button type="submit" class="search-button">🔍</button>
                </form>
            </div>
        </nav>' ;
	   }
	   else{	
			//set the error to display in the login form
			$_SESSION['code'] = 101;
		
			//send the user away
			header('Location:loginForm.php');
			die();
		}
	}//end main if
	else{
		//the user is authenticated. Show the full menu. We can later differentiate between user types and show different menus
		//allow the user to navigate here - present the full menu
		echo 
		' <nav class="navbar" style="background-color:rgba(255, 250, 250, 0.8);">
        <div class="nav-left">
            <a href="index.php"><img src="images/Logo-Site-02.png" alt="Logo" class="logo"></a>
        </div>
		<div class="nav-center">';
		if($_SESSION['type_user'] == "admin"){
			echo '<a>Hello ' . $_SESSION['username'] . ' (' . $_SESSION['type_user'] . ')! </a>';
		}
		else{
			echo '<a>Hello ' . $_SESSION['username'] . '!<a>';
		}
        echo'<a href="index.php">Home</a>
            <a href="anunciarForm.php">Announce</a>
            <a href="updateForm.php">Update</a>
			<a href="chat.php">Chat</a>
        </div>
        <div class="nav-right">
            <form action="search.php" method="POST" class="search-form">
                    <input type="text" name="searchTerm" id="searchTerm" placeholder="Search..." class="search-input">
                    <button type="submit" class="search-button">🔍</button>
                </form>
            <a href="logout.php" class="login-button">Logout</a>
        </div>
		</nav>';
		
	}	
?>