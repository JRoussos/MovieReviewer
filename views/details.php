<div class="user_movie_list">
    <?php
        global $config;
        $content = file_get_contents("http://www.omdbapi.com/?i=".$_GET['id']."&plot=full&apikey=".$config['omdbkey']);
        $json  = json_decode($content, true);

        $poster     = $json['Poster'];
        $title      = $json['Title'].' ('.$json['Year'].')';
        $info       = $json['Rated'].' | '.$json['Runtime'].' | '.$json['Genre'].' | '.$json['Released'];
        $plot       = $json['Plot'];
        $awards     = $json['Awards'];
        $movieID    = $json['imdbID'];

        if($awards == 'N/A'){
            $awards = 'No Awards';
        }

        echo '  <div class="movie">
                    <div class="movie_poster large_poster">
                        <img src="'.$poster.'" alt="poster"></img>
                    </div>
                    <div class="movie_info">
                        <form method="post">
                            <h4>'.$title.'</h4>';
                            if(isLoggedIn()){
                                global $db;
                                $userID = $_SESSION['user']['userID'];
                            
                                $query 	= "SELECT * FROM watchlist WHERE movieID='$movieID' AND userID='$userID' LIMIT 1";
                                $result 	= mysqli_query($db, $query);
                                $watchlist = mysqli_fetch_assoc($result);
                            
                                if( $watchlist ){
                                    echo '<button id="add_to_watchlist_btn" value="'.$movieID.'" title="Remove from watchlist" name="watchlist_btn" class="is_on_watchlist" ></button>';
                                }else{
                                    echo '<button id="add_to_watchlist_btn" value="'.$movieID.'" title="Add to watchlist" name="watchlist_btn" ></button>';
                                }
                            }
                        echo '</form>
                        <h5>'.$info.'</h5>
                        <h5 class="small_info">'.$awards.'</h5>
                        <p id="detailed_plot_id" class="short_plot">'.$plot.'</p>
                        <div id="plot_btn_id" class="plot_btn" onclick="document.getElementById(\'detailed_plot_id\').classList.toggle(\'short_plot\')">see more</div>
                    </div>
                </div>';
    ?>
    <script>
        // check if paragraph is clamped by checking if the elements scrollHeight exceeding the clientHeight
        // https://stackoverflow.com/questions/52169520/how-can-i-check-whether-line-clamp-is-enabled
        
        const el = document.getElementById('detailed_plot_id')
        if(!(el.scrollHeight > el.clientHeight)){
            document.getElementById('plot_btn_id').style.visibility = 'hidden';
        }
    </script>
    <?php if(isLoggedIn()) : ?>
        <form class="post_review" method="post">
            <input 
                id="review_input" 
                type="text" 
                name="review_input"
                oninput="activate_review_post_btn(this.value)"
                placeholder="Tell us your opinion"></input>
            <button id="post_review_btn" name="post_review_btn" disabled>POST</button>
        </form>
    <?php endif ?>
    <?php echo show_comments();?>
</div>