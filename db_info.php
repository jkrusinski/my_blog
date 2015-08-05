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
//  When a form is submitted with the key name 'add' for the submit variable,
//  First check that the form is filled out correctly (form validation)
//  If check passes, set up MySQL query to add row to the table 'posts'
//  Use ->prepare->bind_param->execute() to ensure no malicious code is passed.
//  If the add tag field is filled, execute tag functionality
//  After query is executed, redirect to the index.php page.
//  This is so that if a post is added successfully, you will be able to see it in the index
if(isset($_POST['add'])){
    //  -Form Validation
    if($_POST['title'] == "" || $_POST['author'] == "" ||
        $_POST['contents'] == '' || $_POST['contents'] == 'Your post here...') {
        $failure = true;
    } else {
        //  -Prepare statement
        $add_post = $db->prepare('INSERT INTO posts (title, author, date, date_mod, contents) VALUES (?, ?, ?, ?, ?)');
        //  -Create value variables
        $p_title = $_POST['title'];
        $p_author = $_POST['author'];
        $p_date = date('D, j M Y, H:i');
        $p_date_mod = $p_date;
        $p_contents = $_POST['contents'];
        //  -Bind parameters to query
        $add_post->bind_param('sssss', $p_title, $p_author, $p_date, $p_date_mod, $p_contents);
        //  -Execute
        $add_post->execute();

        //ADD TAG
        if($_POST['new_tag']) {
            //newest post is post to be saved with tag
            //save last post.id inserted into posts
            $post_id = $db->insert_id;

            //Insert tag into $db
            $add_tag = $db->prepare('INSERT INTO tags (tag) VALUES (?)');
            $tag_name = $_POST['new_tag'];
            $add_tag->bind_param('s', $tag_name);
            $add_tag->execute();
            //Add id's to post_to_tags
            $add_ids = $db->prepare('INSERT INTO posts_to_tags (post_id, tag_id) VALUES (?, ?)');
            //save last tag.id inserted into tags
            $tag_id = $db->insert_id;
            $add_ids->bind_param('ii', $post_id, $tag_id);
            $add_ids->execute();

            //
        }

        //  -Redirect to index.php
        header('Location: index.php');
    }
}

//SELECT POST
//  For the view_post.php page, a single post must be selected.
//  First a get variable is passed in the URL with the id number for the post wanted.
//  This id number is used to select a table row with a MySQL query
//  This query is set up with the prepare->bind_param->execute() structure to combat malicious code
//  ->bind_result is used to add the results from SELECT to the $select_post object
//  $select_post->fetch() pulls the variables declared in ->bind_result to be used in PHP
if(isset($_GET['id'])){
    //  -Prepare query
    $select_post = $db->prepare('SELECT title, author, date, date_mod, contents FROM posts WHERE id=?');
    //  -Bind Parameters
    $select_post->bind_param('i', $_GET['id']);
    //  -Execute
    $select_post->execute();
    //  -Bind Result
    $select_post->bind_result($title, $author, $date, $date_mod, $contents);
    //  -Fetch Results
    $select_post->fetch();
}

//EDIT POST
//  First the form is validated
//  For the edit_post.php WITH $_GET['id'] passed.
//  The id value in $_GET is included in the form under a hidden input.
//  The id value is used to select the specific post in MySQL
//  The new contents and metadata are added to the post with UPDATE
//  The page redirects to view_post.php?id=...
if(isset($_POST['edit'])) {
    //  -Form Validation
    if($_POST['title'] == "" || $_POST['author'] == "" ||
        $_POST['contents'] == '' || $_POST['contents'] == 'Your post here...') {
        $failure = true;
    } else {
        //  -Prepare statement
        $update_post = $db->prepare('UPDATE posts SET title=?,author=?,date_mod=?,contents=? WHERE id=?');
        //  -Create value variables
        $up_title = $_POST['title'];
        $up_author = $_POST['author'];
        $up_date_mod= date('D, j M Y, H:i');
        $up_contents = $_POST['contents'];
        $up_id = $_POST['id'];
        //  -Bind parameters
        $update_post->bind_param('ssssi',$up_title, $up_author, $up_date_mod, $up_contents, $up_id);
        //  -Execute
        $update_post->execute();

        //ADD TAG
        if($_POST['new_tag']) {
            //select post that should be involved with tag editing
            $post_id = $_POST['id'];

            //Insert tag into $db
            $add_tag = $db->prepare('INSERT INTO tags (tag) VALUES (?)');
            $tag_name = $_POST['new_tag'];
            $add_tag->bind_param('s', $tag_name);
            $add_tag->execute();
            //Add id's to post_to_tags
            $add_ids = $db->prepare('INSERT INTO posts_to_tags (post_id, tag_id) VALUES (?, ?)');
            //save last tag.id inserted into tags
            $tag_id = $db->insert_id;
            $add_ids->bind_param('ii', $post_id, $tag_id);
            $add_ids->execute();

        }

        //  -Redirect to view_post.php?id=...
        $loc = 'Location: view_post.php?id=' . $_POST['id'];
        header($loc);


    }
}

//DELETE POST FROM DATABASE
//  The form passes the id value which is used to delete the post
//  The DELETE query is prepared
//  After the parameters are bound, the query is executed
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

//SEARCH / LIST POSTS
//  Controls index.php
//  If search is set, query is prepared using SELECT WHERE and LIKE
//  Parameters are bound with the search term
//  Executed
//  Finally ->bind_result is used to retrieve results
//  If no search is entered, a simple SELECT query is prepared to list all posts
//  This is set up in a ->prepare->execute->bind_result formula to keep index.php HTML simple
//  ->fetch() is called in the index.php page
if (isset($_GET['search'])) {
    $get_posts = $db->prepare("SELECT * FROM posts WHERE contents LIKE ?");
    $p_search = "%" . $_GET['term'] . "%";
    $get_posts->bind_param('s', $p_search);
    $get_posts->execute();
    $get_posts->bind_result($id, $title, $author, $date, $date_mod, $contents);
} elseif (isset($index)) {
    $get_posts = $db->prepare('SELECT * FROM posts');
    $get_posts->execute();
    $get_posts->bind_result($id, $title, $author, $date, $date_mod, $contents);
}





