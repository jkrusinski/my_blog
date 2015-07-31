<?php

//Connect to database
include_once('db_info.php');

?>

<!DOCTYPE html>
<html>
    <head>
        <title>My Blog</title>
        <meta charset="utf-8">
    </head>
    <body>
        <form action="index.php" method="get">
            <label>Search <input type="text" name="term"></label>
            <input type="submit" name="search" value="Go">
        </form>
        <table>
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Author</th>
                    <th>Date Added</th>
                    <th>Date Modified</th>
                    <th>Preview</th>
                    <th></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
            <?php
                while($get_posts->fetch()){ ?>
                    <tr>
                        <td><?php echo $title; ?></td>
                        <td><?php echo $author; ?></td>
                        <td><?php echo $date; ?></td>
                        <td><?php echo $date_mod; ?></td>
                        <td><?php
                            $preview = substr($contents, 0, 99);
                            echo $preview;
                            if (strlen($contents) > 100) {
                                echo '...';
                            }
                            ?>
                        </td>
                        <td>
                            <form action="index.php" method="post">
                                <input type="submit" name="delete" value="DELETE">
                                <input type="hidden" name="id" value="<?php echo $id; ?>">
                            </form>
                        </td>
                        <td>
                            <a href="view_post.php?id=<?php echo $id; ?>">View</a>
                        </td>
                    </tr>
            <?php } ?>
            </tbody>
        </table>
        <a href="index.php">Home</a>
        <a href="edit_post.php">Add New Post</a>
    </body>
</html>
