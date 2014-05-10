<?php
    ob_start();
    //session_start();
    // require_once("./includes/config.php");
    // require_once("./includes/functions.php");
    include("./_admin_start.php");
    include("./_admin_initialize.php");
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

    <div class="row">

        <form class="form" role="form" action="" method="post">
            <div class="form-group">

                <label for="post_title" class="col-xs-12 col-sm-12 col-md-7 col-lg-7 col-md-offset-1 col-lg-offset-1"> Title <span id= "post_title_help" class="text-danger"></span> </label>
                <div class="col-xs-12 col-sm-12 col-md-7 col-lg-7 col-md-offset-1 col-lg-offset-1">
                  <input type="text" class="form-control" id="post_title" name="post_title" placeholder="title" onfocus="help_message('post_title');" onblur="check_content_size('post_title');">
                </div>
                <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                    <!--filled by javascript for help msg-->
                    <p id="post_title_help_msg" class="text-muted"></p>
                </div>
            </div>

            <div class="form-group">
                <div class="col-xs-12 col-sm-12 col-md-7 col-lg-7 col-md-offset-1 col-lg-offset-1">
                    <label for="post content">Post content  <span id= "post_content_help" class="text-danger"></span> </label>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-7 col-lg-7 col-md-offset-1 col-lg-offset-1">
                    <textarea class="form-control" id="post_content" name="post_content" rows="10" cols="40" maxlength="2000" placeholder="post" onfocus="help_message('post_content');" onblur="check_content_size('post_content');"></textarea>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                  <!--filled by javascript for help msg-->
                  <p id="post_content_help_msg" class="text-muted"> </p>
                </div>
            </div>

            <div class="form-group">
                <div class="col-xs-12 col-sm-12 col-md-7 col-lg-7 col-md-offset-1 col-lg-offset-1">
                    <label for="post content">Tags <span id= "tag_help" class="text-danger"> </label>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-7 col-lg-7 col-md-offset-1 col-lg-offset-1">
                    <textarea class="form-control" id="tag" name="tag" rows="1" cols="1" maxlength="500" placeholder="tags" onfocus="help_message('tag');" onblur="check_content_size('tag');"></textarea>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                  <!--filled by javascript-->
                  <p id="tag_help_msg" class="text-muted"> </p>
                </div>
                <!-- <p>Suggestions: <span id="txtHint"></span></p> tag suggstion -->
                <!--<p> It sdfsdfnsofnn sndfnsdfn <br/> jsdfsndfnsonf <br/> lets me </p>-->
            </div>


            <div class="form-group">
                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 col-md-offset-1 col-lg-offset-1">
                  <br/>
                  <button type="submit" class="btn btn-success"> <i class="fa fa-sign-in"></i> Post It </button>
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
    function help_message(inputField) {
        if ( inputField == "post_title" ) {
            document.getElementById('post_title_help_msg').innerHTML   = 'Be specific.</br> * A good title can be very helpful for other.';
            document.getElementById('post_content_help_msg').innerHTML = "";
            document.getElementById('tag_help_msg').innerHTML         = "";
        }
        else if ( inputField == "post_content" ) {
            document.getElementById('post_title_help_msg').innerHTML   = "";
            document.getElementById('post_content_help_msg').innerHTML = 'How to Format? Check <br/> * editor support <a href="http://en.wikipedia.org/wiki/Markdown" target="_blank">markdown </a>.<br/>* put enter between paragraphs. <br/> * for linebreak add 2 spaces at end. <br/> * _italic_ or **bold** <br/> * quote by placing > at start of line.';
            document.getElementById('tag_help_msg').innerHTML         = "";
        }
        else if ( inputField == "tag"  ) {
            document.getElementById('post_title_help_msg').innerHTML   = "";
            document.getElementById('post_content_help_msg').innerHTML = "";
            document.getElementById('tag_help_msg').innerHTML         = 'A tag is a keyword or label that categorizes your post with other similar post.<br/>* max 5 tags.';
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
    
</script>
</body>    