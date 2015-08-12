<?php
include_once('db_info.php');

//  -Prepare statement
$add_post = $db->prepare('INSERT INTO posts (title, author, date, date_mod, contents) VALUES (NULL, NULL, ?, ?, NULL)');
$p_date = date('D, j M Y, H:i');
//  -Bind parameters to query
$add_post->bind_param('ss', $p_date, $p_date);
//  -Execute
$add_post->execute();

$redirect = 'Location: edit_post.php?postid=' . $db->insert_id;
//  -Redirect to index.php
header($redirect);
