<?php

//connect to database
include_once('db_info.php');

?>

<!DOCTYPE html>
<html>
    <head>
        <title>Edit Post</title>
        <link href="style.css" rel="stylesheet" type="text/css">
    </head>
    <body>
        <?php $post = grab_post($_GET['postid']); ?>
        <form action ="edit_post.php" method="post" id="form-edit">
            <label>Title: <input type="text" name="title" value="<?php echo $post->pTitle; ?>"></label><br>
            <label>Author: <input type="text" name="author" value="<?php echo $post->pAuthor; ?>"></label><br>
            <textarea name="contents" rows="10" cols="30"><?php echo $post->pBody; ?></textarea><br>


            <!--TAG BOX-->
            <!--Prints values of pTags into individual buttons-->
            <h3>Tags:</h3>
            <div id="tag_box">
                <?php
                if (isset($post)){ //if edit_post.php... send postID number
                    //Loop through post->pTags
                    //echo span elements for each tag, format:
                    //<span class='tag' id='pTag#'>value</span>
                    foreach($post->pTags as $key => $value){
                        echo "<span class='tag visible' id='pTag" . $key . "'>" . $value . "</span>";
                    }
                }
                ?>
            </div>

            <!--SUGGESTION DROP DOWN-->
            <!--Prints values of gTags into a drop down list-->
            <label>Enter New Tag: <br />
                <input type="text" name="new-tag" id="new-tag" class="key-sensitive" autocomplete="off"/></label><br />
            <ul id="suggestions" class="hidden">
                <?php
                //Loop through $post->gTags
                //echo <li> elements for each tag, format:
                //<li><a href='#' id='gTag#'>value</a></li>
                foreach($post->gTags as $key => $value){
                    echo "<li><a href='#' class='gTag key-sensitive' id='gTag$key'>$value</a></li>";
                }
                ?>
            </ul>
            <input type="hidden" name="post-id" id="post-id" value="<?php echo $post->pID;//pass postID to js ?>">


            <input type="submit" name="edit" id="edit-submit" value="Update">
            <input type="hidden" name="id" value="<?php echo $post->pID; ?>">
        </form>

        <?php
        if (isset($failure)) {
            echo "<p>Please make sure all fields are entered correctly</p>";
        }
        ?>
        <script src="jquery-1.11.3.js" type="text/javascript"></script>
        <script src="app.js" type="text/javascript"></script>
    </body>
</html>
