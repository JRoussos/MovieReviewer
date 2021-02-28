<?php global $db;
$userID = $_SESSION['user']['userID'];

$query = "SELECT * FROM (
            SELECT movieID FROM watchlist WHERE userID='$userID' UNION 
            SELECT movieID FROM comments WHERE userID='$userID' ) AS temo
            INNER JOIN comments ON comments.movieID=temo.movieID ORDER BY date DESC";
$result = mysqli_query($db, $query);

if($result){
    if(mysqli_num_rows($result) > 0){
        echo '<div class="home">';
		while($row = mysqli_fetch_assoc($result)){
            $content    = file_get_contents("http://www.omdbapi.com/?i=".$row['movieID']."&apikey=".$config['omdbkey']);
            $json       = json_decode($content, true);
            
            $title      = $json['Title'];
            $poster     = $json['Poster'];
            $movieID    = $json['imdbID'];
            $user       = ($row['userID'] == $userID) ? 'you' : $row['user'];

			echo '<div class="review">
                    <p><span>'.$user.'</span> reviewed <span><a style="display: inline;" href="?id='.$movieID.'">'.$title.'</a></span></p>
                    <div class="review_content">
                        <p>'.$row['comment'].'</p>
                    </div>
                </div>';	
		}
		echo '</div>';
    }
    else{
		echo '<p id="info_text">Welcome to your home sceen, here you can see the activity of the movies you have interact with 🙂</p>';
	}
}else{
    echo "Error: " . mysqli_error($db);
}
?>