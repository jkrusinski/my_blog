<?php

//connect to database
include_once('db_info.php');

?>

<!DOCTYPE html>
<html>
    <head>
        <title>View Post</title>
        <meta charset="utf-8">
    </head>
    <body>
        <div class="outer">
            <div class="inner">
                <h1><?php echo $title; ?></h1>
                <h3>By <?php echo $author; ?></h3>
                <h3>Created <?php echo $date; ?></h3>
                <p><?php echo $contents; ?></p>
            </div>
        </div>
        <a href="index.php">Home</a>
        <a href="edit_post.php?id=<?php echo $_GET['id'] ?>">Edit</a>
    </body>
</html>
