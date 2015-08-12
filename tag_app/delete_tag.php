<?php
//Delete tag from post

include_once('../db_info.php');

$postID = $_GET['postid'];
$tagID = $_GET['tagid'];

//remove tag relationship from posts_to_tags
remove_pTag($postID, $tagID);

echo 'Tag removed.';
