var main = function () {

    /***********************************************
     ******************* GLOBALS *******************
     ***********************************************/

    //  Jquery object globals
    var $new_tag = $('#new-tag');                   //edit_post.php
    var $suggestions = $('#suggestions');           //edit_post.php
    var $suggestions_app = $('#suggestions-app');   //edit_post.php
    var $tag_box = $('#tag_box');                   //edit_post.php
    var $delete = $('.delete');                     //index.php, final delete button
    var $delete_warning = $('#delete-warning');     //index.php, delete-warning
    var $cancel_edit_warning = $('#cancel-edit-warning');//edit_post.php
    //  page values
    var postID = $('#post-id').val();               //edit_post.php

    /*************************************************
     ******************* FUNCTIONS *******************
     *************************************************/

    //  Create new XMLHttpRequest();
    //  Includes IE Check
    function createXHR(){
        var xmlHttp;
        if(window.XMLHttpRequest) {                 // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlHttp = new XMLHttpRequest();
        } else {                                    // code for IE6, IE5
            xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        return xmlHttp;
    }

    //add tag upon click
    //pass url in form 'tag_app/add_tag.php?postid=*&tagid=*&tag=*
    function addTag(url){
        //generate new XMLHttpRequest()
        var XHRsubmit = createXHR();                                    //new XML Object
        XHRsubmit.onreadystatechange = function () {                    //listener for XML ready state change
            if(XHRsubmit.readyState == 4 && XHRsubmit.status == 200){   //if ready
                var xmlDoc = XHRsubmit.responseXML;                     //retrieve XML response
                console.log(xmlDoc);
                var status = xmlDoc.getElementsByTagName('status')[0].childNodes[0].nodeValue;
                //todo - add boxes detailing <status>
                //if status equals a 'tag added' string, append tag into div#tag_box
                if(status == 'Existing tag added.' || status == 'New tag added.') {
                    //get data from XML document
                    var tagID = xmlDoc.getElementsByTagName('tag_id')[0].childNodes[0].nodeValue;
                    var tagBody = xmlDoc.getElementsByTagName('tag_body')[0].childNodes[0].nodeValue;
                    //load into div#tag_box
                    $tag_box.append('<span class="tag visible btn btn-default" id="pTag' + tagID + '">' + tagBody + '</span>');
                    //scroll to bottom of div#tag_box, this shows newest tag added
                    $tag_box.scrollTop($tag_box[0].scrollHeight);
                    //if a new tag is added, make sure it shows up in suggestions
                    if(status == 'New tag added.'){
                        $('#suggestions-list').append('<li><a href="#" class="gTag key-sensitive list-group-item" id="gTag' + tagID + '">' + tagBody + '</a></li>')
                    }
                }
            }
        };
        //Request and Execution
        XHRsubmit.open("GET", url, true);
        XHRsubmit.send();
    }

   /**********************************************************
    ******************* APPLICATION EVENTS *******************
    **********************************************************/



   /******************* TAG FUNCTIONALITY ********************/

    //**EVENT: ON KEYPRESS
    //  For the tag input, if 'enter' is pressed, make sure form does not submit
    $new_tag.on('keypress', function(e){
       if(e.which == '13'){                         //if 'enter' is pressed while new_tag is in focus
           return false;                            //kill form
       }
    });

    //**EVENT: ON KEYUP
    //  for <input id='new-tag'> & <a>
    //  Controls navigation of the suggestions box
    //  Uses the enter key to "submit the form"
    //      -XMLHttpRequest() is used in place of forms
    //      -add_tag.php is called. Form validation, MySQL controls
    $suggestions_app.on('keyup', '.key-sensitive', function(e){
        //Event Variables
        var $inFocus = $('*:focus');                //Element in focus
        var hints = [];                             //initialize array

        //FILTER SUGGESTIONS
        var url = 'tag_app/filter_tags.php?filter=' + $new_tag.val();       //pass input value with get
        var XHRfilter = createXHR();                                        //create XML object for filter functionality
        XHRfilter.onreadystatechange = function () {
            if(XHRfilter.readyState == 4 && XHRfilter.status == 200){       //once connection ready
                var xmlDoc = XHRfilter.responseXML;                         //get the XML document add_tag.php created
                //in_filter children (visible suggestions) (check filter_tags.php for tree structure)
                var in_filter = xmlDoc.getElementsByTagName('in_filter')[0].childNodes;//
                for(var i = 0; i < in_filter.length; i++){                  //loop through array of <in_filter> children
                    var tagID = in_filter[i].childNodes[0].nodeValue;       //store the <tag_id>'s in <in_filter>
                    var $elID = $('#gTag' + tagID);                         //create suggestion id using 'gTag#'
                    //add id to hints which tells the arrow movements which suggestions are visible
                    hints[i] = tagID;
                    if($elID.hasClass('hidden')) {                          //if suggestion is hidden, unhide it
                        $elID.show().removeClass('hidden').addClass('visible');
                    }
                }

                //ex_filter children (hidden suggestions) (check filter_tags.php for tree structure)
                var ex_filter = xmlDoc.getElementsByTagName('ex_filter')[0].childNodes;
                for(i = 0; i < ex_filter.length; i++){                      //loop through array of <ex_filter> children
                    tagID = ex_filter[i].childNodes[0].nodeValue;           //store the <tag_id>'s in <ex_filter>
                    $elID = $('#gTag' + tagID);                             //create suggestion id using 'gTag#'
                    if(!$elID.hasClass('hidden')){                          //if suggestion is NOT hidden, hide it
                        $elID.hide().removeClass('visible').addClass('hidden');
                    }
                }
                //MOVE TO SUGGESTION
                //  Controls movement of the focus on suggestions list
                //  *** Up Arrow ***
                var last = hints.length - 1;
                if(e.which == '38'){
                    if($inFocus.attr('id') == 'new-tag'){                   //if text field in focus
                        $('#gTag' + hints[last]).focus();                   //move to last suggestion
                    } else if($inFocus.attr('id') == 'gTag' + hints[0]) {   //if focus is on top suggestion
                        $new_tag.focus();                                   //move to text field
                    } else {
                        tagID = $inFocus.attr('id').slice(4);               //get tagID from suggestion ID attribute
                        var index = hints.indexOf(tagID);                   //find index of tagID in hints
                        $('#gTag' + hints[index - 1]).focus();              //move focus to the index before
                    }
                }
                //  *** Down Arrow ***
                else if(e.which == '40'){
                    if($inFocus.attr('id') == 'new-tag'){                   //if text field in focus
                        $('#gTag' + hints[0]).focus();                      //move to first suggestion
                    } else if($inFocus.attr('id') == 'gTag' + hints[last]) {//if focus is on last suggestion
                        $new_tag.focus();                                   //move to text field
                    } else {
                        tagID = $inFocus.attr('id').slice(4);               //get tagID from suggestion ID attribute
                         index = hints.indexOf(tagID);                      //find index of tagID in hints
                        $('#gTag' + hints[index +1]).focus();               //move focus to the following index
                    }
                }
            }
        };
        XHRfilter.open("GET", url, true);                                   //XMLHttpRequest to filter_tags.php
        XHRfilter.send();


        //  *** Enter/Return ***
        if(e.which == '13'){
            //Create request URL with $_GET variables:
            //      - postid: contains the id of post
            //      - tagid: new-tag -or- pTag#
            //      - tag: contains value of tag
            url = "tag_app/add_tag.php?postid=" + postID;
            url += '&tagid=' + $inFocus.attr('id');
            if($inFocus.attr('id') == 'new-tag'){                           //if text field in focus
                url += '&tag=' + $new_tag.val();                            //get value
            } else {                                                        //if <a> in focus
                url += '&tag=' + $inFocus.text();                           //get text
            }
            addTag(url);                                                    //call function to add tag
        }
    });

    //**EVENT: ON CLICK - ADD SUGGESTION (for mobile)
    $suggestions_app.on('click', 'a', function() {
        var $this = $(this);
        var url = 'tag_app/add_tag.php?postid=' + postID;
        url += '&tagid=' + $this.attr('id');
        url += '&tag=' + $this.text();
        addTag(url);
    });

    //**EVENT: ON CLICK
    //  CLEAR SUGGESTIONS
    //  Click on page to hide suggestions box
    $('html').on('click', function(){                       //hide suggestions when $('html') clicked
        if(!$suggestions.hasClass('hidden')){               //if suggestions isn't hidden, hide it
            $suggestions.hide().removeClass('hidden').addClass('hidden');
        }
    });
    $new_tag.on('click', function(e){                       //stop click form hitting $('html') when input clicked
        e.stopPropagation();                                //will keep suggestions open when in use
    });

    //**EVENT: ON CLICK - DELETE TAG
    $tag_box.on('click', 'span', function(){
        var $this = $(this);
        var tagID = $this.attr('id').slice(4);                          //grab tagID from class
        var url = 'tag_app/delete_tag.php?tagid=' + tagID;              //create request URL
        url += '&postid=' + postID;

        //New XMLHttpRequest()
        var XHRdelete = createXHR();                                    //new XML object
        XHRdelete.onreadystatechange = function(){                      //add listener for ready state change
            if(XHRdelete.readyState == 4 && XHRdelete.status == 200){   //once delete_tag.php runs...
                $this.hide().removeClass('visible').addClass('hidden'); //hide the element
            }                                                           //(element will not exist after refresh)
        };
        //send request
        XHRdelete.open('GET', url, true);                               //calls delete_tag.php
        XHRdelete.send();
    });

    //**EVENT: ON FOCUS
    $suggestions_app.on('focus', '.key-sensitive', function() {         //when a tags in focus, show suggestions
        if ($suggestions.hasClass('hidden')) {                          //if suggestions hidden, make visible
            $suggestions.show().removeClass('hidden').addClass('visible');
        }
    });

   /******************* WARNINGS ********************/

   /**
    **   DELETING POSTS
    **/

    //**EVENT: ON CLICK - DELETE POST
    $('.post-delete').on('click', function() {                          //on click a post trash button
        var postID = $(this).data('post-id');                           //store postID
        var newID = 'del' + postID;                                     //create newID for #delete-final button
        $delete.removeAttr('id');                                       //remove existing ID
        $delete.attr('id', newID);                                      //put newID in #delte-final
        if ($delete_warning.hasClass('hidden')) {                       //if #delete-warning is hidden, show it
            $delete_warning.show().removeClass('hidden').addClass('visible');
        }
    });

    //**EVENT: ON CLICK - FINAL DELETE PROMPT
    $delete.on('click', function() {
        var postID = $(this).attr('id').slice(3);                       //pull postID from button ID
        window.location = 'delete_post.php?postid=' + postID;           //point to delete_post.php
    });

    //**EVENT: ON CLICK - NEVERMIND
    $('#nevermind').on('click', function(){
       if($delete_warning.hasClass('visible')) {                        //hide delete warning on click #nevermind
           $delete_warning.hide().removeClass('visible').addClass('hidden');
       }
    });

    /**
     **   CANCEL EDIT
     **/

    //**EVENT: ON CLICK - CANCEL EDIT
    //todo - remove the tags that were added during editing
    $('#edit-cancel').on('click', function() {                          //event on cancel button in edit_post.php
        if($cancel_edit_warning.hasClass('hidden')) {                   //show warning before canceling edit
            $cancel_edit_warning.show().removeClass('hidden').addClass('visible');
        }
    });

    //**EVENT: ON CLICK - CANCEL EDIT NEVERMIND
    $('#cancel-cancel').on('click', function() {                        //cancel edit_post.php - nevermind
        if($cancel_edit_warning.hasClass('visible')) {                  //hide warning if visible
            $cancel_edit_warning.hide().removeClass('visible').addClass('hidden');
        }
    });

    //**EVENT: ON CLICK - CANCEL EDIT I'M SURE
    $('#confirm-cancel').on('click', function() {                       //i'm sure - cancel edit
        //if user has not changed the default value of the post, delete it
        //todo - not a complete solution, if post changed and edit canceled, post not deleted
        if($('#input-body').val() == 'Your post goes here...' && $('#input-title').val() == "New Post") {
            window.location = 'delete_post.php?postid=' + $(this).data('postid');
        } else {
            window.location = 'index.php';                                  //go to index.php
        }

    });

};

$(document).ready(main);
