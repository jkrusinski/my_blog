<?php

//connect to database
include_once('db_info.php');

?>

<!DOCTYPE html>
<html>
    <head>
        <title>Edit Post</title>
    </head>
    <body>

        <!--New Post-->
        <form action="edit_post.php" method="post">

            <?php
            if (isset($_GET['id'])) { ?>
                <label>Title: <input type="text" name="title" value="<?php echo $title; ?>"></label><br>
                <label>Author: <input type="text" name="author" value="<?php echo $author; ?>"></label><br>
                <textarea name="contents" rows="10" cols="30"><?php echo $contents; ?></textarea><br>
                <label>Add Tag: <input type="text" name="new_tag"></label><br>
                <input type="submit" name="edit" value="Update">
                <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>">
            <?php } else { ?>
                <label>Title: <input type="text" name="title"></label><br>
                <label>Author: <input type="text" name="author"></label><br>
                <textarea name="contents" rows="10" cols="30">Enter your post here...</textarea><br>
                <label>Add Tag: <input type="text" name="new_tag"></label><br>
                <input type="submit" name="add" value="Post">
            <?php } ?>

        </form>


        <?php
        if (isset($failure)) {
            echo "<p>Please make sure all fields are entered correctly</p>";
        }
        ?>

    </body>
</html>
