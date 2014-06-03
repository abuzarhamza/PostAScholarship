<?php

    //session_start();
    // require_once("./includes/config.php");
    // require_once("./includes/functions.php");
    include("./_admin_start.php");
    include("./_admin_initialize.php");
    include("./classes/Parsedown.php");
?>

<?php

    function clean($string) {
        $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
        return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
    }

    if  ( array_key_exists('action', $_GET) ) {

        $action = $_GET['action'];
        $txt    = "";
        if ( $action == "get_tag" ) {
            $serachTerm = $_GET['tag'] . "%";
            $tags = [];
            $sql = 'select tag_name
                      from tag
                     where tag_name like (?) order by tag_name asc';

            $stmt = $conn->prepare("$sql");
            $stmt->bind_param('s',$serachTerm);
            if($stmt === false) {
                echo "no suggestion";
                exit;
            }
            $stmt->execute();
            $stmt->bind_result($tag_name);
            while ($stmt->fetch()) {
                $tags[] = $tag_name;
            }
            $stmt->free_result();
            $stmt->close();

            header('Content-Type: txt');
            echo join($tags,',');
        }
        elseif ($action == "add_post") {
            #1.validate data
            #2.flag error
            #3.parse data from markdown to html
            #4.save the data (begin tansation)
            #5.add tags (end)
            #6.error flag as per required
            $errorCode = 0;

            foreach ($_POST as $k => $v) {
                //echo "\$a[$k] => $v.\n";
                if ( $errorCode > 0 ) {
                   break;
                }
                switch ($k) {

                    case "post_title" :
                        $errorCode = (strlen($v) > 150 || strlen($v) < 15 ? 1 : 0);
                        break;

                    case "post_content" :
                        $errorCode = (strlen($v) > 1500 || strlen($v) < 1 ? 2 : 0);
                        break;

                    case "tag" :
                        $errorCode = (strlen($v) > 250 ? 3 : 0);
                        break;

                    case "post_type":
                        if ( ! preg_match("/^(scholarship|job|question|blog|social_bookmark)$/",$v,$match) ) {
                            $errorCode  =4;
                        }
                        break;

                    case "scholarship_type" :
                        if ( ! preg_match("/^(phd|postdoc|fellowship|research_associate|senior_scientist|research_fellow|other)$/",$v,$match) ){
                            $errorCode  =5;
                        }
                        break;
                }
            }

            #saving the input by the user will be used for regeneration of the form
            $_SESSION['post_title']   = $_POST['post_title'];
            $_SESSION['post_content'] = $_POST['post_content'];
            $_SESSION['tag']          = $_POST['tag'];

            switch ($errorCode){
                case 1 :
                    $errMsg = "Exceed the limit of character in title, has more than 150 or less the 15 character.";
                    $RES = "post_error1";
                    break;

                case 2 :
                    $errMsg = "Exceed the limit of character in post, has more than 1500 character.";
                    $RES = "post_error2";
                    break;

                case 3 :
                    $errMsg = "Exceed the limit of character in tag, has more than 250 character.";
                    $RES = "post_error3";
                    break;

                case 4 :
                    $errMsg = "Incorrect post type.";
                    $RES = "post_error4";
                    break;

                case 5 :
                    $errMsg = "Incorrect scholarship type.";
                    $RES = "post_error5";
                    break;
            }

            if ($errorCode) {
                header("Location: add_post.php?res=$RES");
                exit;
            }
            #parse_markdown
            $Parsedown = new Parsedown();
            $postHtml = $Parsedown->text($_POST["post_content"]);

            $author          = $_SESSION['s_admin_username'];
            $title           = $_POST["post_title"];
            $content         = $_POST["post_content"];
            $postType        = strtoupper($_POST["post_type"]);
            $scholarshipType = strtoupper($_POST["scholarship_type"]);

            #for slug remove metacharacters and space
            $slug   = clean($_POST["post_title"]);

            #database entry
            #start transaction
            $conn->autocommit(FALSE);
            try {
                if (! $conn->multi_query("call add_post_with_name('$author','$title','$content','$postHtml','$slug','$postType',1)")
                ) {
                    throw new Exception($conn->error);
                }

                do {
                    if ($res = $conn->store_result()) {
                        $row = $res->fetch_assoc();
                        $res->free();
                        $postId = (int) $row["post_id"];
                        echo $postId;
                    }
                } while ($conn->more_results() && $conn->next_result());

                foreach ( explode(',', $_POST["tag"]) as $tagName ) {

                    if (! $conn->multi_query("call add_tag_for_post($postId,'$tagName')")
                    ) {
                        throw new Exception($conn->error);
                    }


                    do {
                        if ($res = $conn->store_result()) {
                            //var_dump($res->fetch_assoc());
                            $res->free();
                        }
                    } while ($conn->more_results() && $conn->next_result());
                }

                $conn->commit();
            } catch (Exception $e ) {
                $errMsg = $e->getMessage();
                $conn->rollback();
            }

            if ( $errorCode ) {
                $RES = "db_error1";
                header("Location: add_post.php?res=$RES");
                exit;
            }
            else {
                header("Location: add_post.php?res=post_success");
                exit;
            }


        }
        else {

            $RES = "error_post";
        }

    }

?>

<?php
$conn->close();
ob_end_flush();
?>