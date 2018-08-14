<?php

include '../init.php';
$getFromUsers->preventAccess($_SERVER['REQUEST_METHOD'],realpath(__FILE__),realpath($_SERVER['SCRIPT_FILENAME']));

if(isset($_POST['like']) && !empty($_POST['like'])) {


    $user_id = $_SESSION['user_id'];
    $tw_id = $_POST['like'];
    $get_id = $_POST['user_id'];

    $getFromTweets->addLike($user_id,$tw_id,$get_id);
}

if(isset($_POST['unlike']) && !empty($_POST['unlike'])) {


    $user_id = $_SESSION['user_id'];
    $tw_id = $_POST['unlike'];
    $get_id = $_POST['user_id'];
    $getFromTweets->unlike($user_id,$tw_id,$get_id);
    //$getFromTweets->countLikes($user_id);
}


?>