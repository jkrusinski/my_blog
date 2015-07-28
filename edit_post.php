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
        <form action="index.php" method="post">

            <label>Title: <input type="text" name="title"></label><br>
            <label>Author: <input type="text" name="author"></label><br>
            <textarea name="contents" rows="10" cols="30" class="wide">Your post here...</textarea><br>
            <input type="submit" name="add" value="Post">

        </form>

    </body>
</html>
