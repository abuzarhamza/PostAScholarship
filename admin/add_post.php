<?php
    ob_start();
    //session_start();
    // require_once("./includes/config.php");
    // require_once("./includes/functions.php");
    include("./_admin_start.php");
    include("./_admin_initialize.php");
    #need to create error handle
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
<link rel="icon" href="templates/img/logo.png" sizes="16x16" type="image/png">
<title><? echo SITE_URL_TITLE; ?> - Administrator</title>
<?php include "_assets.php";?>
</head>

<body>
<?php
    include("_top.php");
?>


<div="container" style="margin: 10px;">
    <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10 col-md-offset-1 col-lg-offset-1" >
                <h1>Add Post</h1>
            </div>
    </div>

    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10 col-md-offset-1 col-lg-offset-1" >
            <ol class="breadcrumb">
              <li><a href="./index.php?page=home">Home</a></li>
              <li><a href="./index.php?page=dashboard">Dashboard</a></li>
              <li><a href="./post.php">Manage Post</a></li>
              <li class="active">Add post</li>
            </ol>
        </div>
    </div>

    <!--error flag-->
    <?php if ($RES=="post_error1") : ?>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10 col-md-offset-1 col-lg-offset-1">
                <div class="alert alert-danger">
                    <a class="close" data-dismiss="alert">×</a>
                    <strong>Error </strong> Exceed the limit of character in title, has more than 150 or less the 15 character.
                </div>
            </div> <!--close col-->
        </div> <!--close row-->
    <?php elseif ($RES=="post_error2") : ?>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10 col-md-offset-1 col-lg-offset-1">
                <div class="alert alert-danger">
                    <a class="close" data-dismiss="alert">×</a>
                    <strong>Error </strong> Exceed the limit of character in post, has more than 1500 character or have no content.
                </div>
            </div> <!--close col-->
        </div> <!--close row-->
    <?php elseif ($RES=="post_error3") : ?>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10 col-md-offset-1 col-lg-offset-1">
                <div class="alert alert-danger">
                    <a class="close" data-dismiss="alert">×</a>
                    <strong>Error </strong> Exceed the limit of character in tag, has more than 250 character.
                </div>
            </div> <!--close col-->
        </div> <!--close row-->
    <?php elseif ($RES=="post_error4") : ?>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10 col-md-offset-1 col-lg-offset-1">
                <div class="alert alert-danger">
                    <a class="close" data-dismiss="alert">×</a>
                    <strong>Error </strong> Incorrect post type.
                </div>
            </div> <!--close col-->
        </div> <!--close row-->
    <?php elseif ($RES=="post_error5") : ?>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10 col-md-offset-1 col-lg-offset-1">
                <div class="alert alert-danger">
                    <a class="close" data-dismiss="alert">×</a>
                    <strong>Error </strong> Incorrect scholarship type.
                </div>
            </div> <!--close col-->
        </div> <!--close row-->
     <?php elseif ($RES=="post_success") : ?>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10 col-md-offset-1 col-lg-offset-1">
                <div class="alert alert-success">
                    <a class="close" data-dismiss="alert">×</a>
                    <strong>Success! </strong> post has been added.
                </div>
            </div> <!--close col-->
        </div> <!--close row-->
    <?php endif; ?>
    <div class="row">

        <form class="form" role="form" action="./admin_ops.php?action=add_post" method="post">
            <div class="form-group">

                <label for="post_title" class="col-xs-12 col-sm-12 col-md-7 col-lg-7 col-md-offset-1 col-lg-offset-1"> Title <span id= "post_title_help" class="text-danger"></span> </label>
                <div class="col-xs-12 col-sm-12 col-md-7 col-lg-7 col-md-offset-1 col-lg-offset-1">
                  <input type="text" class="form-control" id="post_title" name="post_title" placeholder="title" onfocus="help_message('post_title');" onblur="check_content_size('post_title');" value="<?php if (isset($_SESSION['post_title'])) echo htmlspecialchars($_SESSION['post_title']);?>">
                </div>
                <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                    <!--filled by javascript for help msg-->
                    <p id="post_title_help_msg" class="text-muted"></p>
                </div>
            </div>

            <div class="form-group">
                <div class="col-xs-12 col-sm-12 col-md-7 col-lg-7 col-md-offset-1 col-lg-offset-1">
                     <br/>
                    <label for="post content">Post content  <span id= "post_content_help" class="text-danger"></span> </label>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-7 col-lg-7 col-md-offset-1 col-lg-offset-1">
                    <textarea class="form-control" id="post_content" name="post_content" rows="10" cols="40" maxlength="2000" placeholder="post" onfocus="help_message('post_content');" onblur="check_content_size('post_content');"> <?php if (isset($_SESSION['post_content'])) echo htmlspecialchars($_SESSION['post_content']);?> </textarea>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                  <!--filled by javascript for help msg-->
                  <p id="post_content_help_msg" class="text-muted"> </p>
                </div>
            </div>

            <div class="form-group">
                <div class="col-xs-12 col-sm-12 col-md-7 col-lg-7 col-md-offset-1 col-lg-offset-1">
                     <br/>
                    <label for="tag">Tags <span id= "tag_help" class="text-danger"> </label>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-7 col-lg-7 col-md-offset-1 col-lg-offset-1">
                    <textarea class="form-control" id="tag" name="tag" rows="1" cols="1" maxlength="500" placeholder="tags" onfocus="help_message('tag');" onblur="check_content_size('tag');" onkeyup="getSuggestionForTag('tag','http://localhost/PostAScholarship/admin/admin_ops.php','tag_suggestion');"> <?php if (isset($_SESSION['tag'])) echo htmlspecialchars($_SESSION['tag']);?> </textarea>
                    <span class="help-block" id="tag_suggestion"></span>

                </div>
                <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                  <!--filled by javascript-->
                  <p id="tag_help_msg" class="text-muted"> </p>
                </div>
                <!-- <p>Suggestions: <span id="txtHint"></span></p> tag suggstion -->
                <!--<p> It sdfsdfnsofnn sndfnsdfn <br/> jsdfsndfnsonf <br/> lets me </p>-->
            </div>

            <div class="form-group">
                <div class="col-xs-12 col-sm-12 col-md-7 col-lg-7 col-md-offset-1 col-lg-offset-1">
                    <br/>
                    <label for="post_type">Post type</label>
                </div>

                <div class="col-xs-12 col-sm-12 col-md-7 col-lg-7 col-md-offset-1 col-lg-offset-1">
                    <!-- Single button -->
                    <select class="form-control" id="post_type" name="post_type" onclick="enable_scholarship('post_type');" onfocus="help_message('post_type');">
                      <option value="scholarship">Scholarship</option>
                      <option value="job">Job</option>
                      <option value="question">Question</option>
                      <option value="blog">Blog</option>
                      <option value="social_bookmark">Social bookmark</option>
                    </select>
                </div>

                <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                    <!--filled by javascript for help msg-->
                    <p id="post_type_help_msg" class="text-muted"></p>
                </div>
            </div>

            <div class="form-group">
                <div class="col-xs-12 col-sm-12 col-md-7 col-lg-7 col-md-offset-1 col-lg-offset-1">
                    <br/>
                    <label for="scholarship_type" >Scholarship type </label>
                </div>

                <div class="col-xs-12 col-sm-12 col-md-7 col-lg-7 col-md-offset-1 col-lg-offset-1">
                    <!-- Single button -->
                    <select class="form-control" id="scholarship_type" name="scholarship_type">
                        <option value="select the option"> --options-- </option>
                        <option value="phd">PhD Studentship </option>
                        <option value="postdoc">Postdoctoral</option>
                        <option value="fellowship">Fellowship</option>
                        <option value="research_associate">Research Associate</option>
                        <option value="senior_scientist">Senior Scientist</option>
                        <option value="research_fellow">Research Fellow </option>
                        <option value="other">Other</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 col-md-offset-1 col-lg-offset-1">
                  <br/>
                  <button type="submit" class="btn btn-success" action="./admin_ops.php?action=add_post"> <i class="fa fa-sign-in"></i> Post It </button>
                  <button type="button" class="btn btn-info"> <i class="fa fa-external-link-square"></i>  Preview the post</button>

                </div>
            </div>


        </form>
            <!-- content post_settings-->
    </div>

