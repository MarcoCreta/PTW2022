<?php
require_once("../bootstrap.php");
require_once("../db/database.php");

session_start();

if(isset($_GET['action'])) {
    if($_GET["action"] == "getPosts"){
        $templateParams['post'] = $dbh->getProfilePostsFromUser($_GET['username']);
        require('../template/post.php');

    } elseif ($_GET["action"] == "getPostsByUserAndFriends") {
        $templateParams['post'] = $dbh->getPostsByUserAndFriends($_GET['username']);
        require('../template/post.php');

    } elseif ($_GET["action"] == "getComments") {
        $templateParams['comments'] = $dbh->getCommentsFromPost(
            $_GET["post"]["username"],
            $_GET["post"]["ID_profile"],
            $_GET["post"]["date"],
            $_GET["post"]["time"]
        );
        require('../template/comment.php');
    }

} elseif(isset($_POST['action'])) {
    if($_POST["action"] == "createPost") {
        $post = array(
            'username' => $_SESSION["username"],
            'ID_profile' => $_POST["post"]["ID_profile"],
            'content' => $_POST["post"]["content"],
            'date' => date("y-m-d"),
            'time' => date("H:i:s")
        );

        $result = $dbh->createPost(
            $post["username"],
            $post["ID_profile"],
            $post["content"],
            $post['date'],
            $post['time']);

        if($result){
            $username = $dbh->getUsernameFromProfile($_POST["post"]["ID_profile"]);
            if(isset($username)){
                if($username != $_SESSION["username"]){
                    $email = $dbh->getUserEmail($username);
                    if($email){
                        $to = $email;
                        $subject = "Nuovo post";
                        $txt = "L'utente " . $_SESSION["username"] . " ha pubblicato qualcosa sul tuo profilo";
                        $headers = "From: learny@help.com" . "\r\n";
                        $send = mail($to,$subject,$txt,$headers);
                    }
                }
            }

            $templateParams['posts'] = array($post);
            require('../template/post.php');
        } else {
            $templateParams['alert']['title'] = 'an error as occurred';
            $templateParams['alert']['content'] = 'the post could not be created';
            require('../template/alert.php');
        }

    } elseif($_POST["action"] == "createComment") {
        $comment = array(
            'username' => $_SESSION["username"],
            'post_ID_profile' => $_POST["comment"]["post_ID_profile"],
            'post_username' => $_POST["comment"]["post_username"],
            'content' => $_POST["comment"]["content"],
            'date' => date("y-m-d"),
            'time' => date("H:i:s"),
            'post_date' => $_POST["comment"]["post_date"],
            'post_time' => $_POST["comment"]["post_time"]
        );

        $result = $dbh->createComment(
            $comment["username"],
            $comment["post_ID_profile"],
            $comment["post_username"],
            $comment["content"],
            $comment["date"],
            $comment["time"],
            $comment["post_date"],
            $comment["post_time"]);

            if($result){
                $templateParams['comments'] = array($comment);
                require('../template/comment.php');
            } else {
                $templateParams['alert']['title'] = 'an error as occurred';
                $templateParams['alert']['content'] = 'the comment could not be created';
                require('../template/alert.php');
            }

    } elseif($_POST["action"] == "deleteComment") {
        $result = $dbh->deleteComment(
            $_SESSION["username"],
            $_POST["comment"]["post_ID_profile"],
            $_POST["comment"]["post_username"],
            $_POST["comment"]["date"],
            $_POST["comment"]["time"],
            $_POST["comment"]["post_date"],
            $_POST["comment"]["post_time"]);

        echo $result ? json_encode(array("result" => "success")) : json_encode(array("result" => "failed"));

    }  elseif($_POST["action"] == "deletePost") {
        $result =  $dbh->deletePost(
            $_SESSION["username"],
            $_POST["post"]["ID_profile"],
            $_POST["post"]["date"],
            $_POST["post"]["time"]);

        echo $result ? json_encode(array("result" => "success")) : json_encode(array("result" => "failed"));

    }
}

?>