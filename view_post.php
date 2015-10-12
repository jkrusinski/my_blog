<?php
//open $session
session_start();
//if user is not logged in, go to login index
if (!isset($_SESSION['user'])) {
    header('Location: user/login.php');
}

//connect to database
include_once('db_info.php');

$post = grab_post($_GET['postid']);

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>View Post</title>

    <!--Bootstrap-->
    <link href="bootstrap/css/bootstrap.css" rel="stylesheet"/>
    <!--Customizable Stylesheet-->
    <link href="style.css" type="text/css" rel="stylesheet"/>
</head>
<body>
<div class="container">

    <div class="row">
        <div class="hidden-xs col-sm-2 col-md-3">&nbsp</div>
        <div class="col-xs-12 col-sm-8 col-md-6">

            <nav class="navbar navbar-default">
                <div class="container-fluid">
                    <!-- Brand and toggle get grouped for better mobile display -->
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                                data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a class="navbar-brand" href="#">Cloud Journal</a>
                    </div>
                    <!-- Collect the nav links, forms, and other content for toggling -->
                    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">

                        <p class="navbar-text hidden-sm">
                            <span class="glyphicon glyphicon-user" aria-hidden="true"></span>
                            <?php echo $_SESSION['user']; ?>
                        </p>

                        <ul class="nav navbar-nav hidden-sm">
                            <li><a href="user/logout.php">Logout</a></li>
                        </ul>

<!--                        <form action="index.php" method="get" class="navbar-form navbar-right" role="search">-->
<!--                            <div class="form-group">-->
<!--                                <input type="text" class="form-control" placeholder="Search" name="term">-->
<!--                            </div>-->
<!--                            <button type="submit" class="btn btn-default">Submit</button>-->
<!--                            <input type="hidden" name="search">-->
<!--                        </form>-->

                    </div>
                </div>
            </nav>

        </div>
        <div class="hidden-xs col-sm-2 col-md-3">&nbsp</div>

    </div>

    <!--todo - make this page more readable -->

    <div class="row">
        <div class="hidden-xs col-sm-2 col-md-3">&nbsp</div>
        <div class="col-xs-12 col-sm-8 col-md-6">
            <div class="panel panel-info" id="view-panel">
                <div class="panel-heading">
                    <h1 class="panel-title">Entry</h1>
                </div>
                <div class="panel-body">
                    <h1><?php echo $post->pTitle; ?><br/>
                        <small>By <?php echo $post->pAuthor; ?></small>
                    </h1>
                    <h5>Date Created:
                        <small><?php echo $post->pDate; ?></small>
                    </h5>
                    <?php
                    if ($post->pMod != '') { ?>
                        <h5>Date Modified:
                            <small><?php echo $post->pMod; ?></small>
                        </h5>
                    <?php } ?>

                    <div class="panel panel-default">
                        <div class="panel-body">
                            <?php echo $post->pBody; ?>
                        </div>
                    </div>

                    <h5>Tags:</h5>
                    <ul id="view-tags">
                        <?php
                        foreach ($post->pTags as $i) { ?>
                            <li class="btn btn-default"><?php echo $i; ?></li>
                        <?php } ?>
                    </ul>
                </div>
                <div class="panel-footer">

                    <!-- Delete Button -->
                    <button class="btn btn-danger post-delete" data-post-id="<?php echo $post->pID; ?>">
                        <span class="glyphicon glyphicon-trash" aria-hidden="true"></span> Delete
                    </button>

                    <!-- Edit Button -->
                    <a href="edit_post.php?postid=<?php echo $post->pID; ?>" class="btn btn-warning">
                        <span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Edit
                    </a>

                    <!-- Home Button -->
                    <a href="index.php" class="btn btn-primary pull-right">
                        <span class="glyphicon glyphicon-home" aria-hidden="true"></span> Home
                    </a>

                </div>
            </div>
        </div>
        <div class="hidden-xs col-sm-2 col-md-3">&nbsp</div>
    </div>
</div>


<div id="delete-warning" class="hidden">
    <div class="panel panel-danger col-xs-10 col-sm-4">
        <div class="panel-heading"><h1 class="panel-title">WARNING</h1></div>
        <div class="panel-body">
            Are you sure you want to delete this post? This change is permanent and cannot be undone.
        </div>
        <div class="panel-footer">
            <button class="btn btn-danger delete" id="deleteID">I'm sure</button>
            <button class="btn btn-default pull-right" id="nevermind">Nevermind</button>
        </div>
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
