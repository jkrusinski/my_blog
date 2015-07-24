<?php

//create database connection
$db = new mysqli('localhost', 'root', 'root', 'my_blog');

//connection error handler
if($db->connect_errno) {
    echo "Failed to connect to database.";
    echo $db->connect_error;
    exit();
}

//todo 404 page




