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
    //  -Form Validation
    if($_POST['title'] == "" || $_POST['author'] == "" ||
        $_POST['contents'] == '' || $_POST['contents'] == 'Your post here...') {
        $failure = true;
    } else {
        //  -Prepare statement
        $add_post = $db->prepare('INSERT INTO posts (title, author, date, contents) VALUES (?, ?, ?, ?)');
        //  -Create value variables
        $p_title = $_POST['title'];
        $p_author = $_POST['author'];
        $p_date = date('D, j M Y, H:i');
        $p_contents = $_POST['contents'];
        //  -Bind parameters to query
        $add_post->bind_param('ssss', $p_title, $p_author, $p_date, $p_contents);
        //  -Execute
        $add_post->execute();
        //  -Redirect to index.php
        header('Location: index.php');
    }
}

//SELECT POST
if(isset($_GET['id'])){
    //  -Prepare query
    $select_post = $db->prepare('SELECT title, author, date, contents FROM posts WHERE id=?');
    //  -Bind Parameters
    $select_post->bind_param('i', $_GET['id']);
    //  -Execute
    $select_post->execute();
    //  -Bind Result
    $select_post->bind_result($title, $author, $date, $contents);
    //  -Fetch Results
    $select_post->fetch();
}

//EDIT POST
if(isset($_POST['edit'])) {
    //  -Form Validation
    if($_POST['title'] == "" || $_POST['author'] == "" ||
        $_POST['contents'] == '' || $_POST['contents'] == 'Your post here...') {
        $failure = true;
    } else {
        //  -Prepare statement
        //  -todo: add date modified
        $update_post = $db->prepare('UPDATE posts SET title=?,author=?,contents=? WHERE id=?');
        //  -Create value variables
        $up_title = $_POST['title'];
        $up_author = $_POST['author'];
        $up_contents = $_POST['contents'];
        $up_id = $_POST['id'];
        //  -Bind parameters
        $update_post->bind_param('sssi',$up_title, $up_author, $up_contents, $up_id);
        //  -Execute
        $update_post->execute();
        //  -Redirect to view_post.php?id=...
        $loc = 'Location: view_post.php?id=' . $_POST['id'];
        header($loc);


    }
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