<?php
    include("_footer.php");
    include ("_assets_javascript.php");
?>

<script type="text/javascript">

    function getDataFromAjax(url,data) {
        if (window.XMLHttpRequest == undefined) {
            window.XMLHttpRequest = function () {
                try {
                    return new ActiveXObject("Msxml.XMLHTTP.6.0");
                }
                catch(e1) {
                    try {
                        return new ActiveXObject("Msxml.XMLHTTP.3.0");
                    }
                    catch(e2){
                        throw new Error("XMLHTTP is not supported")
                    }
                }
            }
        } 

        var request = new XMLHttpRequest();
        var inputUrl   = url + '?' + data;
        console.log("t3 >>" + inputUrl);
        request.open("GET",inputUrl);
        request.setRequestHeader("Content-Type","text/plain;charset=UTF-8");
        request.onreadystatechange = function() {
            if (request.readyState == 4 && reqest.status == 200 ) {
                console.log("t4" + request.responseText);
                var type = request.getResponseHeader(Content-Type);
                if ( type.indexOf("xml") && request.responseXML) {
                    callback(responseXML);
                }
                else if ( type == "application/json") {
                    callback(JSON.parse(request.responseText));
                } else {
                    callback(request.responseText);
                }
            }
        }
        request.send(null);
    }

    function getSuggestionForTag(divId,url,suggestionId) {
        if (document.getElementById(divId).length < 2) {
            document.getElementById(suggestionId).innerHTML = "";
            return;
        }
        console.log("t1");
        console.log(document.getElementById(divId).value + " t2 " + url);
        var data   = "action=get_tag&tag=" + document.getElementById(divId).value;
        var txtObj = getDataFromAjax(url,data);
        console.log("t5>>" + txtObj);
        //var txt = getDataFromAjax(url,data);

        //document.getElementById("divId").innerHTML= "Suggestion : "+ txt ;
    }
    function help_message(inputField) {

        //console.log(inputField + 'testing');

        if ( inputField == "post_title" ) {
            document.getElementById('post_title_help_msg').innerHTML   = 'Be specific.</br> * A good title can be very helpful for other.';
            document.getElementById('post_content_help_msg').innerHTML = "";
            document.getElementById('tag_help_msg').innerHTML          = "";
            document.getElementById('post_type_help_msg').innerHTML    = "";
        }
        else if ( inputField == "post_content" ) {
            document.getElementById('post_title_help_msg').innerHTML   = "";
            document.getElementById('post_content_help_msg').innerHTML = 'How to Format? Check <br/> * editor support <a href="http://en.wikipedia.org/wiki/Markdown" target="_blank">markdown </a>.<br/>* put enter between paragraphs. <br/> * for linebreak add 2 spaces at end. <br/> * _italic_ or **bold** <br/> * quote by placing > at start of line.';
            document.getElementById('tag_help_msg').innerHTML          = "";
            document.getElementById('post_type_help_msg').innerHTML    = "";
        }
        else if ( inputField == "tag"  ) {
            document.getElementById('post_title_help_msg').innerHTML   = "";
            document.getElementById('post_content_help_msg').innerHTML = "";
            document.getElementById('tag_help_msg').innerHTML         = 'A tag is a keyword or label that categorizes your post with other similar post.<br/>* max 5 tags.';
            document.getElementById('post_type_help_msg').innerHTML    = "";
        }
        else if ( inputField ==  "post_type") {
             console.log(inputField + 'testing2');
            document.getElementById('post_title_help_msg').innerHTML   = "";
            document.getElementById('post_content_help_msg').innerHTML = "";
            document.getElementById('tag_help_msg').innerHTML          = "";
            document.getElementById('post_type_help_msg').innerHTML    = 'Select the catagory.<br/>That will keep your post better organised';
        }
    }

    function check_content_size(inputField) {
        var error = 0;

        if ( inputField == "post_title" )  {
            if ( document.getElementById(inputField).value.length < 15  ) {
                error = 1;
                document.getElementById('post_title_help').innerHTML   = '* should be have more than 15 character.';
            } else if ( document.getElementById(inputField).value.length > 150 ) {
                error = 1;
                document.getElementById('post_title_help').innerHTML   = '* should be have less than 150 character.';
            } else {
                document.getElementById('post_title_help').innerHTML   = '';
            }
        } else if ( inputField == "post_content" ) {
            if ( document.getElementById(inputField).value.length <= 0 ) {
                error = 1;
                document.getElementById('post_content_help').innerHTML   = '* should have some content.';
            } else {
                document.getElementById('post_content_help').innerHTML   = '';
            }

        } else if ( inputField == "tag" ) {
            if ( document.getElementById(inputField).value.length <= 3 ) {
                error = 1;
                document.getElementById('tag_help').innerHTML   = '* add few tags';
            }
            else {
                document.getElementById('tag_help').innerHTML   = '';
            }
        }
    }
    
    function enable_scholarship(inputId) {
        if ( document.getElementById(inputId).value == "scholarship" ) {
            document.getElementById("scholarship_type").disabled=false;
            document.getElementById("tentataive_expiry_date").disabled=false;
        } else {
            document.getElementById("scholarship_type").disabled=true;
            document.getElementById("tentataive_expiry_date").disabled=true;
        }
    }

</script>
</body>