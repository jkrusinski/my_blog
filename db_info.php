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



