<?php

//connect to database
include_once('db_info.php');

$viewPost = grab_post($_GET['postid']);

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
                <h1><?php echo $viewPost->pTitle; ?></h1>
                <h3>By <?php echo $viewPost->pAuthor; ?></h3>
                <h3>Date Created <?php echo $viewPost->pDate; ?></h3>
                <h3>Date Modified <?php echo $viewPost->pMod; ?></h3>
                <p><?php echo $viewPost->pBody; ?></p>
                <ul>
                <?php
                foreach($viewPost->pTags as $i){ ?>
                    <li><?php echo $i; ?></li>
                <?php } ?>
                </ul>
            </div>
        </div>
        <a href="index.php">Home</a>
        <a href="edit_post.php?postid=<?php echo $_GET['postid']; ?>">Edit</a>
    </body>
</html>
