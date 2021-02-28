<?php global $db, $config;
$userID = $_SESSION['user']['userID'];
$query = "SELECT * FROM watchlist WHERE userID='".$userID."'";
$result = mysqli_query($db, $query);

if(mysqli_num_rows($result) > 0){
    while($row = mysqli_fetch_assoc($result)){

        $content = file_get_contents("http://www.omdbapi.com/?i=".$row['movieID']."&plot=short&apikey=".$config['omdbkey']);
        $json  = json_decode($content, true);

        $poster     = $json['Poster'];
        $title      = $json['Title'].' ('.$json['Year'].')';
        $info       = $json['Rated'].' | '.$json['Runtime'].' | '.$json['Genre'].' | '.$json['Released'];
        $plot       = $json['Plot'];
        $movieID    = $json['imdbID'];

        echo '  <div class="user_movie_list">
                    <div class="movie">
                        <div class="movie_poster small_poster">
                            <img src="'.$poster.'" alt="poster"></img>
                        </div>
                        <div class="movie_info">
                            <form method="post">
                                <a href="?id='.$movieID.'">'.$title.'</a>';
                                
                                $query 	    = "SELECT * FROM watchlist WHERE movieID='$movieID' AND userID='$userID' LIMIT 1";
                                $heart 	    = mysqli_query($db, $query);
                                $watchlist  = mysqli_fetch_assoc($heart);
            
                                if( $watchlist ){
                                    echo '<button title="Remove from watchlist" value="'.$movieID.'" name="watchlist_btn" class="is_on_watchlist" ></button>';
                                }else{
                                    echo '<button title="Add to watchlist" value="'.$movieID.'" name="watchlist_btn" ></button>';
                                }

                            echo '</form>
                            <h5>'.$info.'</h5>
                            <p>'.$plot.'</p>
                        </div>
                    </div>
                </div> ';
    }
}else{
    echo '<p id="info_text">You don\'t have any shows listed yet. 😔</p>';
}?>