<?php

//create database connection
$db = new mysqli('localhost', 'root', 'root', 'my_blog');

//connection error handler
if($db->connect_errno) {
    echo "Failed to connect to database.";
    echo $db->connect_error;
    exit();
}

//ADD POST TO DATABASE
if(isset($_POST['add'])){
    //  -Prepare statement
    $add_post = $db->prepare('INSERT INTO posts (title, author, date, contents) VALUES (?, ?, ?, ?)');
    //  -Create value variables
    $p_title = $_POST['title'];
    $p_author = $_POST['author'];
    $p_date = date('D, j M Y');
    $p_contents = $_POST['contents'];
    //  -Bind parameters to query
    $add_post->bind_param('ssss', $p_title, $p_author, $p_date, $p_contents);
    //  -Execute
    $add_post->execute();
}

//DELETE POST FROM DATABASE
if(isset($_POST['delete'])){
    //  -Prepare statement
    $delete_post = $db->prepare('DELETE FROM posts WHERE id=?');
    //  -Create value variables
    $p_id = $_POST['id'];
    //  -Bind parameters to query
    $delete_post->bind_param('i', $p_id);
    //  -Execute
    $delete_post->execute();
}

//ACCESS DATABASE DATA
//  -Prepare query statement
$get_posts = $db->query('SELECT * FROM posts');

//todo 404 page




