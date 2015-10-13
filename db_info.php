<?php

//create database connection
<<<<<<< HEAD
$db = new mysqli('localhost', 'root', 'AQR5rlyb5ipU', 'cloud_journal'); 
=======
$db = new mysqli('localhost', 'root', 'root', 'my_blog'); //ACA Local Environment
>>>>>>> 5496e9b012be2207e8742a17efe618e2912e8ae4

//connection error handler
if($db->connect_errno) {
    echo "Failed to connect to database.";
    echo $db->connect_error;
    exit();
}

//CLASS - POST
//  This class is used to describe each post created by the user.
//  See function grab_post()
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

//FUNCTION grab_post_tags($post_id)
//  Returns an array of tags that are associated with a specific $post_id
function grab_post_tags($post_id) {
    global $db;                             //include db connection in function
    $tag_array = array();                   //initialize return array
    $select_tag = $db->prepare('SELECT tags.id, tags.tag FROM tags, posts, posts_to_tags WHERE posts.id = posts_to_tags.post_id AND tags.id = posts_to_tags.tag_id AND posts.id = ?');
    $select_tag->bind_param('i', $post_id); //bind parameters to SELECT query
    $select_tag->execute();
    $select_tag->bind_result($id, $tag);
    while($select_tag->fetch()){            //loop through fetch object
        $tag_array[$id] = $tag;             //create a new key => value pair for each tag in result
    }
    $select_tag->close();                   //close query to open the session back up
    return $tag_array;
}

//FUNCTION grab_all_tags()
//  Creates a list of all tags that exist in the blog PER USER
function grab_all_tags() {
    global $db;                                     //include db connection in function
    $tag_array = array();                           //initialize return array
    $lg_query = 'SELECT tags.id, tags.tag ';
    $lg_query .= 'FROM posts, tags, posts_to_tags ';
    $lg_query .= 'WHERE posts.id = posts_to_tags.post_id ';
    $lg_query .= 'AND tags.id = posts_to_tags.tag_id ';
    $lg_query .= 'AND posts.author = ?';
    $grab_query = $db->prepare($lg_query);//prepare query
    $grab_query->bind_param('s', $_SESSION['user']);
    $grab_query->execute();
    $grab_query->bind_result($id, $tag);            //bind results
    while($grab_query->fetch()) {                   //loop through results with fetch
        $tag_array[$id] = $tag;                     //create a new key => value pair for each tag in result
    }
    $grab_query->close();                           //close query to open the session back up
    return $tag_array;
}
//FUNCTION grab_post($post_id)
//  For multiple site pages, a single post must be selected.
//  The posts.id key is passed through the function
//  This id number is used to select a table row with a MySQL query
//  This query is set up with the prepare->bind_param->execute() structure to combat malicious code
//  ->bind_result is used to add the results from SELECT to the $select_post object
//  $select_post->fetch() pulls the variables and uses them to create a new Post object.
//  The query is closed to make a new query available to be executed in the same session.
//  The function returns the new object
function grab_post($post_id) {
    global $db;                         //Include db connection in function
    $pTags = grab_post_tags($post_id);  //Grab the tags associated with the post using grab_post_tags()
    $gTags = grab_all_tags();           //Grabs global tags with grab_all_tags()
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

//FUNCTION add_tag_relationship($post_id, $tag_id)
//  adds a post/tag relationship with $post_id and $tag_id into the posts_to_tags table
function add_tag_relationship($post_id, $tag_id){
    global $db;
    $addRelationship = $db->prepare('INSERT INTO posts_to_tags (post_id, tag_id) VALUES (?, ?)');
    $addRelationship->bind_param('ii', $post_id, $tag_id);
    $addRelationship->execute();
}

//FUNCTION add_tag($post_id, $tag)
//  Creates a new tag in the tags table
//  Also adds a post/tag relationship using add_tag_relationship($post_id, $tag_id)
function add_tag($post_id, $tag) {
    global $db;
    $tag = strtolower($tag);        //make all tags lowercase
    //Insert tag into $db
    $addTag = $db->prepare('INSERT INTO tags (tag) VALUES (?)');
    $addTag->bind_param('s', $tag);
    $addTag->execute();
    $tagID = $db->insert_id;        //save the newest made tags.id using ->insert_id property
    //Add id's to post_to_tags
    add_tag_relationship($post_id, $tagID);
    return $tagID;                  //returns the newly created tag id
}

//FUNCTION remove_pTag($post_id, $tag_id)
//  Removes a relationship from posts_to_tags
//  DOES NOT remove anything from my_blog.posts or my_blog.tags.
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
    if($_POST['title'] == "" ||
        $_POST['contents'] == '' || $_POST['contents'] == 'Your post here...') {
        $failure = true;

        //  -Redirect back to edit_post.php?postid=...
        $loc = 'Location: edit_post.php?postid=' . $_POST['postid'];
        header($loc);
    } else {
        //  -Prepare statement to update post
        $update_post = $db->prepare('UPDATE posts SET title=?,date_mod=?,contents=? WHERE id=?');
        $up_date_mod= date('D, d M Y, H:i');
        $update_post->bind_param('sssi',$_POST['title'], $up_date_mod, $_POST['contents'], $_POST['postid']);
        $update_post->execute();

        //  -Redirect to view_post.php?id=...
        $loc = 'Location: view_post.php?postid=' . $_POST['postid'];
        header($loc);
