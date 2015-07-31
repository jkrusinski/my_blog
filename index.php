<?php

//Connect to database
include_once('db_info.php');

//ACCESS DATABASE DATA
//  -Prepare query statement
$get_posts = $db->query('SELECT * FROM posts');

?>

<!DOCTYPE html>
<html>
    <head>
        <title>My Blog</title>
        <meta charset="utf-8">
    </head>
    <body>
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
            foreach($get_posts as $row) { ?>
                <tr>
                    <td><?php echo $row['title']; ?></td>
                    <td><?php echo $row['author']; ?></td>
                    <td><?php echo $row['date']; ?></td>
                    <td><?php echo $row['date_mod']; ?></td>
                    <td><?php
                        $preview = substr($row['contents'], 0, 99);
                        echo $preview;
                        if (strlen($row['contents']) > 100) {
                            echo '...';
                        }
                        ?>
                    </td>
                    <td>
                        <form action="index.php" method="post">
                            <input type="submit" name="delete" value="DELETE">
                            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                        </form>
                    </td>
                    <td>
                        <a href="view_post.php?id=<?php echo $row['id']; ?>">View</a>
                    </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
        <a href="edit_post.php">Add New Post</a>
    </body>
</html>
