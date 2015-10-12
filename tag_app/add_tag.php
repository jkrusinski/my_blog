<?php

include_once('../db_info.php');
session_start();

//todo if tag added from two different accounts, duplicate will be made

//set variables
$postID =  $_GET['postid'];
$tagID = $_GET['tagid'];
$tag = strtolower($_GET['tag']);  //make lowercase to ensure no duplicates
$post = grab_post($postID);       //create $post object

/*
 * XML STRUCTURE
 * <tag>
 *     <status></status>
 *     <tag_id></tag_id>
 *     <tag_body></tag_body>
 * </tag>
 */

//XML declaration
header('Content-type: text/xml');   //make this an XML file
echo '<?xml version="1.0" encoding="utf-8"?>';
echo '<tag>';                       //root element

//ADD NEW TAG (if focus was on <input id='new-tag'>)
if($tagID == 'new-tag'){
    $dupCheck = array_search($tag, $post->gTags);   //Duplicate Check: searches for tag in $posts->gTags (global)
    if($tag == '') {                                //if tag is blank, do nothing
        echo '<status>Tag field empty.</status>';   //update <status>
    }
    else if($dupCheck) {                            //if Duplicate was returned
        if(isset($post->pTags[strval($dupCheck)])) {//if duplicate already exists in post
            echo '<status>Tag already exists in post.</status>';//update status
        } else {                                    //if tag does not already exist in post
            add_tag_relationship($postID, $dupCheck);                                   //add relationship
            echo "<status>Existing tag added.</status><tag_id>$dupCheck</tag_id>";      //update status, tag_id
            echo "<tag_body>$tag</tag_body>";                                           //update tag_body
        }
    }
    else {                                                      //otherwise create new tag
        $newID = add_tag($postID, $tag);
        echo "<status>New tag added.</status>";                 //update status
        echo "<tag_id>$newID</tag_id><tag_body>$tag</tag_body>";//update tag_id, tag_body
    }
}

//ADD OLD TAG (if focus was on <a>)
else {
    $tagID = substr($tagID, 4);                                 //get id in int format (splice pTag# -> #)
    if(isset($post->pTags[$tagID])) {                           //if tag already exists in post
        echo "<status>Tag already exists in post.</status>";    //update status
    } else {
        add_tag_relationship($postID, $tagID);                  //add relationship
        echo "<status>Existing tag added.</status><tag_id>$tagID</tag_id>";
        echo "<tag_body>$tag</tag_body>";                       //update status, tag_id, tag_body
    }

}
//close root element
echo '</tag>';