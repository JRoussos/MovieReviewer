<?php session_start();

if( file_exists('config.ini') ){
	$config = parse_ini_file('config.ini');
	$db = mysqli_connect($config['server'], $config['username'], $config['password'], $config['dbname']);
}else {
	$config = parse_ini_file('../config.ini');
	$db = mysqli_connect($config['server'], $config['username'], $config['password'], $config['dbname']);
}

if( $db === false ){
	die( "Connection failed: ". mysqli_connect_error()); 
}

$username = "";
$email    = "";
$errors   = array(); 

$movie_id = "";

function register(){
	global $db, $errors, $username, $email;

	$username    =  escape_string($_POST['username']);
	$email       =  escape_string($_POST['email']);
	$password_1  =  escape_string($_POST['password_1']);
	$password_2  =  escape_string($_POST['password_2']);

	if (empty($username)) { 
		array_push($errors, "Username is required"); 
	}
	if (empty($email)) { 
		array_push($errors, "Email is required"); 
	}
	if (empty($password_1)) { 
		array_push($errors, "Password is required"); 
	}
	if ($password_1 != $password_2) {
		array_push($errors, "The two passwords do not match");
	}

	// check the database to make sure that a user does not already exist with the same username and/or email
	$user_check_query = "SELECT * FROM users WHERE username='$username' OR email='$email' LIMIT 1";
	$result = mysqli_query($db, $user_check_query);
	$user = mysqli_fetch_assoc($result);
	
	if ($user) { // if user exists
		if ($user['username'] === $username) {
		array_push($errors, "Username already exists");
		}

		if ($user['email'] === $email) {
		array_push($errors, "Email already exists");
		}
	}

	if (count($errors) == 0) {
		$password = md5($password_1); 

		if (isset($_POST['user_type'])) { //if the new user is created by the admin

			$user_type = escape_string($_POST['user_type']);
			$query = "INSERT INTO users (username, email, user_type, password) VALUES('$username', '$email', '$user_type', '$password')";
			mysqli_query($db, $query);

			$_SESSION['success']  = "A new user is created";
			
			header('Location: '.getURL());

		}else{

			$query = "INSERT INTO users (username, email, user_type, password) VALUES('$username', '$email', 'user', '$password')";
			mysqli_query($db, $query);		

			$logged_in_user_id = mysqli_insert_id($db); // get id of the created user

			$_SESSION['user'] = getUserById($logged_in_user_id); // put logged in user in session
			$_SESSION['success']  = "You are logged in";

			header('location: user/user.php?page=home');				
		}
	}
}

function getUserById($id){
	global $db;
	$query = "SELECT * FROM users WHERE userID=" . $id;
	$result = mysqli_query($db, $query);

	$user = mysqli_fetch_assoc($result);
	return $user;
}

function escape_string($val){
	global $db;
	return mysqli_real_escape_string($db, trim($val));
}

function display_error() {
	global $errors;

	if (count($errors) > 0){
		echo '<div class="error">';
			foreach ($errors as $error){
				echo '<p>'.$error.'</p>';
			}
		echo '</div>';
	}
}

function show_comments() {
	global $db;
	$movie_id = $_GET['id'];
	
	$query = "SELECT * FROM comments WHERE movieID='$movie_id' ORDER BY date DESC";
	$result = mysqli_query($db, $query);

	if(mysqli_num_rows($result) > 0){
		echo '<div id="movie_reviews">';
		while($row = mysqli_fetch_assoc($result)){
			echo '<div class="review"><h5>User '.$row['user'].' said: </h5><p>'.$row['comment'].'</p></div>';	
		}
		echo '</div>';
	}else{
		echo '<p id="info_text">No reviews yet. Be the first to review this movie. 😀</p>';
	}
}

function login(){
	global $db, $username, $errors;

	$username = escape_string($_POST['username']);
	$password = escape_string($_POST['password']);

	if (empty($username)) {
		array_push($errors, "Username is required");
	}
	if (empty($password)) {
		array_push($errors, "Password is required");
	}

	if (count($errors) == 0) {
		$password = md5($password);

		$query = "SELECT * FROM users WHERE username='$username' AND password='$password' LIMIT 1";
		$results = mysqli_query($db, $query);

		if (mysqli_num_rows($results) == 1) { // user found
			$logged_in_user = mysqli_fetch_assoc($results);

			if ($logged_in_user['user_type'] == 'admin') { // check if user is admin or user

				$_SESSION['user'] = $logged_in_user;
				$_SESSION['success']  = "You are logged in";
				header('location: user/admin.php?page=home');		    

			}else if ($logged_in_user['user_type'] == 'user') {

				$_SESSION['user'] = $logged_in_user;
				$_SESSION['success']  = "You are logged in";
				header('location: user/user.php?page=home');		  

			}

		}else {
			array_push($errors, "The username or password you entered is wrong");
		}
	}
}

function isAdmin() {
	if (isset($_SESSION['user']) && $_SESSION['user']['user_type'] == 'admin' ) {
		return true;
	}else{
		return false;
	}
}

function isLoggedIn() {
	if (isset($_SESSION['user'])) {
		return true;
	}else{
		return false;
	}
}

function getStats() {
	global $db;
	$userID 	= $_SESSION['user']['userID'];

	$query 			= "SELECT * FROM watchlist WHERE userID='$userID' ";
	$heart_result	= mysqli_query($db, $query);
	$heart_counter	= mysqli_num_rows($heart_result);

	$query 			= "SELECT * FROM comments WHERE userID='$userID' ";
	$review_result	= mysqli_query($db, $query);
	$review_counter	= mysqli_num_rows($review_result);

	// echo 'My Stats: <span class="heart_counter_icon"></span>'.$count;

	echo 'My Stats: <span class="notification-container">
			<span class="icon-heart"></span>
	  		<span class="notification-counter">'.$heart_counter.'</span>
		</span>
		<span class="notification-container">
			<span class="icon-review"></span>
	  		<span class="notification-counter">'.$review_counter.'</span>
		</span>';
}

function getURL() {
	if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')   
		$url = "https://";   
	else  
		$url = "http://";   

	$url .= $_SERVER['HTTP_HOST'];   

	// Append the requested resource location to the URL   
	$url .= $_SERVER['REQUEST_URI'];    
	
	return $url;  
}

include('clicks.php'); 