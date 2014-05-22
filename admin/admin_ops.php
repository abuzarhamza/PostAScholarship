<?php
    ob_start();
    //session_start();
    // require_once("./includes/config.php");
    // require_once("./includes/functions.php");
    include("./_admin_start.php");
    include("./_admin_initialize.php");
?>

<?php

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
    }

?>

<?php
$conn->close();
ob_end_flush();
?>