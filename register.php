<?php include('functions.php') ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Sign in | Movie Reviewer</title>
        <link rel="stylesheet" href="styles/login.css">    
    </head>
    <body> 
        <div class="wrapper">
            <div id="formContent">
                <form id="form_id" action="register.php" method="POST"> 
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
                    <input type="submit" class="fadeIn" name="register_btn" value="Register">  
                    <p>
                        <a href="login.php">You have an account already? Sign in</a>
                    </p> 
                    <?php echo display_error(); ?>
                </form>
            </div>
        </div>
        <div class="guest_promt">
            <p>Try out the site, get a taste of what we do 😉</p>
            <p><a href="user/guest.php">Browse as a guest</a></p>
        </div>
    </body>
</html>
