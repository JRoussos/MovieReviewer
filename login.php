<?php include('functions.php') ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Login | Movie Reviewer</title>
        <link rel="stylesheet" href="styles/login.css">    
    </head>
    <body> 
        <div class="wrapper">
            <div id="formContent">
                <form id="form_id" action="login.php" method="POST"> 
                    <div id="username_wrapper" class="input_wrapper">
                        <input id="username_input_id" class="input" type="text" name="username" placeholder="Username" required>
                    </div>

                    <div id="password_wrapper" class="input_wrapper">
                        <input id="password_input_id" class="input" type="password" name="password" placeholder="Password" required>
                    </div>
                    <input type="submit" class="fadeIn" name="login_btn" value="Login">
                    <p>
                        <a href="register.php">You dont have an account? Sign In</a>
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
