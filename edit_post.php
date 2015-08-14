<?php

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
        <link href="bootstrap/css/bootstrap.css" rel="stylesheet" />
        <!--Customizable Stylesheet-->
        <link href="style.css" type="text/css" rel="stylesheet" />
    </head>
    <body>
        <div class="panel panel-default" id="edit-panel">
            <form action ="edit_post.php" method="post" id="form-edit" class="form-horizontal">
                <!--Title Input-->
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="input-title">Title</label>
                    <div class="col-sm-10">
                        <input type="text" name="title" value="<?php echo $post->pTitle; ?>" class="form-control" id="input-title">
                    </div>
                </div>

                <!-- Author Input -->
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="input-author">Author</label>
                    <div class="col-sm-10">
                        <input type="text" name="author" value="<?php echo $post->pAuthor; ?>" class="form-control" id="input-author">
                    </div>
                </div>

                <!-- Body Input -->
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="input-body">Body</label>
                    <div class="col-sm-10">
                        <textarea name="contents" class="form-control" id="input-body" rows="4"><?php echo $post->pBody; ?></textarea>
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
                                if (isset($post)){ //if edit_post.php... send postID number
                                    //Loop through post->pTags
                                    //echo span elements for each tag, format:
                                    //<span class='tag' id='pTag#'>value</span>
                                    foreach($post->pTags as $key => $value){
                                        echo "<span class='tag visible btn btn-info' id='pTag" . $key . "'>" . $value . "</span>";
                                    }
                                }
                                ?>
                            </div>
                        </div>
                        <!--SUGGESTION DROP DOWN-->
                        <!--Prints values of gTags into a drop down list-->
                        <div class="input-group">
                            <span class="input-group-addon" id="new-tag-label">Add New Tag</span>
                            <input type="text" name="new-tag" id="new-tag" class="key-sensitive form-control" aria-describedby="new-tag-label" autocomplete="off"/>
                        </div>
                        <div class="panel panel-default hidden" id="suggestions">
                            <ul id="suggestions-list" class="list-group">
                                <?php
                                //Loop through $post->gTags
                                //echo <li> elements for each tag, format:
                                //<li><a href='#' id='gTag#'>value</a></li>
                                foreach($post->gTags as $key => $value){
                                    echo "<li><a href='#' class='gTag key-sensitive list-group-item' id='gTag$key'>$value</a></li>";
                                }
                                ?>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="form-group">
                    <span class="col-sm-2">&nbsp</span>
                    <div class="col-sm-10">
                        <input type="hidden" name="postid" id="post-id" value="<?php echo $post->pID;//pass postID to js ?>">
                        <input type="submit" name="edit" id="edit-submit" value="Update" class="btn btn-default">
                    </div>
                </div>

            </form>
        </div>

        <?php
        if (isset($failure)) {
            echo "<p>Please make sure all fields are entered correctly</p>";
        }
        ?>
        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="bootstrap/js/bootstrap.min.js"></script>
        <!-- Include app.js -->
        <script src="app.js" type="text/javascript"></script>
    </body>
</html>
