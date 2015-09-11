<?php
include_once('db_info.php');
session_start();
//DELETE POST FROM DATABASE
//  The form passes the id value which is used to delete the post
//  The DELETE query is prepared
//  After the parameters are bound, the query is executed
if(isset($_GET['postid'])){
    //  -Prepare statement
    $delete_post = $db->prepare('DELETE FROM posts WHERE id=?');
    //  -Create value variables
    $p_id = $_GET['postid'];
    //  -Bind parameters to query
    $delete_post->bind_param('i', $p_id);
    //  -Execute
    $delete_post->execute();
}

header('Location: index.php');