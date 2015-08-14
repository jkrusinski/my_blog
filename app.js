var main = function () {
    //GLOBALS
    //  Jquery object globals
    var $new_tag = $('#new-tag');
    var $suggestions = $('#suggestions');
    var $debug = $('#debug');
    var $tag_box = $('#tag_box');
    //  page values
    var postID = $('#post-id').val();

    //FUNCTIONS
    //  Create new XMLHttpRequest();
    //  Includes IE Check
    function createXHR(){
        var xmlHttp;
        if(window.XMLHttpRequest) {         // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlHttp = new XMLHttpRequest();
        } else {                            // code for IE6, IE5
            xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        return xmlHttp;
    }

    //**EVENT: ON KEYPRESS
    //  For the tag input, if 'enter' is pressed, make sure form does not submit
    $new_tag.on('keypress', function(e){
       if(e.which == '13'){     //if 'enter' is pressed while new_tag is in focus
           return false;        //kill form
       }
    });

    //**EVENT: ON KEYUP
    //  for <input id='new-tag'> & <a>
    //  Controls navigation of the suggestions box
    //  Uses the enter key to "submit the form"
    //      -XMLHttpRequest() is used in place of forms
    //      -add_tag.php is called. Form validation, MySQL controls
    $('.key-sensitive').on('keyup', function(e){
        //Event Variables
        var $inFocus = $('*:focus');        //Element in focus
        var hints = [];

        //FILTER SUGGESTIONS
        var url = 'tag_app/filter_tags.php?filter=' + $new_tag.val();   //pass input value with get
        var XHRfilter = createXHR();
        XHRfilter.onreadystatechange = function () {
            if(XHRfilter.readyState == 4 && XHRfilter.status == 200){
                var xmlDoc = XHRfilter.responseXML;
                //in_filter children
                var in_filter = xmlDoc.getElementsByTagName('in_filter')[0].childNodes;
                for(var i = 0; i < in_filter.length; i++){
                    var tagID = in_filter[i].childNodes[0].nodeValue;
                    var $elID = $('#gTag' + tagID);
                    hints[i] = tagID;
                    if($elID.hasClass('hidden')) {
                        $elID.show().removeClass('hidden').addClass('visible');
                    }
                }

                //ex_filter children
                var ex_filter = xmlDoc.getElementsByTagName('ex_filter')[0].childNodes;
                for(i = 0; i < ex_filter.length; i++){
                    tagID = ex_filter[i].childNodes[0].nodeValue;
                    $elID = $('#gTag' + tagID);
                    if(!$elID.hasClass('hidden')){
                        $elID.hide().removeClass('visible').addClass('hidden');
                    }
                }
                //todo when new tag added, arrows stop functioning
                //MOVE TO SUGGESTION
                //  Controls movement of the focus on suggestions list
                //  *** Up Arrow ***
                var last = hints.length - 1;
                if(e.which == '38'){
                    if($inFocus.attr('id') == 'new-tag'){
                        $('#gTag' + hints[last]).focus();
                    } else if($inFocus.attr('id') == 'gTag' + hints[0]) {
                        $new_tag.focus();
                    } else {
                        tagID = $inFocus.attr('id').slice(4);
                        var index = hints.indexOf(tagID);
                        $('#gTag' + hints[index - 1]).focus();
                    }
                }
                //  *** Down Arrow ***
                else if(e.which == '40'){
                    if($inFocus.attr('id') == 'new-tag'){
                        $('#gTag' + hints[0]).focus();
                    } else if($inFocus.attr('id') == 'gTag' + hints[last]) {
                        $new_tag.focus();
                    } else {
                        tagID = $inFocus.attr('id').slice(4);
                         index = hints.indexOf(tagID);
                        $('#gTag' + hints[index +1]).focus();
                    }
                }
            }
        };
        XHRfilter.open("GET", url, true);
        XHRfilter.send();


        //  *** Enter/Return ***
        if(e.which == '13'){
            //Create request URL with $_GET variables:
            //      - postid: contains the id of post
            //      - tagid: new-tag -or- pTag#
            //      - tag: contains value of tag
            var $url = "tag_app/add_tag.php?postid=" + postID;
            $url += '&tagid=' + $inFocus.attr('id');
            if($inFocus.attr('id') == 'new-tag'){   //if <input> in focus
                $url += '&tag=' + $new_tag.val();   //get value
            } else {                                //if <a> in focus
                $url += '&tag=' + $inFocus.text();  //get text
            }

            //generate new XMLHttpRequest()
            var XHRsubmit = createXHR();                                  //new XML Object
            XHRsubmit.onreadystatechange = function () {                  //listener for XML connection ready state change
                if(XHRsubmit.readyState == 4 && XHRsubmit.status == 200){ //if ready
                    var xmlDoc = XHRsubmit.responseXML;                   //retrieve XML response
                    var status = xmlDoc.getElementsByTagName('status')[0].childNodes[0].nodeValue;

                    //if status equals a 'tag added' string, append tag into div#tag_box
                    if(status == 'Existing tag added.' || status == 'New tag added.') {
                        //get data from XML document
                        var tagID = xmlDoc.getElementsByTagName('tag_id')[0].childNodes[0].nodeValue;
                        var tagBody = xmlDoc.getElementsByTagName('tag_body')[0].childNodes[0].nodeValue;
                        //load into div#tag_box
                        $tag_box.append('<span class="tag visible btn btn-info" id="pTag' + tagID + '">' + tagBody + '</span>');
                        //scroll to bottom of div#tag_box, this shows newest tag added
                        $tag_box.scrollTop($tag_box[0].scrollHeight);
                        //if a new tag is added, make sure it shows up in suggestions
                        if(status == 'New tag added.'){
                            $('#suggestions-list').append('<li><a href="#" class="gTag key-sensitive list-group-item" id="gTag' + tagID + '">' + tagBody + '</a></li>')
                        }
                    }

                    //debugger
                    $debug.append(status);
                    $debug.append('<br>');
                }
            };
            //Request and Execution
            XHRsubmit.open("GET", $url, true);
            XHRsubmit.send();
        }

    });

    //**EVENT: ON CLICK
    //  CLEAR SUGGESTIONS
    //  Click on page to hide suggestions box
    $('html').on('click', function(){       //hide suggestions when $('html') clicked
        if(!$suggestions.hasClass('hidden')){
            $suggestions.hide().removeClass('hidden').addClass('hidden');
        }
    });
    $suggestions.on('click', function(e){   //stop click from hitting $('html') when suggestions clicked
        e.stopPropagation();
    });
    $new_tag.on('click', function(e){       //stop click form hitting $('html') when input clicked
        e.stopPropagation();
    });

    //CLICK TO DELETE TAG
    $tag_box.on('click', 'span', function(){
        var $this = $(this);
        var tagID = $this.attr('id').slice(4);     //grab tagID from class
        var url = 'tag_app/delete_tag.php?tagid=' + tagID;      //create request URL
        url += '&postid=' + postID;

        //New XMLHttpRequest()
        var XHRdelete = createXHR();                    //new XML object
        XHRdelete.onreadystatechange = function(){      //add listener for ready state change
            if(XHRdelete.readyState == 4 && XHRdelete.status == 200){//if ready
                //do things
                $debug.append(XHRdelete.responseText + '<br>');
                $this.hide().removeClass('visible').addClass('hidden');
            }
        };
        //send request
        XHRdelete.open('GET', url, true);
        XHRdelete.send();
    });

    //***EVENT: ON FOCUS
    //  control suggestion toggle
    $new_tag.on('focus', function(){
        if ($suggestions.hasClass('hidden')) {          //if input not empty and sugg. hidden
            $suggestions.show().removeClass('hidden').addClass('visible');      //show suggestions
        }
    });

    $('.gTag').on('focus', function(){
        if ($suggestions.hasClass('hidden')) {          //if input not empty and sugg. hidden
            $suggestions.show().removeClass('hidden').addClass('visible');      //show suggestions
        }
    });


};

$(document).ready(main);
