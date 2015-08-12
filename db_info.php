<?php

//create database connection
$db = new mysqli('localhost', 'root', 'root', 'my_blog');

//connection error handler
if($db->connect_errno) {
    echo "Failed to connect to database.";
    echo $db->connect_error;
    exit();
}

class Post {
    public $pID;
    public $pTitle;
    public $pAuthor;
    public $pDate;
    public $pMod;
    public $pBody;
    public $pTags; //an array... $pTags[tags.id => tags.tag]
    public $gTags; //an array... $gTags[tags.id => tags.tag]

    public function __construct($pID, $pTitle, $pAuthor, $pDate, $pMod, $pBody, $pTags, $gTags) {
        $this->pID = $pID;
        $this->pTitle = $pTitle;
        $this->pAuthor = $pAuthor;
        $this->pDate = $pDate;
        $this->pMod = $pMod;
        $this->pBody = $pBody;
        $this->pTags = $pTags;
        $this->gTags = $gTags;
    }
}

function grab_post_tags($post_id) {
    global $db;
    $tag_array = array();
    $select_tag = $db->prepare('SELECT tags.id, tags.tag FROM tags, posts, posts_to_tags WHERE posts.id = posts_to_tags.post_id AND tags.id = posts_to_tags.tag_id AND posts.id = ?');
    $select_tag->bind_param('i', $post_id);
    $select_tag->execute();
    $select_tag->bind_result($id, $tag);
    while($select_tag->fetch()){
        $tag_array[$id] = $tag;
    }
    $select_tag->close();
    return $tag_array;
}

function grab_all_tags() {
    global $db;
    $tag_array = array();
    $grab_query= $db->query('SELECT * FROM tags');
    foreach($grab_query as $row){
        $tag_array[$row['id']] = $row['tag'];
    }
    return $tag_array;
}
//todo SELECT POST comments
//  For the view_post.php page, a single post must be selected.
//  First a get variable is passed in the URL with the id number for the post wanted.
//  This id number is used to select a table row with a MySQL query
//  This query is set up with the prepare->bind_param->execute() structure to combat malicious code
//  ->bind_result is used to add the results from SELECT to the $select_post object
//  $select_post->fetch() pulls the variables declared in ->bind_result to be used in PHP
function grab_post($post_id) {
    global $db;
    $pTags = grab_post_tags($post_id);
    $gTags = grab_all_tags();
    //  -Prepare query
    $select_post = $db->prepare('SELECT title, author, date, date_mod, contents FROM posts WHERE id=?');
    //  -Bind Parameters
    $select_post->bind_param('i', $post_id);
    //  -Execute
    $select_post->execute();
    //  -Bind Result
    $select_post->bind_result($title, $author, $date, $date_mod, $contents);
    //  -Fetch Results
    $select_post->fetch();
    //Create post object
    $newPost = new Post($post_id, $title, $author, $date, $date_mod, $contents, $pTags, $gTags);
    //Close query
    $select_post->close();
    return $newPost;
}

//ADD TAG RELATIONSHIP
function add_tag_relationship($post_id, $tag_id){
    global $db;
    $addRelationship = $db->prepare('INSERT INTO posts_to_tags (post_id, tag_id) VALUES (?, ?)');
    $addRelationship->bind_param('ii', $post_id, $tag_id);
    $addRelationship->execute();
}

//todo function add_tag comments
function add_tag($post_id, $tag) {
    global $db;
    $tag = strtolower($tag);
    //Insert tag into $db
    $addTag = $db->prepare('INSERT INTO tags (tag) VALUES (?)');
    $addTag->bind_param('s', $tag);
    $addTag->execute();
    $tagID = $db->insert_id;
    //Add id's to post_to_tags
    add_tag_relationship($post_id, $tagID);
    return $tagID;
}

function remove_pTag($post_id, $tag_id) {
    global $db;
    $delTag = $db->prepare('DELETE FROM posts_to_tags WHERE post_id = ? AND tag_id = ?');
    $delTag->bind_param('ii', $post_id, $tag_id);
    $delTag->execute();
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
        //  -Prepare statement to update post
        $update_post = $db->prepare('UPDATE posts SET title=?,author=?,date_mod=?,contents=? WHERE id=?');
        $up_date_mod= date('D, j M Y, H:i');
        $update_post->bind_param('ssssi',$_POST['title'], $_POST['author'], $up_date_mod, $_POST['contents'], $_POST['id']);
        $update_post->execute();

        //  -Redirect to view_post.php?id=...
        $loc = 'Location: view_post.php?postid=' . $_POST['id'];
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







