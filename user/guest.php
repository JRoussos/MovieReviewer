<?php include('../functions.php');
if (isAdmin()) {
	header('location: ..user/admin.php');
}else if(isLoggedIn()) {
    header('location: ..user/user.php');
}?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home | Movie Reviewer</title>
    <link rel="stylesheet" href="../styles/home.css">
    <link rel="stylesheet" href="../styles/guest.css">
    <script src='https://cdn.jsdelivr.net/npm/lodash@4.17.10/lodash.min.js'></script>
    <script type='text/javascript' src='../scripts/config.js'></script>
    <script type='text/javascript' src='../scripts/functions.js'></script>
    <script type='text/javascript' src='../scripts/clicks.js'></script>
</head>
<body>
    <main>
        <section class="content">
            <div class="content_wrapper">
                <div class="flex">
                    <div class="search_bar">
                        <div id="clear" onclick="clear_searchbar()"/></div>
                        <input id="input_field" 
                            type="text" name="search"
                            oninput="debounce_search(this.value)"
                            placeholder="Search for a movie, series or an episode.."/>
                    </div>
                </div>

                <div style="width: 100%; position: relative;">
                    <div id="search_results"></div>
                </div>

                <div id="included">
                    <div class="login_promt">
                        <p>Enjoy the full experience of our site by signing up</p>
                        <p><a href="../register.php">Go to the register page</a></p>
                    </div>
                    <?php if (isset($_GET['id'])) { include('../views/details.php'); } ?>
                </div>
            </div>
        </section>

    </main>
</body>
</html>