<?php global $db, $config;
$userID = $_SESSION['user']['userID'];
$query = "SELECT * FROM comments WHERE userID='$userID' ORDER BY date DESC";
$result = mysqli_query($db, $query);

if(mysqli_num_rows($result) > 0){

    while($row = mysqli_fetch_assoc($result)){
        $content    = file_get_contents("http://www.omdbapi.com/?i=".$row['movieID']."&apikey=".$config['omdbkey']);
        $json       = json_decode($content, true);
        
        $title      = $json['Title'];

        echo '<div class="user_movie_list">
                <div id="'.$row['commentID'].'" class="movie border">
                    <a href="?id='.$row['movieID'].'">'.$title.'</a>
                    <div>
                        <p>'.$row['comment'].'</p>
                        <form class="btn_wrapper" method="post">
                            <button type="button" class="edit" onclick="edit_review('.$row['commentID'].')">edit</button>
                            <button class="delete" value="'.$row['commentID'].'" name="delete_review_btn"></button>
                        </form>
                    </div>
                </div>
            </div>';
    }
}else{
    echo '<p id="info_text">You haven\'t posted any reviews yet. 😔</p>';
}?>