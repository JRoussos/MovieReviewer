<div class="form_wrapper">
    <h3 class="header_title">Create User</h3>
    <form id="form_id" action="<?php echo getURL();?>" method="POST"> 
        <div class="input_container">
            <div id="username_wrapper" class="input_wrapper">
                <input id="reg_username_input_id" class="input" type="text" name="username" value="<?php echo $username; ?>" placeholder="Username" required>
            </div>
            <div id="email_wrapper" class="input_wrapper">
                <input id="email_input_id" class="input" type="email" name="email" placeholder="Email" value="<?php echo $email; ?>" required>
            </div>
            <div id="password_wrapper" class="input_wrapper">
                <input id="reg_password_input_id" class="test" type="password" name="password_1" placeholder="Password" required>
            </div>
            <div id="password1_wrapper" class="input_wrapper">
                <input id="password_check_input_id" class="input" type="password" name="password_2" placeholder="Cofirm Password" required> 
            </div>
            <div class="input_wrapper">
                <select name="user_type" id="usertype">
                    <option selected="selected" disabled>Select User Type</option>
                    <option value="user">User</option>
                    <option value="admin">Admin</option>
                </select>
            </div>
            <button name="register_btn" >Create User</button>
        </div>
        <?php echo display_error(); ?>
    </form>
</div>
<h3 class="header_title">User List</h3>
<?php global $db;
$userID = $_SESSION['user']['userID'];

$query = "SELECT userID, username, email, user_type FROM users";
$result = mysqli_query($db, $query);

if($result){
    if(mysqli_num_rows($result) > 0){
        echo '<div class="table_wrapper outer">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>USERNAME</th>
                            <th>EMAIL</th>
                            <th>ACCESS</th>
                            <th>ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody>';
		while($row = mysqli_fetch_assoc($result)){
			echo '<tr>
                    <td>'.$row['userID'].'</td>
                    <td>'.$row['username'].'</td>
                    <td>'.$row['email'].'</td>
                    <td id="'.$row['userID'].'">'.$row['user_type'].'</td>
                    <td>
                        <form class="btn_wrapper" method="post">';
                            if( $row['userID'] === $_SESSION['user']['userID'] ){
                                echo '  <button class="edit" title="You can\'t change your access rights" disabled></button>
                                        <button class="delete" title="You can\'t delete yourself" disabled></button>';
                            }else{
                                echo '  <button type="button" class="edit" onclick="edit_user('.$row['userID'].')" title="Change '.$row['username'].'\'s access rights"></button>
                                        <button class="delete" value="'.$row['userID'].'" name="delete_user_btn" title="Delete user '.$row['username'].'"></button>';
                            }
                    echo '</form></td></tr>';	
		}
		echo '</tbody></table></div>';
    }
    else{
		echo '<p id="info_text">No users ⚠️</p>';
	}
}else{
    echo "Error: " . mysqli_error($db);
}
?>