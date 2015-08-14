<?php

//connect to database
include_once('db_info.php');

$viewPost = grab_post($_GET['postid']);

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>View Post</title>
        <!--Bootstrap-->
        <link href="bootstrap/css/bootstrap.css" rel="stylesheet" />
        <!--Customizable Stylesheet-->
        <link href="style.css" type="text/css" rel="stylesheet" />
    </head>
    <body>
        <div class="panel panel-default" id="view-panel">
            <div class="panel-heading">
                <h1 class="panel-title">Entry</h1>
            </div>
            <div class="panel-body">
                <h1><?php echo $viewPost->pTitle; ?><br /><small>By <?php echo $viewPost->pAuthor; ?></small></h1>
                <h5>Date Created: <small><?php echo $viewPost->pDate; ?></small></h5>
                <h5>Date Modified: <small><?php echo $viewPost->pMod; ?></small></h5>
                <p><?php echo $viewPost->pBody; ?></p>
                <h5>Tags:</h5>
                <ul style="padding: 0;">
                <?php
                foreach($viewPost->pTags as $i){ ?>
                    <li class="btn btn-default"><?php echo $i; ?></li>
                <?php } ?>
                </ul>
            </div>
            <div class="panel-footer">
                <a href="index.php" class="btn btn-primary">Home</a>
                <a href="edit_post.php?postid=<?php echo $_GET['postid']; ?>" class="btn btn-default pull-right">Edit</a>
            </div>
        </div>


        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="bootstrap/js/bootstrap.min.js"></script>
        <!-- Include app.js -->
        <script src="app.js" type="text/javascript"></script>
    </body>
</html>
