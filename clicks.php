<?php

if (isset($_POST['register_btn'])) {
	register();
}

if (isset($_GET['logout'])) {
	session_destroy();
	unset($_SESSION['user']);
	header("location: ../login.php");
}

if (isset($_POST['login_btn'])) {
	login();
}

if (isset($_POST['post_review_btn'])) {
	global $db;
	$username 	= $_SESSION['user']['username'];
	$userID 	= $_SESSION['user']['userID'];
	$movieID 	= escape_string($_GET['id']);
	$comment 	= escape_string($_POST['review_input']);

	$query 		= "INSERT INTO comments (comment, movieID, user, userID, date) VALUES('$comment', '$movieID', '$username', '$userID', CURRENT_TIMESTAMP)";

	if(!mysqli_query($db, $query)) {
		echo "Error: " . mysqli_error($db);
	}

	// prevent resubmitting data on page refresh by redirecting to the same page 
	header('Location: '.getURL());
}

if (isset($_POST['watchlist_btn'])) {
	global $db;
	$userID 	= $_SESSION['user']['userID'];
	$movieID 	= escape_string($_POST['watchlist_btn']);

	$query 		= "SELECT * FROM watchlist WHERE movieID='$movieID' AND userID='$userID' LIMIT 1";
	$result 	= mysqli_query($db, $query);

	if(mysqli_num_rows($result) == 1){ //if exists remove entry else insert it again
		$query = "DELETE FROM watchlist WHERE movieID='$movieID'";
		mysqli_query($db, $query);
	}else{
		$query = "INSERT INTO watchlist (movieID, userID) VALUES('$movieID', '$userID')";
		mysqli_query($db, $query);
	}

	// prevent resubmitting data on page refresh by redirecting to the same page 
	header('Location: '.getURL());
}

if (isset($_POST['delete_review_btn'])) {
	global $db;
	$userID 	= $_SESSION['user']['userID'];
	$commentID 	= escape_string($_POST['delete_review_btn']);

	$query 		= "DELETE FROM comments WHERE commentID='$commentID'";
	$result 	= mysqli_query($db, $query);

	// prevent resubmitting data on page refresh by redirecting to the same page 
	header('Location: '.getURL());
}

if (isset($_POST['edit_review_btn'])) {
	global $db;
	$userID 	= $_SESSION['user']['userID'];
	$commentID 	= escape_string($_POST['edit_review_btn']);
	$newComment = escape_string($_POST['edit_review_textarea']);

	$query 		= "UPDATE comments SET comment='$newComment' WHERE commentID='$commentID'";
	$result 	= mysqli_query($db, $query);

	// prevent resubmitting data on page refresh by redirecting to the same page 
	header('Location: '.getURL());
}

if (isset($_POST['delete_user_btn'])) {
	global $db;
	$user_type 	= $_SESSION['user']['user_type'];
	$userID		= $_SESSION['user']['userID'];
	$delete_userID 	= escape_string($_POST['delete_user_btn']);

	if($user_type === 'admin' && $userID != $delete_userID){
		$query 		 = "DELETE FROM users WHERE userID='$delete_userID';";
		$query 		.= "DELETE FROM comments WHERE userID='$delete_userID';";
		$query 		.= "DELETE FROM watchlist WHERE userID='$delete_userID'";
		$result 	 = mysqli_multi_query($db, $query);
	}

	// prevent resubmitting data on page refresh by redirecting to the same page 
	header('Location: '.getURL());
}

if (isset($_POST['edit_user_btn'])) {
	global $db;
	$userID 	= escape_string($_POST['edit_user_btn']);
	$user_type 	= escape_string($_POST['edit_user_type']);

	if($user_type != 'admin' && $user_type != 'user'){
		return;
	}
	
	if($_SESSION['user']['user_type'] === 'admin' && $_SESSION['user']['userID'] != $userID){
		$query 		= "UPDATE users SET user_type='$user_type' WHERE userID='$userID'";
		$result 	= mysqli_query($db, $query);
		
		if(!$result) {
			echo "Error: " . mysqli_error($db);
		}
	}

	// prevent resubmitting data on page refresh by redirecting to the same page 
	header('Location: '.getURL());
}