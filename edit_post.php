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
    <title>Edit Post</title>
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

                    </div>
                </div>
            </nav>
        </div>
        <div class="hidden-xs col-sm-2 col-md-3">&nbsp</div>
    </div>

    <div class="row">

        <div class="hidden-xs col-sm-2 col-md-3">&nbsp</div>
        <div class="col-xs-12 col-sm-8 col-md-6">

            <form action="edit_post.php" method="post" id="form-edit" class="form-horizontal">
                <div class="panel panel-info" id="edit-panel">
                    <div class="panel-heading"><h1 class="panel-title">Edit Entry</h1></div>
                    <div class="panel-body">
                        <!--Title Input-->
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="input-title">Title</label>

                            <div class="col-sm-10">
                                <input type="text" name="title" value="<?php echo $post->pTitle; ?>"
                                       class="form-control" id="input-title" autocomplete="off">
                            </div>
                        </div>

                        <!-- Body Input -->
                        <!-- todo use nl2br() for body to format post correctly -->
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="input-body">Body</label>

                            <div class="col-sm-10">
                                <textarea name="contents" class="form-control" id="input-body"
                                          rows="4"><?php echo $post->pBody; ?></textarea>
                            </div>
                        </div>

                        <!-- Tag Controls -->
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Tags</label>

                            <div class="col-sm-10">
                                <!--TAG BOX-->
                                <!--Prints values of pTags into individual buttons-->
                                <div class="panel panel-default">
                                    <div id="tag_box" class="panel-body">
                                        <?php
                                        if (isset($post)) { //if edit_post.php... send postID number
                                            //Loop through post->pTags
                                            //echo span elements for each tag, format:
                                            //<span class='tag' id='pTag#'>value</span>
                                            foreach ($post->pTags as $key => $value) {
                                                echo "<span class='tag visible btn btn-default' id='pTag$key'>";
                                                echo "$value</span>";
                                            }
                                        }
                                        ?>
                                    </div>
                                </div>
                                <!--SUGGESTION DROP DOWN-->
                                <!--Prints values of gTags into a drop down list-->
                                <div id="suggestions-app">
                                    <div class="input-group">
                                        <span class="input-group-addon" id="new-tag-label">Add New Tag</span>
                                        <input type="text" name="new-tag" id="new-tag"
                                               class="key-sensitive form-control" aria-describedby="new-tag-label"
                                               autocomplete="off"/>
                                    </div>
                                    <div class="panel panel-default hidden" id="suggestions">
                                        <ul id="suggestions-list" class="list-group">
                                            <?php
                                            //Loop through $post->gTags
                                            //echo <li> elements for each tag, format:
                                            //<li><a href='#' id='gTag#'>value</a></li>
                                            foreach ($post->gTags as $key => $value) {
                                                echo "<li><a href='#' class='gTag key-sensitive list-group-item'";
                                                echo " id='gTag$key'>$value</a></li>";
                                            }
                                            ?>
                                        </ul>
                                    </div>
                                </div>
                                <input type="hidden" name="postid" id="post-id"
                                       value="<?php echo $post->pID;//pass postID to js ?>">
                                <input type="hidden" name="edit">
                                <?php
                                if (isset($failure)) {
                                    echo "<p>Please make sure all fields are entered correctly</p>";
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="panel-footer">
                        <!-- Cancel Button -->
                        <button class="btn btn-danger" type="button" id="edit-cancel">
                            <span class="glyphicon glyphicon-remove-sign" aria-hidden="true"></span> Cancel
                        </button>
                        <!-- Submit Button -->
                        <button type="submit" class="btn btn-success">
                            <span class="glyphicon glyphicon-ok-sign" aria-hidden="true"></span> Save
                        </button>
                    </div>
                </div>
            </form>

        </div>
        <div class="hidden-xs col-sm-2 col-md-3">&nbsp</div>

    </div>
</div>


<div id="cancel-edit-warning" class="hidden">
    <div class="panel panel-danger col-xs-10 col-sm-4">
        <div class="panel-heading"><h1 class="panel-title">WARNING</h1></div>
        <div class="panel-body">
            Any changes you have made will not be saved. Are you sure you want to cancel editing this entry?
        </div>
        <div class="panel-footer">
            <button class="btn btn-danger delete" data-postid="<?php echo $_GET['postid']; ?>" id="confirm-cancel">I'm
                sure
            </button>
            <button class="btn btn-default pull-right" id="cancel-cancel">Nevermind</button>
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
