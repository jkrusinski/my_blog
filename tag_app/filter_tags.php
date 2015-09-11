<?php
include_once('../db_info.php');
session_start();

$filter = $_GET['filter'];

$gTags = grab_all_tags();
$len = strlen($filter);

/*
 *  XML STRUCTURE
 *  <suggestions>
 *      <in_filter>
 *          <tag_id></tag_id>
 *          ...
 *          <tag_id></tag_id>
 *      </in_filter>
 *      <ex_filter>
 *          <tag_id></tag_id>
 *          ...
 *          <tag_id></tag_id>
 *      </ex_filter>
 */

//XML declaration
header("Content-type: text/xml");
echo "<?xml version='1.0' encoding='utf-8'?>";  //doctype
echo "<suggestions>";                           //root tag


echo "<in_filter>";
//loop through tags
foreach($gTags as $key => $value){
    if(substr($value, 0, $len) == $filter){
        echo "<tag_id>$key</tag_id>";
    }
}
echo "</in_filter>";
echo "<ex_filter>";
//loop through tags
foreach($gTags as $key => $value){
    if(substr($value, 0, $len) != $filter){
        echo "<tag_id>$key</tag_id>";
    }
}

echo "</ex_filter>"; //
echo "</suggestions>"; //close root tag


