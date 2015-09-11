<?php
//open $session
session_start();
//if user is not logged in, go to login index
if(!isset($_SESSION['user'])) {
    header('Location: user/login.php');
}

include_once('db_info.php');

//  -Prepare statement
$add_post = $db->prepare('INSERT INTO posts (title, author, date, date_mod, contents) VALUES (?, ?, ?, ?, ?)');
$title = "New Post";
$date = date('D, j M Y, H:i');
//  -Get username
$usr = $_SESSION['user'];
$contents = "Your post goes here...";
//  -Bind parameters to query
$add_post->bind_param('sssss', $title, $usr, $date, $date, $contents);
//  -Execute
$add_post->execute();

$redirect = 'Location: edit_post.php?postid=' . $db->insert_id;
//  -Redirect to index.php
header($redirect);